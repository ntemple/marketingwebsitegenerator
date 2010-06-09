<!-- admin.genstaller.view.php -->
<?php
  //  MWG::getInstance()->response->contentbox('Extension Manager');
  ob_start();
?>

<!-- Sidebar Navigation -->
<div class="gt-sidebar-nav gt-sidebar-nav-brown">
  <h3>Quick Links</h3>
  <ul>
    <li><a href="controller.php?c=genstaller&t=loadmanifest">Refresh Software List</a></li>
    <li><a href="controller.php?c=updates">Check for Updates</a></li>
  </ul>
</div><!-- /Sidebar Navigation -->



<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="c" value="genstaller">
  <input type="hidden" name="t" value="install">
  <h3 class="gt-form-head">Upload a Package File</h3>       
  <div class="gt-form gt-content-box">
    <div class="gt-form-row gt-width-100">
      <label>Package File:<img src="media/images/icons/help.png" title="Select a .zip package containing an MWG extension from your harddrive."></label>
      <input class="gt-form-file-upload" type="file" name="package">  
      <input type="submit" class="gt-btn-brown-medium" value="Upload &amp; Install" />
    </div>                    
  </div>        
</form>

<form method="post">
  <input type="hidden" name="c" value="genstaller">
  <input type="hidden" name="t" value="install">
  <h3 class="gt-form-head">Install Package from URL</h3>       
  <div class="gt-form gt-content-box">
    <div class="gt-form-row gt-width-100">
      <label>Url to Package:<img src="media/images/icons/help.png" title="Enter the web address of a .zip package containing a MWG extension."></label>
      <input class="gt-form-text" type="text" name="package">  
      <input type="submit" class="gt-btn-brown-medium" value="Install" />
    </div>                    
  </div>        
</form>

<form method="post">
  <input type="hidden" name="c" value="genstaller">
  <input type="hidden" name="t" value="activate">
  <h3 class="gt-form-head">Activate Network</h3>       
  <div class="gt-form gt-content-box">
    <div class="gt-form-row gt-width-66">
      <label>Email:<img src="media/images/icons/help.png" title="Enter your MWG Username"></label>
      <input class="gt-form-text" type="text" name="username" value="<?php echo $username ?>">  
    </div>           
    <div class="gt-form-row gt-width-66">
      <label>Password:<img src="media/images/icons/help.png" title="Enter your MWG Password"></label>
      <input class="gt-form-text" type="password" name="password">  
      <input type="submit" class="gt-btn-brown-medium" value="Activate" /> <a href="http://marketingwebsitegenerator.com/club/signup.php">Create An Account</a>
    </div>                                 

  </div>        
</form>


<?php
  $sidebar = ob_get_clean();
  MWG::getInstance()->response->activateSidebar($sidebar);
?>
<h1>Extension Manager</h1>
<h2 class="gt-table-head">Available Extensions</h2>
<!-- content box -->
<div class="gt-content-box">
  <table class="gt-table" border="0">
    <thead>
      <tr>
        <th class="gt-table-col-checkbox"><a href=""><img src="media/images/icons/tick.png" alt="check"></a></th>
        <th>Name</th>
        <th>Type</th>
        <th>Version</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
  <?php 
//  print_r($items);
//  die();
//  
  foreach($items as $id => $item) { ?>
    <tr>
      <td><input  type="checkbox"></td>
      <td><?php echo $item['name'] ?></td>
      <td><?php echo $item['type']?></td>
      <td><?php echo $item['version']; ?></td>
      <td>
        <?php
//          if (isset($extensions[$id])) {
//            $installed_ext = &$extensions[$id];
            // This has already been installed
//            /*
//            print "<pre>\n";
//            print_r($extensions[$id]);
//            print_r($item);
//            print "</pre>\n";
//            */
//            if ($installed_ext['serial'] >= $item['serial']) {
//              print "installed</td></tr>\n";
//              continue;
//            } else {
//              if (isset($item['updates']) && in_array($installed_ext['serial'], $item['updates'])) {
                // We can be updated
//                $upgrades = $item['upgrades']; // an array
//                $task   = "upgrade";
//                $submit = "Upgrade";
//              }
//            }
//          }
  
          $task   = 'install';
          $submit = 'install';
        ?>
        <form method="post">
          <input type="hidden" name="c" value="genstaller">
          <input type="hidden" name="t" value="<?= $task ?>">
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="submit" value="<?= $submit ?>" Xclass="gt-btn-brown-small">
        </form>
      </td>
    </tr>
    <?php } ?>
        </tbody>
    </table>
    </div><!-- /content box -->



