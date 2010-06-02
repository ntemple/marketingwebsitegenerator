<?php
/**
 * @version    $Id$
 * @package    MWG
 * @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
 * @license    GNU/GPL v2.0, see LICENSE.txt
 *
 * Marketing Website Generator is free software.
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

function mwg_theme_switcher($atts) {

  $mwg = MWG::getInstance();
  $themes = $mwg->theme->listThemes();

  $s = '<form action="" method="get" id="themeswitch"><select name="theme">';
  foreach ($themes as $theme => $type) {
    $selected = '';
    if ($theme == $mwg->theme) $selected = 'selected';
    $s .= "\n<option $selected>$theme</option>";
  }
  $s .= "\n</select> <input type='submit' value='Switch Themes'></form>\n";
  return $s;

}
add_shortcode('themeswitcher', 'mwg_theme_switcher');
