<?php
// +---------------------------------------------------------+
// |3*N级分佣更改推广员级别                                  |
// +---------------------------------------------------------+
// |日期:2015-12-21	                                         |	
// +---------------------------------------------------------+
// |By 黄照鸿                                                |
// +---------------------------------------------------------+

  header("Content-type: text/html; charset=utf-8"); 
  require('../../../config.php');
  require('../../../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
  //require('../../../back_init.php');   
  $pagenum=1; 
  if(!empty($_GET["pagenum"])){
	  
	$pagenum = $configutil->splash_new($_GET["pagenum"]); 
  }
  $user_id=-1; 
  if(!empty($_GET["user_id"])){
	$user_id = $configutil->splash_new($_GET["user_id"]); 
	$user_id = passport_decrypt($user_id); 
  }
  $parent_id = $configutil->splash_new($_GET["parent_id"]); 
  $link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
  mysql_select_db(DB_NAME) or die('Could not select database');
  mysql_query("SET NAMES UTF8");
  require('../../../proxy_info.php');
  
    //读取商家自定义参数
    $query = "select is_ncomission_order from weixin_commonshops where isvalid=true and customer_id=".$customer_id." limit 0,1";
	$result = mysql_query($query) or die('w4292 Query failed: ' . mysql_error());
	$is_ncomission_order = 0;  //是否开启改变等级进行分佣 1:开启 0:关闭
	while ($row = mysql_fetch_object($result)) {
	   $is_ncomission_order  = $row->is_ncomission_order; 
	   break;
	}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content.css">
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content<?php echo $theme; ?>.css">
<link rel="stylesheet" type="text/css" href="../../Common/css/Users/promoter/change_pro_level.css">
<link rel="stylesheet" type="text/css" href="../../Common/css/Users/promoter/add_qrsell_account.css">
<script type="text/javascript" src="../../../common/js/jquery-2.1.0.min.js"></script>
<title>修改推广员分佣级别</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">

</head>
<body>
<div class="WSY_content">
	<div class="WSY_columnbox">
	<div class="WSY_column_header">
			<div class="WSY_columnnav">
				<a class="white1">修改推广员分佣级别</a>
			</div>
		</div>
		<form action="change_pro_level.class.php?pagenum=<?php echo $pagenum; ?>"  id="keywordFrm" method="post">
			<div class="WSY_remind_main">
				
				<dl class="WSY_remind_dl02"> 
					<dt>推广员分佣级别：</dt>
					<dd>
				<select name="level" id="level">
					<?php 
					//个人推广员的推广员分佣级别ID
					$query="select commision_level from promoters where isvalid=true and customer_id=".$customer_id." and user_id=".$user_id." limit 0,1";
					$result = mysql_query($query) or die('W61 Query failed: ' . mysql_error());
					$commision_level = 0;  
					while ($row = mysql_fetch_object($result)) {
						$commision_level = $row->commision_level;
					}
					$query="select id,level,level_price,exp_name from weixin_commonshop_commisions where isvalid=true and customer_id=".$customer_id." order by level asc";
					$result = mysql_query($query) or die('Query failed: ' . mysql_error());
					$level_id = -1;  
					$exp_name = "推广员"; //自定义名称
					$level = 1;			//级别 0:默认级别
					$level_price = 0;	//成为级别推广员条件金额
					while ($row = mysql_fetch_object($result)) {
						$level_id = $row->id;
						$level = $row->level; 
						$exp_name = $row->exp_name;
						//分佣等级小于自己的不可以设置,不显示出来
						if($commision_level<=$level){
					 ?>
					 <option value="<?php echo $level;?>" <?php if($level==$commision_level){ ?>selected<?php }  ?>><?php echo $exp_name;?></option>
						<?php }
						}?>
					<input type="hidden" name="parent_id" value="<?php echo $parent_id ;?>"/>
					<input type="hidden" name="customer_id_en" value="<?php echo $customer_id_en ;?>"/>
					<input type="hidden" name="user_id" value="<?php echo passport_encrypt($user_id) ;?>"/>
					<input type="hidden" name="op" value="modify_level"/>
			    </select>	 		
					</dd>
				</dl>	
				
		<div class="submit_div">
			<input type="button" class="WSY_button" value="提交" onclick="return submitV(this);" style="cursor:pointer;">
			<input type="button" class="WSY_button" value="取消" onclick="document.location='promoter.php?customer_id=<?php echo $customer_id_en ?>&pagenum=<?php echo $pagenum; ?>';">
		</div>
	
	
	</form>
	</div>
</div> 	
<script type="text/javascript" src="../../../common/js_V6.0/content.js"></script>
<script type="text/javascript" src="../../../common/js/layer/V2_1/layer.js"></script>
</body>
<script>

var checkSubmitFlg = false;


function submitV(){
		var commision_level     = <?php echo $commision_level;?>;	     //个人推广员级别ID
		var is_ncomission_order = <?php echo $is_ncomission_order;?>;	 //是否开启改变等级进行分佣 1:开启 0:关闭
		var level = $('#level').val();						     	 	 //选择的推广员级别
		if(level==-1){
			layer.alert('请选择级别');
			return;
		}
		//如果级别一致,则不需要更改
		if(level==commision_level){
			layer.alert('不需更改相同级别');
			return;
		}
		str = "改变推广员等级";
		if(is_ncomission_order){
			str = "改变推广员等级并进行等级分佣";
		}
	    layer.confirm(str, {
			btn: ['确定','取消'] //按钮
		}, function(){
			if (!checkSubmitFlg) {
			// 第一次提交
			  checkSubmitFlg = true;
			  document.getElementById("keywordFrm").submit();
			  return true;
			 } else {
			//重复提交
			  return false;
			 }
			
		}, function(){
			layer.alert('已取消');
		});	  
}
</script>
<?php 

mysql_close($link);

?>
</html>