<!-- admin.genstaller.view.php -->
<table width="100%">
  <tr>
    <td align="center"><b>Preview</b></td>
    <td><b>Name</b></td>
    <td><b>Type</b></td>
  </tr>
  <?php foreach($items as $item) { ?>
    <tr>
      <td align="center">
      <?php 
          if (isset($item->preview)) {
            echo "<a href='{$item->preview}' target='preview'><img src='{$item->preview}' width='80'></a>";
          } else {
            echo "No Preview";
          }  
        ?>
        <form method="post">
        <input type="hidden" name="c" value="themes">
        <input type="hidden" name="t" value="activate">
        <input type="hidden" name="id" value="<?= $item->id ?>">
        <input type="submit" value="Activate"></td>
      </form>        
      </td>
      <td><?php echo $item->name ?></td>
      <td><?php echo $item->type ?></td>
      <td>
      </td>
    </tr>
    <?php } ?>
</table>
<b>Please Note:</b> The ThemeSwitcher plugin is installed! just use the shortcode: [themeswitcher] in your front-end content to 
enable your users to switch themes.
