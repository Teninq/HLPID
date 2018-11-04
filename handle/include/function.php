<?php


function web_error($error_state,$error_type,$error_message){

	$error_message=$error_state.":".$error_message;

	switch ($error_type) {
		case 0:
			$error_message="<font color='Brown' face='courier'>".$error_message."</font>";
			break;
		case 1:
			$error_message="<font color='Green' face='courier'>".$error_message."</font>";
			break;
		case 2:
			$error_message="<font color='Purple' face='courier'>".$error_message."</font>";
			break;
	}

	return  $error_message;
}


function to_datasource($ids,$datasoures,$type){
	$out="";
	switch ($type) {
		case 'gene':
			$data=explode(',',$datasoures);
			for($i=0;$i<count($data);$i++){
				switch ($data[$i]) {
					case 'uniprot':
					$out=$out." <a href='http://www.uniprot.org/uniprot/?query=gene%3A".$ids."+AND+taxonomy%3A9606&sort=score' target='_blank'><img src='./img/s_uniprot.png' width='28' height='28' /></a>";	
					break;	
					case 'aceview':
						$out=$out." <a href='http://www.ncbi.nlm.nih.gov/IEB/Research/Acembly/av.cgi?db=human&term=".$ids."' target='_blank'><img src='./img/s_aceview.png' width='28' height='28' /></a>";
					break;
					case 'refseq':
						$out=$out." <a href='http://www.ncbi.nlm.nih.gov/gene?term=(".$ids."%5BGene%20Name%5D)%20AND%209606%5BTaxonomy%20ID%5D' target='_blank'><img src='./img/s_refseq.png' width='28' height='28' /></a>";
						break;
				}
			}
			break;
		case 'protein':
			$data=explode(',',$datasoures);
			$id=explode(',',$ids);
			for($i=0;$i<count($data);$i++){
				switch ($data[$i]) {
					case 'uniprot':
					$uniprotid=explode('|',$id[$i]);
					$unid=$uniprotid[1];			
					$out=$out." <a href='http://www.uniprot.org/uniprot/?query=".$unid."+AND+taxonomy%3A9606&sort=score' target='_blank'>$id[$i]</a>,";	
					break;	
					case 'aceview':
						$out=$out." <a href='http://www.ncbi.nlm.nih.gov/IEB/Research/Acembly/av.cgi?db=human&term=".$id[$i]."' target='_blank'>$id[$i]</a>,";
					break;
					case 'refseq':
						$out=$out." <a href='http://www.ncbi.nlm.nih.gov/protein?term=".$id[$i]."' target='_blank'>$id[$i]</a>,";
						break;
				}
			}
			break;
		case 'datasource':
			$data=explode(',',$datasoures);
			for($i=0;$i<count($data);$i++){
				switch ($data[$i]) {
					case 'uniprot':		
					$out=$out." <img src='./img/s_uniprot.png' width='28' height='28' />";	
					break;	
					case 'aceview':
						$out=$out." <img src='./img/s_aceview.png' width='28' height='28' />";
					break;
					case 'refseq':
						$out=$out." <img src='./img/s_refseq.png' width='28' height='28' />";
						break;
				}
			}
			break;
			
		case 'evi_num':
				if($ids>0){
					$uniprotid=explode(',',$datasoures);
					$unid=$uniprotid[0];
					$out="<a href='query.php?search=".$unid."&s_type=1' target='_blank'>$ids</a>";
				}else{
					$out=$ids;
				}
				break;
	}
	return $out;
	
}


function e2i($a)
{
	$q0_4=-10.9282;
   $q1_4=-2.302585;
   $q2_4=-1.55027;
   $q3_4=0.600926;
   $wh=25;
   if($a=="NA"){
   	$ei="<img src='img/ex_x.png' width='$wh' height='$wh' title='NULL'/>";
   }else{
   	if($a>=$q3_4){
   		$ei="<img src='img/ex_4.png' width='$wh' height='$wh' title='$a'/>";
   	}
   	elseif ($q3_4>$a and $a>=$q2_4){
   		$ei="<img src='img/ex_3.png' width='$wh' height='$wh' title='$a'/>";
   	}
   	elseif ($q2_4>$a and $a>=$q1_4){
   		$ei="<img src='img/ex_2.png' width='$wh' height='$wh' title='$a'/>";
   	}
   	elseif ($q1_4>$a and $a>=$q0_4){
   		$ei="<img src='img/ex_1.png' width='$wh' height='$wh' title='$a'/>";
   	}
   	elseif($a<$q0_4){
   		$ei="<img src='img/ex_0.png' width='$wh' height='$wh' title='$a'/>";
   	}
   }

	return $ei;
}

