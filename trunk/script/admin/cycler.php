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
	$q2=new cdb;
	$chck_funtions = '';
	$t->set_file("content", "admin.cycler.html");
	$t->set_file("cyclelist", "admin.cycler.cycle.html");
	if (get_setting('activate_cycler')){
		$t->set_var('activ_chck',"checked");
	}else{
		$t->set_var('activ_chck',"");
	}
	$query="select id,cycle,file from cycle group by cycle order by file";
	$q->query($query);
	if (!$q->nf())
		$t->set_var("cycle_list",'');
	while ($q->next_record())
	{
		$chck_funtions .= "display_tr(document.getElementById('add_".$q->f('id')."'));";
	$manually="			
		  <tr>
		  				<input type='checkbox' name='add_".$q->f('id')."' id='add_".$q->f('id')."' style='display:none'>
				<td colspan=2 name='tr_".$q->f('id')."'><label for='tr_".$q->f('id')."' style='cursor:pointer; text-decoration:underline;color:#0000FF;' onClick=\"if (document.getElementById('add_".$q->f('id')."').checked==true) {document.getElementById('add_".$q->f('id')."').checked=false} else{document.getElementById('add_".$q->f('id')."').checked=true}display_tr(document.getElementById('add_".$q->f('id')."'))\">Add new value:</label></td>
  </tr>
  <tr>
    <td  colspan=2 name='add_".$q->f('id')."_td' id='add_".$q->f('id')."_td'><form name='form2' method='post' action='do.add.new.value.php?cycle={cycle_name}&file={file_name}'>
      <div align='center'>
        <textarea name='text' cols='80' rows='5'></textarea>
        <label></label>
        <input type='submit' name='Submit1' value='Add value'>
      </div>
    </form>    </td>
  </tr>
";
		$t->set_var("manually", $manually);
$chck_funtions .= "display_tr(document.getElementById('values_".$q->f('id')."'));";
	$values="			
            <tr>
 		  		<input type='checkbox' name='values_".$q->f('id')."' id='values_".$q->f('id')."' style='display:none'>
				<td colspan='2' name='tr_values_".$q->f('id')."'><label for='tr_values_".$q->f('id')."' style='cursor:pointer; text-decoration:underline;color:#0000FF;' onClick=\"if (document.getElementById('values_".$q->f('id')."').checked==true) {document.getElementById('values_".$q->f('id')."').checked=false} else{document.getElementById('values_".$q->f('id')."').checked=true}display_tr(document.getElementById('values_".$q->f('id')."'))\">Values:</label></td>
            </tr>
            <tr name='values_".$q->f('id')."_td' id='values_".$q->f('id')."_td'>
            <td colspan='2'>
            <table>";
 		$query="select * from cycle where cycle='".$q->f("cycle")."'";
		$q2->query($query);
		while($q2->next_record())
		{
			$values.="<tr>
				<td style='vertical-align:middle'>
					<textarea name='cycle_values_".$q2->f("id")."' cols='70'>".$q2->f("text")."</textarea>
				&nbsp;<a href='do.delete.cycler.value.php?id=".$q2->f("id")."'>Delete Value</a>
				</td>
			</tr>";
		}
            $values.= "
                        <tr>
              
            </tr>
</table>
              </td>
              </tr>
              <tr>
              <td colspan='2'>
              <br>
              	<input type='submit' name='Submit2' value='Do Changes'>
              </td>
              </tr>
              <hr>
";
		$t->set_var("values_tr", $values);
		$t->set_var("file_name",$q->f("file"));
		$t->set_var("cycle_name", $q->f("cycle"));
		$t->set_var("view_stats",'<a href="cycler_stats.php?file='.$q->f("file").'&campa='.$q->f("cycle").'">View Stats</a>');
		$t->set_var("delete",'<a href="do.delete.cycler.php?cycler='.$q->f('cycle').'">Delete Campaign</a>');
		$t->set_var($q->f("file"), "selected");
		$t->parse("cycle_list", "cyclelist", true);
		$t->unset_var("values_list");
		$t->unset_var($q->f("file"));
	}
		 $t->set_var("chck_funtions",$chck_funtions);
	include("inc.bottom.php");
?>