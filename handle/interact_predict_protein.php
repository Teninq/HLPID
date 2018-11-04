<?php
include "include/mysql.php";
include "include/function.php";


$results=array();
$i_p=$_REQUEST["interaction_protein"];
$type=$_REQUEST["type"];
$y_hat=$_REQUEST["y_hat"];


$i_p=trim($i_p);
$ll="\"";//

if($type=="enst")
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/enst/$i_p.txt";
}
elseif ($type=="ensg")
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/ensg/$i_p.txt";
}
elseif ($type=="ensp")
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/ensp/$i_p.txt";
}
elseif ($type=="symbol")
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/lnc_symbol/$i_p.txt";
}
/* elseif ($type=="swisssprot")
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/swisssprot/$i_p.txt";
}
else 
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/trembl/$i_p.txt";
} */

else 
{
	$file_path="/home/webserver/HLPID/handle/lnc_pro/uniprot/$i_p.txt";
}

if (file_exists($file_path))
{
	$file = fopen($file_path,"r");
	$i=0;
	while(!feof($file))
	{   $i=$i+1;

	$text=fgets($file);
	$ts=explode("\t",$text);
	if( (float)$ts[6]>(float)$y_hat)
	{
	
		
		$result=array();
		$result["pro_symbol"]="<a href='http://www.genecards.org/cgi-bin/carddisp.pl?gene=$ts[0]' target='_blank'>$ts[0]</a>";
		#http://www.uniprot.org/uniprot/A0AV96
		
		$uniprot_name=str_replace("tr|", "", $ts[1]);
		$uniprot_name=str_replace("sp|", "", $uniprot_name);
		
		$result["pro_uniprot"]="<a href='http://www.uniprot.org/uniprot/$uniprot_name' target='_blank'>$ts[1]</a>";
		
		$result["pro_ensp"]=$ts[2];
		$result["lnc_symbol"]="<a href='http://www.genecards.org/cgi-bin/carddisp.pl?gene=$ts[3]' target='_blank'>$ts[3]</a>";
		$result["lnc_ensg"]="<a href='http://uswest.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=$ts[4]' target='_blank'>$ts[4]</a>";
		$result["lnc_enst"]="<a href='http://uswest.ensembl.org/Homo_sapiens/Transcript/Summary?db=core;t=$ts[5]' target='_blank'>$ts[5]</a>";
		$result["y_hat"]=$ts[6];
		
		array_push($results,$result);
	}
}
fclose($file);

}

echo $json=json_encode($results);

?>