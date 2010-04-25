<!-- admin.genstaller.view.php -->
<form method="post">
 <input type="hidden" name="c" value="genstaller">
 <input type="hidden" name="t" value="loadmanifest">
 <input type="submit" value="Refresh Software List">
</form>

    <form method="post">
      <input type="hidden" name="c" value="genstaller">
      <input type="hidden" name="t" value="install">
      Url to Package: <input type="text" name="url" size="60"> 
      <input type="submit" value="Install">
    </form>

    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="c" value="genstaller">
      <input type="hidden" name="t" value="install">
      Upload Package: <input type="file" name="package" size="60"> 
      <input type="submit" value="Install">
    </form>



<table width="100%">
<tr>
  <td><b>Name</b></td>
  <td><b>Type</b></td>
  <td><b>Description</b></td>
  <td><b>Version</b></td>
  <td><b>Action</b></td>
</tr>
<?php foreach($items as $id => $item) { ?>
<tr>
  <td><Xa href="?c=genstaller&t=details&id=<?php echo $id ?>"><?php echo $item['name'] ?></Xa></td>
  <td><?php echo $item['type']?></td>
  <td><?php echo $item['title']?></td>
  <td><?php echo $item['version']; ?></td>
  <td>
<?php
  $task   = 'install';
  $submit = 'install';

  if (isset($extensions[$id])) {
    $installed_ext = &$extensions[$id];
    // This has already been installed
/*
print "<pre>\n";
print_r($extensions[$id]);
print_r($item);
print "</pre>\n";
*/
    if ($installed_ext['serial'] >= $item['serial']) {
      print "installed</td></tr>\n";
      continue;
    } else {
      if (isset($item['updates']) && in_array($installed_ext['serial'], $item['updates'])) {
        // We can be updated
        $upgrades = $item['upgrades']; // an array
        $task   = "upgrade";
        $submit = "Upgrade";
      }
    }
  }
?>
<form method="post">
 <input type="hidden" name="c" value="genstaller">
 <input type="hidden" name="t" value="<?= $task ?>">
 <input type="hidden" name="id" value="<?= $id ?>">
 <input type="submit" value="<?= $submit ?>">
</form>
  </td>
</tr>
<?php } ?>
</table>

