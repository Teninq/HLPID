<?php
// ini_set('display_errors','On');
// error_reporting(E_ALL);

$posti=0;
$webdir=$_SERVER['DOCUMENT_ROOT'];
$dtemp=$webdir."/msdb/data/splib_raw/";
$dout_splib=$webdir."/msdb/data/splib_out/";
set_time_limit(0);
date_default_timezone_set('UTC');
$my_link["host"]="202.127.22.39";
//$my_link["username"]="caoruifang";
//$my_link["password"]="caoruifang";
//$my_link["dbname"]="sapdb";

$my_link["username"]="webserver";
$my_link["password"]="ecnu2015";
$my_link["dbname"]="LNCRNA";

$my_link["charset"]="utf8";
$db=new Mysql($my_link);



class Mysql{
    var $conn;
    var $query_list = array();
    public $query_count = 0;

    public function __construct($c){
        if(!isset($c['port'])){
            $c['port'] = '3306';
        }
        $server = $c['host'] . ':' . $c['port'];
        $this->conn = mysql_connect($server, $c['username'], $c['password'], true) or die('connect db error');
        mysql_select_db($c['dbname'], $this->conn) or die('select db error');
        if($c['charset']){
            mysql_query("set names " . $c['charset'], $this->conn);
        }
    }

    /**
     * 鎵ч敓鏂ゆ嫹 mysql_query 閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷�
     */
    public function query($sql){
        $stime = microtime(true);

        $result = mysql_query($sql, $this->conn);
        $this->query_count ++;
        if($result === false){
            throw new Exception(mysql_error($this->conn)." in SQL: $sql");
        }

        $etime = microtime(true);
        $time = number_format(($etime - $stime) * 1000, 2);
        $this->query_list[] = $time . ' ' . $sql;
        return $result;
    }

    /**
     * 鎵ч敓鏂ゆ嫹 SQL 閿熸枻鎷烽敓锟�閿熸枻鎷烽敓鎴枻鎷烽敓渚ョ鎷蜂竴閿熸枻鎷烽敓鏂ゆ嫹褰�閿熸枻鎷蜂竴閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷�.
     */
    public function get($sql){
        $result = $this->query($sql);
        if($row = mysql_fetch_object($result)){
            return $row;
        }else{
            return null;
        }
    }

    /**
     * 閿熸枻鎷烽敓鎴鎷疯閿熸枻鎷烽敓锟�閿熸枻鎷�key 涓洪敓鏂ゆ嫹閿熸枻鎷风粐閿熺即鐧告嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷� 姣忎竴閿熸枻鎷峰厓閿熸枻鎷烽敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹.
     * 閿熸枻鎷烽敓锟絢ey 涓洪敓鏂ゆ嫹, 閿熸触灏嗘枻鎷烽敓鏂ゆ嫹閿熻顖ゆ嫹閿熸枻鎷烽敓閰殿煉鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓锟�
     */
    public function find($sql, $key=null){
        $data = array();
        $result = $this->query($sql);
        while($row = mysql_fetch_object($result)){
            if(!empty($key)){
                $data[$row->{$key}] = $row;
            }else{
                $data[] = $row;
            }
        }
        return $data;
    }

    public function last_insert_id(){
        return mysql_insert_id($this->conn);
    }

    /**
     * 鎵ч敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鍙枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓锟絚ount SQL 閿熸枻鎷烽敓锟�閿熸枻鎷烽敓鏂ゆ嫹閿熺煫纭锋嫹閿熸枻鎷�
     */
    public function count($sql){
        $result = $this->query($sql);
        if($row = mysql_fetch_array($result)){
            return (int)$row[0];
        }else{
            return 0;
        }
    }

    /**
     * 閿熸枻鎷峰涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹.
     */
    public function begin(){
        mysql_query('begin');
    }

    /**
     * 閿熺粨浜や竴閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷�
     */
    public function commit(){
        mysql_query('commit');
    }

    /**
     * 閿熸埅鐧告嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹.
     */
    public function rollback(){
        mysql_query('rollback');
    }

    /**
     * 閿熸枻鎷峰彇鎸囬敓鏂ゆ嫹閿熸枻鎷疯鍕熼敓閾帮拷
     * @param int $id 瑕侀敓鏂ゆ嫹鍙栭敓渚ョ》鎷峰綍閿熶茎鎲嬫嫹閿燂拷
     * @param string $field 閿熻璁规嫹閿熸枻鎷� 榛橀敓鏂ゆ嫹涓�id'.
     */
    function load($table, $id, $field='id'){
        $sql = "select * from `{$table}` where `{$field}`='{$id}'";
        $row = $this->get($sql);
        return $row;
    }

    /**
     * 閿熸枻鎷烽敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷峰綍, 閿熸枻鎷烽敓鐭尨鎷� id閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷�
     * @param object $row
     */
    function save($table, &$row){
        $sqlA = '';
        foreach($row as $k=>$v){
            $sqlA .= "`$k` = '$v',";
        }

        $sqlA = substr($sqlA, 0, strlen($sqlA)-1);
        $sql  = "insert into `{$table}` set $sqlA";
        $this->query($sql);
        if(is_object($row)){
            $row->id = $this->last_insert_id();
        }else if(is_array($row)){
            $row['id'] = $this->last_insert_id();
        }
    }

    /**
     * 閿熸枻鎷烽敓鏂ゆ嫹$arr[id]閿熸枻鎷锋寚閿熸枻鎷烽敓渚ョ》鎷峰綍.
     * @param array $row 瑕侀敓鏂ゆ嫹閿熼摪鐨勭》鎷峰綍, 閿熸枻鎷烽敓鏂ゆ嫹涓篿d閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熻鎶电敇鎾呮嫹閿熸枻鎷烽敓鎻亷鎷烽敓鏂ゆ嫹纰屽嫙閿熼摪锟�
     * @return int 褰遍敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿燂拷
     * @param string $field 閿熻璁规嫹閿熸枻鎷� 榛橀敓鏂ゆ嫹涓�id'.
     */
    function update($table, &$row, $field='id'){
        $sqlA = '';
        foreach($row as $k=>$v){
            $sqlA .= "`$k` = '$v',";
        }

        $sqlA = substr($sqlA, 0, strlen($sqlA)-1);
        if(is_object($row)){
            $id = $row->{$field};
        }else if(is_array($row)){
            $id = $row[$field];
        }
        $sql  = "update `{$table}` set $sqlA where `{$field}`='$id'";
        return $this->query($sql);
    }

    /**
     * 鍒犻敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷峰綍.
     * @param int $id 瑕佸垹閿熸枻鎷峰嫙閿熼摪纭锋嫹閿熸枻鎷�
     * @return int 褰遍敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿燂拷
     * @param string $field 閿熻璁规嫹閿熸枻鎷� 榛橀敓鏂ゆ嫹涓�id'.
     */
    function remove($table, $id, $field='id'){
        $sql  = "delete from `{$table}` where `{$field}`='{$id}'";
        return $this->query($sql);
    }

    function escape(&$val){
        if(is_object($val) || is_array($val)){
            $this->escape_row($val);
        }
    }

    function escape_row(&$row){
        if(is_object($row)){
            foreach($row as $k=>$v){
                $row->$k = mysql_real_escape_string($v);
            }
        }else if(is_array($row)){
            foreach($row as $k=>$v){
                $row[$k] = mysql_real_escape_string($v);
            }
        }
    }

    function escape_like_string($str){
        $find = array('%', '_');
        $replace = array('\%', '\_');
        $str = str_replace($find, $replace, $str);
        return $str;
    }
}
?>
