


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
<iframe width="100%" height="600%" src="http://marketingwebsitegenerator.com/update.php?v=<?php echo $current ?>" frameborder="0" name="i1" />
