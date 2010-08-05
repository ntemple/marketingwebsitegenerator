<h1>Available Gizmos</h1>
<p>These gizmos are installed on your system and available for use. You must create a new instance by clicking on "New" to setup your gizmo. Each gizmo may be used more than once - as 
  many times as you need. <a href="http://www.intellispire.com/web/gizmos/" target="intellispire">Get more Gizmos from the Intellispire Marketplace.</a></p>
<div class="gt-content-box">
  <table class="gt-table" border="0">
    <thead>
      <tr>
        <th class="gt-table-col-checkbox"><a href="#"><img src="media/images/icons/tick.png" alt="check"></a></th>
        <th>Name</th>
        <th>Description</th>
        <th>&nbsp;</th>
      </tr>
    </thead>

    <tbody>
      <?php
        $count = 0;
        foreach ($gizmos_mf as $identity => $item) {              
          $count++;
          $link = "?c={$this->controller_name}&t=details&identity=$identity";
        ?>        
        <tr>
          <td><?php echo $count ?></td>
          <td><?php echo $item['name'] ?></td>
          <td><?php echo $item['title'] ?></td>
          <td><a href="<?php echo $link ?>" class="gt-btn-brown-medium gt-btn-left">New Instance</a></td>
        </tr>
        <?php        
        }
      ?>      
    </tbody>
  </table>
</div><!-- /content box -->

<?php
  // ################ Sidebar  ####################################3
  ob_start();

  /*
  <div class="gt-sidebar-content">
  <h3>Documentation</h3>
  <p><?php echo $gizmo->getDocumentation(); ?></p>  
  </div>
  */
?>

<div class="gt-sidebar-nav gt-sidebar-nav-brown">
  <h3>Quick Links</h3>
  <ul>
    <li><a href="controller.php?c=gizmo&t=shownew">New Gizmo</a></li>
    <li><a href="controller.php?c=gizmo">Manage Gizmos</a></li>
    <li><a href="controller.php?c=genstaller">Install Gizmos</a></li>
  </ul>
</div>

<!--/* OpenX Javascript Tag v2.8.5 */-->
<script type='text/javascript'><!--//<![CDATA[
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
  //]]>--></script>
  
<?php  
  /** @var mwgResponse */
  $response = MWG::getInstance()->response;
  $response->activateSidebar(ob_get_clean());    
  
      