<?php

class editorActions extends mwgActions {

  function doDefaultView(mwgRequest $request, mwgResponse $response) {

    
    $response->includeHeaderFile('editor_default_view.js');
/*    
    $response->editor = 'editarea';
    $response->includeHeaderFile('editor_editarea.js');      
*/    

    $response->editor = 'tinymce';
    $response->includeHeaderFile('editor_tinymce.js');  
    
    $mwg = MWG::getInstance();
    $files = $mwg->listFiles(MWG_BASE . '/templates');
    sort($files);

    $filelist = array(
     '' => 'Select a File'
    );
    foreach($files as $file) {
     $filelist[$file] = $file;
    }

    $response->setSelect('filename', $filelist);
    $response->files = $files; 
    $response->filecontent = '';      
 
    $filename = $request->get('filename'); 
    if ($filename) {
      $response->set('filecontent', file_get_contents(MWG_BASE . '/templates/' . $filename));
      $response->set('filename', $filename);
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
