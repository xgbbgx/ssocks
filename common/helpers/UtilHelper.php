<?php
namespace common\helpers;

use Yii;
/**
 * 一些统一帮助类
 * @author Administrator
 *
 */
class UtilHelper{
    /**
     * 返回错误码
     */
    public static function rtnError($errorCode="10001",$msg='',$callback=null,$pos=null){
        if(!empty($msg)){
            $errorMsg=$msg;
        }else if(!empty(Yii::t('error',$errorCode))){
                $errorMsg=Yii::t('error',$errorCode);
            }else{
                $errorCode='10001';
                $errorMsg=Yii::t('error',$errorCode);
            }
            $return = array("code"=>$errorCode,"msg"=>$errorMsg,"pos"=>$pos);
            echo (empty($callback) ?json_encode($return) : $callback."(".(json_encode($return)).")");
            exit;
    }
    
    /**
     * componts return 错误
     */
    public static function rtnCode($errorCode="10001",$msg=''){
        if(!empty($msg)){
            $error_msg=$msg;
        }else if(!empty(Yii::t('error',$errorCode))){
                $errorMsg=Yii::t('error',$errorCode);
            }else{
                $errorCode='10001';
                $errorMsg=Yii::t('error',$errorCode);
            }
            $return = array("code"=>$errorCode,"msg"=>$errorMsg);
            return $return;
    }
    /**
     * 获取 model的第一条错误
     * @param unknown $model
     * @return string|mixed
     */
    public static function getModelError($modelError) {
        if(!is_array($modelError)) return '';
        $firstError = array_shift($modelError);
        if(!is_array($firstError)) return '';
        return array_shift($firstError);
    }
    
