<?php
header("Content-type: text/html; charset=utf-8"); 
require('../config.php');
require('../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
date_default_timezone_set(PRC);
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');

require('../common/utility_shop.php');
require('../proxy_info.php');	
$callback = $configutil->splash_new($_GET["callback"]);
//$customerid =$configutil->splash_new($_GET["customerid"]); //去掉，前面引入的文件中已经获取
$fromuser =$configutil->splash_new($_GET["fromuser"]);
$userid =$configutil->splash_new($_GET["userid"]);
$batchcode =$configutil->splash_new($_GET["batchcode"]);



$query="select totalprice,pid from weixin_commonshop_orders where batchcode='".$batchcode."' limit 0,1";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$pid=-1;
$totalprice=0;
$pro_name_one=""; //产品名称
$pro_name=""; //产品名称
while ($row = mysql_fetch_object($result)) {
    $totalprice = $row->totalprice; 	//订单总金额
    $pid = $row->pid;
	$sql="select name from weixin_commonshop_products where id='".$pid."'";
	$result_sql = mysql_query($sql) or die('Query failed: ' . mysql_error());
	$agent_discount=0;
	while ($row_sql = mysql_fetch_object($result_sql)) {
		$product_name = $row_sql->name;	
		$pro_name_one = "<".$product_name.">";
	} 
	$pro_name = $pro_name.$pro_name_one;
}
	
	//$content="亲，您有订单未付款，<a href='http://".$http_host."/weixinpl/common_shop/jiushop/order_list.php?customer_id=".$customer_id_en."&user_id=".$userid."&islist=1'>[去付款]</a>";
	$content = "亲，您有一笔订单【未支付】\n商品：".$pro_name."\n金额：".$totalprice."元\n时间：".date( "Y-m-d H:i:s")."\n\n<a href='http://".$http_host."/weixinpl/common_shop/jiushop/order_list.php?customer_id=".$customer_id_en."&user_id=".$userid."&islist=1'>【立即支付】</a>";
	$shopmessage= new shopMessage_Utlity();
	$shopmessage->SendMessage($content,$fromuser,$customer_id);



fclose($f); 

$error =mysql_error();
mysql_close($link);
echo $callback."([{status:1}";
echo "]);";
echo $callback;

?>