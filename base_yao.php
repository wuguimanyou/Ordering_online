<?php
header("Content-type: text/html; charset=utf-8");  
require('../config.php');
require('../back_init.php'); 
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD); 
mysql_select_db(DB_NAME) or die('Could not select database');

require('../proxy_info.php');
require('../auth_user.php');
mysql_query("SET NAMES UTF8");

$query = "select * from weixin_commonshops where isvalid=true and customer_id=".$customer_id." limit 0,1";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$name="";
$email="";
$template_head_bg="";
$template_type_bg;
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
$bottom_support_imgurl=""; //底部技术支持LOGO
$bottom_support_cont="";//技术支持内容
$exp_mem_name = "我的会员_一级会员_二级会员_三级会员";
$reward_level = 3;
$watertype = 1;
$exp_pic_text1 = "消费变成投资 人人都是老板";
$exp_pic_text2 = "长按此图片识别图中二维码搞定";
$exp_pic_text3 = "奖励送不停,别人消费你还有奖励";
$parent_ps = "您还不是推广员,不能为您生成推广图片，立即点击成为推广员";
$is_pic=0; 	//是否开启评价图片上传
$is_applymoney=1;
$define_share_image='';
$define_share_image_flag;
$auto_cus_time = 7;
$isOpenAgent = 0; //是否在个人中心开启代理商申请
$isOpenSupply = 0; //是否在个人中心开启供应商申请
$isOpenInstall=0;	//是否在个人中心开启安装预约 
$promoter_bg_imgurl = ""; //推广员背景图片
$is_dis_model = 0; //是否保存过分销模式
$issell_model = 1; //1:顶级推广员购买返佣;2:只要是推广员,都有返佣
$parent_class = -1;
$parent_pid = -1;
$stock_remind = 0; 
$is_godefault=0;   
$is_identity = 0;       //是否开启身份证验证
$per_identity_num = 0;   //每个身份证号每天可下单数量
$is_cost_limit = 0;       //是否开启购买限制
$per_cost_limit = 0;   //每人每天不高于的总额 
$is_weight_limit = 0;   //是否开启重量限制
$per_weight_limit = 0;   //每人每天不高于的KG 
$is_number_limit = 0;   //是否开启数量限制
$per_number_limit = 0;   //每人每天购买产品数量不多于
$isOpenPublicWelfare = 0 ;//是否开启公益基金
$OpenBillboard = 0 ;//是否开启龙虎榜
$is_bottom_support = 0;//是否开启底部技术支持样式
$isAgreement = 0;//是否开启商城购买协议
$is_team = 0;//是否开启团队奖励
$nowprice_title ="";//"现价"名称自定义
$shopping_status = 0;//单品非关注也能购买
while ($row = mysql_fetch_object($result)) {
    $name=$row->name;
    $parent_ps=$row->parent_ps;
	if(empty($parent_ps)){
		$parent_ps = "您还不是推广员,不能为您生成推广图片，立即点击成为推广员"; 
	}
    $is_godefault=$row->is_godefault;
    $staff_imgurl=$row->staff_imgurl;
	$bottom_support_imgurl=$row->bottom_support_imgurl;
	$is_bottom_support=$row->is_bottom_support;
	$bottom_support_cont=$row->bottom_support_cont;
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
	$shopping_status= $row->shopping_status;
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
	$template_head_bg=$row->template_head_bg;
	$template_type_bg=$template_head_bg?1:0;
	
	$isOpenAgent=$row->isOpenAgent;//是否在个人中心开启代理商申请
	$isOpenSupply=$row->isOpenSupply;//是否在个人中心开启供应商申请
	$isOpenInstall=$row->isOpenInstall; //是否在个人中心开启安装预约	
	$promoter_bg_imgurl=$row->promoter_bg_imgurl;//推广员背景图片
	$is_dis_model=$row->is_dis_model;//是否保存过分销模式
	$issell_model=$row->issell_model;//1:顶级推广员购买返佣;2:只要是推广员,都有返佣1
	$parent_class=$row->parent_class;
	$parent_pid=$row->parent_pid;
	$stock_remind=$row->stock_remind; 
	
	$is_identity=$row->is_identity; 
	$per_identity_num=$row->per_identity_num; 
	$is_cost_limit=$row->is_cost_limit; 
	$per_cost_limit=$row->per_cost_limit; 
	$is_weight_limit=$row->is_weight_limit; 
	$per_weight_limit=$row->per_weight_limit;
	$is_number_limit = $row->is_number_limit;
	$per_number_limit = $row->per_number_limit;
	$isOpenPublicWelfare=$row->isOpenPublicWelfare; 
	$OpenBillboard=$row->openbillboard; 
	$isAgreement=$row->isAgreement; 	
	$is_team=$row->is_team; 	//团队奖励
	$nowprice_title=$row->nowprice_title;
}

$query = "select valuepercent from weixin_commonshop_publicwelfare where isvalid=true and  customer_id=".$customer_id;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$valuepercent = ""; //分配到公益基金的比例
//$welfare_images=""; //公益基金背景图片
while ($row = mysql_fetch_object($result)) {
	$valuepercent=$row->valuepercent; 
	//$welfare_images=$row->backimg;
}

