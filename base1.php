<?php
header("Content-type: text/html; charset=utf-8"); //test
require('../config.php');
require('../back_init.php');
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');

require('../proxy_info.php');

mysql_query("SET NAMES UTF8");//

$query = "select id,staff_imgurl,name,email,is_showdiscuss,introduce,per_share_score,is_applymoney,exp_name,reward_level,shop_url,nopostage_money,is_needlogin,shop_card_id,member_template_type,is_showshare_info,is_autoupgrade,need_express,distr_type,auto_upgrade_money,auto_upgrade_money_2,is_attent,attent_url,auto_confirmtime,online_type,online_qq,need_online,need_email,sell_detail,issell,sell_discount,reward_type,init_reward,need_customermessage,isprint,detail_template_type,is_showbottom_menu,gz_url,exp_mem_name,watertype,exp_pic_text1,exp_pic_text2,exp_pic_text3,is_applymoney_enddate,is_applymoney_startdate,is_applymoney_minmoney,is_pic,define_share_image,auto_cus_time,isOpenAgent,promoter_bg_imgurl from weixin_commonshops where isvalid=true and customer_id=".$customer_id;
//file_put_contents('hello.txt',$query);
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$name="";
$email="";
$need_express=0;
$need_email=0;
$shop_id=-1;
$issell=0;
$sell_discount = 0;
$reward_type = 2;
$init_reward= 0.2;
$need_customermessage= 0;
$need_online=1;
$online_type = 1;
$online_qq="";
$detail_template_type = 1;
$sell_detail="";
$auto_confirmtime = 30;
$is_attent=0;
$attent_url="";
$member_template_type = 1;
$distr_type = 2;
$is_showbottom_menu = 1;
$auto_upgrade_money = 0;
$is_autoupgrade = 0;
$is_needlogin = 1;
$shop_card_id = -1;
$is_showdiscuss = 1;
$is_showshare_info = 0;
$per_share_score=0;
$introduce = "";
$gz_url = "";
$auto_upgrade_money_2 =0;
$nopostage_money = 0;
$shop_url="";
$staff_imgurl="";
$exp_name = "推广员";
$exp_mem_name = "我的会员_一级会员_二级会员_三级会员";
$reward_level = 3;
$watertype = 1;
$exp_pic_text1 = "消费变成投资 人人都是老板";
$exp_pic_text2 = "长按此图片识别图中二维码搞定";
$exp_pic_text3 = "奖励送不停,别人消费你还有奖励";
$is_pic=0; 	//是否开启评价图片上传
$is_applymoney=1;
$define_share_image='';
$define_share_image_flag;
$auto_cus_time = 7;
$isOpenAgent = 0; //是否在个人中心开启代理商申请
$promoter_bg_imgurl = ""; //推广员背景图片
while ($row = mysql_fetch_object($result)) {
    $name=$row->name;
    $staff_imgurl=$row->staff_imgurl;
	$email=$row->email;
	$need_express= $row->need_express;
	$need_email = $row->need_email;
	$shop_id=$row->id;
	$issell = $row->issell;
	$sell_discount = $row->sell_discount;
	$reward_type = $row->reward_type;
	$init_reward= $row->init_reward;
	$need_customermessage= $row->need_customermessage;
	$need_online = $row->need_online;
	
	$online_type = $row->online_type;
	$online_qq = $row->online_qq;
	$isprint = $row->isprint;
	$detail_template_type = $row->detail_template_type;
	$member_template_type = $row->member_template_type;
	$sell_detail= $row->sell_detail;
	
	$auto_confirmtime = $row->auto_confirmtime;
	$auto_cus_time = $row->auto_cus_time;	//自动确认收货时间
	$is_attent = $row->is_attent;
	$attent_url = $row->attent_url;
	$distr_type = $row->distr_type;
	$is_showbottom_menu = $row->is_showbottom_menu;
	$auto_upgrade_money = $row->auto_upgrade_money;
	$is_autoupgrade = $row->is_autoupgrade;
	$is_needlogin = $row->is_needlogin;
	$shop_card_id = $row->shop_card_id;
	$is_showdiscuss = $row->is_showdiscuss;
	
	$is_showshare_info = $row->is_showshare_info;
	$per_share_score = $row->per_share_score;
	$introduce = $row->introduce;
	$gz_url = $row->gz_url; //点击关注的链接
	
	$auto_upgrade_money_2 = $row->auto_upgrade_money_2;
	$nopostage_money = $row->nopostage_money;
	
	$shop_url = $row->shop_url;
	$exp_name = $row->exp_name;
	$reward_level = $row->reward_level;
	$exp_mem_name = $row->exp_mem_name;
	//echo $exp_mem_name.'+++++++++++';
	$watertype = $row->watertype;  //选择推广图片风格
	$exp_pic_text1 = $row->exp_pic_text1;  //推广图片自定义文字1
	$exp_pic_text2 = $row->exp_pic_text2;  //推广图片自定义文字2
	$exp_pic_text3 = $row->exp_pic_text3;  //推广图片自定义文字3
	$is_applymoney = $row->is_applymoney;
	$is_applymoney_startdate=$row->is_applymoney_startdate;//提现开始时间
	$is_applymoney_enddate=$row->is_applymoney_enddate;//提现结束时间
	$is_applymoney_minmoney=$row->is_applymoney_minmoney;//最小提现起点
	$is_pic = $row->is_pic;
	$define_share_image=$row->define_share_image;
	$define_share_image_flag=$define_share_image?1:0;
	
	$isOpenAgent=$row->isOpenAgent;//是否在个人中心开启代理商申请
	$promoter_bg_imgurl=$row->promoter_bg_imgurl;//推广员背景图片
}

