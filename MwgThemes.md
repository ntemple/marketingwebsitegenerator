#introduction to themes in MWG

# Themes #

Themes control the look and feel (decoration) of your website.  Sometimes themes are also  called "templates", however to avoid confusion with other parts of the system, "themes" is the preferred term.

With MWG, you can handle themes in one of 4 different ways:
  * The legacy theme is controlled by the template [templates/homepage](http://code.google.com/p/marketingwebsitegenerator/source/browse/trunk/script/templates/main.html) The default theme is changed by editing this page.
  * The Wordpress Theme Subsystem runs some Wordpress themes
  * The Joomla! Theme Subsystem runs some legacy joomla 1.0 themes
  * (upcoming in 1.2) Native MWG themes are to be available shortly via the Smarty templating engine.


## Packaging a Theme ##
A Joomla, Wordpress or MWG theme must be a zip file with a single subdirectory that contains the name of the theme, and are loaded to the themes directory,
```
/ MWG ROOT
/themes/
/themes/nameoftheme/
/themes/nameoftheme/index.php <- main theme file
/themes/nameoftheme/nameoftheme.yml.php <- MWG Manifest
/themes/nameoftheme/(additional) Additional files a directories needed to run the theme. 
```

For the most part, Joomla and Wordpress themes can be installed as is, just add an appropriate manifest so that the system knows where to install it:


### Example Theme Manifest ###
```
#<?php die(); ?>
identity: mwg.themes.mytheme-10
name: My MWG Theme
title: My MWG Theme
version: 1.0.0
api:     1.1.0
compatibility:
  - mwg
  - php5
type: thme
meta:
  copyright:  (c)2010 Intellispire, LLC
  license:    BY-SA
```



## Implementation ##


  * MWG creates the "inner" content using the existing template system, and "buffers" the output. This becomes the "post" (wordpres) or "content" (joomla)

  * if a theme is activated, it then loads a basic "compatibility" set of functions and "runs" the theme (wordpress or Joomla! - index.php in the theme)

  * the output is buffered, and the the entire page is parsed by MWG, and fixups are added (shortcodes, like headers and titles)


To make the theme work "correctly": install it, then view the site, see what breaks, and go in and fix it - preferably in the core, rather than the theme - and send in a patch.

Each iteration gives us better core compatibility.

The files you want are:
code.google.com/p/marketingwebsitegenera...pt/components/themes

I'd like to move those to /lib/compat at some point, so we can have somewhat complete compatibility subsystems, and not tie those into the core.

