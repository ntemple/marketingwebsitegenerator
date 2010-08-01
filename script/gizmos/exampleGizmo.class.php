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
* example Gizmo
*/
class exampleGizmo extends mwgBaseGizmo {

  /* Modify these functions */

  function getFields() {
    return array(
    );
  }
  
  function getName() { return 'example'; }


  /**
  * display the form to get the parameters
  * 
  * @param array $atts associative array of attributes from the database
  * @return string
  */

  function getAdminForm($atts = array()) {

    $fields = $this->getFields();
    $params = shortcode_atts($fields, $atts);

    $out = $this->generateAdminForm($fields, $params, false);
    // The HTML below is the control form for editing options.
    /*      
    ob_start();
    ?>
    <?php
    $out = ob_get_clean();
    */    

    return "<div>\n$out</div>\n";
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
    $data = shortcode_atts($this->params, $atts);
    extract($data);

    $out = '';

    return $out;
  }



  /**
  * Render a Gizmo similiar to to a wordpress widget
  * 
  *   $defaults = array(
  *    'name'          => sprintf(__('Sidebar %d'), $i ),
  *    'id'            => 'sidebar-$i',
  *    'before_widget' => '<li id="%1$s" class="widget %2$s">',
  *    'after_widget'  => '</li>',
  *    'before_title'  => '<h2 class="widgettitle">',
  *    'after_title'   => '</h2>' 
  *  ); 
  *
  * 
  * @param mixed $atts
  */
  function render_as_widget($atts) {
    if (isset($atts['before_title'])) echo $atts['before_title'];
    echo $this->title;
    if (isset($atts['after_title'])) echo $atts['after_title'];
    if (isset($atts['before_widget'])) echo $atts['before_widget'];
    echo $this->render($atts);
    if (isset($atts['after_widget'])) echo $atts['after_widget'];
  }


  /* 
  * Events model.  override to hook into appropriate events
  * Events are added occasionally, so check documentation in
  * lib/mwg/mwgBaseGizmo.php.
  */

  /**
  * Called after a signup has been completed
  * 
  * @param mixed $member_id
  * @param mixed $password
  */
  //function afterSignup($member_id, $password) { print "afterSignup($member_id, $password)\n"); }

  /**
  * Called before a signup. Allows you to modify the POST data if necessary
  * 
  */
  //function beforeSignup() { print "beforeSignup()\n"); }


  /**
  * Called after the template has been processed, but before
  * shortcodes are run. Used to forcefully add or remove existing
  * shortcodes from pages.
  * 
  * For example, use:
  * $this->add_shortcode($shortcode, $method);
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

