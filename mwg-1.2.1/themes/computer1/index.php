<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if ( $my->id ) {
	initEditor();
}
?>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/template_css.css\" type=\"text/css\"/>" ; ?>
<!--[if lte IE 6]>
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/ie6.css\" type=\"text/css\"/>" ; ?>
<![endif]-->

<link rel="alternate" type="application/rss+xml" title="<?php echo $mosConfig_sitename?>" href="<?php echo $mosConfig_live_site;?>/index.php?option=com_rss&feed=RSS2.0&no_html=1" />
</head>

<body id="page_bg">

<div id="under">
	<div id="bottom">
	
		<div id="wrapper">
			<div id="top_menu">	
				<?php include'menu.php'; ?>	
			</div>
			
				<div class="holder_m">
					<div class="holder_l">
						<div class="holder_r">
							<div id="header">
								<div id="header_img">
									<table cellspacing="0" cellpadding="0" class="header_logo">
										<tr>
											<td>
												<div id="logo">
													<h1><?php echo $GLOBALS['mosConfig_sitename']?></h1>
												</div>	
											</td>
										</tr>
									</table>
										<div id="pathway">
											<?php mosPathWay(); ?>
										</div>
								</div>
							</div>
						<div class="content_m">
							<div class="content_gradient">								
								<div id="content">
								
									<div id="leftcolumn">					
										<?php mosLoadModules('left' , '-3'); ?>
										<? $sg = 'banner'; include "templates.php"; ?>
									<div class="clr"></div>	
									</div>
									<?php if (mosCountModules('right')){ ?>
									<div id="main"> 
										<? } else { ?>						
									<div id="main_full">
										<? } ?>
										<?php mosMainBody(); ?>
										
										<?php if (mosCountModules('user2')){ ?> 
										<div class="latest_news">
											<?php mosLoadModules ( 'user2' , '-3'); ?>
										</div> 
										<? } else { ?> 
										<? } ?>
										
										<?php if (mosCountModules('newsflash')){ ?> 																												
										<div id="news_flash">
											<?php mosLoadModules('newsflash', '-3'); ?>
										</div>															
										<? } else { ?>	
										<? } ?>
										<div class="clr"></div>															
									</div>	
																							
									
									<?php if (mosCountModules('right')){ ?>	
									<div id="rightcolumn">
										<?php mosLoadModules('right' , '-3'); ?>				
									</div>					
									<? } ?>				
									<div class="clr"></div>																									
								</div>										
								</div>
								<div class="content_bottom"></div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
				

		<div id="footer">
			<p class="copyright"><? $sg = ''; include "templates.php"; ?></p>
		</div>
		

	</div>
</div>
</body>
</html>