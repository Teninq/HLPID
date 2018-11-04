<?php

include "include/mysql.php";
include "include/function.php";



$results=array();
$gene="";
$lncs=array();
$sample=$_REQUEST["sample"];
$p_value=$_REQUEST["p_value"];
$n=$_REQUEST["n"];
$file_path= time();

//echo "/usr/lib64/R/bin/Rscript tcga/tcga_signal.R ".$sample." ".$p_value." ".$n." ".$file_path,$a,$states;

exec("/usr/lib64/R/bin/Rscript tcga/tcga_signal.R ".$sample." ".$p_value." ".$n." ".$file_path,$a,$states);

#echo "/usr/lib64/R/bin/Rscript tcga/tcga_signal.R ".$sample." ".$p_value." ".$n." ".$file_path,$a,$states;

#echo "Rscript tcga_signal.R ".$sample." ".$p_value." ".$n." ".$file_path,$a,$states;
$file=fopen("/var/www/html/HLPID/handle/tcga/tmp/$file_path/lnc.txt","r");
$text=fgets($file);
while(!feof($file))
{   
	$text=fgets($file);
	$ts=explode("\t",$text);
	
	if($ts[0]=="")
	{
		break;
	}
	
	
	$lnc=array();
	#$lnc['sample']=$ts[0];
	$lnc['sample']=str_replace(".", "-", $ts[0]);
	$lnc['score']=$ts[1];
	$lnc['lable']=$ts[2];
	$lnc['c_time']=$ts[3];
	$lnc['c_event']=$ts[4];
	array_push($lncs,$lnc);

}
fclose($file);



$file=fopen("/var/www/html/HLPID/handle/tcga/tmp/$file_path/gene.txt","r");
$text=fgets($file);
$i=0;
$gene=$gene."<tr>";
while(!feof($file))
{   
	$text=fgets($file);
	$ts=explode("\t",$text);
	$i=$i+1;
	if($ts[0]=="")
	{
		break;
	}
	if($i%5==0)
	{
		$gene=$gene."<td><a href='search_id.html?search_id=$ts[0]' target='_blank'>$ts[0]</a> ( <a href='search_id.html?search_id=$ts[1]' target='_blank'>$ts[1]</a>)</td></tr><tr>";
	}
	else 
	{
		$gene=$gene."<td><a href='search_id.html?search_id=$ts[0]' target='_blank'>$ts[0]</a> ( <a href='search_id.html?search_id=$ts[1]' target='_blank'>$ts[1]</a>)</td>";
	}
	

}
$gene=$gene."</tr>";
fclose($file);



$results['pic']="handle/tcga/tmp/".$file_path."/sruv.png";
$results['lnc']=$lncs;
$results['gene']=$gene;
#echo  "Rscript tcga_signal.R ".$sample." ".$p_value." ".$n." ".$pic_name;
#echo "Rscript LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name;
#echo $states;
#echo "handle/tmp/".$pic_name;
#echo "xxx";


#echo "ddd";




echo $json=json_encode($results)


?>