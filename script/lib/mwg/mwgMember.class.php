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

defined('_MWG') or die ('Restricted Access');

class mwgMember {

  var $id; // user id
  var $record;
  var $levels;

  function __construct($id = '') {
    if ($id) {
      $this->id = $id;    
      $this->_load();
    } else {
      // legacy session
      if ($SESSION['sess_id']) {
        $this->record =  MWG::getDb()->get_row('select * from members where mdid=?', $SESSION['sess_id']);
        if ($this->record) $this->id = $record['id'];
      }    
    } 

    if (!$this->id) {
      // This is a guest user, we need to special case.
    }    
  }

  protected function _load() {
    $this->record = MWG::getDb()->get_row('select * from members where id=?', $this->id);    
  }

  /**
  * Return current member level
  */

  function getLevels() {
    if (!$this->record) return array(); // Guest is member of nothing
    if (! $this->levels) {
      $raw_levels = explode(",", $this->record['history']);
      $this->levels = $this->dedupe($raw_levels);
    }
    return $this->levels;
  }
  
  function addLevel($membership_id) {
    if (!$this->record) return array(); // Guest is member of nothing

    $levels = $this->getLevels();
    $levels[] = $membership_id;
    $this->storeLevels($levels);       
    return $this->getLevels();    
  }


  function removeLevel($membership_id) {
    if (!$this->record) return array(); // Guest is member of nothing

    $raw_levels = $this->getLevels();
    $levels = $this->dedupe($raw_levels, $membership_id);
    $this->storeLevels($levels);
    return $this->getLevels();
  }
  
  /**
  * Remove current top rank and add a new one.
  * The new top rank becomes the greatest of 
  * allowed membership levels.
  * 
  * @param mixed $membership_id
  */
  function changeLevel($membership_id) {
    if (!$this->record) return array(); // Guest is member of nothing
    
    $this->removeLevel($this->record['membership_id']);
    $this->addLevel($membership_id);
    return $this->getLevels();    
  }

  /**
  * Deduplicate a numeric array
  * optional remove remove a specific level from the array 
  * during the process
  * 
  * @param mixed $raw_levels
  * @param mixed $remove       optional level to remove 
  * @return array
  */

  function dedupe($raw_levels, $remove = 0) {
    // de-duplicate and weed out blanks
    $current_levels = array();
    foreach ($raw_levels as $level) {
      if ($level) $current_levels[$level] = true;
    }
    if (($remove > 0) && isset($current_levels[$remove])) {
      unset($current_levels[$remove]);
    }
    $levels = array_keys($current_levels);
    return $levels;        
  }

  /**
  * store the new, updated levels array
  * Note that we assume that rank may not be unique, this the somewhat convaluted rank sorting logic
  * 
  * @param array $levels new levels array
  */
  function storeLevels($levels) {

    // Levels have changed (added or deleted)
    // Set the new rank and save the record
    $levels = $this->dedupe($levels);
    $in = implode(",", $levels);
    $ranks = MWG::getDb()->get_select("select id,rank from membership where id in($in) order by rank asc");

    // Loop through to create the levels in rank order, and determine the max rank id.    
    // Our main membership id is the maximum we are allowed access to.
    // Note it IS possible that our main membership id is inactive. 
    // In this case, results become undefined. 
    // Don't deactivate membership levels in which you have members!

    $levels = array(); // Clear the array
    foreach ($ranks as $id => $rank) {
      $levels[] = $id;
      $membership_id = $id;
    }
    $this->record['history'] =   implode(',', $levels) . ","; // Extra comma added for backward compatibility until we fix the other data handling routines.
    $this->record['membership_id'] = $membership_id;
    MWG::getDb()->query('update members set membership_id=?, history=? where id=?', $this->record['membership_id'], $this->record['history'], $this->id);
    $this->levels = ''; // Remove levels cache

  }

  function dump() {
    print_r($this);
    print_r($SESSION);
  }


}
/*

function updateHistory($member_h_id, $membership_h_id, $append = false) {
$db = MWG::getDb();
$history = $db->get_value('select history from members where id=?', $member_h_id);

if ($append) {
$history.=$membership_h_id.",";

$current_levels = array();
$history_explode=explode(",",$history);
foreach ($history_explode as $level) {
if ($level)
$current_levels[$level] = true;
}
$levels = array_keys($current_levels);
}
$res2 = array_keys($res2); 
}

$history_explode=array_unique($history_explode);

$ihi=0;
$history="";
while ($ihi<count($history_explode)) {
if ($history_explode[$ihi]!="") {
$history.=$history_explode[$ihi].",";
}
$ihi++;
}
$query="UPDATE members SET history="."'$history"."' WHERE id='".$member_h_id."'";
$q4->query($query);      
} else {
$history_exp=explode(",", $history);
$ihi=0;
$history="";
while ($ihi<count($history_exp)) {
if ($history_exp[$ihi]!=$membership_h_id && $history_exp[$ihi]!="") {
$history.=$history_exp[$ihi].",";
}
$ihi++;
}
$query="UPDATE members SET history="."'$history"."' WHERE id='".$member_h_id."'";
$q4->query($query);      
}
}
*/