    /**
     * jquery.datatables 的参数
     */
    public static function getDataTablesParams($arr=array(),$aColumns=array()){
        if(empty($arr) || empty($aColumns)){
            return;
        }
        $data=array();
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".( intval($_GET['iDisplayStart']) ).", ".
                ( intval($_GET['iDisplayLength']) );
        }
        $sOrder='';
        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
            {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" && !empty($aColumns[intval( $_GET['iSortCol_'.$i])]))
                {
                    $sSortDir='asc';
                    if(isset($_GET['sSortDir_'.$i]) && strtolower($_GET['sSortDir_'.$i])=='desc'){
                        $sSortDir='desc';
                    }
                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
					 	".$sSortDir .", ";
                }
            }
            
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }
        $sWhere = "";
        if ( $_GET['sSearch'] != "" )
        {
            $sSearchContent=self::fnSafe($_GET['sSearch']);
            if($sSearchContent){
                $sWhere = "WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    if(!empty($aColumns[$i]) &&  isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true"){
                        $sWhere .= $aColumns[$i]." LIKE  '%".( $sSearchContent )."%' OR ";
                    }
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
            }
        }
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' && !empty($aColumns[$i]))
            {
                $sSearchContent=self::fnSafe($_GET['sSearch_'.$i]);
                if($sSearchContent){
                    if ( $sWhere == "" )
                    {
                        $sWhere = "WHERE ";
                    }
                    else
                    {
                        $sWhere .= " AND ";
                    }
                    $sWhere .= $aColumns[$i]."  '%".($sSearchContent)."%' ";
                }
            }
        }
        $data["sLimit"]=$sLimit;
        $data["sOrder"]=$sOrder;
        $data["sWhere"]=$sWhere;
        return $data;
    }
    /**
     * 简单的 php 防注入、防跨站 函数
     * @return String
     */
    
    public static function fnSafe($str_string) {
        //直接剔除
        $_arr_dangerChars = array(
            "|", ";", "$", "@", "+", "\t", "\r", "\n", ",", "(", ")", PHP_EOL //特殊字符
        );
        
        //正则剔除
        $_arr_dangerRegs = array(
            /* -------- 跨站 --------*/
            
            //html 标签
            "/<(script|frame|iframe|bgsound|link|object|applet|embed|blink|style|layer|ilayer|base|meta)\s+\S*>/i",
            
            //html 属性
            "/on(afterprint|beforeprint|beforeunload|error|haschange|load|message|offline|online|pagehide|pageshow|popstate|redo|resize|storage|undo|unload|blur|change|contextmenu|focus|formchange|forminput|input|invalid|reset|select|submit|keydown|keypress|keyup|click|dblclick|drag|dragend|dragenter|dragleave|dragover|dragstart|drop|mousedown|mousemove|mouseout|mouseover|mouseup|mousewheel|scroll|abort|canplay|canplaythrough|durationchange|emptied|ended|error|loadeddata|loadedmetadata|loadstart|pause|play|playing|progress|ratechange|readystatechange|seeked|seeking|stalled|suspend|timeupdate|volumechange|waiting)\s*=\s*(\"|')?\S*(\"|')?/i",
            
            //html 属性包含脚本
            "/\w+\s*=\s*(\"|')?(java|vb)script:\S*(\"|')?/i",
            
            //js 对象
            "/(document|location)\s*\.\s*\S*/i",
            
            //js 函数
            "/(eval|alert|prompt|msgbox)\s*\(.*\)/i",
            
            //css
            "/expression\s*:\s*\S*/i",
            
            /* -------- sql 注入 --------*/
            
            //显示 数据库 | 表 | 索引 | 字段
            "/show\s+(databases|tables|index|columns)/i",
            
            //创建 数据库 | 表 | 索引 | 视图 | 存储过程 | 存储过程
            "/create\s+(database|table|(unique\s+)?index|view|procedure|proc)/i",
            
            //更新 数据库 | 表
            "/alter\s+(database|table)/i",
            
            //丢弃 数据库 | 表 | 索引 | 视图 | 字段
            "/drop\s+(database|table|index|view|column)/i",
            
            //备份 数据库 | 日志
            "/backup\s+(database|log)/i",
            
            //初始化 表
            "/truncate\s+table/i",
            
            //替换 视图
            "/replace\s+view/i",
            
            //创建 | 更改 字段
            "/(add|change)\s+column/i",
            
            //选择 | 更新 | 删除 记录
            "/(select|update|delete)\s+\S*\s+from/i",
            
            //插入 记录 | 选择到文件
            "/insert\s+into/i",
            
            //sql 函数
            "/load_file\s*\(.*\)/i",
            
            //sql 其他
            "/(outfile|infile)\s+(\"|')?\S*(\"|')/i",
        );
        
        $_str_return = $str_string;
        //$_str_return = urlencode($_str_return);
        
        foreach ($_arr_dangerChars as $_key=>$_value) {
            $_str_return = str_ireplace($_value, "", $_str_return);
        }
        
        foreach ($_arr_dangerRegs as $_key=>$_value) {
            $_str_return = preg_replace($_value, "", $_str_return);
        }
        
        $_str_return = htmlentities($_str_return, ENT_QUOTES, "UTF-8", true);
        
        return $_str_return;
    }
    
    /**
     * 检查日期格式
     */
    public static function checkDatetime($str, $format="Y-m-d H:i:s"){
        $unixTime=strtotime($str);
        $checkDate= date($format, $unixTime);
        if($checkDate===$str)
            return true;
            else
                return false;
    }
    /**
     检查 email
     */
    public static function checkEmail($email=''){
        if(empty($email)){
            return false;
        }
        if(preg_match('/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/',$email))
        {
            return true;
        }
        return false;
    }
    
    /**
     * 
     */
    public static function rtnUqCode(){
        $randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);
        return md5(hash('sha512', $randomData));
    }
    /**
     * 
     * @param unknown $name
     * @return string
     */
    public static function rtnNameByLang($name){
        $language=Yii::$app->language;
        if($language=='zh-CN'){
            $name=$name.'_cn';
        }else if($language=='zh-TW'){
            $name=$name.'_tw';
        }
        return $name;
    }
    
    /**
     * [getIP description]
     * @return [type] [description]
     */
    public static function getIP(){
        $remoteAddr = @getenv("REMOTE_ADDR");
        $xForward = @getenv("HTTP_X_FORWARDED_FOR");
        
        if ($xForward) {
            $arr = explode(",",$xForward);
            $cnt = count($arr);
            $xForward = $cnt==0?"":trim($arr[$cnt-1]);
        }
        
        if (self::isPrivateIp($remoteAddr) && $xForward) {
            return $xForward;
        }
        return $remoteAddr;
    }
    public static function isPrivateIp($ip) {
        $i = explode('.', $ip);
        if ($i[0] == 10) return true;
        if ($i[0] == 172 && $i[1] > 15 && $i[1] < 32) return true;
        if ($i[0] == 192 && $i[1] == 168) return true;
        return false;
    }
    public static function rtnMilesByTime($time){
        $miles=0;
        switch ($time)
        {   
            case $time>=1:
                 $miles=1*$time;
            break;
        }
        return $miles;
    }
    public static function rtnStoreCurrency($currency){
        $currencyS='CNY';
        if($currency=='2'){
            $currencyS='USD';
        }else if($currency=='3'){
            $currencyS='USD';
        }
        return $currencyS;
    }
    public static function rtnStorePay($pay){
        $payS='';
        if($pay=='1'){
            $payS='paypal';
        }else if($pay=='2'){
            $payS='alipay';
        }else if($pay=='3'){
            $payS='wxpay';
        }
        return $payS;
    }
    public  static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
    public static function arrayToObject($array) {
        if (is_array($array)) {
            $obj = new \StdClass();
            foreach ($array as $key => $val){
                $obj->$key = $val;
            }
        }
        else { $obj = $array; }
        return $obj;
    }
}