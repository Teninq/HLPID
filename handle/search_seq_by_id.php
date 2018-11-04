<?php
include "include/mysql.php";
include "include/function.php";

$search_seq=$_REQUEST["id"];

$search_seq=trim($search_seq);
$ll="\"";//


$sql="SELECT * FROM LNCRNA.lncRNA where original_id  like $ll%$search_seq%$ll  ";


$results=$db->find($sql);



echo $json=json_encode($results[0])
?>