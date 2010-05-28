<?php
/**
* @version    $Id$
* @package    MWG
* @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
* @license    GNU/GPL v2.0, see LICENSE.txt
*
* Marketing Website Generator is free software.
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// functions for install wizard
$perm_file="-rwxrwxrwx";
$perm_folder="drwxrwxrwx";


function execute_sql($filename, $autoincrementvalue)
{
  $q=new Cdb;
  FFileRead($filename, $content);
  $a=explode(";\n", $content);
  $k=0;
  while ($a[$k]!="")
  {
    $query=$a[$k];
    $q->query($query);
    $k++;
  }

  $secret = substr(md5(uniqid(rand(), true)), 0, 28);

  $q->query('ALTER TABLE members AUTO_INCREMENT=' . $autoincrementvalue);  
  $q->query("update settings set value='$secret' where name='secret_string'");

}

function FFileRead($name/*filename*/, &$contents/*returned contents of file*/)
{
  $fd = fopen ($name, "r");
  $contents = fread ($fd, filesize ($name));
  fclose ($fd);
}
function FFileWrite($name, $content, $w="w+")
{
  $filename = $name;
  $somecontent = $content;

  // Let's make sure the file exists and is writable first.
  if (is_writable($filename)) {

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, $w)) {
      echo "Cannot open file ($filename)";
      exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
      echo "Cannot write to file ($filename) please make sure that you chmod 777 templates folder";
      exit;
    }

    fclose($handle);

  } else {
    echo "The file $filename is not writable please make sure that you chmod 777 templates folder";
  }
}

function get_permissions($filename)
{
  $perms = fileperms($filename);
  if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
  } elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
  } elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
  } elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
  } elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
  } elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
  } elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
  } else {
    // Unknown
    $info = 'u';
  }
  // Owner
  $info .= (($perms & 0x0100) ? 'r' : '-');
  $info .= (($perms & 0x0080) ? 'w' : '-');
  $info .= (($perms & 0x0040) ?
  (($perms & 0x0800) ? 's' : 'x' ) :
  (($perms & 0x0800) ? 'S' : '-'));
  // Group
  $info .= (($perms & 0x0020) ? 'r' : '-');
  $info .= (($perms & 0x0010) ? 'w' : '-');
  $info .= (($perms & 0x0008) ?
  (($perms & 0x0400) ? 's' : 'x' ) :
  (($perms & 0x0400) ? 'S' : '-'));
  // World
  $info .= (($perms & 0x0004) ? 'r' : '-');
  $info .= (($perms & 0x0002) ? 'w' : '-');
  $info .= (($perms & 0x0001) ?
  (($perms & 0x0200) ? 't' : 'x' ) :
  (($perms & 0x0200) ? 'T' : '-'));
  return $info;
}



