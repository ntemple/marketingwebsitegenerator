<?php

class editorActions extends mwgActions {

  function doDefaultView(mwgRequest $request, mwgResponse $response) {

    $response->includeHeaderFile('editor_view.1.js.html');
    $response->includeHeaderFile('editor_view.2.js.html');

    $mwg = MWG::getInstance();
    $files = $mwg->listFiles(MWG_BASE . '/templates');
    sort($files);

    $filelist = array();
    foreach($files as $file) {
     $filelist[$file] = $file;
    }

    $response->setSelect('select', $filelist);
    $response->files = $files; 
    $response->filecontent = '';  
 
    $filename = $request->get('filename'); 
    if ($filename) {
      $response->set('filecontent', file_get_contents(MWG_BASE . '/templates/' . $filename));
      $response->set('filename', $filename);
      $response->set('select', $filename);
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
