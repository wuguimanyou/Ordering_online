<?php
header("Content-type: text/html; charset=utf-8"); 
require('../config.php');
require('../back_init.php');
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');

require('../proxy_info.php');

mysql_query("SET NAMES UTF8");

$query = "select id,name,email,is_showdiscuss,is_needlogin,shop_card_id,member_template_type,is_autoupgrade,need_express,distr_type,auto_upgrade_money,is_attent,attent_url,auto_confirmtime,online_type,online_qq,need_online,need_email,sell_detail,issell,sell_discount,reward_type,init_reward,need_customermessage,isprint,detail_template_type,is_showbottom_menu from weixin_commonshops where isvalid=true and customer_id=".$customer_id;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$name="";
$email="";
$need_express=0;
$need_email=0;
$shop_id=-1;
$issell=0;
$sell_discount = 0;
$reward_type = 1;
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
$distr_type = 1;
$is_showbottom_menu = 1;
$auto_upgrade_money = 0;
$is_autoupgrade = 0;
$is_needlogin = 1;
$shop_card_id = -1;
$is_showdiscuss = 1;
while ($row = mysql_fetch_object($result)) {
    $name=$row->name;
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
	$is_attent = $row->is_attent;
	$attent_url = $row->attent_url;
	$distr_type = $row->distr_type;
	$is_showbottom_menu = $row->is_showbottom_menu;
	$auto_upgrade_money = $row->auto_upgrade_money;
	$is_autoupgrade = $row->is_autoupgrade;
	$is_needlogin = $row->is_needlogin;
	$shop_card_id = $row->shop_card_id;
	$is_showdiscuss = $row->is_showdiscuss;
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

$query="select sum(totalprice) as today_totalprice from weixin_commonshop_orders where paystatus=1 and isvalid=true and customer_id=".$customer_id." and year(createtime)=".$year." and month(createtime)=".$month." and day(createtime)=".$day;
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

?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title></title>
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/global.js"></script>
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
			<li class=""><a href="qrsell.php?customer_id=<?php echo $customer_id; ?>">推广员</a></li>
			<li class=""><a href="customers.php?customer_id=<?php echo $customer_id; ?>">顾客</a></li>
		
		</ul>
	</div>
<link href="css/operamasks-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/operamasks-ui.min.js"></script>
<div class="r_con_config r_con_wrap">
	<form id="config_form" action="save_base.php?customer_id=<?php echo $customer_id; ?>" method="post">
	    <input type=hidden name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>" />
		
		<table border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td width="50%" valign="top">
					<h1><span class="fc_red">*</span> <strong>微商城名称</strong></h1>
					
					     <input type="text" class="input" name="name" value="<?php echo $name; ?>" maxlength="30" notnull="">
					<?php if($is_shopdistr){ ?>
						<h1><strong>是否开启分销</strong><span class="tips">(让顾客成为你的推广员)</span></h1>
						<div class="input">
						<label>
						<input type="checkbox" name="chk_express" <?php if($issell){?>checked<?php } ?> onclick="change_issell(this);"><span class="tips">必须是认证过的服务号</span>
						</label>
						</div>
						
						<input type=hidden name="issell" id="issell" value=<?php echo $issell; ?>  />
						<div id="tr_sell" style="display:none">
						
						
						<h1><strong>推广员下线发展模式:</strong></h1>
						<div class="input">
						<label><input type=radio <?php if($distr_type==1){ ?>checked<?php } ?> value=1 name="distr_type">以最后一次为准
						</label>
						<label><input type=radio <?php if($distr_type==2){ ?>checked<?php } ?> value=2 name="distr_type">以第一次为准
						</label>
						</div>
						
						<h1><strong>推广员生成条件:</strong></h1>
						<div class="input" style="height:60px;">
						<label><input type=radio <?php if($is_autoupgrade==0){ ?>checked<?php } ?> value=0 name="is_autoupgrade" onclick="change_autoupgrade(0,this.checked);">不自动生成
						</label>
						<label><input type=radio <?php if($is_autoupgrade==1){ ?>checked<?php } ?> value=1 name="is_autoupgrade" onclick="change_autoupgrade(1,this.checked);">自动生成
						</label>
						<div id="div_autoupgrade_money" <?php if($is_autoupgrade==0){ ?>style="display:none"<?php } ?>>
						消费了<input type=text value="<?php echo $auto_upgrade_money; ?>" style="width:50px" name="auto_upgrade_money">元,申请后自动成为推广员 
						</div>
						</div>
						
						<h1><strong>通过推广购买折扣:</strong></h1>
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
						
						<h1><strong>佣金类型:</strong></h1>
						<div class="input">
						<label>
						<input type="radio" name="reward_type" value=1 <?php if($reward_type==1){?>checked<?php } ?> onchange="changeRewardType(1);">积分
						</label>&nbsp;&nbsp;
						<label>
						<input type="radio" name="reward_type" value=2 <?php if($reward_type==2){?>checked<?php } ?>  onchange="changeRewardType(2);">金额
						</label>
						</div>
						<h1><strong>总佣金比例:</strong></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" name="init_reward" id="init_reward" value="<?php echo $init_reward; ?>" />（0~1)
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
						<h1><strong>自动确认订单 (顾客收货的订单,在该时间后,自动确认完成并返佣):</strong></h1>
						<div class="input">
						<label><input type="text" style="width:50px;" name="auto_confirmtime" id="auto_confirmtime" value="<?php echo $auto_confirmtime; ?>" />天
						</label>
						
						</div>
						<h1><strong>分销体系描述:</strong></h1>
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
					
					<h1 style="margin-top:15px;"><strong>是否开始微小票打印<?=$isprint?></strong><span class="tips"></span></h1>
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
					
					<h1 style="margin-top:15px;"><strong>详情页面模板</strong><span class="tips"></span></h1>
					<div class="input" style="height:120px;">
					<label>
					  <input type=radio name="detail_template_type" <?php if($detail_template_type==1){ ?>checked=true<?php } ?> value=1>橱窗(产品图片要求:400*400)</label><br/>
					  <label>&nbsp;<input type=radio name="detail_template_type" <?php if($detail_template_type==2){ ?>checked<?php } ?> value=2>幻灯片(产品图片要求:640*320)&nbsp;</label><br/>
					  <label>&nbsp;<input type=radio name="detail_template_type" <?php if($detail_template_type==3){ ?>checked<?php } ?> value=3>幻灯片-购物车(产品图片要求:640*320)&nbsp;</label><br/>
					  <label>&nbsp;<input type=radio name="detail_template_type" <?php if($detail_template_type==4){ ?>checked<?php } ?> value=4>幻灯片-立即购买(产品图片要求:640*320)&nbsp;</label>
					</div>
					
					
				</td>
			</tr>
			
			
		</tbody></table>
		<div class="submit"><input type="button" name="submit_button" value="提交保存" onclick="subBase();"></div>
		<input type="hidden" name="do_action" value="shop.config">
		<input type="hidden" name="member_template_type" value="1" />
		
	</form>
</div>	</div>
<div>

<?php 

mysql_close($link);
?>

<script type="text/javascript" src="../../weixin/plat/Public/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../weixin/plat/Public/ckfinder/ckfinder.js"></script>

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
  
  function subBase(){
     <?php if($is_shopdistr==1){ ?>
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
	 <?php } ?>
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
     if(type==0){
	     if(v){
		    document.getElementById("div_autoupgrade_money").style.display="none";
		 }
	 }else{
	    if(v){
		    document.getElementById("div_autoupgrade_money").style.display="block";
		 }
	 }
  }
  

</script>
</div></div></body></html>