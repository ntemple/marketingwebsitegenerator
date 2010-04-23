


Your Version: <?php echo $current ?><br>
Latest Version: <?php echo $latest ?><br>
<?php 
    if ($needsUpdate) {
?>
<center>
      <form method="post">
        <input type="hidden" name="c" value="updates">
        <input type="hidden" name="t" value="upgrade">
        <input type="submit" value="Upgrade Now!"></td>
      </form>        
</center>      
<?php  } else { ?>
Congratulations! your site is fully patched!
<?php      
    }
?>

<h2>Please Note:</h2>
<p>This edition of MWG makes some minor changes to the main templates (main.html, etc).
Specifically, the contents of the HEAD section has been removed and they have been
cleaned up to be valid HTML.
<p>Please see the templates in the templates-updates directory, and update your main
theme templates.
<p>Note: if you are using Wordpres or Joomla! themes, no other action is required.

<!--
<iframe width="100%" height="600%" src="http://www.marketingwebsitegenerator.com/update.php" frameborder="0" name="i1" />
-->
