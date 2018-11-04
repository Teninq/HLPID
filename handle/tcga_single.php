<?php
include "include/mysql.php";
include "include/function.php";

$sample=$_REQUEST["sample"];
$lncrna=$_REQUEST["lncrna"];
$n=$_REQUEST["n"];
$pic_name= time().".jpg";


#echo "/usr/lib64/R/bin/Rscript tcga/LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name,$a,$states;

exec("/usr/lib64/R/bin/Rscript tcga/tcga_single.R ".$sample." ".$lncrna." ".$n." ".$pic_name,$a,$states);

#echo "Rscript LncRNA.R ".$sample." ".$lncrna." ".$n." ".$pic_name;
#echo $states;
#$url = 'https://mobile.jschina.com.cn/jschina/register.php';


echo "handle/tcga/tmp/".$pic_name;
?>
