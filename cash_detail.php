<?php
header("Content-type: text/html; charset=utf-8"); 
require('../../../config.php');
require('../../../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
require('../../../back_init.php');
$link = mysql_connect(DB_HOST,DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
mysql_query("SET NAMES UTF8");
require('../../../proxy_info.php');
$head = 1;
$customer_id = passport_decrypt($customer_id);

$batchcode = $configutil->splash_new($_GET["b"]); 

$user_id 		= -1;//用户id
$getmoney 		=  0;//申请提现金额
$status	  		= -1;//提现状态 0：未审核 1：已同意提现 2:驳回 3:用户取消提现
$remark			= '';//状态备注
$cash_type 		=  0;//0：微信零钱1:支付宝,2:财付通,3:银行账户
$createtime 	= '';//最后处理时间
$percentage 	=  0;//折现率（千分比）
$surplus_type 	=  0;//0:全额提现 1：直接扣取 2：返购物币
$real_cash 		=  0;//实际到账金额
$type 			= '';
$query = "SELECT user_id,getmoney,status,remark,cash_type,createtime,percentage,surplus_type,real_cash FROM weixin_cash_being_log WHERE batchcode=$batchcode LIMIT 1";
$result= mysql_query($query) or die('Query failed 16: ' . mysql_error());
while( $row = mysql_fetch_object($result) ){
	$user_id 		= $row->user_id;
	$getmoney 		= $row->getmoney;
	$status	  		= $row->status;
	$remark			= $row->remark;
	$cash_type 		= $row->cash_type;
	$createtime 	= $row->createtime;
	$percentage 	= $row->percentage;
	$surplus_type 	= $row->surplus_type;
	$real_cash 		= $row->real_cash;
}
$status_str = '';
switch ($status) {
	case '0':
		$status_str = '<span style="color:#c22439;font-weight:blod;font-size:14px;">未审核</span>';
	break;

	case '1':
		$status_str = '<span style="color:#06a7e1;font-weight:blod;font-size:14px;">已同意提现</span>';
	break;

	case '2':
		$status_str = '<span style="color:#68af27;font-weight:blod;font-size:14px;">驳回</span>';
	break;

}

//手续费/返购物币
if($surplus_type == 0){
	$commission = 0;
}else{
	$commission = round($getmoney*$percentage/1000,2);
}
$real_cash = round((($getmoney-$commission)*100)/100,2);

switch ($cash_type) {
	case '0':
		$type = '微信零钱';
		break;
	case '0':
		$type = '支付宝';
		break;
	case '0':
		$type = '财付通';
		break;
	case '0':
		$type = '银行卡';
		break;
}
$custom = '购物币';
$query = "SELECT custom FROM weixin_commonshop_currency WHERE isvalid=true AND customer_id=$customer_id LIMIT 1";
$result= mysql_query($query) or die('Query failed 63: ' . mysql_error());
while( $row = mysql_fetch_object($result) ){
	$custom = $row->custom;
}

?>  
<!doctype html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>提现详情</title>
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content.css">
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content<?php echo $theme; ?>.css">
<link rel="stylesheet" type="text/css" href="../../Common/css/Mode/agent/set.css">
<script type="text/javascript" src="../../../common/js/jquery-1.7.2.min.js"></script>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
</head>
<style>
.white1{background-color: #fff;
border-bottom: solid 2px #06a7e1;}
dd{line-height: 28px;}
</style>
<body>
	<!--内容框架-->
	<div class="WSY_content">
		<!--列表内容大框-->
		<div class="WSY_columnbox">
			<!--列表头部切换开始-->
				<?php
			include("basic_head.php"); 
			?> 
			<!--列表头部切换结束-->
			<form action="save_set_balance.php?customer_id=<?php echo $customer_id_en; ?>&user_id=<?php echo $user_id;?>" enctype="multipart/form-data" method="post" id="upform" name="upform" onSubmit="return subBase()">
				<div class="WSY_remind_main">
					
					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">提现用户ID：</dt>
						<dd>
							<a href="cash_being.php?promoter=<?php echo $user_id;?>&b=<?php echo $batchcode;?>" style="color:#06a7e1;"><?php echo $user_id;?></a>
							
						</dd>
					</dl>

					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">申请提现金额：</dt>
						<dd>
							<?php echo $getmoney;?>	元
						</dd>
					</dl>
					<?php if($surplus_type!=0){?>
					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left"><?php if($surplus_type==1){ echo "手续费";}else{ echo $custom;}?> 折率：</dt>
						<dd>
							千分之 <?php echo $percentage;?> 
						</dd>
					</dl>
					<?php 
						}
					if($surplus_type == 1){?>
					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">手续费：</dt>
						<dd>
							<?php echo $commission;?>	元
						</dd>
					</dl>
					<?php }elseif($surplus_type == 2){

					?>
					
					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">返购物币：</dt>
						<dd>
							<?php echo $commission;?>
						</dd>
					</dl>
					<?php }?>
					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">提现到：</dt>
						<dd>
							<?php echo $type;?>
						</dd>
					</dl>

					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">计算后应到账：</dt>
						<dd style="color:red;">
							<?php echo $real_cash;?>	元
						</dd>
					</dl>

					<dl class="WSY_remind_dl02">
						<dt style="line-height:28px;" class="WSY_left">当前状态：</dt>
						<dd style="color:red;">
							<?php echo $status_str;?>
						</dd>
					</dl>

					<input type="hidden" name="real_name" value="<?php echo $real_name; ?>">
					<!--列表按钮开始-->

					<div class="WSY_text_input"><button style="float: left;margin: 20px 10px 20px 10%;" class="WSY_button" >保存</button>
					<input type="button" class="WSY_button" style="float: left;margin: 20px 0 20px 0;"  value="取消" onclick="javascript:history.go(-1);"></div>
				</div> 
			</form>
		</div>
	</div>
<?php mysql_close($link);?>	

<script>



function subBase(){
	var berfor_money = $(".berfor").val();
	var money = $(".not_agent_tip").val();

	var member = /^(\+\d+|\d+|\-\d+|\d+\.\d+|\+\d+\.\d+|\-\d+\.\d+)$/;
	if(money=='' || !member.test(money)){
		alert("请输入正确的金额！");
		return false;
	}
	var after_money = parseFloat(berfor_money)+parseFloat(money);
	if( after_money < 0 ){
		alert("用户余额不足扣取！");
		return false;
	}
	
}



</script>

</body>
</html>