<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Marketing Webite Generator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language=JavaScript src='../editor/scripts/innovaeditor.js'></script>
    <script src="../js/functions.js" language="javascript" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset-fonts-grids.css">
    <link href="media/css/admin.css" rel="stylesheet" type="text/css">
    <?php echo $head ?>
    <style type="text/css">
      <!--
      body {    
        background-color: #ffffff;
      }

      table {border-collapse: collapse;}
      
      .header, .footer, .header a, .footer a { 
        background-color: #008000;        
        color: #fff;
      }
      .menu, .menu a {
        border-bottom: 1px solid; 
        border-color: #808080;
        padding: 1px 4px;
        background-color: #07A23A;
        color: #fff;
      }
      .submenu {
        border-bottom-style: solid; 
        border-bottom-width: 1; 
        padding-left: 4; 
        padding-right: 4; 
        padding-top: 1; 
        padding-bottom: 1;
        border-color: #808080;
        background-color: #E5FBEC;        
      }
      .bold { font-weight: bold; }
      .toptitle { font-size: 212%; }

      .a_selected {
        color: #FFFFFF;
        font-size: larger;
        font-weight: bold;
      }
      -->
    </style>
  </head>
  <body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" vlink="#0000FF" bgcolor="#ffffff">
    <div id="doc4">
      <table border="2" cellpadding="3" cellspacing="0" bordercolor="#000000" width="974" bgcolor="#FFFFFF">
        <tr>
          <td width="100%">
            <div align="center">
              <center>

                <table width="970" border="0" cellpadding="5" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
                  <tr class="header bold">
                    <td align="left" valign="top">
                      <h2 class="toptitle"><?php echo $sitename ?> Administrator</h2>
                    </td>
                    <td align="right" valign="top">MWG Version:&nbsp;<?php echo $version?>&nbsp;<a href="logout.php">Logout</a> | <a href="<?php echo MWG_BASEHREF ?>" target="_blank" class="a">Preview</a></td>
                  </tr>
                  <tr>
                    <td class="menu" width="80%" colspan="2" elign="center">
                      <p align="center" class="a">
                        <?php echo $menu ?> <br />
                        <?php echo $component_menu; ?>
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td class="submenu" colspan="2" width="80%" align="center">
                      <?php echo $submenu ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" width="100%">
                      <?php echo $message ?>
                      <?php echo $content; ?>
                    </td>
                  </tr>
                  <tr class="footer bold">
                    <td>
                      <p>&copy;2010 - powered by <a href="http://marketingwebsitegenerator.com" target="mwg" class="a">MarketingWebsiteGenerator.com</a><p>
                    </td>
                    <td align='right'>
                      <p><a href="http://www.intellispire.com/forum" target="mwg" class="a">Community Forum</a></p>
                    </td>
                  </tr>
                </table>
              </center>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
