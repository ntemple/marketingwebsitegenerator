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

class editorActions extends mwgActions {

  function doDefaultView(mwgRequest $request, mwgResponse $response) {

    
    $response->includeHeaderFile('editor_default_view.js');

//    $response->editor = 'editarea';
//    $response->includeHeaderFile('editor_editarea.js');      

//    $response->editor = 'tinymce';
//    $response->includeHeaderFile('editor_tinymce.js');  

    $response->noeditor = true;
    
    $mwg = MWG::getInstance();
    $files = $mwg->listFiles(MWG_BASE . '/templates');
    sort($files);

    $filelist = array(
     '' => 'Select a File'
    );
    
    $db = MWG::getDb();
    $data = $db->get_results('select * from templates', $file);
    
    foreach($files as $file) {
      $r = $db->get_row('select name from templates where filename=?', $file);
      if ($r) {
        $dfile = "$file ($r[name])";
      } else {
        $dfile = $file;
      }
     $filelist[$file] = $dfile;     
    }

    $response->setSelect('filename', $filelist);
    $response->files = $files; 
    $response->filecontent = '';      
 
    $filename = $request->get('filename'); 
    if ($filename) {
      $contents =  file_get_contents(MWG_BASE . '/templates/' . $filename);
      $response->set('filecontent', $contents);
      $response->set('filename', $filename);
      $description = $db->get_value('select description from templates where filename=?', $filename);
      if (! $description) $description = 'None Available';
      $response->set('description',  $description);

      if (stripos($contents, '</head>') === false) {
        $response->initEditor();
        $response->noeditor = false;
      }

    }

  }

  function doDefaultStore(mwgRequest $request, mwgResponse $response) {

    $filename = $request->get('filename');
    $content  = $request->get('filecontent');

    if (file_exists(MWG_BASE . '/templates/' . $filename)) {
      file_put_contents(MWG_BASE . '/templates/' . $filename, $content);
      $response->setFlash("<b>$filename</b> Saved");
    } else {
      $response->setFlash('Could not save ' . $filename);
    }
    return $response->route('editor', 'default', 'filename=' . $filename);
  }
  
}
