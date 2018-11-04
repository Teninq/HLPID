<?php
include "include/mysql.php";
include "include/function.php";




$search_id=$_REQUEST["search_id"];
$type=$_REQUEST["type"];

$search_id="ENST00000294715";
$ll="\"";//

$datas=array();
$results=array();
$colors=array();


$colors['Thyroid']='rgb(212.388237834,212.388237834,212.388237834)';
$colors['Cervix - Ectocervix']='rgb(191.305886149,191.305886149,191.305886149)';
$colors['Cervix - Endocervix']='rgb(191.305886149,191.305886149,191.305886149)';
$colors['Testis']='rgb(164.070593655,164.070593655,164.070593655)';
$colors['Uterus']='rgb(137.372553289,137.372553289,137.372553289)';
$colors['Vagina']='rgb(112.282353848,112.282353848,112.282353848)';
$colors['Fallopian Tube']='rgb(87.4352965057,87.4352965057,87.4352965057)';
$colors['Pituitary']='rgb(56.9411785603,56.9411785603,56.9411785603)';
$colors['Minor Salivary Gland']='rgb(26.6980403662,26.6980403662,26.6980403662)';
$colors['Stomach']='rgb(219.3,94.656,86.7)';
$colors['Spleen']='rgb(219.3,194.106,86.7)';
$colors['Bladder']='rgb(145.044,219.3,86.7)';
$colors['Breast - Mammary Tissue']='rgb(86.7,219.3,127.806)';
$colors['Colon - Sigmoid']='rgb(86.7,211.344,219.3)';
$colors['Colon - Transverse']='rgb(86.7,211.344,219.3)';
$colors['Prostate']='rgb(86.7,111.894,219.3)';
$colors['Pancreas']='rgb(160.956,86.7,219.3)';
$colors['Liver']='rgb(219.3,86.7,178.194)';
$colors['Heart - Atrial Appendage']='rgb(137.7,22.644,15.3)';
$colors['Heart - Left Ventricle']='rgb(137.7,22.644,15.3)';
$colors['Cells - EBV-transformed lymphocytes']='rgb(137.7,114.444,15.3)';
$colors['Cells - Transformed fibroblasts']='rgb(137.7,114.444,15.3)';
$colors['Adipose - Subcutaneous']='rgb(69.156,137.7,15.3)';
$colors['Adipose - VisceralOmentum']='rgb(69.156,137.7,15.3)';
$colors['Artery - Aorta']='rgb(15.3,137.7,53.244)';
$colors['Artery - Coronary']='rgb(15.3,137.7,53.244)';
$colors['Artery - Tibial']='rgb(15.3,137.7,53.244)';
$colors['Small Intestine - Terminal Ileum']='rgb(15.3,130.356,137.7)';
$colors['Ovary']='rgb(15.3,38.556,137.7)';
$colors['Muscle - Skeletal']='rgb(83.844,15.3,137.7)';
$colors['Whole Blood']='rgb(137.7,15.3,99.756)';
$colors['Esophagus - Gastroesophageal Junction']='rgb(69,77,162)';
$colors['Esophagus - Mucosa']='rgb(69,77,162)';
$colors['Esophagus - Muscularis']='rgb(69,77,162)';
$colors['Nerve - Tibial']='rgb(149,165,166)';
$colors['Brain - Amygdala']='rgb(255,0,0)';
$colors['Brain - Anterior cingulate cortexBA24']='rgb(255,0,0)';
$colors['Brain - Caudatebasal ganglia']='rgb(255,0,0)';
$colors['Brain - Cerebellar Hemisphere']='rgb(255,0,0)';
$colors['Brain - Cerebellum']='rgb(255,0,0)';
$colors['Brain - Cortex']='rgb(255,0,0)';
$colors['Brain - Frontal CortexBA9']='rgb(255,0,0)';
$colors['Brain - Hippocampus']='rgb(255,0,0)';
$colors['Brain - Hypothalamus']='rgb(255,0,0)';
$colors['Brain - Nucleus accumbensbasal ganglia']='rgb(255,0,0)';
$colors['Brain - Putamenbasal ganglia']='rgb(255,0,0)';
$colors['Brain - Spinal cordcervical c-1']='rgb(255,0,0)';
$colors['Brain - Substantia nigra']='rgb(255,0,0)';
$colors['Lung']='rgb(166,206,227)';
$colors['Skin - Not Sun ExposedSuprapubic']='rgb(141,159,202)';
$colors['Skin - Sun ExposedLower leg']='rgb(141,159,202)';
$colors['Adrenal Gland']='rgb(0,0,255)';
$colors['Kidney - Cortex']='rgb(255,0,255)';



#$sql="SELECT * FROM LNCRNA.expression_multi_tissue where Tissue  like $ll%$search_id%$ll";


$file = fopen("/home/webserver/CLncRNA/handle/boxplot/tittle.txt","r");
$text=fgets($file);
fclose($file);
$tittles=explode("\t",$text);

$file = fopen("/home/webserver/CLncRNA/handle/boxplot/data/$search_id.txt","r");
if (file_exists($file_path))
{	
	$text=fgets($file);
	$datas=explode("\t",$text);
}
fclose($file);

for($i=1;$i<count($tittles);$i++)
{
	$data=array();
	$values=explode(",",$datas[$i]);
	for($i=0;$i<count($values);$i++)
	{
	
		$values[$i] = intval($values[$i]);
	
	}
	
	$color=$colors[$name];
	
	$marker=array();
	$marker['color']=$color;
	$data['marker']=$marker;
	
	$data['boxpoints']="outliers";
	$data['legendgroup']="VV";
	$data['y']=$values;
	$data['pointpos']=0;
	$data['whiskerwidth']=1;
	$data['fillcolor']='cls';
	//$data['jitter']=0;
	$data['name']=$name;
	$data['type']="box";
	$data['zmax']=10;
	
	//$data['showlegend']=false;
	array_push($datas,$data);
}





foreach($result as $name=>$value)
{
	if($name!=="Tissue")
	{
		$data=array();
		$values=explode(",",$value);
		
		for($i=0;$i<count($values);$i++)
		{
		
			$values[$i] = intval($values[$i]);
		
		}
		$color=$colors[$name];
		
		$marker=array();
		$marker['color']=$color;
		$data['marker']=$marker;
	
		$data['boxpoints']="outliers";
		$data['legendgroup']="VV";
		$data['y']=$values;
		$data['pointpos']=0;
		$data['whiskerwidth']=1;
		$data['fillcolor']='cls';
		//$data['jitter']=0;
		$data['name']=$name;
		$data['type']="box";
		$data['zmax']=10;
		
		//$data['showlegend']=false;
		array_push($datas,$data);
	}
	
}

echo $json=json_encode($datas)

?>