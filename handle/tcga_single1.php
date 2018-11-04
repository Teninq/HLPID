<?php
include "include/mysql.php";
include "include/function.php";

$sample=$_REQUEST["sample"];
$lncrna=$_REQUEST["lncrna"];
$n=$_REQUEST["n"];
$pic_name= time().".jpg";



$post_data=array();
$post_data['sample']=$_REQUEST["sample"];
$post_data['lncrna']=$_REQUEST["lncrna"];
$post_data['n']=$_REQUEST["n"];

#exec("Rscript LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name,$a,$states);

#echo "Rscript LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name;
#echo $states;
#$url = 'https://mobile.jschina.com.cn/jschina/register.php';


#echo "handle/tmp/".$pic_name;

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

$url="https://www.52yanyan.cn/CLncRNA/handle/tcga_single.php";
$res = request_post($url, $post_data);
#echo($res);

?>