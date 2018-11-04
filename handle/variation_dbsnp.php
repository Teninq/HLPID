<?php
include "include/mysql.php";
include "include/function.php";


$variation_snp=$_REQUEST["variation_snp"];
$type=$_REQUEST["type"];
$variation_snp=trim($variation_snp);

$datas=array();


$ll="\"";//

if($type=="lnc_enst")
{
	$sql="SELECT * FROM LNCRNA.lncRNA where original_id  like $ll%$variation_snp%$ll";
}
elseif ($type=="lnc_ensg")
{
	$sql="SELECT * FROM LNCRNA.lncRNA where gene_id  like $ll%$variation_snp%$ll";
}
elseif($type=="lnc_symbol")
{
	$sql="SELECT * FROM LNCRNA.lncRNA where gene_symbol  like $ll%$variation_snp%$ll ";
}
else 
{
	$sql="SELECT * FROM LNCRNA.lncRNA where original_id  like $ll%$variation_snp%$ll or gene_id like $ll%$variation_snp%$ll or gene_symbol like $ll%$variation_snp%$ll";
}



$results=$db->find($sql);
for($j=0;$j<count($results);$j++)
{
	
	    $lnc_enst=$results[$j]->original_id;
	    $file_path="/home/webserver/HLPID/handle/dbSNP1/$lnc_enst.txt";
		if (file_exists($file_path))
		{
			$file = fopen($file_path,"r");
			$i=0;
			while(!feof($file))
			{   $i=$i+1;
		        $data=array();
		        $data['Start']=$results[$j]->start;
		        $data['End']=$results[$j]->end;
		        $data['Strand']=$results[$j]->strand;
		        
		        $original_id=$results[$j]->original_id;
				$data['CHLncRNA_ID']="<a href='http://uswest.ensembl.org/Homo_sapiens/Transcript/Summary?db=core;t=$original_id' target='_blank'>$original_id</a>";
				$gene_id=$results[$j]->gene_id;
				$data['lnc_ensg']="<a href='http://uswest.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=$gene_id' target='_blank'>$gene_id</a>";
				$gene_symbol=$results[$j]->gene_symbol;
				$data['gene_symbol']="<a href='http://www.genecards.org/cgi-bin/carddisp.pl?gene=$gene_symbol' target='_blank'>$gene_symbol</a>";
				
		        
		        
		        
				$text=fgets($file);
				$ts=explode("\t",$text);
				
				if($ts[0]=="")
				{
					break;
				}
				
				
				$data['Feature']=$ts[0];
				$data['Chr']=$ts[2];
				$data['Position']=$ts[3];
				#https://www.ncbi.nlm.nih.gov/snp/?term=rs942133
				$data['dbSNP_ID']="<a href='https://www.ncbi.nlm.nih.gov/snp/?term=$ts[4]' target='_blank'>$ts[4]</a>";
				
				$data['REF']=$ts[5];
				$data['ALT']=$ts[6];
				$data['score']=$ts[7];
				$data['disease']=$ts[8];
				
				array_push($datas,$data);
			}
		
		fclose($file);
		
		}
	
	
	
}




echo $json=json_encode($datas)

?>