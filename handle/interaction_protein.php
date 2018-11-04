


<?php
include "include/mysql.php";
include "include/function.php";

$results=array();
$interaction_protein=$_REQUEST["interaction_protein"];
$type=$_REQUEST["type"];
$y_hat=$_REQUEST["y_hat"];
#$interaction_protein="ENSP00000490935";

if($type=="LncRNA" )
{   
	$file_path="/home/webserver/CLncRNA/handle/lnc/$interaction_protein.txt";
}
else 
{
	$file_path="/home/webserver/CLncRNA/handle/pro/$interaction_protein.txt";
}


if (file_exists($file_path))
{
	$file = fopen($file_path,"r");
	$i=0;
	while(!feof($file))
	{   $i=$i+1;
	
		$text=fgets($file);
		$ts=explode("\t",$text);
		if( (float)$ts[7]>(float)$y_hat)
		{
			#echo $ts[7]."<br/>";
			
			$result=array();
			$result["pro_gene_id"]=$ts[0];
			$result["pro_transcript_id"]=$ts[1];
			$result["uniprot_swissprot"]=$ts[2];
			$result["uniprot_trembl"]=$ts[3];
			$result["hgnc_symbol"]=$ts[4];
			$result["rbp"]=$ts[5];
			$result["target"]=$ts[6];
			$result["y_hat"]=$ts[7];
			$result["lnc_gene_id"]=$ts[9];
			$result["lcn_gene_symbol"]=$ts[10];
			array_push($results,$result);
		}
	}
	fclose($file);

}

echo $json=json_encode($results)

?>