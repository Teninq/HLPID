<?php
include "include/mysql.php";
include "include/function.php";


$search_id=$_REQUEST["search_id"];
$type=$_REQUEST["type"];

$search_id="Muscle - Skeletal";
$ll="\"";//

$datas=array();


$sql="SELECT * FROM LNCRNA.expression_tissue_specific where Enriched_Tissue  like $ll%$search_id%$ll";

#echo $sql;
$results=$db->find($sql);


for($j=0;$j<count($results);$j++)
{
	$value=$results[$j]->datas;
	
	#echo $value;
	$values=explode(",",$value);
		
			
	for($i=0;$i<count($values);$i++)
	{
	
		$values[$i] = log10(intval($values[$i])+0.01);
	
	}
	//echo json_encode($values);
	array_push($datas,$values);
}

		
	

echo $json=json_encode($datas)

?>