$query="select init_reward_1 ,init_reward_2,init_reward_3 from weixin_commonshop_commisions where isvalid=true and customer_id=".$customer_id;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$init_reward_1 = 0;
$init_reward_2 = 0;
$init_reward_3 = 0;
while ($row = mysql_fetch_object($result)) {
    $init_reward_1 = $row->init_reward_1;
	$init_reward_2 = $row->init_reward_2;
	$init_reward_3 = $row->init_reward_3;
	break;
}

//新增客户
$new_customer_count =0;
//今日销售
$today_totalprice=0;
//新增订单
$new_order_count =0;
//新增推广员
$new_qr_count =0;

$nowtime = time();
$year = date('Y',$nowtime);
$month = date('m',$nowtime);
$day = date('d',$nowtime);

$query="select count(1) as new_order_count from weixin_commonshop_orders where isvalid=true and customer_id=".$customer_id." and year(createtime)=".$year." and month(createtime)=".$month." and day(createtime)=".$day;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
 //  echo $query;
while ($row = mysql_fetch_object($result)) {
   $new_order_count = $row->new_order_count;
   break;
}

$query="select sum(totalprice) as today_totalprice from weixin_commonshop_orders where paystatus=1 and sendstatus!=4 and isvalid=true and customer_id=".$customer_id." and year(createtime)=".$year." and month(createtime)=".$month." and day(createtime)=".$day;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
 //  echo $query;
while ($row = mysql_fetch_object($result)) {
   $today_totalprice = $row->today_totalprice;
   break;
}
$today_totalprice = round($today_totalprice,2);

$query="select count(1) as new_customer_count from weixin_commonshop_customers where isvalid=true and customer_id=".$customer_id." and year(createtime)=".$year." and month(createtime)=".$month." and day(createtime)=".$day;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
 //  echo $query;
while ($row = mysql_fetch_object($result)) {
   $new_customer_count = $row->new_customer_count;
   break;
}

$query="select count(1) as new_qr_count from promoters where isvalid=true and status=1 and customer_id=".$customer_id." and year(createtime)=".$year." and month(createtime)=".$month." and day(createtime)=".$day;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
 //  echo $query;
while ($row = mysql_fetch_object($result)) {
   $new_qr_count = $row->new_qr_count;
   break;
}

$is_shopdistr=0;
//分销商城的功能项是 204
$query="select id from customer_funs where isvalid=true and customer_id=".$customer_id." and column_id=204";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
$rcount= mysql_num_rows($result);
if($rcount>0){
   $is_shopdistr=1;
}
$is_distribution=0;
//代理模式,分销商城的功能项是 266
$query1="select cf.id,c.filename from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.filename='scdl' and c.id=cf.column_id";
$result1 = mysql_query($query1) or die('Query failed: ' . mysql_error());  
$dcount= mysql_num_rows($result1);
if($dcount>0){
   $is_distribution=1;
}
$arr[]="";
?>

<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title></title>
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="../common/js/layer/layer.js"></script>

<style type="text/css" media="screen">#ReplyImgUploadUploader {visibility:hidden}</style></head>

<body>

<style type="text/css">body, html{background:url(images/main-bg.jpg) left top fixed no-repeat;}</style>


		<div class="div_line">
		   <div class="div_line_item" onclick="show_newOrder(<?php echo $customer_id; ?>);">
		      今日订单: <span style="padding-left:10px;font-size:18px;font-weight:bold"><?php echo $new_order_count; ?></span>
		   </div>
		   <div class="div_line_item_split"></div>
		   <div class="div_line_item"  onclick="show_todayMoney(<?php echo $customer_id; ?>);">
		      今日销售: <span style="padding-left:10px;color:red;font-size:18px;font-weight:bold">￥<?php echo $today_totalprice; ?></span>
		   </div>
		   <div class="div_line_item_split"></div>
		   <div class="div_line_item"  onclick="show_newCustomer(<?php echo $customer_id; ?>);">
		       新增客户: <span style="padding-left:10px;font-size:18px;font-weight:bold"><?php echo $new_customer_count; ?></span>
		   </div>
		   <div class="div_line_item_split"></div>
		   <div class="div_line_item"  onclick="show_newQrsell(<?php echo $customer_id; ?>);">
		      新增推广员: <span style="padding-left:10px;font-size:18px;font-weight:bold"><?php echo $new_qr_count; ?></span>
		   </div>
		</div>
		
<div id="iframe_page">
	<div class="iframe_content" >
			<link href="css/shop.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/shop.js"></script>
  <div class="r_nav">
		<ul>
			<li class="cur"><a href="base.php?customer_id=<?php echo $customer_id; ?>">基本设置</a></li>
			<li class=""><a href="fengge.php?customer_id=<?php echo $customer_id; ?>">风格设置</a></li>
			<li class=""><a href="defaultset.php?customer_id=<?php echo $customer_id; ?>">首页设置</a></li>
			<li class=""><a href="product.php?customer_id=<?php echo $customer_id; ?>">产品管理</a></li>
			<li class=""><a href="order.php?customer_id=<?php echo $customer_id; ?>&status=-1">订单管理</a></li>
			<li class=""><a href="agent.php?customer_id=<?php echo $customer_id; ?>">代理商</a></li>
			<li class=""><a href="qrsell.php?customer_id=<?php echo $customer_id; ?>">推广员</a></li>
			<li class=""><a href="customers.php?customer_id=<?php echo $customer_id; ?>">顾客</a></li>
		
		</ul>
	</div>
