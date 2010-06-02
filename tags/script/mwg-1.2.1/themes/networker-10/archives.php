<?php get_header(); ?>

<div id="container">

	<?php get_header(); ?>

<div id="content">
<div class="post">
<h2>Archives</h2>
<h3>Month:</h3>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h3>Categories:</h3>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

</div>	
</div>

	
</div>

<?php get_sidebar(); ?>

<?php get_footer() ?>

</div></body>
</html>