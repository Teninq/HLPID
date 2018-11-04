<?php
include "include/mysql.php";
include "include/function.php";


$interaction_rna=$_REQUEST["interaction_rna"];
$type=$_REQUEST["type"];

$interaction_rna=trim($interaction_rna);
$ll="\"";//


if($type=="none")
{
	$sql="SELECT * FROM CHLncRNA.lncRNARNA where LncRNA_Original_ID  like $ll%$interaction_rna%$ll";
}

else 
{
	$sql="SELECT * FROM CHLncRNA.lncRNARNA where LncRNA_Original_ID  like $ll%$interaction_rna%$ll and type=$ll$type$ll";
}



$results=$db->find($sql);



echo $json=json_encode($results)

?>