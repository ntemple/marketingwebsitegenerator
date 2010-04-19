<?php

defined('_MWG') or die ('Restricted Access');

define('UPDATER_SERVER',  'http://www.intellispire.com/network/server51/soap.php');
define('UPDATER_VERSION', 22);
define('UPDATER_MANIFEST', BMGHelper::path(GENSTALL_BASEPATH . '/config/manifest.yml.php'));

require_once ('isnclient/utils.inc.php');
require_once ('isnclient/intellispireNetworkClient.class.php');
require_once ('isnclient/manifest.class.php');

class modelGenstaller {

  var $client;
  var $manifest;

  function getClient() {

    $registry = BMGenRegistry::getInstance();

    if ($this->client) return $client;

    $repository = UPDATER_SERVER;
    $channels   = 'bfm'; // $registry->get('channels'); //'bfm';
    $isnid      = '257-dw8ws-N1-rn2r9bzv'; // '5-ruzqq-N1-fgtwg6gm'; // $registry->get('isnid');
    $machnineid = 0; // $registry->get('machineid');

    $client = new intellispireNetworkClient($repository, $channels, $isnid, $machineid);

    return $client;
  }

  function retrievedownloadlink($package) {
    $client = $this->getClient();
    $link = $client->retrievedownloadlink($package, $this->getInstalledVersion($package));
    return $link;
  }

  function getInstalledVersion($package) {
    $registry = BMGenRegistry::getInstance();
    $extensions =  $registry->findExtensions();
    if (isset($extensions[$package])) {
      $serial = $extensions[$package]['serial'];
    } else {
      $serial = 0;
    }
    return $serial;
  }


  function retrieveManifest() {

    $client = $this->getClient();

    $result = $client->retrievemanifest($channels, UPDATER_VERSION);

    if ($result['code'] == 200) {
      $yml = $result['payload'];
      $f = fopen(UPDATER_MANIFEST, 'w+');
      if (!$f) throw new Exception("Cannot write manifest: " . UPDATER_MANIFEST);
      fwrite($f, "#<?php die(); ?>\n$yml");
      fclose($f);
    } else {
      throw new Exception('Cannot retrieve manifest. Please try again.(' . $result['code'] . ')');
    }
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