<link href="css/operamasks-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/operamasks-ui.min.js"></script>
<div class="r_con_config r_con_wrap">
	<form id="config_form" action="save_base.php?customer_id=<?php echo $customer_id; ?>" method="post" enctype="multipart/form-data">
	    <input type=hidden name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>" />
		
		<table border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td width="50%" valign="top">
					    <h1><span class="fc_red">*</span> <strong>微商城名称（模板消息添加<img src='images/help.png' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/mobanxiaoxi.png>')" onMouseOut="toolTip()">）</strong></h1>
					    <input type="text" class="input" name="name" value="<?php echo $name; ?>" maxlength="30" notnull="">
						&nbsp;<input type=button style="padding:5px 5px 5px 5px" value="二维码" onclick="showMediaMap(<?php echo $customer_id; ?>,'<?php echo QRURL."?qrtype=2&customer_id=".$customer_id; ?>');" />
						
						<h1><span class="fc_red">*</span> <strong>微商城简介(不超过128个字)</strong></h1>
					    <textarea name="introduce" rows=2 cols=20 onpropertychange="if(value.length>128) value=value.substr(0,128)"><?php echo $introduce; ?></textarea>
						
						<h1><strong>免运费设置(0表示不免运费)</strong></h1>
						<div class="input">
						订单金额达到&nbsp;<input type="text" value="<?php echo $nopostage_money; ?>" name="nopostage_money" style="width:50px;">元，免除运费
						</div>
						
						<h1><span class="fc_red"></span> <strong><a href="../word/guanzhu_operation.doc">点击关注链接(点击下载操作文档)</a></strong></h1>
					    <input type="text" class="input" name="gz_url" value="<?php echo $gz_url; ?>" notnull="">
					
					
					<?php if($is_shopdistr){ ?>
						<h1><strong>是否开启分销</strong><span class="tips">(让顾客成为你的推广员)</span></h1>
						<div class="input">
						<label>
						<input type="checkbox"  <?php if($issell){?>checked<?php } ?> onclick="change_issell(this);"><span class="tips">必须是认证过的服务号</span>
						</label>
						</div>						
						<input type=hidden name="issell" id="issell" value=<?php echo $issell; ?>  />
						
						<h1><strong>是否在个人中心开启代理商申请</strong><span class="tips"></span></h1>
						<div class="input">
						<label>
						<input type="checkbox"  <?php if($isOpenAgent){?>checked<?php } ?> onclick="change_isOpenAgent(this);">
						</label>
						</div>
						<input type=hidden name="isOpenAgent" id="isOpenAgent" value=<?php echo $isOpenAgent; ?>  />
						
						<div id="tr_sell" style="display:none">
						
						<h1 style="margin-top:15px;"><strong>个人中心模板</strong><span class="tips"></span></h1>
						<div class="input" style="height:130px;">
						<label style="float:left;width:33%"><input type=radio name="member_template_type" <?php if($member_template_type==1){ ?>checked=true<?php } ?> value=1>传统模式 <img src='images/small_center.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_center.jpg>')" onMouseOut="toolTip()"></label>
						  <label style="float:left;width:33%">&nbsp;<input type=radio name="member_template_type" <?php if($member_template_type==2){ ?>checked<?php } ?> value=2>微店模式 <img src='images/small_center2.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_center2.jpg>')" onMouseOut="toolTip()"></label>
						  <label style="float:left;width:33%">&nbsp;<input type=radio name="member_template_type" <?php if($member_template_type==3){ ?>checked<?php } ?> value=3>单品模式 <img src='images/small_center3.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_center3.jpg>')" onMouseOut="toolTip()"></label>
						 
						</div>
						
						<h1><strong>推广员下线发展模式:</strong><span class="tips" style="color:red">(选定一种模式不得修改)</span></h1>
						<div class="input">
						<label><input type=radio <?php if($distr_type==1){ ?>checked<?php } ?> value=1 id="distr_type_1" name="distr_type" onclick="change_distribution()">以最后一次为准
						</label>
						
						<label><input type=radio <?php if($distr_type==2){ ?>checked<?php }else{?>disabled<?php } ?> value=2 id="distr_type_2" name="distr_type" >以第一次为准
						<!--<label><input type=radio <?php if($distr_type==2){ ?>checked<?php } ?> value=2 id="distr_type_2" name="distr_type" >以第一次为准-->
					
						</label>
						</div>
						
						<h1><strong>分享链接出去，是否显示分享者的信息:</strong></h1>
						<div class="input">
						<label><input type=radio <?php if($is_showshare_info==0){ ?>checked<?php } ?> value=0 name="is_showshare_info">不显示
						</label>
						<label><input type=radio <?php if($is_showshare_info==1){ ?>checked<?php } ?> value=1 name="is_showshare_info">显示
						</label>
						</div>
						
						<h1><strong>推广奖励积分:</strong></h1>
						<div class="input">
						推广每增加一名粉丝，奖励<input type="text" value="<?php echo $per_share_score; ?>" name="per_share_score" style="width:50px;">积分
						</div>
						
						<h1><strong>推广员生成条件:</strong></h1>
						<div class="input" style="height:60px;">
						<label><input type=radio <?php if($is_autoupgrade==0){ ?>checked<?php } ?> value=0 name="is_autoupgrade" onclick="change_autoupgrade(0,this.checked);">不自动生成
						</label>
						<label><input type=radio <?php if($is_autoupgrade==1){ ?>checked<?php } ?> value=1 name="is_autoupgrade" onclick="change_autoupgrade(1,this.checked);">自动审核
						</label>
						<label><input type=radio <?php if($is_autoupgrade==2){ ?>checked<?php } ?> value=2 name="is_autoupgrade" onclick="change_autoupgrade(2,this.checked);">自动生成
						</label>
						<div id="div_autoupgrade_money" <?php if($is_autoupgrade==1){ ?>style="display:block"<?php  }else{ ?> style="display:none" <?php } ?>>
						消费了<input type=text value="<?php echo $auto_upgrade_money; ?>" style="width:50px" name="auto_upgrade_money">元,申请后自动成为推广员 
						</div>
						<div id="div_autoupgrade_money_2"  <?php if($is_autoupgrade==2){ ?>style="display:block"<?php }else{ ?> style="display:none" <?php } ?>>
						消费了<input type=text value="<?php echo $auto_upgrade_money_2; ?>" style="width:50px" name="auto_upgrade_money_2">元,无需申请,自动成为推广员
						</div>
						</div>
						
						<h1><strong>购买折扣率:</strong></h1>
						<div class="input">
						<label><input type="text" name="sell_discount" id="sell_discount" style="width:50px;" value="<?php echo $sell_discount; ?>" />% (0:表示无折扣)
						</label>
						</div>
						
						<h1><strong>分销会员卡:</strong><span class="tips">(佣金/积分会返回在该会员卡上)</span></h1>
						<div class="input">
						 <select name="shop_card_id">
						    <?php 
							   $query="select id,name from weixin_cards where isvalid=true and customer_id=".$customer_id;
							   $result = mysql_query($query) or die('Query failed: ' . mysql_error());
	                           while ($row = mysql_fetch_object($result)) {
							       $tid = $row->id;
								   $tname = $row->name;
							?>  
							     <option value="<?php echo $tid; ?>" <?php if($shop_card_id==$tid){ ?>selected<?php } ?>><?php echo $tname; ?></option>
							<?php } ?>
						 </select>
						</div>
						<?php $reward_type = 2;//默认为金额;积分隐藏?>
						<h1><strong>佣金类型:</strong></h1>
						<div class="input">
						<!--<label>
						<input type="radio" name="reward_type" value=1 <!?php if($reward_type==1){?>checked<!?php } ?> onchange="changeRewardType(1);">积分
						</label>&nbsp;&nbsp;-->
						<label>
						<input type="radio" name="reward_type" value=2 <?php if($reward_type==2){?>checked<?php } ?>  onchange="changeRewardType(2);">金额
						</label>
						</div>
						<h1><strong>总佣金比例:</strong></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" name="init_reward" id="init_reward" value="<?php echo $init_reward; ?>" />（0~1)
						</label>
						</div>
						
						<h1><strong>分佣级数:</strong><span class="tips">(能够享受返佣金的级数)</span></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" maxlength=1 onkeypress="return event.keyCode>=49&&event.keyCode<=51" name="reward_level" id="reward_level" value="<?php echo $reward_level; ?>" />(不能超过3级)
						</label>
						</div>
						
						<h1><strong>三级佣金比例(三级相加等于1）:</strong></h1>
						<div class="input" style="height:150px;">
						<p><label>第一级:<input type="text" style="width:50px;" name="init_reward_1" id="init_reward_1" value="<?php echo $init_reward_1; ?>" />（0~1)
						</label></p>
						<p><label>第二级:<input type="text" style="width:50px;" name="init_reward_2" id="init_reward_2" value="<?php echo $init_reward_2; ?>" />（0~1)
						</label></p>
						<p><label>第三级:<input type="text" style="width:50px;" name="init_reward_3" id="init_reward_3" value="<?php echo $init_reward_3; ?>" />（0~1)
						</label></p>
						</div>
						
						<h1><strong>推广员名称:</strong></h1>
						<div class="input">
						<label><input type="text" style="width:100px;" name="exp_name" id="exp_name" value="<?php echo $exp_name; ?>" />
						</label>
						</div>
						<h1><strong>单品自定义会员名称:</strong></h1>
						<?php 
						$exp_mem_name = explode("_", $exp_mem_name);
						if($exp_mem_name[0]==""){ $exp_mem_name[0] = "我的会员";};
						if($exp_mem_name[1]==""){ $exp_mem_name[1] = "一级会员";};
						if($exp_mem_name[2]==""){ $exp_mem_name[2] = "二级会员";};
						if($exp_mem_name[3]==""){ $exp_mem_name[3] = "三级会员";};
						?>
						<div class="input" >
						<label>标    题：<input type="text" style="width:100px;" name="arr[]" value="<?php echo $exp_mem_name[0]?>" />
						</label>
						</div>
						<div class="input">
						<label>一级会员：<input type="text" style="width:100px;" name="arr[]" value="<?php echo $exp_mem_name[1]?>"/>
						</label>
						</div>
						<div class="input">
						<label>二级会员：<input type="text" style="width:100px;" name="arr[]" value="<?php echo $exp_mem_name[2]?>"/>
						</label>
						</div>
						<div class="input">
						<label>三级会员：<input type="text" style="width:100px;" name="arr[]" value="<?php echo $exp_mem_name[3]?>"/>
						</label>
						</div>
						<!--
						<h1><strong>自动确认订单 (顾客收货的订单,在该时间后,自动确认完成):</strong></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" name="auto_confirmtime" id="auto_confirmtime" value="<?php echo $auto_confirmtime; ?>" />天
						</label>
						</div>
						-->
						<h1><strong>自动确认收货 (商家确认发货后,在该时间后,自动确认收货):</strong></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" name="auto_cus_time" id="auto_cus_time" value="<?php echo $auto_cus_time; ?>" />天
						</label>
						
						
						</div>
						
						<h1><strong>是否可以申请提现:</strong></h1>
						<div class="input">
						<label><input type=radio  value=0 <?php if($is_applymoney==0){ ?>checked<?php } ?> name="is_applymoney" class="is_applymoney">不可以提现
						</label>
						<label><input type=radio value=1 <?php if($is_applymoney==1){ ?>checked<?php } ?> name="is_applymoney" class="is_applymoney">可以提现
						</label>
						</div>
						<div id="is_applymoney_date" <?php if(!$is_applymoney) echo "style='display:none'"; ?>>
							<label>每月的</label><input type="text" name="is_applymoney_startdate" id="is_applymoney_startdate" value="<?php echo $is_applymoney_startdate;?>" style="width:50px;text-align:center" maxlength='2' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"><label>号~</label><input type="text" name="is_applymoney_enddate" id="is_applymoney_enddate" value="<?php echo $is_applymoney_enddate;?>" style="width:50px;text-align:center;" maxlength='2' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"><label>号，可以提现</label><br>
							<label>起提点（大于这个数值才可以提）</label><input value="<?php echo $is_applymoney_minmoney?>" id="is_applymoney_minmoney" name="is_applymoney_minmoney" style="width:60px;text-align:center;" maxlength='5' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
						</div>
						
						
						<h1><strong>分销体系描述/使用许可协议:</strong></h1>
						 <textarea id="editor1"   name="sell_detail"><?php echo $sell_detail; ?></textarea>
						</div>
					<?php } ?>
					
					
				</td>
				<td width="50%" valign="top">
					<h1><strong>顾客是否短信通知</strong><span class="tips">（开启后，将按每条收取短信费用）</span></h1>
					<div class="input">
					<label><input type="checkbox" name="chk_customermessage" <?php if($need_customermessage){?>checked<?php } ?> onclick="change_express(this);"><span class="tips">如果无需短信通知顾客，请关闭</span>
					</label>
					</div>
					<input type=hidden name="need_customermessage" id="need_customermessage" value=<?php echo $need_customermessage; ?> />
					
					<h1><strong>是否开启在线客服</strong><span class="tips"></span></h1>
					<div class="input">
					<label><input type="checkbox" name="chk_online" <?php if($need_online){?>checked<?php } ?> onclick="change_online(this.checked);"><span class="tips"></span>
					</label>
					</div>
					<input type=hidden name="need_online" id="need_online" value=<?php echo $need_online; ?> />
					<div id="div_onlinetype" style="display:none">
					   <label><input type=radio name="online_type" id="online_type1" value=1 onclick="change_onlinetype(this.value);">在线客服&nbsp;</label>
					   <label><input type=radio name="online_type" id="online_type2" value=2 onclick="change_onlinetype(this.value);">QQ客服&nbsp;</label>
					</div>
					<div id="div_onlineqq" style="display:none">
					    qq号码：<input type=text value="<?php echo $online_qq; ?>" name="online_qq" />
					</div>
					
					<h1 style="margin-top:15px;"><strong>是否开启微小票打印</strong><span class="tips"></span></h1>
					<div class="input">
					<label><input type="checkbox" name="isprint" <?php if($isprint){?>checked<?php } ?>>&nbsp;&nbsp;&nbsp;<button><a href="/weixin/plat/app/index.php/Printer_cd/printer_list/type/5/shop_id/<?=$shop_id?>/shop_name/<?=$name?>/C_id/<?=$customer_id?>" style="cursor:pointer;" >点击设置小票打印机</a></button>
					</label>
					</div>
					
					<h1><strong>是否显示底部菜单</strong><span class="tips"></span></h1>
					<div class="input">
					<label><input type="checkbox" name="chk_showbottommenu" <?php if($is_showbottom_menu){?>checked<?php } ?> onclick="change_bottommenu(this.checked);"><span class="tips"></span>
					</label>
					</div>
					<input type=hidden name="is_showbottom_menu" id="is_showbottom_menu" value=<?php echo $is_showbottom_menu; ?> />
					
					<h1><strong>是否显示好评/中评/差评</strong><span class="tips"></span></h1>
					<div class="input">
					<label><input type="checkbox" name="chk_showdiscuss" <?php if($is_showdiscuss){?>checked<?php } ?> onclick="change_discuss(this.checked);"><span class="tips"></span>
					</label>
					</div>
					<input type=hidden name="is_showdiscuss" id="is_showdiscuss" value=<?php echo $is_showdiscuss; ?> />
					
					<h1><strong>是否开启评价图片上传</strong><span class="tips">（需要是认证的订阅号或者服务号）</span></h1>
					<div class="input">
					<label><input type="checkbox" name="chk_pic" <?php if($is_pic){?>checked<?php } ?> onclick="change_pic(this.checked);"><span class="tips"></span>
					</label>
					</div>
					<input type=hidden name="is_pic" id="is_pic" value=<?php echo $is_pic; ?> />
					
					<h1 style="margin-top:15px;"><strong>详情页面模板</strong><span class="tips"></span></h1>
					<div class="input" style="height:340px;">
					<label style="float:left;width:33%"> <input type=radio name="detail_template_type" <?php if($detail_template_type==1){ ?>checked=true<?php } ?> value=1>橱窗<img src='images/small_detail1.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_detail1.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="detail_template_type" <?php if($detail_template_type==2){ ?>checked<?php } ?> value=2>幻灯片1<img src='images/small_detail2.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_detail2.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="detail_template_type" <?php if($detail_template_type==3){ ?>checked<?php } ?> value=3>幻灯片2<img src='images/small_detail3.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_detail3.jpg>')" onMouseOut="toolTip()"></label><br/>
					<label style="float:left;width:33%"><input type=radio name="detail_template_type" <?php if($detail_template_type==4){ ?>checked<?php } ?> value=4>幻灯片3<img src='images/small_detail4.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_detail4.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="detail_template_type" <?php if($detail_template_type==5){ ?>checked<?php } ?> value=5>风格5<img src='images/small_detail5.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_detail5.jpg>')" onMouseOut="toolTip()"></label>
					<div style="clear:both"></div>
					   <label>&nbsp;&nbsp;产品图片尺寸要求:</label><br/>
					   <label style="float:left;width:33%;text-align:center">400*400</label>
					   <label style="float:left;width:33%;text-align:center">640*320</label>
					   <label style="float:left;width:33%;text-align:center">640*320</label>
					   <label style="float:left;width:33%;text-align:center">640*320</label>	
					   <label style="float:left;width:33%;text-align:center">640*320</label>					   
					</div>
					<h1 style="margin-top:15px;"><strong>推广图片风格</strong><span class="tips"></span></h1>
					<div class="input" style="height:520px;">
					<label style="float:left;width:33%"> <input type=radio name="watertype" <?php if($watertype==1){ ?>checked=true<?php } ?> value=1>风格1<img src='images/small_pic.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==2){ ?>checked<?php } ?> value=2>风格2<img src='images/small_pic2.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic2.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==3){ ?>checked<?php } ?> value=3>风格3<img src='images/small_pic3.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic3.jpg>')" onMouseOut="toolTip()"></label><br/>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==4){ ?>checked<?php } ?> value=4>风格4<img src='images/small_pic4.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic4.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==5){ ?>checked<?php } ?> value=5>风格5<img src='images/small_pic5.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic5.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==6){ ?>checked<?php } ?> value=6>风格6<img src='images/small_pic6.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic6.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==7){ ?>checked<?php } ?> value=7>风格7<img src='images/small_pic7.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic7.jpg>')" onMouseOut="toolTip()"></label>
					<!--风格8 开始-->
					<?php
					if($http_host=='szsmer.app258.com'){//只给何妍特定的那个客户
					?>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==8){ ?>checked<?php } ?> value=8>风格8<img src='images/small_pic8.jpg' style="margin-left:5px;" onMouseOver="toolTip('<img src=images/big_pic8.jpg>')" onMouseOut="toolTip()"></label>
					<?php
					}
					?>
					<!--风格8 结束-->
					<label style="float:left">推广自定义文字1(文字不适宜太长):<input type="text" style="width:275px;" name="exp_pic_text1" value="<?php echo $exp_pic_text1?>" /></label>
					<label style="float:left">推广自定义文字2(文字不适宜太长):<input type="text" style="width:275px;" name="exp_pic_text2" value="<?php echo $exp_pic_text2?>"/></label>
					<label style="float:left">推广自定义文字3(文字不适宜太长):<input type="text" style="width:275px;" name="exp_pic_text3" value="<?php echo $exp_pic_text3?>"/></label>		
					</div>
					
					<h1 style="margin-top:15px;"><strong>推广二维码图片模板</strong><span class="tips"></span></h1>
					<div class="input" style="height:320px;">
					<label style="float:left;width:33%"> <input type=radio name="watertype" <?php if($watertype==11){ ?>checked=true<?php } ?> value=1>模板1<img src='images/small_pic4.jpg' style="width:50px;margin-left:5px;" onMouseOver="toolTip('<img src=images/b_sample1.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==12){ ?>checked<?php } ?> value=2>模板2<img src='images/small_pic3.jpg' style="width:50px;margin-left:5px;" onMouseOver="toolTip('<img src=images/b_sample2.jpg>')" onMouseOut="toolTip()"></label>
					<label style="float:left;width:33%"><input type=radio name="watertype" <?php if($watertype==13){ ?>checked<?php } ?> value=3>模板3<img src='images/small_pic5.jpg' style="width:50px;margin-left:5px;" onMouseOver="toolTip('<img src=images/b_sample3.jpg>')" onMouseOut="toolTip()"></label><br/>
					<div class="input" style="height:220px;">
							
								<span class="upload_file">
									<div>
										<iframe src="iframe_images_promoters.php?customer_id=<?php echo $customer_id; ?>&promoter_bg_imgurl=<?php echo $promoter_bg_imgurl; ?>" height=200 width=100% FRAMEBORDER=0 SCROLLING=no></iframe>
									</div>
								</span>
						
							<div class="clear"></div>
							<input type=hidden name="promoter_bg_imgurl" id="promoter_bg_imgurl" value="<?php echo $promoter_bg_imgurl ; ?>" />
					</div>
					
					</div>
					
					
					<h1 style="margin-top:15px;"><strong>申请推广员头部图片</strong><span class="tips"></span></h1>
					<div class="input" style="height:220px;">
							
								<span class="upload_file">
									<div>
										<iframe src="iframe_images_staff.php?customer_id=<?php echo $customer_id; ?>&staff_imgurl=<?php echo $staff_imgurl; ?>" height=200 width=100% FRAMEBORDER=0 SCROLLING=no></iframe>
									</div>
								</span>
						
							<div class="clear"></div>
							<input type=hidden name="staff_imgurl" id="staff_imgurl" value="<?php echo $staff_imgurl ; ?>" />
					</div>
					
					<h1><strong>产品分享图片</strong></h1>
					<div class="input" <?php if($define_share_image_flag==1){?>style='height:300px'<?php }?>>
					<label><input type=radio value=0 <?php if($define_share_image_flag==0){ ?>checked<?php } ?> name="define_share_image_flag" class="define_share_image_flag">默认</label>
					<label><input type=radio value=1 <?php if($define_share_image_flag==1){ ?>checked<?php } ?> name="define_share_image_flag" class="define_share_image_flag">自定义</label>
					<div id="define_share_image_div" <?php if(!$define_share_image_flag) echo "style='display:none'"; ?>>
						<input name='new_define_share_image' id='new_define_share_image' type='file' style='width:180px;'>
						<input type='hidden' name='now_define_share_image' id='now_define_share_image' value='<?php echo $define_share_image;?>'>
						<?php
						if($define_share_image){
						?>
							<img src="<?php echo $define_share_image;?>" style="width:200px;height:200px;">
						<?php
						}
						?>
					</div>
					</div>
				</td>
			</tr>
			
			
		</tbody></table>
		<div class="submit"><input type="button" name="submit_button" value="提交保存" onclick="subBase();"></div>
		<input type="hidden" name="do_action" value="shop.config">
	</form>
