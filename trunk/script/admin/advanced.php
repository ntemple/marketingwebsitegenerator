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

  include("inc.top.php");
  $db = MWG::getDb();
  $request = MWG::getInstance()->request;
  $response = MWG::getInstance()->response;

  if ($request->isPost()) {

    $fields = $db->get_column('select name from mwg_setting');
    foreach ($fields as $name) {
      if (isset($_POST[$name]) && $_POST[$name]) {
        $value = trim($_POST[$name]);
        $db->query('update mwg_setting set value=? where name=?', $value, $name);
        
        switch($name) {
          case 'site_title':          $db->query('update settings set value=? where name=?', 'keywords', $value); break;
          case 'site_description':    $db->query('update settings set value=? where name=?', 'description', $value); break;
          case 'email_from_name':     $db->query('update settings set value=? where name=?', 'emailing_from_name', $value); break;
          case 'email_from_address':  $db->query('update settings set value=? where name=?', 'emailing_from_email', $value); break;
        }
        
      }
    }
    $response->setFlash('Settings Stored');
    $response->redirect('advanced.php?menu=settings', 'Settings Saved');
    exit();    
  }

  $response->getFlash();



  function form_item($ff) {
    $value = $ff['value'];
    if (! $value) $value = $ff['default_value'];


    switch($ff['input_type']) {
      case 'input': echo "<input class='gt-form-text' type='text' name='$ff[name]' value='$value' >\n"; break;
      case 'hidden'; break;
      case 'select':
        $options = unserialize($ff['options']);
        print "<select name='$ff[name]'>\n";
        foreach ($options as $val => $label) {
          $selected = '';
          if ($val == $value) $selected = 'selected';
          print "<option value='$val' $selected>$label</option>\n";
        }
        print "</select>";
        break;
      default: print "<pre>" . print_r($ff, true) .print "</pre>\n";
    }
  }  
?> 
<h1>Advanced Site Settings</h1>
<form method="POST">
  <div class="gt-form-row">
    <input type="submit" name="_cmd_default" value="Save" class="gt-btn-green-medium" />
  </div>

  <?php
    $cats = $db->get_column('select distinct category from mwg_setting');
    foreach ($cats as $cat) {
    ?>

    <h2 class="gt-form-head"><?php echo $cat ?></h2>
    <div class="gt-form gt-content-box">
      <?php 
        $results = $db->get_results('select * from mwg_setting where category=? order by rank', $cat);
        foreach ($results as $ff) {
        ?>
        <div class="gt-form-row gt-width-66">
          <label><?php 
              echo $ff['label'];
              if ($ff['help_text'])  echo "<img src='media/images/icons/help.png' title='$ff[help_text]'>";
          ?></label>                      
          <?php form_item($ff); ?>
        </div><!-- /form row -->

        <?php } ?>
    </div>
    <?php  }  // Categories  ?>
  <div class="gt-form-row">
    <input type="submit" name="_cmd_default" value="Save" class="gt-btn-green-medium" />
  </div>
</form>

<?php
  /** @var mwgResponse */
  $response = MWG::getInstance()->response->activateSidebar(
  '<div class="gt-sidebar-content">
  <h3>Advanced Settings</h3>
  <p>This settings page allows you to control additional aspects of your website</p>
  </div>'
  );
	include("inc.bottom.php");

