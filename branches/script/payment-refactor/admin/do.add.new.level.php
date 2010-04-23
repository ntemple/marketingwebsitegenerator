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

 
	include("inc.top.php");
	$q2=new Cdb;
	$q3=new Cdb;	
	if ($paymode!=1) $paytype=$paytype."_split";
	if ($paytype=="percent" || $paytype=="percent_split")
	{
		if ($value>100)
			{
				header ("location:levels.php?error=".urlencode("You cannot add a percent value bigger then 100%"));
				die();
			}
		if ($jv1 && $jv1>100)
			{
				header ("location:levels.php?error=".urlencode("You cannot add a percent for your JV bigger then 100%"));
				die();
			}
		if ($jv2 && $jv2>100)
			{
				
				header ("location:levels.php?error=".urlencode("You cannot add a percent for your JV bigger then 100%"));
				die();
			}	
	}
	if ($paytype=="full_amount" || $paytype=="full_amount_split")
	{
		$query="select price from products where id='$product_id'";
		$q2->query($query);
		$q2->next_record();
		if ($value > $q2->f("price"))
			{
				header ("location:levels.php?error=".urlencode("You cannot add a pay value bigger then the price of the product"));
				die();
			}
		if ($jv1 && $jv1>$q2->f("price"))
			{
				header ("location:levels.php?error=".urlencode("You cannot add a pay value for your JV bigger then the price of the product"));
				die();
			}
		if ($jv2 && $jv2>$q2->f("price"))
			{
				header ("location:levels.php?error=".urlencode("You cannot add a pay value for your JV bigger then the price of the product"));
				die();
			}
	}
	
$u=0;
if ($payto=="all")
{
	
	$query="select id from membership where active=1";
	$q->query($query);
	while ($q->next_record())
	{
		
		$query="select id from levels where level='$level' and product_id='$product_id' and membership_id='".$q->f("id")."' and paytype='$paytype' order by id asc";
		$q2->query($query);
		if ($q2->nf()==0)
		{	
			if ($jv1=='') $jv1=$value;
			if ($jv2=='') $jv2=$value;
			$query="insert into levels (level, membership_id, value, paytype, product_id, jv1, jv2, highcom, highval, highdays) values ('$level','".$q->f("id")."','$value','$paytype','$product_id', '$jv1', '$jv2', '$highcomms', '$highval', '$highdays')";
			$q2->query($query);
			$u=0;
		}
		else
		{
			$q2->next_record();
			$lid=$q2->f("id");
			$u=1; 
			$query="update levels set membership_id='".$q->f("id")."', value='$value', paytype='$paytype', product_id='$product_id', jv1='$jv1', jv2='$jv2' where id='$lid'";
			$q3->query($query)."<br>";
		}
		$i=0;
		if ($paytype=="percent_split")  
		{
			$value2=100-$value;
			$jv12=100-$jv1;
			$jv22=100-$jv2;
			$highval2=100-$highval;
			$i=1;
		}
		if ($paytype=="full_amount_split")
		{
			$query="select price from products where id='$product_id'";
			$q2->query($query);
			$q2->next_record();
			$value2=$q2->f("price")-$value;
			$jv12=$q2->f("price")-$jv1;
			$jv22=$q2->f("price")-$jv2;
			$highval2=$q2->f("price")-$highval;
			$i=1;
		}
		if ($i==1)
		{
			if ($u==0)
			{	
				$query="insert into levels (level, membership_id, value, paytype, product_id, jv1, jv2, highcom, highval, highdays) values ('$level','".$q->f("id")."','$value2','$paytype','$product_id','$jv12','$jv22', '$highcomms','$highval2','$highdays')";
				$q2->query($query);
			}
			else
			{
				$q2->next_record();
				$lid++; 
				$query="update levels set membership_id='".$q->f("id")."', value='$value2', paytype='$paytype', product_id='$product_id', jv1='$jv12', jv2='$jv22' where id='$lid'";
				$q3->query($query);
			}
		}
	}
}
if ($payto=="just")
{
	if (isset($membership_id))
	foreach ($membership_id as $x => $valua)
	{	
		$u=0;
		$query="select id from levels where level='$level' and product_id='$product_id' and membership_id='".$x."' and paytype='$paytype' order by id asc";
		$q2->query($query);
		if ($q2->nf()==0)
		{
			if ($jv1=='') $jv1=$value;
			if ($jv2=='') $jv2=$value;
			$query="insert into levels (level, membership_id, value, paytype, product_id, jv1, jv2, highcom, highval, highdays) values ('$level','$x','$value','$paytype','$product_id', '$jv1', '$jv2','$highcomms','$highval','$highdays')";
			$q2->query($query);
		}
		else
		{	
			$q2->next_record(); 
			$lid=$q2->f("id");
			$u=1;
			$query="update levels set membership_id='".$x."', value='$value', paytype='$paytype', product_id='$product_id', jv1='$jv1', jv2='$jv2' where id='$lid'";
			$q3->query($query);
		}
		$i=0;
		if ($paytype=="percent_split")  
		{
			$value2=100-$value;
			$jv12=100-$jv1;
			$jv22=100-$jv2;
			$highval2=100-$highval;
			$i=1;
		}
		if ($paytype=="full_amount_split")
		{
			$query="select price from products where id='$product_id'";
			$q2->query($query);
			$q2->next_record();
			$value2=$q2->f("price")-$value;
			$jv12=$q2->f("price")-$jv1;
			$jv22=$q2->f("price")-$jv2;
			$highval2=$q2->f("price")-$highval;
			$i=1;
		}
		if ($i==1)
		{
			if ($u==0)
			{	
				$query="insert into levels (level, membership_id, value, paytype, product_id, jv1, jv2, highcom, highval, highdays) values ('$level','".$x."','$value2','$paytype','$product_id','$jv12','$jv22', '$highcomms','$highval2','$highdays')";
				$q2->query($query);
			}
			else
			{
				$q2->next_record();
				$lid++;
				$query="update levels set membership_id='".$x."', value='$value2', paytype='$paytype', product_id='$product_id', jv1='$jv12', jv2='$jv22' where id='$lid'";
				$q3->query($query);
			}
		}
	}
	
}
	header("location:levels.php");
?>