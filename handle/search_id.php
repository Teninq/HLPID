<?php
include "include/mysql.php";
include "include/function.php";


$search_id=$_REQUEST["search_id"];


$search_id=trim($search_id);
$type=$_REQUEST["type"];



$ll="\"";//


{
	$sql="SELECT * FROM LNCRNA.lncRNA where original_id  like $ll%$search_id%$ll or gene_id like $ll%$search_id%$ll or gene_symbol like $ll%$search_id%$ll";                   
}

$results=$db->find($sql);

for($i=0;$i<count($results);$i++)
{   
	
	
	$original_id=$results[$i]->original_id;
	$gene_id=$results[$i]->gene_id;
	$gene_id_show=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_id);

	$lncrna_id=$results[$i]->lncrna_id;
	$lncrna_id_show=str_replace($search_id, "<span style='color:red'>$search_id</span>", $lncrna_id);
	
	$lncrna_id="<a href='http://uswest.ensembl.org/Homo_sapiens/Transcript/Summary?db=core;t=$lncrna_id' target='_blank'>$lncrna_id_show</a>";
	
	
	$gene_id="<a   href='http://uswest.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=$gene_id' target='_blank'>$gene_id_show</a>";
	#$gene_id=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_id);
	
	
	$results[$i]->seq="<a style='cursor:pointer' data_tissue='$original_id' onclick='show_table(this)'><img src='img/tcga.jpg'><a>";

	#$original_id=str_replace($search_id, "<span style='color:red'>$search_id</span>", $original_id);

	$gene_symbol=$results[$i]->gene_symbol;
	$gene_symbol_show=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_symbol);
	
	#http://www.genecards.org/cgi-bin/carddisp.pl?gene=$gene_symbol
	#$gene_symbol=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_symbol);
	$gene_symbol="<a   href='http://www.genecards.org/cgi-bin/carddisp.pl?gene=$gene_symbol' target='_blank'>$gene_symbol_show</a>";



	$results[$i]->gene_id=$gene_id;
	$results[$i]->lncrna_id=$lncrna_id;
	$results[$i]->gene_symbol=$gene_symbol;
	$results[$i]->lnc_protein="<a href='interact_predict_protein.html?lnc=$original_id' target='_blank'><img src='img/timg.jpg'></a>";

}

echo $json=json_encode($results)

?>