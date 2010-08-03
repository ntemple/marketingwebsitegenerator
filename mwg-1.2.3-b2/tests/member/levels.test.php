<?php

class TestOfMemberLevels extends UnitTestCase {
  
    function setup() {
      $this->member = new mwgMember(2);
      $this->member->storeLevels(array(1));
    }
    
    function testLoadingMember() {
        $member = $this->member;      
        $this->assertTrue(isset($member->record));
        $this->assertTrue($member->id == 2);
        $this->assertTrue($member->record['id'] == 2);
        $this->assertTrue($member->record['history'] == '1,');
    }
    
    function testGetLevels() {
        $member = $this->member;      
        
        $this->assertTrue($member->record['history'] == '1,');
        $levels = $member->getLevels();
        $this->assertTrue(count($levels) == 1, print_r($levels, true));        
        $this->assertTrue($levels[0] == 1, "invalid initial level");
    }
    
    function testStoreLevels() {
      $member = $this->member;
      $this->assertTrue($member->record['history'] == '1,');


      $levels = array(2,3);
      $member->storeLevels($levels);
      $levels = $member->getLevels();
      $this->assertTrue((count($levels) == 2), print_r($levels, true));      
      $this->assertFalse($member->record['history'] == '1,');
      // Default Rank was changed in 
      $this->assertTrue($member->record['history'] == '3,2,', "Record:" . $member->record['history']);

      
      $levels = array(1);
      $member->storeLevels($levels);
      $this->assertTrue(count($levels) == 1, print_r($levels, true));        
      $this->assertTrue($levels[0] == 1, "invalid initial level");
      $this->assertTrue($member->record['history'] == '1,');
    }
    