</div>	</div>
<div>

<?php 

mysql_close($link);
?>
<script type="text/javascript" src="js/ToolTip.js"></script>
<script type="text/javascript" src="../../weixin/plat/Public/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../weixin/plat/Public/ckfinder/ckfinder.js"></script>

<script type="text/javascript">
$(document).ready(function() {
$(".is_applymoney").change(
function() {
var $selectedvalue = $("input[name='is_applymoney']:checked").val();
if ($selectedvalue == 1) {
 $("#is_applymoney_date").show();
}
else {
 $("#is_applymoney_date").hide();
}
});
$(".define_share_image_flag").change(
function() {
var $selectedvalue = $("input[name='define_share_image_flag']:checked").val();
if ($selectedvalue == 1) {
 $("#define_share_image_div").show();
}
else {
 $("#define_share_image_div").hide();
}
});
});
</script>

<script>
CKEDITOR.replace( 'editor1',
{
extraAllowedContent: 'img iframe[*]',
filebrowserBrowseUrl : '../../weixin/plat/Public/ckfinder/ckfinder.html',
filebrowserImageBrowseUrl : '../../weixin/plat/Public/ckfinder/ckfinder.html?type=Images',
filebrowserFlashBrowseUrl : '../../weixin/plat/Public/ckfinder/ckfinder.html?type=Flash',
filebrowserUploadUrl : '../../weixin/plat/Public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl : '../../weixin/plat/Public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl : '../../weixin/plat/Public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});


  var issell = <?php echo $issell; ?>;
  var isOpenAgent = <?php echo $isOpenAgent; ?>;
  var reward_type = <?php echo $reward_type; ?>;
  var need_online =<?php echo $need_online; ?>;
  var online_type = <?php echo $online_type; ?>;
  function change_express(obj){
      if(obj.checked){
	     document.getElementById("need_customermessage").value=1;
	  }else{
	     document.getElementById("need_customermessage").value=0;
	  }
  }
function setParentDefaultimgurl(staff_imgurl){
    document.getElementById("staff_imgurl").value=staff_imgurl;
}
function setPromoterDefaultimgurl(promoter_bg_imgurl){
    document.getElementById("promoter_bg_imgurl").value=promoter_bg_imgurl;
}
  function subBase(){

     <?php if($is_shopdistr==1){ ?>
	 var reward_level = document.getElementById("reward_level").value;
	  if(reward_level>3){
	    alert('分佣级数不能超过3');
		return false;
	 }
	 var init_reward_1 = document.getElementById("init_reward_1").value;
	 if(isNaN(init_reward_1)){
	    alert('分佣必须为数字');
		return false;
	 }
	 var init_reward_2 = document.getElementById("init_reward_2").value;
	 if(isNaN(init_reward_2)){
	    alert('分佣必须为数字');
		return false;
	 }
	 var init_reward_3 = document.getElementById("init_reward_3").value;
	 if(isNaN(init_reward_3)){
	    alert('分佣必须为数字');
		return false;
	 }
	 var d = parseFloat(init_reward_1) + parseFloat(init_reward_2)+parseFloat(init_reward_3);
	 if(d>1){
	    alert('佣金总和不能超过1!');
	    return false;
	 }
	
	  var temp = document.getElementsByName("is_applymoney");
	  for(var i=0;i<temp.length;i++)
	  {
		if(temp[i].checked)
		var is_applymoney_state = temp[i].value;
	  } 
	  if(is_applymoney_state==1){
		var is_applymoney_startdate = parseInt(document.getElementById("is_applymoney_startdate").value);
		var is_applymoney_enddate = parseInt(document.getElementById("is_applymoney_enddate").value);
		var is_applymoney_minmoney = parseInt(document.getElementById("is_applymoney_minmoney").value);
		if(is_applymoney_minmoney==''){
			is_applymoney_minmoney=200;
		}
			///alert(is_applymoney_startdate+'------'+is_applymoney_enddate);
			if(is_applymoney_startdate<=0){
				alert('提现开始时间错误');
				document.getElementById("is_applymoney_startdate").focus();
				return false;
			}
			if(is_applymoney_enddate>=32){
				alert('提现结束时间错误');
				document.getElementById("is_applymoney_enddate").focus();
				return false;
			}
			if(is_applymoney_startdate > is_applymoney_enddate){
				//alert(is_applymoney_startdate+'********'+is_applymoney_enddate);
				alert('提现开始时间>提现结束时间');
				document.getElementById("is_applymoney_startdate").focus();
				return false;
			}
	  }
	   <?php } ?>
	   var New=document.getElementsByName("define_share_image_flag");
   var define_share_image_flag;
   for(var i=0;i<New.length;i++)
   {
	//alert(New[i].value);
     if(New[i].checked)
         define_share_image_flag=New[i].value;
   }
  // alert(define_share_image_flag);
   if(define_share_image_flag!=0){//选择了自定义
		//alert('+++');
		var now_define_share_image=document.getElementById("now_define_share_image").value;
		var new_define_share_image=document.getElementById("new_define_share_image").value;
		//alert(now_define_share_image+'---------------'+new_define_share_image);
		if(now_define_share_image==''&&new_define_share_image==''){
		alert('图片空');
		return;
		}
   }
	 document.getElementById("config_form").submit();
  }
  
  function change_online(v){
      if(v){
	     document.getElementById("need_online").value=1;
		 document.getElementById("div_onlinetype").style.display="block";
		 need_online = 1;
		 if(online_type==1){
		    document.getElementById("div_onlineqq").style.display="none";
		 }else{
		    document.getElementById("div_onlineqq").style.display="block";
		 }
	  }else{
	     document.getElementById("need_online").value=0;
		 document.getElementById("div_onlinetype").style.display="none";
		 document.getElementById("div_onlineqq").style.display="none";
		 need_online = 0;
	  }
  }
  
  function change_distribution(){		//改变以第一次为准和以最后一次为准;
	    var distr_type_1 = document.getElementById("distr_type_1").value;
		alert("选择后,不得恢复以第一次为准模式");
		return;
  }
  function change_bottommenu(v){
  
      if(v){
	     document.getElementById("is_showbottom_menu").value=1;
	  }else{
	     document.getElementById("is_showbottom_menu").value=0;
	  }
  }
  
  function change_discuss(v){
  
      if(v){
	     document.getElementById("is_showdiscuss").value=1;
	  }else{
	     document.getElementById("is_showdiscuss").value=0;
	  }
  }
  
  function change_pic(v){	//是否开启评价图片上传
  
      if(v){
	     document.getElementById("is_pic").value=1;
	  }else{
	     document.getElementById("is_pic").value=0;
	  }
  }
  
  function change_email(obj){
      if(obj.checked){
	     document.getElementById("need_email").value=1;
	  }else{
	     document.getElementById("need_email").value=0;
	  }
  }
  
  function change_issell(obj){
      changesellT(obj.checked);
  }
  
  function changesellT(issell){
      if(issell){
	     document.getElementById("issell").value=1;
		 document.getElementById("tr_sell").style.display="block";
	  }else{
	     document.getElementById("issell").value=0;
		 document.getElementById("tr_sell").style.display="none";
	  }
  }
  
  changesellT(issell); 
  
  //是否在个人中心开启代理商申请 start
  function change_isOpenAgent(obj){
      changeOpenAgent(obj.checked);
  }
  
  function changeOpenAgent(isOpenAgent){
      if(isOpenAgent){
	     document.getElementById("isOpenAgent").value=1;
	  }else{
	     document.getElementById("isOpenAgent").value=0;
	  }
  }
  
  changeOpenAgent(isOpenAgent);
  //是否在个人中心开启代理商申请 end
  function changeRewardType(v){
     /*if(v==1){
	     document.getElementById("span_reward_name").innerHTML="&nbsp;积分";
	 }else{
	    document.getElementById("span_reward_name").innerHTML="&nbsp;元";
	 }*/
  }
  
  changeRewardType(reward_type);
  
  function change_onlinetype(v){
     if(v==1){
	     document.getElementById("div_onlineqq").style.display="none";
	 }else{
	     document.getElementById("div_onlineqq").style.display="block";
	 }
	 document.getElementById("online_type"+v).checked=true;
	 online_type  = v;
  }
  function change_isattent(obj){
     if(obj.checked){
	    document.getElementById("div_attenturl").style.display="block";
		document.getElementById("is_attent").value=1;
	 }else{
	    document.getElementById("div_attenturl").style.display="none";
		document.getElementById("is_attent").value=0;
	 }
  }
  change_onlinetype(online_type);
  change_online(need_online);
  
  function change_autoupgrade(type,v){
     
     switch(type){
	    case 0:
	     if(v){
		    document.getElementById("div_autoupgrade_money").style.display="none";
			document.getElementById("div_autoupgrade_money_2").style.display="none";
		 }
		 break;
	   case 1:
		if(v){
			document.getElementById("div_autoupgrade_money").style.display="block";
			document.getElementById("div_autoupgrade_money_2").style.display="none";
		 }
		break;
	   case 2:
		if(v){
			document.getElementById("div_autoupgrade_money").style.display="none";
			document.getElementById("div_autoupgrade_money_2").style.display="block";
		 }
		break;
	 }
	 
  }
  
  
    var i;
function showMediaMap(customer_id,url){
	i = $.layer({
		type : 2,
		shadeClose: true,
		offset : ['10px' , '80px'],
		time : 0,
		iframe : {
			//src : '../common_shop/jiushop/forward.php?type=2&customer_id='+customer_id+'&product_id='+product_id
			src:url
		},
		title : "商城首页二维码(扫码即可以购买)",
		//fix : true,
		zIndex : 2,
		border : [5 , 0.3 , '#437799', true],
		area : ['500px','500px'],
		closeBtn : [0,true],
		success : function(){ //层加载成功后进行的回调
			//layer.shift('right-bottom',1000); //浏览器右下角弹出
		},
		end : function(){ //层彻底关闭后执行的回调
			/*$.layer({
				type : 2,
				offset : ['100px', ''],
				iframe : {
					src : 'http://sentsin.com/about/'
				},	
				area : ['960px','500px']
			})*/
		}
	});
}
  

</script>
</div></div></body></html>