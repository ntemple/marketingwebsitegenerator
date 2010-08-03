<?php

class TestOfLadder extends UnitTestCase {
  
    function testLadder() {
//      print "<pre>";
      $ipn1 = 'transaction_subject=&payment_date=20%3A57%3A33+Jun+30%2C+2010+PDT&txn_type=subscr_payment&subscr_id=I-M0WK7ASNJVRY&last_name=Temple&residence_country=US&item_name=PAID+MEMBERSHIP&payment_gross=0.01&mc_currency=USD&business=corp%40intellispire.com&payment_type=instant&protection_eligibility=Ineligible&verify_sign=Ac63Hda1Nf3r7XSB7VctDvaXbv7iAyyxwbyNYkxZeWbwufj7eFJrTjCd&payer_status=verified&payer_email=sales%40integralrd.com&txn_id=916615538K712182R&receiver_email=corp%40intellispire.com&first_name=Nick&payer_id=JQSJ47H2UQYAG&receiver_id=NEJTZ8XAJGXBL&item_number=PAID&payer_business_name=Integral+Research+and+Development%2C+LLC&payment_status=Completed&payment_fee=0.01&mc_fee=0.01&mc_gross=0.01&custom=4118682b4d682916b35b86643c34193ac6bpm9swmhocejbx417ddtvkb7he0pjmvvci45eql33&charset=windows-1252&notify_version=3.0';
      $pairs = explode('&', $ipn1);
      foreach ($pairs as $pair) {
       list($k,$v) = explode('=', $pair);
       $ipn[$k] = $v;
      }
                 

      $member = new mwgMember(4);
      $member->storeLevels(array(1)); // Set back to initial level      

      MWG::getInstance()->runEvent('paypalIPN', array($ipn, true));

      $member = new mwgMember(4);
      $levels  = $member->getLevels();
//      print_r($member);
//      print_r($levels);      
//      print_r($ipn);
      
      
    }
    
    
    
}



