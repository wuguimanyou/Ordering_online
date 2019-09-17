<?php
  header("Content-type: text/html; charset=utf-8"); 
  require('../../../config.php');
  require('../../../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
  require('../../../back_init.php');   
  $pagenum=1; 
  if(!empty($_GET["pagenum"])){
   $pagenum = $_GET["pagenum"];
  }
  $user_id = $configutil->splash_new($_GET["user_id"]); 
  $isAgent = $configutil->splash_new($_GET["isAgent"]);
  $fromw =$configutil->splash_new($_GET["fromw"]);
  $parent_id =$configutil->splash_new($_GET["parent_id"]);

  $link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
  mysql_select_db(DB_NAME) or die('Could not select database');
  mysql_query("SET NAMES UTF8");
  require('../../../proxy_info.php');

   $sql = "SELECT agent_name,agent_price,agent_discount from weixin_commonshop_applyagents where isvalid=true and user_id=".$user_id;
   $res = mysql_query($sql);
   while($row=mysql_fetch_object($sql)){
   	$agent_name 	= $row->agent_name;
   	$agent_price	= $row->agent_price;
  	$agent_discount = $row->agent_discount;
   }
$query = "select id,agent_price,agent_detail,is_showdiscount from weixin_commonshop_agents where isvalid=true and customer_id=".$customer_id;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$agent_price=""; 	
$agent_detail="";
$is_showdiscount=0;
while ($row = mysql_fetch_object($result)) {
    $agent_price=$row->agent_price;		//代理商和价格
	$agent_detail=$row->agent_detail;	//代理说明
	$is_showdiscount=$row->is_showdiscount;
}
$pricearr = explode(",",$agent_price);

$len =  count($pricearr);
$diy_num = $len;





?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content.css">
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content<?php echo $theme; ?>.css">
<link rel="stylesheet" type="text/css" href="../../Common/css/Base/pay_set/allinpay_set.css">
<link rel="stylesheet" type="text/css" href="../../Common/css/Users/promoter/add_qrsell_account.css">
<script type="text/javascript" src="../../../common/js/jquery-2.1.0.min.js"></script>
<title>修改角色</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">

</head>
<body>
<div class="WSY_content">
	<div class="WSY_columnbox">
	<div class="WSY_column_header">
			<div class="WSY_columnnav">
				<a class="white1">修改角色</a>
			</div>
		</div>
		<form action="save_change_role.php?customer_id=<?php echo $customer_id_en ?>&user_id=<?php echo $user_id; ?>&parent_id=<?php echo $parent_id; ?>&pagenum=<?php echo $pagenum; ?>"  id="keywordFrm" method="post" >
		<input type="hidden" name="fromw" value="<?php echo $fromw ;?>"/>
		<input type="hidden" name="user_id" value="<?php echo $user_id ;?>"/>
		<input type="hidden" name="parent_id" value="<?php echo $parent_id ;?>"/>
			<div class="WSY_remind_main">
				
				<dl class="WSY_remind_dl02"> 
					<dt>角色列表：</dt>
					<dd>
				<select name="new_role" id="new_role" onchange="changeType(this.value)" >
					 <option value="0" selected = "selected">请选择</option>
					 <option value="1" <?php if($isAgent==1){ ?>selected<?php }  ?>>代理商</option>
					  <option value="2" <?php  if($isAgent==2){ ?>selected<?php }  ?>>分销商</option> 
					 <option value="3" <?php  if($isAgent==3){ ?>selected<?php }  ?>>供应商</option>
					 
			    </select>
			    <select id="agent_select" name="agent_select" class="agent_select" style="display:none" >
						<?php 
						for($i=0;$i<$len;$i++){
						   $varr= $pricearr[$i];
						   if(empty($varr)){
							  continue;
						   }
						   $vlst = explode("_",$varr);
						   
						   $type = $vlst[0];
						   if(empty($vlst[1])){
							   continue;
						   }
						   $name = $vlst[1];
						   $value = $vlst[2];
						   $discount = $vlst[3];
						?>
					   <option value=<?php echo $pricearr[$i];?> ><?php echo $name;?> 费用:<?php echo $value;?>元 <?php if($is_showdiscount==1){?>折扣:<?php echo $discount;?>%<?php }?></option>
					<?php }?> 
					</select>           	
					</dd>
				</dl>	
				
		<div class="submit_div">
			<input type="button" class="WSY_button" value="提交" onclick="submitV(this);" style="cursor:pointer;">
			<input type="button" class="WSY_button" value="取消" onclick="document.location='fans.php?customer_id=<?php echo $customer_id_en ?>';">
		</div>
	
	
	</form>
	</div>
</div> 	
<script type="text/javascript" src="../../../common/js_V6.0/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../common/js_V6.0/content.js"></script>
<script type="text/javascript" src="../../Common/js/Base/pay_set/allinpay_set.js"></script>

</body>
<script>
function submitV(){
	
	  //
	  var auto_type = <?php echo $isAgent?>;
	  var now_type  = $("#new_role").val();
	  if(auto_type==now_type){
	  		alert("不能重复提交当前身份");
	  		return false;
	  }else{
	  		document.getElementById("keywordFrm").submit();
	  }
 }



var type = $("#new_role").val();
if(type==1){
	$(".agent_select").show();
}else{
	$(".agent_select").hide();
}

var type = $("#new_role").val();
if(type==1){
	$(".agent_select").show();
}else{
	$(".agent_select").hide();
}


function changeType(value){
	if(value==1){
		$(".agent_select").show();
	}else{
		$(".agent_select").hide();
	}
}



</script>
<?php 

mysql_close($link);

?>
</html>