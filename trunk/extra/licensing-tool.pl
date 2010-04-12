#!/usr/bin/perl 

use strict; 
use warnings; 
use File::Find; 

my $startdir = '.'; 
my $find = '^\<\?php'; 
my $replace = '<?php
/**
 * @version    $Id: $
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

'; 
my $doctype = 'php';  


find( 
   sub{ 
      return unless (/\.$doctype$/i); 
      local @ARGV = $_; 
      local $^I = '.bac'; 
      while( <> ){ 
         if( s/$find/$replace/ig ) { 
            print; 
         } 
         else { 
            print; 
         } 
      } 
}, $startdir);