$query="select init_reward_1 ,init_reward_2,init_reward_3,init_reward_4,init_reward_5,init_reward_6,init_reward_7,init_reward_8 from weixin_commonshop_commisions where isvalid=true and customer_id=".$customer_id;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$init_reward_1 = 0;
$init_reward_2 = 0;
$init_reward_3 = 0;
$init_reward_4 = 0;
$init_reward_5 = 0;
$init_reward_6 = 0;
$init_reward_7 = 0;
$init_reward_8 = 0;
while ($row = mysql_fetch_object($result)) {
    $init_reward_1 = $row->init_reward_1;
	$init_reward_2 = $row->init_reward_2;
	$init_reward_3 = $row->init_reward_3;
	$init_reward_4 = $row->init_reward_4;
	$init_reward_5 = $row->init_reward_5;
	$init_reward_6 = $row->init_reward_6;
	$init_reward_7 = $row->init_reward_7;
	$init_reward_8 = $row->init_reward_8;
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

$query="select sum(totalprice) as today_totalprice from weixin_commonshop_orders where paystatus=1 and sendstatus!=4 and isvalid=true and customer_id=".$customer_id." and year(paytime)=".$year." and month(paytime)=".$month." and day(paytime)=".$day;
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


//分销商城的功能项是 204
$is_shopdistr=0;
$is_rcount=0;
$sc_query1="select count(1) as is_rcount from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='3层分销' and c.id=cf.column_id";
$result = mysql_query($sc_query1) or die('Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($result)) {
   $is_rcount = $row->is_rcount;
   break;
}
if($is_rcount>0){
   $is_shopdistr=1;
}
$is_8shopdistr=0;
$is_8rcount=0;
$sc_query8="select count(1) as is_8rcount from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='8层分销' and c.id=cf.column_id";
$result8 = mysql_query($sc_query8) or die('Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($result8)) {
   $is_8rcount = $row->is_8rcount;
   break;
}
if($is_8rcount>0){
   $is_8shopdistr=1;
}
//代理模式,分销商城的功能项是 266
$is_distribution=0;//渠道取消代理商功能
$is_disrcount=0;
$query1="select count(1) as is_disrcount from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='商城代理模式' and c.id=cf.column_id";
$result1 = mysql_query($query1) or die('W_is_disrcount Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($result1)) {
   $is_disrcount = $row->is_disrcount;
   break;
}
if($is_disrcount>0){
   $is_distribution=1;
}

//供应商模式,渠道开通与不开通
$is_supplierstr=0;//渠道取消供应商功能
$sp_count=0;//渠道取消供应商功能
$sp_query="select count(1) as sp_count from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='商城供应商模式' and c.id=cf.column_id";
$sp_result = mysql_query($sp_query) or die('W_is_supplier Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($sp_result)) {
   $sp_count = $row->sp_count;
   break;
}
if($sp_count>0){
   $is_supplierstr=1;
}


//安装平台,渠道开通与不开通
$is_isinstall=0;//渠道取消安装平台功能
$ins_count=0;
$sp_query="select count(1) as ins_count from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='安装平台' and c.id=cf.column_id";
$sp_result = mysql_query($sp_query) or die('Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($sp_result)) {
   $ins_count = $row->ins_count;
   break;
}
if($ins_count>0){
   $is_isinstall=1;
}

$wd_query1="select count(1) as wdcount from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='微店模式' and c.id=cf.column_id";
$wd_result1 = mysql_query($wd_query1) or die('Query failed: ' . mysql_error());  
$is_scwd=0; //是否开通了微店模式 0不开通 1开通
$wdcount=0; 
while ($row = mysql_fetch_object($wd_result1)) {
   $wdcount = $row->wdcount;
   break;
}
if($wdcount>0){
   $is_scwd=1;
}

$dp_query1="select count(1) as dpcount from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='单品模式' and c.id=cf.column_id";
$is_scdp=0; //是否开通了微店模式 0不开通 1开通
$dpcount=0;
$dp_result1 = mysql_query($dp_query1) or die('Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($dp_result1)) {
   $dpcount = $row->dpcount;
   break;
}
if($dpcount>0){
   $is_scdp=1;
}

$query_team="select count(1) as count_team from customer_funs cf inner join columns c where c.isvalid=true and cf.isvalid=true and cf.customer_id=".$customer_id." and c.sys_name='商城区域团队奖励' and c.id=cf.column_id";
$is_openteam=0; //在渠道是否开启团队奖励
$count_team=0;
$result_team = mysql_query($query_team) or die('W_count_team Query failed: ' . mysql_error());  
while ($row = mysql_fetch_object($result_team)) {
   $count_team = $row->count_team;
   break;
}
if($count_team>0){
   $is_openteam=1;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../common/css_V6.0/content.css">
<!--<link rel="stylesheet" type="text/css" href="../common/css_V6.0/contentblue.css">--><!--内容CSS配色·蓝色-->
<!--<link rel="stylesheet" type="text/css" href="../common/css_V6.0/contentGreen.css">--><!--内容CSS配色·绿色-->
<link rel="stylesheet" type="text/css" href="../common/css_V6.0/contentOrange.css"><!--内容CSS配色·橙色-->
<!--<link rel="stylesheet" type="text/css" href="../common/css_V6.0/contentbgreen.css">--><!--内容CSS配色·蓝绿-->
<!--<link rel="stylesheet" type="text/css" href="../common/css_V6.0/contentGGreen.css">--><!--内容CSS配色·草绿-->

<script type="text/javascript" src="../common/js_V6.0/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../common/js_V6.0/jscolor.js"></script><!--拾色器js-->
<script src="js/index.js"></script>	
<script src="../common/ckeditor/ckeditor.js"></script>				<!--这个是整个富文本的JS样式需要链接对-->

</head>

<body>
<!--内容框架开始-->
<div class="WSY_content" id="WSY_content_height">

	<!--微商城统计代码开始-->
	<?php 
		$stock_mun=0; 
		$stock_pidarr=""; 
		$query_stock1="select id from weixin_commonshop_products where isvalid=true and storenum<".$stock_remind." and isout=0 and customer_id=".$customer_id; 
		//echo $query_stock1; 
		$result_stock1 = mysql_query($query_stock1) or die('Query failed: ' . mysql_error()); 
		$stock_mun1 = mysql_num_rows($result_stock1); 
		while ($row_stock1 = mysql_fetch_object($result_stock1)) { 
			$stock_pid1 = $row_stock1->id; 
			if(!empty($stock_pidarr)){ 
				$stock_pidarr=$stock_pidarr."_".$stock_pid1; 
			}else{ 
				$stock_pidarr=$stock_pid1; 
			} 
			 
		} 
		 
		$query_stock2="select id,propertyids,storenum from weixin_commonshop_products where isvalid=true and isout=0 and storenum>".$stock_remind." and customer_id=".$customer_id; 
		$result_stock2 = mysql_query($query_stock2) or die('Query failed: ' . mysql_error()); 
		$stock_mun2=0; 
		while ($row_stock2 = mysql_fetch_object($result_stock2)) { 
			$stock_pid = $row_stock2->id;			 
			$stock_storenum = $row_stock2->storenum;			  
			$stock_propertyids = $row_stock2->propertyids;			 
			if(!empty($stock_propertyids)){ 
			   $query_stock3="SELECT * FROM weixin_commonshop_product_prices WHERE storenum<".$stock_remind." and product_id='".$stock_pid."' limit 0,1"; 
			   //echo  $query_stock3; 
			   $result_stock3 = mysql_query($query_stock3) or die('Query failed: ' . mysql_error()); 
			   $result_stock3_mun1 = mysql_num_rows($result_stock3); 
			   while ($row_stock3 = mysql_fetch_object($result_stock3)) { 
					$stock_pid2 = $row_stock3->product_id; 
				} 
			   if($result_stock3_mun1 !=0){ 
				   $stock_mun2=$stock_mun2 + 1; 
				   if(!empty($stock_pidarr)){ 
						$stock_pidarr=$stock_pidarr."_".$stock_pid2; 
					}else{ 
						$stock_pidarr=$stock_pid2; 
					} 
			   }				    
			}  
		} 
		$stock_mun=$stock_mun1+$stock_mun2;  
		 
	   ?> 
	<div class="WSY_statisticsbox">
		<li><a href="order.php?customer_id=<?php echo $customer_id;?>">今日订单：</a><span><?php echo $new_order_count; ?></span></li>
		<li><a href="order.php?customer_id=<?php echo $customer_id;?>&search_status=3">今日销售：</a><span style="color:#F00">￥<?php echo $today_totalprice; ?></span></li>
		<li><a href="customers.php?customer_id=<?php echo $customer_id;?>">新增客户：</a><span><?php echo $new_customer_count; ?></span></li>
		<li><a href="qrsell.php?customer_id=<?php echo $customer_id;?>">新增推广员：</a><span><?php echo $new_qr_count; ?></span></li>
		<li><a href="stock_product.php?customer_id=<?php echo $customer_id;?>&stock_pidarr=<?php echo $stock_pidarr;?>">库存提醒: 已有</a><span style="color:#F00;width:5%"><?php echo $stock_mun; ?></span><a>个商品库存不足了</a></li>
	</div> 
	<!--微商城统计代码结束-->

       <!--列表内容大框开始-->
	<div class="WSY_columnbox">
    	<!--列表头部切换开始-->
    	<div class="WSY_column_header">
        	<div class="WSY_columnnav">
            	<a href="base.php?customer_id=<?php echo $customer_id; ?>">基本设置</a>
                <a href="fengge.php?customer_id=<?php echo $customer_id; ?>">风格设置</a>
                <a href="defaultset.php?customer_id=<?php echo $customer_id; ?>&default_set=1">首页设置</a>
                <a href="product.php?customer_id=<?php echo $customer_id; ?>">产品管理</a>
                <a href="order.php?customer_id=<?php echo $customer_id; ?>&status=-1">订单管理</a>
				<?php if($is_supplierstr){?>
                <a href="supply.php?customer_id=<?php echo $customer_id; ?>">供应商</a>
				<?php }?>
				<?php if($is_distribution){?>
                <a href="agent.php?customer_id=<?php echo $customer_id; ?>">代理商</a>
				<?php }?>
                <a href="qrsell.php?customer_id=<?php echo $customer_id; ?>">推广员</a>
                <a href="customers.php?customer_id=<?php echo $customer_id; ?>">顾客</a>
                <a href="shops.php?customer_id=<?php echo $customer_id; ?>">门店</a>
				<?php if($isOpenPublicWelfare){?>
				<a href="publicwelfare.php?customer_id=<?php echo $customer_id; ?>">公益基金</a>
				<?php }?>
            </div>
        </div>
        <!--列表头部切换结束-->

		<!--基本设置代码开始-->
		<div class="WSY_data">
			<!--商城设置开始-->
			<div class="WSY_Setting_box">
				<div class="WSY_Setting">
					<p class="WSY_setting_P">商城设置</p><!--每个设置项标题-->

					<div class="WSY_shop_main">
						<dl class="WSY_shop_dl01">
							<dd class="WSY_tishi"><i class="WSY_setting_p_red">*</i>微商城名称（模板消息添加<img src="../common/images_V6.0/contenticon/tishi.png">）
								<span class="WSY_tishiIMG"><img src="images/mobanxiaoxi.png"></span><!--提示效果图-->
							</dd><!--提示图标-->
							<dd><input type="text" name="name" value="<?php echo $name; ?>"></dd>
							<dd class="WSY_erweimadj WSY_public"><a onclick="showMediaMap(<?php echo $customer_id; ?>,'<?php echo QRURL."?qrtype=2&customer_id=".$customer_id; ?>');">二维码</a></dd>
							
						</dl>
						
						<dl class="WSY_shop_dl02">
							<dd>库存提醒（库存提醒不能为0）</dd>
							<dd>库存低于<input type="text" value="<?php echo $stock_remind; ?>" name="stock_remind">件提醒</dd>
						</dl>
						<div class="WSY_remind_main">
							<dl class="WSY_remind_dl03" style="margin-top:15px">
								<dt>是否开启分销</dt>
								<dd class="boldA" style="margin-top:0px;">
									<?php if($issell){?>
									<ul style="background-color: rgb(255, 113, 112);">
										<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
										<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
										<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
									</ul>
									<?php }else{?>
									<ul style="background-color: rgb(203, 210, 216);">
										<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
										<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
										<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
									</ul>		
									<?php } ?>
								</dd>
								<a>点击设置小票打印机</a>
								<input type=hidden name="issell" id="issell" value=<?php echo $issell; ?> />
							</dl>
						</div>
						
						<dl class="WSY_shop_dl03">
							<dd><a href="../word/guanzhu_operation.doc">点击关注链接（点击下载操作文档）</a></dd>
							<dd><input type="text" value="http://mp.weixin.qq.com/s?__biz=MzA3MTM3OTAzMQ==&mid=204311787&idx=1&sn=d1bb3992ee39f625d1d15cd2a7f7feea#rd"></dd>
						</dl>
						
						<dl class="WSY_shop_dl04">
							<dd><i class="WSY_setting_p_red">*</i>微商城简介（不超过128个字）</dd>
							<dd><textarea name="introduce" onpropertychange="if(value.length>128) value=value.substr(0,128)"><?php echo $introduce; ?></textarea></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
        <!--商城设置结束-->

        <!--佣金设置开始-->
     	<div class="WSY_Setting_box">
            <div class="WSY_Setting">
            	<p class="WSY_setting_P">佣金设置</p><!--每个设置项标题-->
                <div class="WSY_commission_main">               
                	<!-- <dl class="WSY_commission_dl01">
     					<dt>佣金类型</dt>
                        <dd><input type="radio" name="sex" id="11"><label for="11">基金</label></dd>
                        <dd><input type="radio" name="sex" id="12"><label for="12">金额</label></dd>
                    </dl> -->
                    
                    <dl class="WSY_commission_dl02">
                    	<dt>总佣金比例</dt>
                        <dd><input type="text" name="init_reward" value="<?php echo $init_reward; ?>">(0~1)</dd>
                    </dl>

                    <dl class="WSY_commission_dl03">
                    	<dt>分佣级数<span>（能够享受返佣金的级数）</span></dt>
                        <dd><input type="text" name="reward_level" onkeypress="return event.keyCode>=49&&event.keyCode<=<?php if($is_8shopdistr!=1){?>51<?php }else{?>56<?php }?>" value="<?php echo $reward_level; ?>">（不能超过<?php if($is_8shopdistr!=1){?>3<?php }else{?>8<?php }?>级）</dd>
                    </dl>
                                        
                    <dl class="WSY_commission_dl04">
						<?php if($is_8shopdistr!=1){?>
                    	<dt>三级佣金比例<span>（三级相加等于1）</span></dt>
						<?php }else{?>
						<dt>三级佣金比例<span>（八级相加等于1）</span></dt>
						<?php }?>
                        <ul>
                            <dd>第一级<input type="text" name="init_reward_1" value="<?php echo $init_reward_1; ?>">(0~1)</dd>
                            <dd>第二级<input type="text" name="init_reward_2" value="<?php echo $init_reward_2; ?>">(0~1)</dd>
                            <dd>第三级<input type="text" name="init_reward_3" value="<?php echo $init_reward_3; ?>">(0~1)</dd>
							<?php if($is_8shopdistr==1){?>
                            <dd>第四级<input type="text" name="init_reward_4" value="<?php echo $init_reward_4; ?>">(0~1)</dd>
                            <dd>第五级<input type="text" name="init_reward_5" value="<?php echo $init_reward_5; ?>">(0~1)</dd>
                            <dd>第六级<input type="text" name="init_reward_6" value="<?php echo $init_reward_6; ?>">(0~1)</dd>
                            <dd>第七级<input type="text" name="init_reward_7" value="<?php echo $init_reward_7; ?>">(0~1)</dd>
                            <dd>第八级<input type="text" name="init_reward_8" value="<?php echo $init_reward_8; ?>">(0~1)</dd>
							<?php }?>
                        </ul>
                    </dl>
                    
                </div>
            </div>
        </div>
        <!--佣金设置结束-->
            
        <!--推广设置开始-->
        <div class="WSY_Setting_box">
            <div class="WSY_Setting1">
            	<p class="WSY_setting_P">推广设置</p><!--每个设置项标题-->
                <div class="WSY_generalize_main"><!--推广设置-->
                
                	<dl class="WSY_generalize_dl01">
                    	<dt>个人中心模板</dt>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==1){ ?>checked=true<?php } ?> value=1><label for="1">传统模式<br><br><img src="images/small_center.jpg" onMouseOver="toolTip('<img src=images/big_center.jpg>')" onMouseOut="toolTip()"></label></dd>
						<?php if($is_scwd or $member_template_type==2){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==2){ ?>checked<?php } ?>  value=2><label for="2">微店模式<br><br><img src="images/small_center2.jpg" onMouseOver="toolTip('<img src=images/big_center2.jpg>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<?php if($is_scwd or $member_template_type==4){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==4){ ?>checked<?php } ?>  value=4><label for="4">微店风格1<br><br><img src="images/small_center_type1.png" onMouseOver="toolTip('<img src=images/big_center_type1.png>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<?php if($is_scwd or $member_template_type==5){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==5){ ?>checked<?php } ?>  value=5><label for="5">微店风格2<br><br><img src="images/small_center_type2.png" onMouseOver="toolTip('<img src=images/big_center_type2.png>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<?php if($is_scdp or $member_template_type==3){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==3){ ?>checked<?php } ?>  value=3><label for="3">单品模式<br><br><img src="images/small_center3.jpg" onMouseOver="toolTip('<img src=images/big_center3.jpg>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<?php if($is_scdp or $member_template_type==6){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==6){ ?>checked<?php } ?>  value=6><label for="6">单品风格1<br><br><img src="images/small_center_type3.png" onMouseOver="toolTip('<img src=images/big_center_type3.png>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<?php if($is_scdp or $member_template_type==7){ ?>
                        <dd><input type="radio" name="member_template_type" <?php if($member_template_type==7){ ?>checked<?php } ?>  value=7><label for="7">单品风格2<br><br><img src="images/small_center_type4.png" onMouseOver="toolTip('<img src=images/big_center_type4.png>')" onMouseOut="toolTip()"></label></dd>
						<?php } ?>
						<input type='hidden' name='is_scwd' id='is_scwd' value='<?php echo $is_scwd;?>'>
						<input type='hidden' name='is_scdp' id='is_scdp' value='<?php echo $is_scdp;?>'> 
                    </dl>
                    
                    <dl class="WSY_generalize_dl02">
                    	<dt>推广员名称：</dt>
                        <dd><input type="text" name="exp_name" value="<?php echo $exp_name; ?>"></dd>
                    </dl>
                    
                    <dl class="WSY_generalize_dl03">
                    	<dt>推广员生成条件：</dt>
                        <dd>
                            <div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==0){ ?>checked<?php } ?> value=0>
								<label>后台审核</label>
							</div>
                            <div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==1){ ?>checked<?php } ?> value=1>
								<label>自动审核</label>
							</div>
                            <div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==2){ ?>checked<?php } ?> value=2>
								<label>自动生成</label>
							</div>
							<div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==5){ ?>checked<?php } ?> value=5>
								<label>关注生成</label>
							</div>
							<div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==4){ ?>checked<?php } ?> value=4>
								<label>购买后同意协议</label>
							</div>
							<div>
								<input type="radio" name="is_autoupgrade" <?php if($is_autoupgrade==3){ ?>checked<?php } ?> value=3>
								<label>扫描推广员二维码生成</label>
							</div>
                        </dd>
                    </dl>
                    <dl class="WSY_generalize_dl03 WSY_generalize_dldd">
                    	<dd <?php if($is_autoupgrade==1){ ?>style="display:block"<?php  }else{ ?> style="display:none" <?php } ?>>消费了<input type="text" name="auto_upgrade_money" value="<?php echo $auto_upgrade_money; ?>">元,申请后自动成为推广员</dd>
                        <dd <?php if($is_autoupgrade==2){ ?>style="display:block"<?php }else{ ?> style="display:none" <?php } ?>>消费了<input type="text" name="auto_upgrade_money_2" value="<?php echo $auto_upgrade_money_2; ?>">元,无需申请,自动成为推广员</dd>
						<dd <?php if($is_autoupgrade==4){ ?>style="display:block"<?php  }else{ ?> style="display:none" <?php } ?>>消费满<input type="text" name="auto_upgrade_money_3" value="<?php echo $auto_upgrade_money; ?>">元,同意协议后成为推广员</dd>
                    </dl>
                    
                    <dl class="WSY_generalize_dl04">
                    	<dt>推广员线下发展模式<span>（选定一种模式不得修改）</span></dt>
                        <dd><input type="radio" <?php if($distr_type==2){ ?>checked<?php } ?> value=2 id="distr_type_2" name="distr_type"><label>以第一次为准</label></dd>
                        <dd><input type="radio" <?php if($distr_type==1){ ?>checked<?php } ?> value=1 id="distr_type_1" name="distr_type" onclick="change_distribution()"><label>以最后一次为准</label></dd>
						<input type=hidden name="is_dis_model" id="is_dis_model" />
                    </dl>
					<div class="WSY_remind_main">
						<?php if($is_supplierstr){?>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>是否在个人中心开启供应商申请</dt>
							<dd class="boldA">
							<?php if($isOpenSupply){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>		
							<?php } ?>
							</dd>
							<input type=hidden name="isOpenSupply" id="isOpenSupply" value=<?php echo $isOpenSupply; ?> />
						</dl>
						<?php }?>
						<?php if($is_distribution){?>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>是否在个人中心开启代理商申请</dt>
							<dd class="boldA">
							<?php if($isOpenAgent){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>		
							<?php } ?>
							</dd>
							<input type=hidden name="isOpenAgent" id="isOpenSupply" value=<?php echo $isOpenAgent; ?> />
						</dl>
						<?php } ?>
						<?php if($is_isinstall){?>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>是否在个人中心开启安装预约</dt>
							<dd class="boldA">
							<?php if($isOpenInstall){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>		
							<?php } ?>
							</dd>
							<input type=hidden name="isOpenInstall" id="isOpenInstall" value=<?php echo $isOpenInstall; ?> />
						</dl>
						<?php }?>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>是否开启购买协议</dt>
							<dd class="boldA">
							<?php if($isAgreement){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>		
							<?php } ?>
							</dd> 
							<input type=hidden name="isAgreement" id="isAgreement" value=<?php echo $isAgreement; ?> />
						</dl>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>推广员复购模式：</dt>
							<dd class="boldA">
							<?php if($issell_model==2){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>		
							<?php } ?>
							</dd>
							<input type=hidden name="issell_model" id="issell_model" value=<?php echo $issell_model; ?> />
						</dl>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>开启我的佣金</dt>
							<dd class="boldA">
							<?php if($is_my_commission==1){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							</dd>
							<input type=hidden name="is_my_commission" id="is_my_commission" value=<?php echo $is_my_commission; ?> />
						</dl>
						<dl class="WSY_remind_dl02" style="margin-top:15px">
							<dt>先进单品，再购买</dt>
							<dd class="boldA">
							<?php if($is_godefault==1){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							</dd>
							<input type=hidden name="is_godefault" id="is_godefault" value=<?php echo $is_godefault; ?> />
						</dl>
						<dl class="WSY_remind_dl02" style="margin-top:15px"> 
							<dt>开启单品非关注也能购买</dt>
							<dd class="boldA">
							<?php if($shopping_status==1){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							</dd>
							<input type=hidden name="shopping_status" id="shopping_status" value=<?php echo $shopping_status; ?> />
						</dl>
						<?php if($is_openteam){?>
						<dl class="WSY_remind_dl02" style="margin-top:15px"> 
							<dt>是否开启团队奖励</dt>
							<dd class="boldA">
							<?php if($is_team==1){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							</dd>
							<input type=hidden name="is_team" id="is_team" value=<?php echo $is_team; ?> />
						</dl>
						<?php } ?>
					</div>
                    <dl class="WSY_generalize_dl05">
                    	<dt>推广奖励分：</dt>
                        <dd>推广每增加一名粉丝，奖励<input type="text" name="per_share_score" value="<?php echo $per_share_score; ?>">积分</dd>
                    </dl>
                    
                    <dl class="WSY_generalize_dl06">
                    	<dt>分享链接出去是否显示分享着信息：</dt>
                        <dd><input type="radio" <?php if($is_showshare_info==0){ ?>checked<?php } ?> value=0 name="is_showshare_info"><label>不显示</label></dd>
                        <dd><input type="radio" <?php if($is_showshare_info==1){ ?>checked<?php } ?> value=1 name="is_showshare_info"><label>显示</label></dd>
                    </dl>
                    
                    <dl class="WSY_generalize_dl07">
                    	<dt>通过推广购买折扣：</dt>
                        <dd><input name="sell_discount" id="sell_discount" type="text" value="<?php echo $sell_discount; ?>">%（0表示无折扣）</dd>
                    </dl>
                    
                     <dl class="WSY_generalize_dl08">
                    	<dt>分销会员卡：<span>（佣金/积分会返回在该会员卡上）</span></dt>
                        <dd>
							<select  name="shop_card_id" id="shop_card_id">
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
						</dd>
                    </dl>
                    
                </div>
            </div>
        </div>
        <!--推广设置结束-->
            
        <!--单品订单分销设置开始-->
        <div class="WSY_Setting_box">
            <div class="WSY_Setting1">
            	<p class="WSY_setting_P">单品/订单/分销设置</p><!--每个设置项标题-->
                <div class="WSY_goods_main">
                
                	<dl class="WSY_goods_dl01">
     					<dt>是否可以申请提现</dt>
                        <dd class="WSY_goods_dldd01">
                            <div class="WSY_div"><input type="radio" value=0 <?php if($is_applymoney==0){ ?>checked<?php } ?> name="is_applymoney" class="is_applymoney"><label>不可以提现</label></div>
                            <div class="WSY_div"><input type="radio" value=1 <?php if($is_applymoney==1){ ?>checked<?php } ?> name="is_applymoney" class="is_applymoney"><label>可以提现</label></div>
                        </dd>
                        <dd class="WSY_goods_dldd02">每个月的<input type="text"name="is_applymoney_startdate" id="is_applymoney_startdate" value="<?php echo $is_applymoney_startdate;?>" maxlength='2' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">号~<input type="text" name="is_applymoney_enddate" id="is_applymoney_enddate" value="<?php echo $is_applymoney_enddate;?>" maxlength='2' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">号~，可以提现</dd>
                    </dl>
                    
                    <dl class="WSY_goods_dl02">
                    	<dt>自动确认收货<span>（商家确认发货后,在该时间后,自动确认收货）<input type="text" name="auto_cus_time" id="auto_cus_time" value="<?php echo $auto_cus_time; ?>">天</span></dt>
                    </dl>
                                        
                    <dl class="WSY_goods_dl03">
                    	<dt>单品自定义会员名称</dt>
						<?php 
						$exp_mem_name = explode("_", $exp_mem_name);
						if(empty($exp_mem_name[0])){ $exp_mem_name[0] = "我的会员";};
						if(empty($exp_mem_name[1])){ $exp_mem_name[1] = "一级会员";};
						if(empty($exp_mem_name[2])){ $exp_mem_name[2] = "二级会员";};
						if(empty($exp_mem_name[3])){ $exp_mem_name[3] = "三级会员";};
						if(empty($exp_mem_name[4])){ $exp_mem_name[4] = "四级会员";};
						if(empty($exp_mem_name[5])){ $exp_mem_name[5] = "五级会员";};
						if(empty($exp_mem_name[6])){ $exp_mem_name[6] = "六级会员";};
						if(empty($exp_mem_name[7])){ $exp_mem_name[7] = "七级会员";};
						if(empty($exp_mem_name[8])){ $exp_mem_name[8] = "八级会员";};
						?>
                        <dd class="WSY_goods_dldd02">标题<input name="arr[]" type="text" value="<?php echo $exp_mem_name[0]; ?>"></dd>
                        <ul>
                            <dd>一级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[1]?>"></dd>
                            <dd>二级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[2]?>"></dd>
                            <dd>三级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[3]?>"></dd>
							<?php if($is_8shopdistr==1){?>
                            <dd>四级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[4]?>"></dd>
                            <dd>五级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[5]?>"></dd>
                            <dd>六级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[6]?>"></dd>
                            <dd>七级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[7]?>"></dd>
                            <dd>八级会员<input type="text" name="arr[]" value="<?php echo $exp_mem_name[8]?>"></dd>
							<?php }?>
                        </ul>
                    </dl>
                    <dl class="WSY_goods_dl04">
                    	<dt>分销体系结束/使用许可协议</dt>
                        <div class="text_box">
                            <textarea id="editor1"   name="sell_detail"><?php echo $sell_detail; ?></textarea>
                    	</div> 
                    </dl>
                </div>
            </div>
        </div>
        <!--单品订单分销设置结束-->
            
			<!--客服提醒设置开始-->
			<div class="WSY_Setting_box">
				<div class="WSY_Setting2">
					<p class="WSY_setting_P">通知/显示设置</p><!--每个设置项标题-->
					<div class="WSY_remind_main"><!--推广设置-->
					
						<dl class="WSY_remind_dl01">
							<dt>顾客是否开启短信通知（开启后，按每条收取短信费用）</dt>
							<dd class="boldA">无需短信通知顾客请关闭：</dd>
							<?php if($need_customermessage){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(1)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(1)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							<input type=hidden name="need_customermessage" id="need_customermessage" value=<?php echo $need_customermessage; ?> />
						</dl>
						
						<dl class="WSY_remind_dl02">
							<dt>是否开启在线客服：</dt>
							<dd>
							 <?php if($need_online){?>
							<ul style="background-color: rgb(255, 113, 112);">
								<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
								<li class="WSY_derail" onclick="derail_off(2)" style="left: 0px; display: list-item;"></li>
								<span class="WSY_derail2" onclick="derail_on(2)" style="left: 0px; display: none;"></span>
							</ul>
							<?php }else{?>
							<ul style="background-color: rgb(203, 210, 216);">
								<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
								<li class="WSY_derail" onclick="derail_off(2)" style="left: 30px; display: none;"></li>
								<span class="WSY_derail2" onclick="derail_on(2)" style="left: 30px; display: block;"></span>
							</ul>
							<?php } ?>
							<input type=hidden name="need_online" id="need_online" value=<?php echo $need_online; ?> />
							 </dd>
							<div class="WSY_servicebox">
								<p><input type="radio" name="sex" id="15"><label for="15">在线客服</label><p>
								<p class="WSY_servicep"><input type="radio"name="online_type"><label for="16">QQ客服</label></p>
								<div class="WSY_servicea">QQ号码：<input class="WSY_remind_ddinput01" value="<?php echo $online_qq; ?>" name="online_qq" type="text"></div>
							</div>
						</dl>
						
						<dl class="WSY_remind_dl03">
							<dt>是否开启小票打印：</dt>
								<dd>
									<?php if($isprint){?>
									<ul style="background-color: rgb(255, 113, 112);">
										<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
										<li class="WSY_derail" onclick="derail_off(3)" style="left: 0px; display: list-item;"></li>
										<span class="WSY_derail2" onclick="derail_on(3)" style="left: 0px; display: none;"></span>
									</ul>
									<?php }else{?>
									<ul style="background-color: rgb(203, 210, 216);">
										<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
										<li class="WSY_derail" onclick="derail_off(3)" style="left: 30px; display: none;"></li>
										<span class="WSY_derail2" onclick="derail_on(3)" style="left: 30px; display: block;"></span>
									</ul>
									<?php } ?>
								</dd>
							<a href="/weixin/plat/app/index.php/Printer_cd/printer_list/type/5/shop_id/<?=$shop_id?>/shop_name/<?=$name?>/C_id/<?=$customer_id?>">点击设置小票打印机</a>
							<input type=hidden name="isprint" id="isprint" value=<?php echo $isprint; ?> />
						</dl>
						
						<dl class="WSY_remind_dl04">
							<dt>是否显示底部菜单：</dt>
							<dd>
								<?php if($is_showbottom_menu){?>
								<ul style="background-color: rgb(255, 113, 112);">
									<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
									<li class="WSY_derail" onclick="derail_off(4)" style="left: 0px; display: list-item;"></li>
									<span class="WSY_derail2" onclick="derail_on(4)" style="left: 0px; display: none;"></span>
								</ul>
								<?php }else{?>
								<ul style="background-color: rgb(203, 210, 216);">
									<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
									<li class="WSY_derail" onclick="derail_off(4)" style="left: 30px; display: none;"></li>
									<span class="WSY_derail2" onclick="derail_on(4)" style="left: 30px; display: block;"></span>
								</ul>
								<?php } ?>
								<input type=hidden name="is_showbottom_menu" id="is_showbottom_menu" value=<?php echo $is_showbottom_menu; ?> />
							</dd>
						</dl>
						
						<dl class="WSY_remind_dl05">
							<dt>是否显示好评/中评/差评：</dt>
							<dd>
								<?php if($is_showdiscuss){?>
								<ul style="background-color: rgb(255, 113, 112);">
									<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
									<li class="WSY_derail" onclick="derail_off(5)" style="left: 0px; display: list-item;"></li>
									<span class="WSY_derail2" onclick="derail_on(5)" style="left: 0px; display: none;"></span>
								</ul>
								<?php }else{?>
								<ul style="background-color: rgb(203, 210, 216);">
									<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
									<li class="WSY_derail" onclick="derail_off(5)" style="left: 30px; display: none;"></li>
									<span class="WSY_derail2"  onclick="derail_on(5)" style="left: 30px; display: block;"></span>
								</ul>
								<?php } ?>
								<input type=hidden name="is_showdiscuss" id="is_showdiscuss" value=<?php echo $is_showdiscuss; ?> />
							</dd>
						</dl>
						
						<dl class="WSY_remind_dl06">
							<dt>是否开启图片评价上传<span>（需要是认证的订阅号或者服务号）</span></dt>
							<dd>
								<?php if($is_pic){?>
								<ul style="background-color: rgb(255, 113, 112);">
									<p style="margin: 0px 0px 0px 22px; color: rgb(255, 255, 255);">NO</p>
									<li class="WSY_derail"  onclick="derail_off(6)" style="left: 0px; display: list-item;"></li>
									<span class="WSY_derail2" onclick="derail_on(6)" style="left: 0px; display: none;"></span>
								</ul>
								<?php }else{?>
								<ul style="background-color: rgb(203, 210, 216);">
									<p style="margin: 0px 0px 0px 6px; color: rgb(127, 138, 151);">OFF</p>
									<li class="WSY_derail" onclick="derail_off(6)" style="left: 30px; display: none;"></li>
									<span class="WSY_derail2" onclick="derail_on(6)" style="left: 30px; display: block;"></span>
								</ul>
								<?php } ?>
								<input type=hidden name="is_pic" id="is_pic" value=<?php echo $is_pic; ?> />
							</dd>
						</dl>
						
					</div>
				</div>
			</div>
			<!--客服提醒设置结束-->
            
			<!--推广图片开始-->
			<div class="WSY_Setting_box">
				<div class="WSY_Setting2">
					<p class="WSY_setting_P">推广图片/详情页面设置</p><!--每个设置项标题-->
					<div class="WSY_setailspage_main"><!--推广设置-->
					
						<dl class="WSY_setailspage_dl01">
							<dt>详情页面模板&nbsp;&nbsp;&nbsp;<b class="WSY_setailspage_dd01">产品图片尺寸要求：400*400&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;640*320&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;640*320&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;640*320&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;640*320</b></dt>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==1){ ?>checked=true<?php } ?> value=1><label for="17">橱窗<br><br><img src="images/small_detail1.jpg" onMouseOver="toolTip('<img src=images/big_detail1.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==2){ ?>checked<?php } ?> value=2><label for="18">幻灯片1<br><br><img src='images/small_detail2.jpg' onMouseOver="toolTip('<img src=images/big_detail2.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==3){ ?>checked<?php } ?> value=3><label for="19">幻灯片2<br><br><img src="images/small_detail3.jpg" onMouseOver="toolTip('<img src=images/big_detail3.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==4){ ?>checked<?php } ?> value=4><label for="20">幻灯片3<br><br><img src="images/small_detail4.jpg" onMouseOver="toolTip('<img src=images/big_detail4.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==5){ ?>checked<?php } ?> value=5><label for="21">幻灯片5<br><br><img src="images/small_detail5.jpg" onMouseOver="toolTip('<img src=images/big_detail5.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="detail_template_type" <?php if($detail_template_type==6){ ?>checked<?php } ?> value=6><label for="21">幻灯片6<br><br><img src="images/small_detail6.jpg" onMouseOver="toolTip('<img src=images/big_detail6.jpg>')" onMouseOut="toolTip()"></label></dd>
						</dl>
						
						<dl class="WSY_setailspage_dl02">
							<dt>推广图片风格</dt>
							<dd><input type="radio" name="watertype" <?php if($watertype==1){ ?>checked=true<?php } ?> value=1><label for="22">风格1<br><br><img src="images/small_pic.jpg"onMouseOver="toolTip('<img src=images/big_pic.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==2){ ?>checked<?php } ?> value=2><label for="23">风格2<br><br><img src="images/small_pic2.jpg" onMouseOver="toolTip('<img src=images/big_pic2.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==3){ ?>checked<?php } ?> value=3><label for="24">风格3<br><br><img src="images/small_pic3.jpg" onMouseOver="toolTip('<img src=images/big_pic3.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==4){ ?>checked<?php } ?> value=4><label for="25">风格4<br><br><img src="images/small_pic4.jpg" onMouseOver="toolTip('<img src=images/big_pic4.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==5){ ?>checked<?php } ?> value=5><label for="26">风格5<br><br><img src="images/small_pic5.jpg" onMouseOver="toolTip('<img src=images/big_pic5.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==6){ ?>checked<?php } ?> value=6><label for="26">风格6<br><br><img src="images/small_pic6.jpg" onMouseOver="toolTip('<img src=images/big_pic6.jpg>')" onMouseOut="toolTip()"></label></dd>
							<dd><input type="radio" name="watertype" <?php if($watertype==7){ ?>checked<?php } ?> value=7><label for="26">风格7<br><br><img src="images/small_pic7.jpg" onMouseOver="toolTip('<img src=images/big_pic7.jpg>')" onMouseOut="toolTip()"></label></dd>
							<?php
							if($http_host=='szsmer.app258.com'){//只给何妍特定的那个客户
							?>
							<dd><input type="radio" name="watertype" <?php if($watertype==8){ ?>checked<?php } ?> value=8><label for="26">风格8<br><br><img src="images/small_pic8.jpg" onMouseOver="toolTip('<img src=images/big_pic8.jpg>')" onMouseOut="toolTip()"></label></dd>
							<?php
							}
							?>
							
						</dl>
						
						<dl class="WSY_setailspage_dl03">
							<dt>推广自定义文字 1（文字不适宜太长）</dt>
							<dd><input type="text" name="exp_pic_text1" value="<?php echo $exp_pic_text1?>"></dd>
						</dl>
						
						<dl class="WSY_setailspage_dl04">
							<dt>推广自定义文字 2（文字不适宜太长）</dt>
							<dd><input type="text" name="exp_pic_text2" value="<?php echo $exp_pic_text2?>"></dd>
						</dl>
						
						<dl class="WSY_setailspage_dl05">
							<dt>推广自定义文字 3 (文字不适宜太长)</dt>
							<dd><input type="text" name="exp_pic_text3" value="<?php echo $exp_pic_text3?>"></dd>
						</dl>
						
					</div>
				</div>
			</div>
			<!--推广设置结束-->

		<!--上传图片代码开始-->
            <div class="WSY_Setting_box" id="WSY_Setting_box1">
            	<p class="WSY_setting_P">上传图片</p><!--每个设置项标题-->
                <div class="WSY_uploadphotos_main"><!--上传图片-->
                
                	<dl class="WSY_uploadphotos_dl01">
                    	<dt>申请推广员头部图片</dt>
                        <a><img src="images/pic_icon.png"></a>
                        <dd>上传1张图片，作为首页的图片。图片大小建议：500*250像素</dd>
                            <!--上传文件代码开始-->
                            <div class="uploader white">
                                <input type="text" class="filename" readonly/>
                                <input type="button" name="file" class="button" value="上传..."/>
                                <input type="file" size="30"/>
                            </div>
                            <!--上传文件代码结束-->
                    </dl>
                    
                    <dl class="WSY_uploadphotos_dl02">
                    	<dt>产品分享图片</dt>
                        <a><img src="images/pic_icon.png"></a>
                        <dd>上传1张图片，作为首页的图片。图片大小建议：500*250像素</dd>
                            <!--上传文件代码开始-->
                            <div class="uploader white">
                                <input type="text" class="filename" readonly/>
                                <input type="button" name="file" class="button" value="上传..."/>
                                <input type="file" size="30"/>
                            </div>
                            <!--上传文件代码结束-->
                    </dl>
                    
                </div>
            </div>
        <!--上传图片代码结束-->
        <div class="WSY_text_input"><button class="WSY_button">提交保存</button><br class="WSY_clearfloat"></div>
	</div>
    <!--基本设置代码结束-->
</div>    
    
<script type="text/javascript" src="js/ToolTip.js"></script>
<script>
function change_distribution(){		//改变以第一次为准和以最后一次为准;
	var distr_type_1 = document.getElementById("distr_type_1").value;
	alert("选择后,不得恢复以第一次为准模式");
	return;
}
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
<!--内容框架结束-->
<script type="text/javascript" src="../common/js_V6.0/jquery.ui.datepicker.js"></script>
<script>
			// Replace the <textarea id="editor1"> with an CKEditor instance.
			CKEDITOR.replace( 'editor1', {});
</script>
</body>
</html>

