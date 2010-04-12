<?php 
	include("inc.top.php");
	$q2=new Cdb;
	$query="select * from levels order by id";
	$q->query($query);
	while ($q->next_record())
	{
		if ($q->f("paytype")=="percent_split")
		{
			$query="update levels set level='".$level[$q->f("id")]."', value='".$value[$q->f("id")]."', product_id='".$product_id[$q->f("id")]."', jv1='".$jv1[$q->f("id")]."', jv2='".$jv2[$q->f("id")]."' where id='".$q->f("id")."'";
			$q2->query($query);
			$previousmid=$membership_id[$q->f("id")];
			$previouslevel=$level[$q->f("id")];
			$previousvalue=$value[$q->f("id")];
			$previousproduct=$product_id[$q->f("id")];
			$previousjv1=$jv1[$q->f("id")];
			$previousjv2=$jv2[$q->f("id")];
			$q->next_record();
			$query="update levels set level='".$previouslevel."', value='".(100-$previousvalue)."', product_id='".$previousproduct."', jv1='".(100-$previousjv1)."', jv2='".(100-$previousjv2)."' where id='".$q->f("id")."'";
			$q2->query($query);
		}
		if ($q->f("paytype")=="full_amount_split")
		{
			$query="update levels set level='".$level[$q->f("id")]."', value='".$value[$q->f("id")]."', product_id='".$product_id[$q->f("id")]."', jv1='".$jv1[$q->f("id")]."', jv2='".$jv2[$q->f("id")]."' where id='".$q->f("id")."'";
			$q2->query($query);
			$previousmid=$membership_id[$q->f("id")];
			$previouslevel=$level[$q->f("id")];
			$previousvalue=$value[$q->f("id")];
			$previousproduct=$product_id[$q->f("id")];
			$previousjv1=$jv1[$q->f("id")];
			$previousjv2=$jv2[$q->f("id")];
			$query="select price from products where id='".$previousproduct."'";
			$q2->query($query);
			$q2->next_record();
			$previousproductprice=$q2->f("price");
			$q->next_record();
			$query="update levels set level='".$previouslevel."', value='".($previousproductprice - $previousvalue)."', product_id='".$previousproduct."', jv1='".($previousproductprice - $previousjv1)."', jv2='".($previousproductprice - $previousjv2)."' where id='".$q->f("id")."'";
			$q2->query($query);
		}
		if ($q->f("paytype")=="percent" or $q->f("paytype")=="full_amount")
		{
			$query="update levels set level='".$level[$q->f("id")]."', value='".$value[$q->f("id")]."', product_id='".$product_id[$q->f("id")]."', jv1='".$jv1[$q->f("id")]."', jv2='".$jv2[$q->f("id")]."' where id='".$q->f("id")."'";
			$q2->query($query);
		}
	}
	header ("location:levels.php");
?>	