<?php

class menuActions extends mwgActions {

  function doMainmenuView(mwgRequest $request, mwgResponse $response)   {    
    $active_menu = $request->get('menu', $_SESSION['menu']);
    $_SESSION['menu'] = $active_menu;
    
    $menu  = 'menu_' . $active_menu .'_active';
    $response->$menu = 'gt-active';

    $gs = BMGenStaller::getInstance();

    $fullmenu = $gs->registry->getMenu();

    $menu = '';
    foreach ($fullmenu as $k => $v) {
      if (is_scalar($v)) {
        $menu .= "<li><a href='controller.php?c=$k&menu=extensions'>$v</a>";

        $menu .= "</li>\n";
      }
    }
    $response->components_menu = $menu;
  }

}
