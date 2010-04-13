<?php
class BMGHelper {

  static function _req($name, $value = null) {
    if (@isset($_REQUEST[$name])) return $_REQUEST[$name];
    return $value;
  }

  // Fix the path for Windows
  static function path($f) {
    if (DS == '/') return $f;
    return str_replace('/', DS, $f);
  }

  static function url($uri) {
    return GENSTALL_URLROOT . '/'. $uri;
  }

  static function url_retrieve($url, $query = '') {
      require_once(BMGHelper::path(GENSTALL_BASEPATH . '/lib/curlemu/libcurlemu.inc.php'));

      if (is_array($query)) {
         $query= http_build_query();
      }

      if ($query) {
        $url .= '?' . $query;
      }

      return self::url_retrieve_curl($url);
  }

  static function url_retrieve_curl($url, $timeout = 300)
  {
      if (!function_exists('curl_version'))
      {
          throw new Exception('Curl not loaded, cannot retrieve file.');
      }

      $ch = curl_init();
      $timeout = $timeout;
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

      // Getting binary data
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
      $contents = curl_exec($ch);
      curl_close($ch);
      return $contents;
  }

  static function unzip($file, $to) {
    require_once(BMGHelper::path(GENSTALL_BASEPATH . '/lib/pclzip.php'));

    $archive = new PclZip($file);
    $return  = $archive->extract($to);
  }

  function rmdir_recurse($path) {
    $path= rtrim($path, '/').'/';
    $handle = opendir($path);
    for (;false !== ($file = readdir($handle));)
        if($file != "." and $file != ".." ) {
            $fullpath= $path.$file;
            if( is_dir($fullpath) ) {
                rmdir_recurse($fullpath);
            } else {
                unlink($fullpath);
            }
    }
    closedir($handle);
    rmdir($path);
  }

   static function safe_ini_get($string)
  {
      $value = strtolower(ini_get($string));

      switch ($value)
      {
        case 'on':
        case '1':
        case 'yes':
        case 'true':
            return 1;
        default: return 0;
      }
  }

  function dir_copy($srcdir, $dstdir, $offset = '', $verbose = false)
  {
    // A function to copy files from one directory to another one, including subdirectories and
    // nonexisting or newer files. Function returns number of files copied.
    // This function is PHP implementation of Windows xcopy  A:\dir1\* B:\dir2 /D /E /F /H /R /Y
    // Syntaxis: [$returnstring =] dircopy($sourcedirectory, $destinationdirectory [, $offset] [, $verbose]);
    // Example: $num = dircopy('A:\dir1', 'B:\dir2', 1);

    // Original by SkyEye.  Remake by AngelKiha.
    // Linux compatibility by marajax.
    // ([danbrown AT php DOT net): *NIX-compatibility noted by Belandi.]
    // Offset count added for the possibilty that it somehow miscounts your files.  This is NOT required.
    // Remake returns an explodable string with comma differentiables, in the order of:
    // Number copied files, Number of files which failed to copy, Total size (in bytes) of the copied files,
    // and the files which fail to copy.  Example: 5,2,150000,\SOMEPATH\SOMEFILE.EXT|\SOMEPATH\SOMEOTHERFILE.EXT
    // If you feel adventurous, or have an error reporting system that can log the failed copy files, they can be
    // exploded using the | differentiable, after exploding the result string.
    //
    if(!isset($offset)) $offset=0;
    $num = 0;
    $fail = 0;
    $sizetotal = 0;
    $fifail = '';
    if(!is_dir($dstdir)) mkdir($dstdir);
    if($curdir = opendir($srcdir)) {
        while($file = readdir($curdir)) {
            if($file != '.' && $file != '..') {
//                $srcfile = $srcdir . '\\' . $file;    # deleted by marajax
//                $dstfile = $dstdir . '\\' . $file;    # deleted by marajax
                $srcfile = $srcdir . '/' . $file;    # added by marajax
                $dstfile = $dstdir . '/' . $file;    # added by marajax
                if(is_file($srcfile)) {
                    if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
                    if($ow > 0) {
                        if($verbose) echo "Copying '$srcfile' to '$dstfile'...<br />";
                        if(copy($srcfile, $dstfile)) {
                            touch($dstfile, filemtime($srcfile)); $num++;
                            chmod($dstfile, 0777);    # added by marajax
                            $sizetotal = ($sizetotal + filesize($dstfile));
                            if($verbose) echo "OK\n";
                        }
                        else {
                            echo "Error: File '$srcfile' could not be copied!<br />\n";
                            $fail++;
                            $fifail = $fifail.$srcfile.'|';
                        }
                    }
                }
                else if(is_dir($srcfile)) {
                    $res = explode(',',$ret);
//                    $ret = dircopy($srcfile, $dstfile, $verbose); # deleted by patrick
                    $ret = dir_copy($srcfile, $dstfile, $verbose); # added by patrick
                    $mod = explode(',',$ret);
                    $imp = array($res[0] + $mod[0],$mod[1] + $res[1],$mod[2] + $res[2],$mod[3].$res[3]);
                    $ret = implode(',',$imp);
                }
            }
        }
        closedir($curdir);
    }
    $red = explode(',',$ret);
    $ret = ($num + $red[0]).','.(($fail-$offset) + $red[1]).','.($sizetotal + $red[2]).','.$fifail.$red[3];
    return $ret;
  }

  static function debug($data) {
    return;
    ob_start();
    print_r($data);
    $msg = ob_get_clean();
    $f = fopen ("/tmp/t.txt", "a+");
    fwrite($f, $msg);
    fclose($f);
  }

  // alert, warn, info
  static function setFlash($class, $msg) {
    global $_flash;
    $_flash = array();
    $_flash['class'] = $class;
    $_flash['msg'] = $msg;
  }

  static function displayFlash() {
    global $_flash;
    if (!isset($_flash)) return;
    $class = $_flash['class'];
    $msg = $_flash['msg'];

    print "<p class='$class'>$msg</p>\n\n";
  }

}



