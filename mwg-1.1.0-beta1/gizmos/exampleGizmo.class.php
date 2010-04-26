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

  defined('_MWG') or die ('Restricted Access');


  /**
  * Example Gizmo
  */
  class exampleGizmo extends mwgBaseGizmo {

    /**
    * Constructor called with the ident of
    * this class.
    * 
    * @param mixed $identity
    * @return mwgGizmoBase
    */
    function __construct($identity) {
      parent::__construct($identity);
    }

    /**
    * display the form to get the parameters
    * 
    * @param array $atts associative array of attributes from the database
    * @return string
    */

    function getAdminForm($atts = array()) {

      $params = shortcode_atts(array(
        'title' => '',
        'text' => '',           
      ), $atts);


      // The HTML below is the control form for editing options.
      ob_start();
    ?>
    <div>
      <label for="mywidget-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="mywidget-title" name="mywidget-title" value="<?php echo $params['title']; ?>" /></label>
      <label for="mywidget-text" style="line-height:35px;display:block;">Widget text: <input type="text" id="mywidget-text" name="mywidget-text" value="<?php echo $params['text']; ?>" /></label>
      <input type="hidden" name="mywidget-submit" id="mywidget-submit" value="1" />
    </div>
    <?php
    return ob_get_clean();
  }

  /**
  * Given a request, extract the data into a format you can use.
  * Assume someone submitted your AdminForm
  * The return will then be serialized and 
  * 
  * @param mwgRequest $request
  */

  function extractAdminFormData(mwgRequest $request) {
    if ($request->get('mywidget-submit') != 1) return null;

    $params = array(
    'title' => $request->get('mywidget-title', ''),
    'text' =>  $request->get('mywidget-text', ''),      
    );
    return $params;
  }

  /**
  * The main routine to display the gizmo.
  * 
  * In addition to the atts,
  * $this->params contans the params from the admin form
  * 
  * You can use $this->saveLocalData to serialize an array for later retrieval
  * and $this->getLocalData to get it back later.
  * 
  * @param mixed $atts shortcode style attributes if called via [gizmo id="x"]
  */

  function render($atts) {  
    // Allow attributes to override parameters
    extract(shortcode_atts(array(
    'title' => $this->params['title'],
    'text' =>  $this->params['text'],           
    ), $this->atts));

    return  "<h1>$title</h1>\n<h2>$text</h2>\n";

  }


  /* Events model.  override to hook into appropriate events 
  * Events are added occasionally, so check documentation.
  */

  // Events to overide
  /**
  * Called after the template has been processed, but before
  * shortcodes are run. Used to forcefully add or remove existing
  * shortcodes from pages.
  * 
  * @param mixed $document
  * @param mixed $content
  */
  // function beforeDoShortcode(mwgDocument $document, &$content) {  print "beforeDoShortcode {$this->id}\n"; }

  /**
  * Called just before the page is put together with the 
  * head, body and other components.  Great place to 
  * add javascript, analytics, etc to the document.
  * 
  * @param mixed $document
  * @param mixed $content
  */
  // function beforeDocumentRender(mwgDocument $document, &$content) {  print "beforeDocumentRender {$this->id}\n"; }

  /**
  * Last call before the page is displayed.
  * 
  * @param mixed $page
  */
  // function afterDocumentRender(&$page) {  print "afterDocumentRender {$this->id}\n"; }

}