function protein_exprision_bak($protein_name,$db)
{
	$trows=$db->count("select count(*) from fi_protein inner JOIN mrna_expression on protein.mrna_name=mrna_expression.mrna_name where protein_id='$protein_name'");
	if($trows>0){
		$expression=array();
		$protein=$db->find("select protein_name,sample,expression_value  from protein LEFT JOIN mrna_expression on protein.mrna_name=mrna_expression.mrna_name where protein_name='$protein_name'");
		for($i=0;$i<count($protein);$i++){
			switch ($protein[$i]->sample){
				case "brain":
					$expression["brain"]=$protein[$i]->expression_value;
					break;
				case "uhr":
					$expression["uhr"]=$protein[$i]->expression_value;
					break;		
				case "liver":
					$expression["liver"]=$protein[$i]->expression_value;
					break;
				case "nb076":
					$expression["nb076"]=$protein[$i]->expression_value;
					break;
				case "nb077":
					$expression["nb077"]=$protein[$i]->expression_value;
					break;
				case "nb078":
					$expression["nb078"]=$protein[$i]->expression_value;
					break;
				case "nb079":
					$expression["nb079"]=$protein[$i]->expression_value;
					break;
				case "nb080":
					$expression["nb080"]=$protein[$i]->expression_value;
					break;
			
			}
			
		}
		$outimg=e2i($expression["brain"]).e2i($expression["uhr"]).e2i($expression["liver"]).e2i($expression["nb076"]).e2i($expression["nb077"]).e2i($expression["nb078"]).e2i($expression["nb079"]).e2i($expression["nb080"]);
	}else{
		$outimg=e2i("NA").e2i("NA").e2i("NA").e2i("NA").e2i("NA").e2i("NA").e2i("NA").e2i("NA");
	}
	return $outimg;
	
}


function protein_exprision($protein_name,$db)
{
	$trows=$db->count("select count(*) from fi_protein inner JOIN mrna_expression on fi_protein.mrna_name=mrna_expression.mrna_name where protein_id='$protein_name' and data_source='aceview'");
	if($trows>0){
		$expression=array();
		$protein=$db->find("select protein_name,sample,expression_value  from fi_protein LEFT JOIN mrna_expression on fi_protein.mrna_name=mrna_expression.mrna_name where protein_id='$protein_name' and data_source='aceview'");
		for($i=0;$i<count($protein);$i++){
			switch ($protein[$i]->sample){
				case "brain":
					$expression["brain"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "uhr":
					$expression["uhr"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "liver":
					$expression["liver"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "nb076":
					$expression["nb076"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "nb077":
					$expression["nb077"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "nb078":
					$expression["nb078"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "nb079":
					$expression["nb079"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
				case "nb080":
					$expression["nb080"]=$protein[$i]->expression_value!='NA'?$protein[$i]->expression_value:-20;
					break;
						
			}
				
		}
		$outimg="<table cellpadding='0' cellspacing='0' border='0' class='heat-map' id='heat-map-3'><tbody><tr>";
		$outimg=$outimg."<td name='heatmap' title='".$expression["brain"]."'>exp</td>
						<td name='heatmap' title='".$expression["uhr"]."'>exp</td>
						<td name='heatmap' title='".$expression["liver"]."'>exp</td>
						<td name='heatmap' title='".$expression["nb076"]."'>exp</td>
						<td name='heatmap' title='".$expression["nb077"]."'>exp</td>
						<td name='heatmap' title='".$expression["nb078"]."'>exp</td>
						<td name='heatmap' title='".$expression["nb079"]."'>exp</td>
						<td name='heatmap' title='".$expression["nb080"]."'>exp</td>
							</tr></tbody></table>";
	}else{
		$native=-20;
		$outimg="<table cellpadding='0' cellspacing='0' border='0' class='heat-map' id='heat-map-3'><tbody>";
		$outimg=$outimg."<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		<td name='heatmap' title='".$native."'>exp</td>
		</tr></tbody></table>";
	}
	return $outimg;
}




function getDirFiles($dir,$jobid)
{
	if ($handle = opendir($dir)){
		while (false !== ($file = readdir($handle))) {
			$files[]=$file;
		}
	}
	closedir($handle);
	if($files){
		$ti=0;$pi=0;
		foreach ($files as $fname){
			if(strstr($fname,$jobid)!=false && strpos($fname,"xml")>0){
				$result["xml"][$ti++]=$fname;
			}
			if(strstr($fname,$jobid)!=false && strpos($fname,"xls")>0){
				$result["xls"][$pi++]=$fname;
			}
			if(strstr($fname,$jobid)!=false && strpos($fname,"html")>0){
				$result["html"][$pi++]=$fname;
			}
		}

		if(isset($result)) return $result;
		else return false;
	}
	else return false;
}



?>