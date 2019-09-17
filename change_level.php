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

  $link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
  mysql_select_db(DB_NAME) or die('Could not select database');
  mysql_query("SET NAMES UTF8");
  require('../../../proxy_info.php');


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
		<form action="save_change_role.php?customer_id=<?php echo $customer_id_en ?>&user_id=<?php echo $user_id; ?>&pagenum=<?php echo $pagenum; ?>"  id="keywordFrm" method="post">
		<input type="hidden" name="fromw" value="<?php echo $fromw ;?>"/>
		<input type="hidden" name="user_id" value="<?php echo $user_id ;?>"/>
			<div class="WSY_remind_main">
				
				<dl class="WSY_remind_dl02"> 
					<dt>角色列表：</dt>
					<dd>
				<select name="new_role" id="new_role">
					 <option value="0" >请选择</option>
					 <option value="2" <?php  if($isAgent==2){ ?>selected<?php }  ?>>推广员</option> 
					 <option value="1" <?php if($isAgent==1){ ?>selected<?php }  ?>>代理商</option>
					  
					 <option value="3" <?php  if($isAgent==3){ ?>selected<?php }  ?>>供应商</option>
					 
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
	  document.getElementById("keywordFrm").submit();
}
</script>
<?php 

mysql_close($link);

?>
</html>