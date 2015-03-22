# Gizmos #

A Gizmo is the way you that you add functionality to any MWG site. It gives programmers full access to the  underlying object and event models, allowing for both ‘displayable’ and ‘behind the scenes’ changes to the page (if you care, we’re moving to a request-response model in the code).


# Details #

A gizmo consists of:
  * A single-word (alphanumeric) name in all lowercase. For example, the Gizmo name "example" may be chosen.
  * A class file called exampleGizmo.class.php, with 1 class: exampleGizmo that extends mwgBaseGizmo
  * The manifest file, exampleGizmo.yml.php

## Class File ##

The best place to start creating your own Gizmos is to look at the example Gizmo shipped with each release of the system. This file is constantly updated:

http://code.google.com/p/marketingwebsitegenerator/source/browse/trunk/script/gizmos/exampleGizmo.class.php

Each Gizmo MUST override the following functions:
  * function getAdminForm($atts): displays a form to collect additional data for this instance
  * function extractAdminFormData(mwgRequest $request): extract the data saved by the form

To display something when the gizmo is called, override:
  * function render($atts)

Optionally, you can also hook into the Events system (observer model), in order to
process various events as they flow through the system.

## Events (1.1) ##
  * beforeDoShortcode(mwgDocument $document, &$content)
  * beforeDocumentRender(mwgDocument $document, &$content)
  * afterDocumentRender(&$page)

## New Events (to be implemented) ##
  * atStart(mwgRequest $request, mwgDocument $document)

## Manifest File ##

The manifest should be named the same as the gizmo, with a .yml.php extension.

Example:
```
#<?php die(); ?>
identity: mwg.gizmos.exampleGizmo
name: Example
title: Example Gizmo for your website
version: 1.0.0
api:     1.1.0
compatibility:
  - mwg
  - php5
type: gizmo
meta:
  description: Example Gizmo for Marketing Website Generator
  copyright:   (c)2010 Intellispire, LLC
  license: GPLv2
documentation: This is an example Gizmo. Read the code to see how to write one.
```

## Additional files ##

If the gizmo requires additional implementation files, they should be stored in the directory **gizmoname** (example, in this case), which will be copied (along with the rest of the files) to the /gizmos/ directory upon installation.