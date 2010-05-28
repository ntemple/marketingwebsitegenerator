<?php

defined('_MWG') or die ('Restricted Access');

define('UPDATER_SERVER',  'http://www.intellispire.com/network/server51/soap.php');
define('UPDATER_VERSION', 22);
define('UPDATER_MANIFEST', MWGHelper::path(GENSTALL_BASEPATH . '/config/manifest.yml.php'));

require_once ('isnclient/utils.inc.php');
require_once ('isnclient/intellispireNetworkClient.class.php');
require_once ('isnclient/manifest.class.php');

class simpleClient {

  function retrievedownloadlink($package, $version) {
    $r = $this->isn_call('retrievedownloadlink', $package);
    return $r['payload'];    
  }

  function retrievemanifest($channels, $version) {
    $r = $this->isn_call('retrievemanifest', $package);
    return $r;
  }

  function check($username, $password) {
    $r = $this->isn_call('check', 'mwg', $username, $password);    
    return false;    
  }

  function isn_call($t = 'ping', $x='mwg12', $username = null, $password = null ) {
    if (!$username) {
      $registry = mwgDataRegistry::getInstance();
      $username = $registry->get('username');
      $password = $registry->get('password');    
    }
    $t = urlencode($t);
    $x = urlencode($p);
    $u = urlencode($username);
    $p = urlencode($password);

    $url = "http://marketingwebsitegenerator.com/club/isn.php?t=$t&p=$p&u=$u&x=$x";
    $r = MWGHelper::url_retrieve($url);
    if (!$r) throw new Exception('Could not connect to server.');
    $r = unserialize(base64_decode($r));

    $this->req    = $url;
    $this->result = $r;

    if ($r['code'] == 200) return $r;

    throw new Exception($r['msg'], $r['code']);   
  }

}



class modelGenstaller {

  var $client;
  var $manifest;

  function getClient() {
    /*
    $registry = mwgDataRegistry::getInstance();

    if ($this->client) return $client;

    $repository = UPDATER_SERVER;
    $channels   = 'bfm'; // $registry->get('channels'); //'bfm';
    $isnid      = '257-dw8ws-N1-rn2r9bzv'; // '5-ruzqq-N1-fgtwg6gm'; // $registry->get('isnid');
    $machnineid = 0; // $registry->get('machineid');

    $client = new intellispireNetworkClient($repository, $channels, $isnid, $machineid);
    */    

    $client = new simpleClient();
    return $client;
  }


  function getInstalledVersion($package) {
    $registry = mwgDataRegistry::getInstance();
    $extensions =  $registry->findExtensions();
    if (isset($extensions[$package])) {
      $serial = $extensions[$package]['serial'];
    } else {
      $serial = 0;
    }
    return $serial;
  }

  function retrievedownloadlink($package) {
    $client = $this->getClient();
    $link = $client->retrievedownloadlink($package, $this->getInstalledVersion($package));
    return $link;
  }

  function checkAuth($username, $passwrd) {
    $client = $this->getClient();
    try {
      $client->check($username, $password);      
      return true;
    } catch (Exception $e) {
      return false;
    }
  }


  function retrieveManifest() {
    $client = $this->getClient();
    try {
      $result = $client->retrievemanifest($channels, UPDATER_VERSION);
    } catch (Exception $e) {
      throw new Exception('Cannot retrieve manifest. Please check your account status and  try again.');
    }

    $yml = $result['payload'];
    $f = fopen(UPDATER_MANIFEST, 'w+');
    if (!$f) throw new Exception("Cannot write manifest: " . UPDATER_MANIFEST);
    fwrite($f, "#<?php die(); ?>\n$yml");
    fclose($f);

    return $yml;
  }

  function getManifest($force = false) {
    if ($this->manifest && !$force) {
      return $this->manifest;
    }

    if (file_exists(UPDATER_MANIFEST)) {
      // Update every 12 hours
      $mtime = filemtime(UPDATER_MANIFEST);
      if (time() - $mtime > 12*60*60)  $force = true;
    }  else {
      $force = true;
    }

    if ($force) {
      $this->retrieveManifest();
    }

    $this->manifest = new Manifest('bfm');
    $this->manifest->loadManifest(UPDATER_MANIFEST, $force);
    return $this->manifest;
  }

}





