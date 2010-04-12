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
	
	$q=new Cdb;
	if (!isset($action)) $action=aff;
	
	switch ($action)
	{
		case "aff":
			FFileRead("../templates/a.admin.template.levels.htm",$content);
			$query="select * from a_levels order by level";
			$q->query($query);
			while($q->next_record())
			{
				if ($q->f("type")==1) $typ="Flat Amount"; else $typ="Percent";
				$rows.="<tr bgcolor='#E2DCDE'>
							<td>".$q->f("level")."</td>
							<td><input name=lev[".$q->f("level")."] value=".$q->f("value").">  </td>
							<td>     
									 <select name=type[".$q->f("level")."]>
										<option value=".$q->f("type")." selected>".$typ."</option>
										<option value=0>Percent</option>
										<option value=1>Flat Amount</option>
									  </select>
						  </td>
						</tr>";
			}
			
			$content=str_replace("{rows}",$rows,$content);
			$content=str_replace("{add}",$q->nf()+1,$content);
			$content=str_replace("{delete}",$q->nf(),$content);
			
			break;
		case "delete_aff":
			$query="delete from a_levels where level='$delete'";
			$q->query($query);
			header("Location: a.aff.levels.php?action=aff");
			break;
		case "add_aff":
			$query="insert into a_levels (level, value, type) values ('$add', '$value', '$type')";
			$q->query($query);
			header("Location: a.aff.levels.php?action=aff");
			break;
		case "save_levels":
			foreach ($lev as $x => $value)
			{	
				$query="update a_levels set value='$value', type='".$type[$x]."' where level='$x'";
				$q->query($query);
			}
			header("Location: a.aff.levels.php?action=aff");
			break;
	}
	
	
	FFileRead("../templates/admin.main.html",$main);
	$main=str_replace("{content}",$content,$main);
	$main=str_replace("{status}",$sta,$main);
	$main=str_replace("{title}",$title,$main);
	$main=str_replace("{sitename}",$sitename,$main);
	$main=str_replace("{webmasteremail}",$webmasteremail,$main);
	echo $main;
?>