    function testAddRemoveLevel() {
      $member = $this->member;
      $this->assertTrue($member->record['history'] == '1,');
      $this->assertTrue($member->record['membership_id'] == 1, 'Invalid Membership Id: ' . $member->record['membership_id']);

      $member->addLevel(3);
      $this->assertTrue($member->record['history'] == '1,3,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 3, 'Invalid Membership Id: ' . $member->record['membership_id']);

      $member->addlevel(2);
      $this->assertTrue($member->record['history'] == '1,3,2,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 2, 'Invalid Membership Id: ' . $member->record['membership_id']);
      
      // Test the actual storage unit - reloads from database
      // Could / should this be cached? How .. a factory?
      $member2 = new mwgMember(2);
      $this->assertTrue($member2->record['history'] == '1,3,2,', "Record: " . $member->record['history']);
      $this->assertTrue($member2->record['membership_id'] == 2, 'Invalid Membership Id: ' . $member->record['membership_id']);
            
      // Remove top level, changes membership_id
      $member->removeLevel(2);
      $this->assertTrue($member->record['history'] == '1,3,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 3, 'Invalid Membership Id: ' . $member->record['membership_id']);
      
      // Remove bottom level
      $member->removeLevel(1);
      $this->assertTrue($member->record['history'] == '3,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 3, 'Invalid Membership Id: ' . $member->record['membership_id']);
          
      $levels = array(1);
      $member->storeLevels($levels);            
      $this->assertTrue(count($levels) == 1, print_r($levels, true));        
      $this->assertTrue($levels[0] == 1, "invalid initial level");
      $this->assertTrue($member->record['history'] == '1,');      
    }
    
    function testChangeLevel() {
      $member = $this->member;

      $member->storeLevels( array(1,2,3));
      $this->assertTrue($member->record['history'] == '1,3,2,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 2, 'Invalid Membership Id: ' . $member->record['membership_id']);
      
      $member->changeLevel(4);
      $this->assertTrue($member->record['history'] == '1,3,4,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 4, 'Invalid Membership Id: ' . $member->record['membership_id']);
      
      $member->changeLevel(2);
      $this->assertTrue($member->record['history'] == '1,3,2,', "Record: " . $member->record['history']);
      $this->assertTrue($member->record['membership_id'] == 2, 'Invalid Membership Id: ' . $member->record['membership_id']);      
    }

/*
Assumed Levels
Array
(
    [1] => 1
    [2] => 3
    [3] => 4
    [4] => 2
    [5] => 5
    [6] => 8
    [7] => 6
    [8] => 9 <- Inactive
    [9] => 7
)
*/    
    function testUpgradeLevel() {
      $member = $this->member;
      $ignore = array();
      
      list($prev, $next) = $member->getBoundingLevels($ignore, 1);
      $this->assertTrue($prev == 1);
      $this->assertTrue($next == 3);
      
      list($prev, $next) = $member->getBoundingLevels($ignore, 2);
      $this->assertTrue($prev == 4);
      $this->assertTrue($next == 5);

      list($prev, $next) = $member->getBoundingLevels($ignore, 3);
      $this->assertTrue($prev == 1);
      $this->assertTrue($next == 4);

      list($prev, $next) = $member->getBoundingLevels($ignore, 6);
      $this->assertTrue($prev == 8);
      $this->assertTrue($next == 7);
      
      // If a level is inactive, then it cannot move, so the current
      // level is always maintained.
      list($prev, $next) = $member->getBoundingLevels($ignore, 9);
      $this->assertTrue($prev == 6, "[$prev, $next]");
      $this->assertTrue($next == 7, "[$prev, $next]");

//      list($prev, $next) = $member->getBoundingLevels($ignore, 9);
//      $this->assertTrue($prev == 9, "[$prev, $next]");
//      $this->assertTrue($next == 9, "[$prev, $next]");


      list($prev, $next) = $member->getBoundingLevels($ignore, 7);
      $this->assertTrue($prev == 6);
      $this->assertTrue($next == 7);
      
      // Test ignoring levels
      $ignore = array(2,4,8);
      list($prev, $next) = $member->getBoundingLevels($ignore, 5);
      $this->assertTrue($prev == 3, "[$prev, $next]");
      $this->assertTrue($next == 6, "[$prev, $next]");

      // Test ignoring levels screwed up (ignoring inactive levels and self)
      $ignore = array(2,2,4,5,4,8,8,9);
      list($prev, $next) = $member->getBoundingLevels($ignore, 5);
      $this->assertTrue($prev == 3, "[$prev, $next]");
      $this->assertTrue($next == 6, "[$prev, $next]");    
    }
    
    function testPromoteLevel() {
      $member = $this->member;
      $ignore = array();
      
      $member->changeLevel(5);
      $levels = $member->getLevels();
      $this->assertTrue(count($levels) == 1);
      $this->assertTrue($levels[0] == 5);
      $this->assertTrue($member->getRankingLevel() == 5);
            
      $levels = $member->promoteLevel($ignore, false);
      $this->assertTrue(count($levels) == 1);
      $this->assertTrue($levels[0] == 8);
      $this->assertTrue($member->getRankingLevel() == 8);
      
      // Reset
      $member->changeLevel(5);
      $levels = $member->promoteLevel($ignore, true);
      $this->assertTrue(count($levels) == 2);
      $this->assertTrue(in_array(5, $levels));
      $this->assertTrue(in_array(8, $levels));
      $this->assertTrue($member->getRankingLevel() == 8);

      $levels = $member->promoteLevel($ignore, true);
      $this->assertTrue(count($levels) == 3);
      $this->assertTrue(in_array(5, $levels));
      $this->assertTrue(in_array(8, $levels));
      $this->assertTrue(in_array(6, $levels));         
      $this->assertTrue($member->getRankingLevel() == 6);

      $levels = $member->promoteLevel($ignore, true);
      $this->assertTrue(count($levels) == 4);
      $this->assertTrue(in_array(5, $levels));
      $this->assertTrue(in_array(8, $levels));
      $this->assertTrue(in_array(6, $levels));         
      $this->assertTrue(in_array(7, $levels));         
      $this->assertTrue($member->getRankingLevel() == 7);

      // promotion should do nothing
      $levels = $member->promoteLevel($ignore, true);
      $this->assertTrue(count($levels) == 4);
      $this->assertTrue(in_array(5, $levels));
      $this->assertTrue(in_array(8, $levels));
      $this->assertTrue(in_array(6, $levels));         
      $this->assertTrue(in_array(7, $levels));         
      $this->assertTrue($member->getRankingLevel() == 7);

      // Reset      
      $levels = array(1);
      $member->storeLevels($levels);
      $this->assertTrue(count($levels) == 1, print_r($levels, true));        
      $this->assertTrue($levels[0] == 1, "invalid initial level");
      $this->assertTrue($member->record['history'] == '1,');
    }
    
    function testDemoteLevel() {
      $member = $this->member;
      $ignore = array();
      
      $member->changeLevel(5);
      $levels = $member->getLevels();
      $this->assertTrue(count($levels) == 1);
      $this->assertTrue($levels[0] == 5);
      $this->assertTrue($member->getRankingLevel() == 5);
            
      $levels = $member->demoteLevel($ignore);
      $this->assertTrue(count($levels) == 1);
      $this->assertTrue(in_array(2, $levels));
      $this->assertTrue($member->getRankingLevel() == 2);            
    }
    
}

