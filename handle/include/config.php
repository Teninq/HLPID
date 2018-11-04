<?PHP
$server = "localhost:3306"; 
#$username = "lipeng"; 		
#$password = "hitler"; 	
$username = "webserver";
$password = "ecnu2015";

$database = "LNCRNA"; 
$couldNotConnectMysql="database connect fail";
$conn = mysql_connect($server,$username,$password) or die ($couldNotConnectMysql); 
mysql_select_db($database,$conn) or die ($couldNotOpenDatabase);
$usercode="7X5BY";
error_reporting(E_ALL);

$posti=0;
$webdir=$_SERVER['DOCUMENT_ROOT'];
$dtemp=$webdir."/msdb/data/splib_raw/";
$ddata=$webdir."/msdb/data/uploadfile/";
$dscript=$webdir."/msdb/include/script/";
set_time_limit(0);
date.timezone = "Asia/Chongqing";
?>
