<?php
include "include/mysql.php";
include "include/function.php";

$disease=$_REQUEST["disease"];
$type=$_REQUEST["type"];

$disease=trim($disease);
$ll="\"";//

if($type=="lcnRNA")
{
	$sql="SELECT * FROM LNCRNA.LncRNADiseas where original_ID  like $ll%$disease%$ll";
}

else
{
	$sql="SELECT * FROM LNCRNA.LncRNADiseas where disease  like $ll%$disease%$ll";
}

$results=$db->find($sql);


for($i=0;$i<count($results);$i++)
{
	$PMID=$results[$i]->PMID;
	$results[$i]->PMID="<a href='https://www.ncbi.nlm.nih.gov/pubmed/$PMID' target='_blank'>$PMID</a>";
	
}





echo $json=json_encode($results)

?>