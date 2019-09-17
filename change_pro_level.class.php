<?php
// +---------------------------------------------------------+
// |3*3级分佣更改推广员级别 --保存                           |
// +---------------------------------------------------------+
// |日期:2015-12-21	                                         |	
// +---------------------------------------------------------+
// |By 黄照鸿                                                |
// +---------------------------------------------------------+

header("Content-type: text/html; charset=utf-8"); 
require('../../../config.php');
require('../../../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('change_pro_level.php Could not select database');
require('../../../common/utility_shop.php');

$pagenum = $configutil->splash_new($_GET["pagenum"]);
$user_id=-1; 
if(!empty($_POST["user_id"])){
	$user_id =$configutil->splash_new($_POST["user_id"]);
	$user_id = passport_decrypt($user_id); 
}
$op = "no_method";
if(!empty($_POST["op"])){
	$op =$configutil->splash_new($_POST["op"]);
}
$from = "pro";
if(!empty($_GET["from"])){
	$from =$configutil->splash_new($_GET["from"]);
}
$level = 1;
if(!empty($_POST["level"])){
	$level =$configutil->splash_new($_POST["level"]);
}
$parent_id = -1;
if(!empty($_POST["parent_id"])){
	$parent_id =$configutil->splash_new($_POST["parent_id"]);
}
switch($op){
	case "modify_level":	//修改分佣等级
		//3:插入分佣记录方法
		$shopMessage= new shopMessage_Utlity(); 
		$shopMessage->GetMoney_Common_NCommision($customer_id,$user_id,$level,1,1);
		$shopMessage= new shopMessage_Utlity(); 
		$shopMessage->ChangeRelation_new($user_id,$parent_id,$parent_id,$customer_id,1,1);
		
		$Url = "promoter.php?customer_id=".passport_encrypt($customer_id)."&pagenum=".$pagenum;
		if($from == "fans"){
			$Url = "../fans/fans.php?customer_id=".passport_encrypt($customer_id)."&pagenum=".$pagenum;
		}
	break;
	default:
		echo "未知方法，请联系管理员！";
	break;
}

		
mysql_close($link);

header("Location: ".$Url); 	
exit;
?>