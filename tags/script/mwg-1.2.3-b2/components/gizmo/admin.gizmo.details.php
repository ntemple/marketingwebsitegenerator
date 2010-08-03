<?php 
  /** @var mwgBaseGizmo */
  $gizmo = $gizmo; // For IDE autocompletion
?>
<form method="post" action="controller.php?">
  <input type="hidden" name="c" value="<?php echo $this->controller_name ?>">
  <input type="hidden" name="t" value="gizmo_store">
  <input type="hidden" name="identity" value="<?php echo $gizmo->identity ?>">
  <input type="hidden" name="id" value="<?php echo $gizmo->id ?>">

  <input type="submit" name= "cmd_save"  class="gt-btn-green-small gt-btn-left" value="Save">
  <input type="submit" name= "cmd_apply" class="gt-btn-green-small gt-btn-left" value="Apply">

<br>
<br>  
<br>
<br>
  
  

<h2 class="gt-form-head">Gizmo Params</h2>
  
  <div class="gt-form gt-content-box">

    <div class="clearfix">
      <!-- left column -->
      <div class="gt-left-col">
        <div class="gt-form-row gt-width-66">
          <label>Name <img src="media/images/icons/help.png" title="The name is a friendly name so you know what this Gizmo is, it is not displayed."> </label>
          <input class="gt-form-text" name="name" type="text" value="<?php echo $gizmo->name ?>" />
        </div>
        <div class="gt-form-row gt-width-66">
          <label>Title<img src="media/images/icons/help.png" title="The title may be displayed by some Gizmos, for example, as a heading."></label>
          <input class="gt-form-text" name="title" type="text" value="<?php echo $gizmo->title ?>" />
        </div><!-- /form row -->

        <!-- form row -->
        <div class="gt-form-row gt-width-66">
          <label>Activate</label>
          <label class="gt-form-element-label"><input type="radio" name="active" class="gt-form-radio" value="1" <?php echo $check_active_1 ?>> Active</label>
          <label class="gt-form-element-label"><input type="radio" name="active" class="gt-form-radio" value="0" <?php echo $check_active_0 ?>> Inactive</label>
        </div><!-- /form row -->
      </div>

      <!-- right column -->
      <div class="gt-right-col">
        <!-- form row -->
        <div class="gt-form-row gt-width-66 clearfix">
<?php if ($gizmo->hasRenderAsWidget())  { ?>         
          <!-- form row -->
          <div class="gt-form-row gt-width-66">
            <label>Display Title</label>
            <label class="gt-form-element-label"><input type="radio" name="display_title" class="gt-form-radio" value="1" <?php echo $check_display_title_1 ?>> Yes</label>
            <label class="gt-form-element-label"><input type="radio" name="display_title" class="gt-form-radio" value="0" <?php echo $check_display_title_0 ?>> No</label>            
          </div><!-- /form row -->      


          <label>Display Position</label>
          <select name="position">
            <option <?php if (isset($select_position['Invocation'])) echo 'selected'; ?>>Invocation</option>
            <option <?php if (isset($select_position['Sidebar1']))   echo 'selected'; ?>>Sidebar1</option>
            <option <?php if (isset($select_position['Sidebar2']))   echo 'selected'; ?>>Sidebar2</option>
            <option <?php if (isset($select_position['right']))      echo 'selected'; ?>>right</option>
            <option <?php if (isset($select_position['left']))       echo 'selected'; ?>>left</option>
          </select>
          
          
<?php }  else { ?>
          <input type="hidden" name="position" value="None" />
<? } ?>
          <!-- form row -->
          <div class="gt-form-row gt-width-66">
            <label>Order</label>
            <input class="gt-form-text" type="text" name="ordre" size="3" value="<?php echo number_format($gizmo->ordre, 0) ?>">
          </div><!-- /form row -->      
        </div>
      </div>
    </div>
  </div>  

<?php if ($gizmo->hasAdminDisplay()) { ?>
  <h2 class="gt-form-head">Details</h2>
  <div class="gt-form gt-content-box">
    <div class="clearfix">
      <?php echo $gizmo->getAdminForm($gizmo->params) ?>
    </div>
  </div>
<?php } ?>

  <input type="submit" name= "cmd_save"  class="gt-btn-green-small gt-btn-left" value="Save">
  <input type="submit" name= "cmd_apply" class="gt-btn-green-small gt-btn-left" value="Apply">

</form>



<?php
  // ################ Sidebar  ####################################3
  ob_start();
?>
<div class="gt-sidebar-nav gt-sidebar-nav-brown">
  <h3>Quick Links</h3>
  <ul>
    <li><a href="controller.php?c=gizmo&t=shownew">New Gizmo</a></li>
    <li><a href="controller.php?c=gizmo">Manage Gizmos</a></li>
    <li><a href="controller.php?c=genstaller">Install Gizmos</a></li>
  </ul>
</div>


<?php if ($gizmo->id) { ?>
  <div class="gt-sidebar-content">
    <h3>Invocation</h3>
    <p>If this Gizmo is active, simply use the code [gizmo id="<?php echo $gizmo->id ?>"] on any page to display it.</p>
  </div>
  <?php } ?>    

<div class="gt-sidebar-content">
  <h3>Documentation</h3>
  <p><?php echo $gizmo->getDocumentation(); ?></p>  
</div>


<!--/* OpenX Javascript Tag v2.8.5 */-->
<Xscript type='text/javascript'><!--//<![CDATA[
  var m3_u = (location.protocol=='https:'?'https://openx.intellispire.com/delivery/ajs.php':'http://openx.intellispire.com/delivery/ajs.php');
  var m3_r = Math.floor(Math.random()*99999999999);
  if (!document.MAX_used) document.MAX_used = ',';
  document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
  document.write ("?zoneid=8");
  document.write ('&amp;cb=' + m3_r);
  if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
  document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
  document.write ("&amp;loc=" + escape(window.location));
  if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
  if (document.context) document.write ("&context=" + escape(document.context));
  if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
  document.write ("'><\/scr"+"ipt>");
  //]]>--></Xscript>
  
<?php  
  /** @var mwgResponse */
  $response = MWG::getInstance()->response;
  $response->activateSidebar(ob_get_clean());    
  
      
