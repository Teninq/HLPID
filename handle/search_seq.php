<?php
include "include/mysql.php";
include "include/function.php";


$search_seq=$_REQUEST["search_seq"];

$search_seq=trim($search_seq);
$ll="\"";//


$sql="SELECT * FROM LNCRNA.lncRNA where seq  like $ll%$search_seq%$ll  ";


$results=$db->find($sql);

for($i=0;$i<count($results);$i++)
{   $seq=$results[$i]->seq;;
	$seq=str_replace($search_seq, "<span style='color:red'>$search_seq</span>", $seq);
	
	$original_id=$results[$i]->original_id;
	
	
	$gene_id=$results[$i]->gene_id;
	#$gene_id=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_id);
	
	$lncrna_id=$results[$i]->lncrna_id;
	$lncrna_id="<a href='http://uswest.ensembl.org/Homo_sapiens/Transcript/Summary?db=core;t=$lncrna_id' target='_blank'>$lncrna_id</a>";
	
	
	$gene_id="<a   href='http://uswest.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=$gene_id' target='_blank'>$gene_id</a>";
	#$gene_id=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_id);
	
	
	#$results[$i]->seq="<a style='cursor:pointer' data_tissue='$original_id' onclick='show_table(this)'><img src='img/tcga.jpg'><a>";
	
	#$original_id=str_replace($search_id, "<span style='color:red'>$search_id</span>", $original_id);
	
	$gene_symbol=$results[$i]->gene_symbol;
	#http://www.genecards.org/cgi-bin/carddisp.pl?gene=$gene_symbol
	#$gene_symbol=str_replace($search_id, "<span style='color:red'>$search_id</span>", $gene_symbol);
	$gene_symbol="<a   href='http://www.genecards.org/cgi-bin/carddisp.pl?gene=$gene_symbol' target='_blank'>$gene_symbol</a>";
	$results[$i]->gene_id=$gene_id;
	$results[$i]->lncrna_id=$lncrna_id;
	$results[$i]->gene_symbol=$gene_symbol;
	$results[$i]->seq=$seq;
	$results[$i]->lnc_protein="<a href='interact_predict_protein.html?lnc=$original_id' target='_blank'><img src='img/timg.jpg'></a>";
	
}

echo $json=json_encode($results)

?>