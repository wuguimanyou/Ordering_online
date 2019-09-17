<?php
header("Content-type: text/html; charset=utf-8"); 
require('../config.php');
require('../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
date_default_timezone_set(PRC);
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');

$batchcode =$configutil->splash_new($_POST["batchcode_id"]);   //订单号
$sendway =$configutil->splash_new($_POST["sendway"]);   //发货指派

$sql="update weixin_commonshop_orders set sendway = ".$sendway." where batchcode=".$batchcode;
mysql_query($sql) or die('Query failed103: ' . mysql_error());
$error =mysql_error();
if($error!=""){
	$msg['status'] = 102;
	$msg['info'] = $error;
}else{
	$msg['status'] = 0;
	$msg['info'] = "成功";		
}
echo json_encode($msg); 

?>