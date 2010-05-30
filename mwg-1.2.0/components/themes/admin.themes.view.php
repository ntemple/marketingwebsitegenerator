


<!-- admin.genstaller.view.php -->
<h1 class="gt-table-head">Installed Themes</h1>
<div class="gt-content-box">
  <table class="gt-table gt-user-table" border="0">
    <tbody>
      <?php foreach($items as $item) { 
          if (! isset($item->preview)) {
//            $item->preview = 'media/images/gt/avatar.gif';
            $item->preview = 'media/images/icons/blank.png';
          }  
        ?>
       <tr>
        <td class="gt-avatar"><a href="<?php echo $item->preview ?>" class="lightbox"><img src="<?php echo $item->preview ?>"  width="53" height="53"></a></td>
        <td>
          <h4><a href="#"><?php echo $item->name ?></a></h4>
          <p><?php echo $item->description ?></p>
            <form method="post">
            <input type="hidden" name="c" value="themes">
            <input type="hidden" name="t" value="activate">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <input type="submit" name= "_cmd_activate_fe" value="Activate Frontend">
            <input type="submit" name= "_cmd_activate_be" value="Activate Backend">
          </form>        
          </p>
        </td>

        <td>
          <!-- Categories Sub Table -->
          <table class="gt-table-categories" border="0">
            <tbody><tr>
                <th>Type</th>
                <td><?php echo $item->type ?></td>
              </tr>
              <tr>
                <th>Id:</th>
                <td><?php echo $item->name ?></td>
              </tr>
            </tbody></table>
        </td>
      </tr>
<? } ?>      


    </tbody>
  </table>
</div><!-- /Content Box -->


<?php
  ob_start();
?>
<div class="gt-sidebar-content">
<h3>Theme Note</h3>
<p>The ThemeSwitcher plugin is installed! just use the shortcode: [themeswitcher] in your front-end content to 
enable your users to switch themes.</p>
<ul>
<li>[themeswitcher]: Display drop-down list to select a global theme.</li>
<!-- <li>[themeswitcher id="example"]: Force that page to theme with the name "example"</li>  -->
</ul>
</div>

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://openx.intellispire.com/delivery/ajs.php':'http://openx.intellispire.com/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=7");
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
  ob_start();  
?>
<script type="text/javascript" src="media/lightbox/js/jquery.lightbox-0.5.pack.js"></script>
<link rel="stylesheet" type="text/css" href="media/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
  $('a.lightbox').lightBox(); // Select all links with lightbox class
});
</script>
<?php
  $response->addHeader(ob_get_clean());
?>


