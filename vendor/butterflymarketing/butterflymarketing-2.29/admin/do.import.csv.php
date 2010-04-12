<?php 
	include ("inc.top.php");
	
	$q->query("SELECT content FROM temp WHERE id='".$_GET['id']."'");
	$q->next_record();
	$contents = stripslashes($q->f("content"));
	$content=explode ("\n", $contents);
	$columns = explode (",", $content[0]);
	
	$columns[0]=str_replace("\"", "", $columns[0]);
	$i=0;
	$j=0;
	
	$fields=array();
	$position=array();
	$posturi_arr = array();
	$fieldsforquery = ", ";
	$nr_col_pass = -1;
	
	if (!empty($import)){
	
		foreach($import as $importcolumn)
		{
			$fields[$i]=$importcolumn;
			$position[$i]=array_search($importcolumn, $import);
			if (strpos($fieldsforquery,", ".$_POST["db_field_".$importcolumn]) === false){}
			else{
				header("Location: import.csv.php?err=1");
				exit;
			}
			if ($_POST["db_field_".$importcolumn] == "password") $nr_col_pass = $importcolumn; 
			$fieldsforquery.=$_POST["db_field_".$importcolumn].", ";
				
			$i++;
					
		}
		$fieldsforquery = substr($fieldsforquery,0,-2);
		$fieldsforquery = substr($fieldsforquery,2);
		
		$verif = array();
		
		foreach ($content as $rows){
			$i_verif = 0;
			if (!empty($rows)){
					$row=explode (",", $rows);
					
					foreach ($row as $fi){	
						$i_verif++; 
					}
					$verif[] = $i_verif;
			}
		}
		
		if (max($verif) != min($verif)){
			header("Location: import.csv.php?err=2");
			exit;
		}
		$i=0;
		$j=0;
		$k=0;
		$cont = 0;
		
		foreach ($content as $rows)
		{
			if (!empty($rows))
			{
				if ($j!=0 || $firstrow){
					
					$row=explode (",", $rows);
					
					foreach ($row as $fi)
					{	
							$fi=str_replace("\"","", $fi);
							$fi=str_replace("#$%^&*",",", $fi);
							
	
							foreach($fields as $element)
							{
								if ($i==$element) 
								{	
									if ($i == $nr_col_pass && $encrypted){
										if ($k==0)
										{
		
											$fieldsforinsert.="MD5('".addslashes($fi)."')";
											$k=1;
										}
										else
										{
											$fieldsforinsert.=", MD5('".addslashes($fi)."')";
		
										}
									}else{
										if ($k==0)
										{
		
											$fieldsforinsert.="'".addslashes($fi)."'";
											$k=1;
										}
										else
										{
											$fieldsforinsert.=", '".addslashes($fi)."'";
		
										}
									}
								}
								
									
							}
							$i++;
						
					}
	
					
					$query="insert into members (".$fieldsforquery.") values (".$fieldsforinsert.")";
					
					$q->query($query);
					$fieldsforinsert='';
					$k=0;
					$i=0;
					$cont++;
				}
				else $j=1;
			}
			
		}
	}
	header("Location: import.csv.num_rows.php?nr=$cont&id_temp=$id");
exit;	
	include ("inc.bottom.php");
?>