<?php

include "include/mysql.php";
include "include/function.php";

$sample=$_REQUEST["sample"];
$p_value=$_REQUEST["p_value"];
$n=$_REQUEST["n"];
$pic_name= time().".jpg";
$post_data=array();
$post_data['sample']=$_REQUEST["sample"];
$post_data['p_value']=$_REQUEST["p_value"];
$post_data['n']=$_REQUEST["n"];
#exec("Rscript tcga_signal.R ".$sample." ".$p_value." ".$n." ".$pic_name,$a,$states);


#echo  "Rscript tcga_signal.R ".$sample." ".$p_value." ".$n." ".$pic_name;
#echo "Rscript LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name;
#echo $states;
#echo "handle/tmp/".$pic_name;
#echo "xxx";

function request_post($url = '', $post_data = array()) {
	if (empty($url) || empty($post_data)) {
		return false;
	}

	$o = "";
	foreach ( $post_data as $k => $v )
	{
		$o.= "$k=" . urlencode( $v ). "&" ;
	}
	$post_data = substr($o,0,-1);

	$postUrl = $url;
	$curlPost = $post_data;
	$ch = curl_init();//初始化curl
	curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch);//运行curl
	curl_close($ch);

	echo $data;
}
#echo "ddd";


$url="https://www.52yanyan.cn/CLncRNA/handle/tcga_signal.php";
$res = request_post($url, $post_data);
#echo($res);

?>