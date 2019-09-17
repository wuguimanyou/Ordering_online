<?php
header("Content-type: text/html; charset=utf-8");     
require('../config.php');
require('../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]

$link = mysql_connect(DB_HOST,DB_USER,DB_PWD); 
mysql_select_db(DB_NAME) or die('Could not select database');
//头文件----start
require('../common/common_from.php');
//头文件----end
require('select_skin.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>修改转赠用户 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="no" name="apple-touch-fullscreen">
    <meta name="MobileOptimized" content="320"/>
    <meta name="format-detection" content="telephone=no">
    <meta name=apple-mobile-web-app-capable content=yes>
    <meta name=apple-mobile-web-app-status-bar-style content=black>
    <meta http-equiv="pragma" content="nocache">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">
    
    <link type="text/css" rel="stylesheet" href="./assets/css/amazeui.min.css" />
    <link type="text/css" rel="stylesheet" href="./css/order_css/global.css" />   
    <link type="text/css" rel="stylesheet" href="./css/css_<?php echo $skin ?>.css" />  
     
<style>  
   .plus-tag-add{width:100%;min-width:350px;line-height:50px;padding-left:10px;}
   .info_middle{width:100%;height:50px;line-height:50px;background-color:white;margin:0 auto;}
   .gray{color:darkgray;}
   .btn{height: 32px;line-height: 32px;vertical-align: middle;}
   .am-btn{width: 100%;height: 50px;}
   .info_right{text-align:left;color:black;} 
   .plus-tag-add img{margin-right:5px;margin-left:10px;height:14px;vertical-align:middle;}
</style>


</head>
<!-- Loading Screen -->
<div id='loading' class='loadingPop'style="display: none;"><img src='./images/loading.gif' style="width:40px;"/><p class=""></p></div>

<body data-ctrl=true style="background:#f8f8f8;">
	<!-- <header data-am-widget="header" class="am-header am-header-default">
		<div class="am-header-left am-header-nav" onclick="goBack();">
			<img class="am-header-icon-custom" src="./images/center/nav_bar_back.png" style="vertical-align:middle;"/><span style="margin-left:5px;">返回</span>
		</div>
	    <h1 class="am-header-title" style="font-size:18px;">修改转赠用户 </h1>
	</header>
	<div class="topDiv"></div> --><!-- 暂时隐藏头部导航栏 -->
	
	<div style="height: 50px;background-color:#f8f8f8;">
		<div class="plus-tag-add gray"><img src="./images/info_image/edit.png" /><span style="vertical-align: middle;">修改转赠用户ID<span></div>
    </div>
    <div style="width:100%;font-size:16px;">
        	<div class="info_middle">
		        <div class="gray" style="float:left;padding-left:15px">
		    		用户 &nbsp;&nbsp;&nbsp;&nbsp;ID：
		    	</div>
	    	<div class="info_right_text"><span ><input type="text" id="currency_user" style="border:none;"></span></div>
    </div>
    
    <div data-am-widget="navbar" class="am-cf am-navbar-default  am-no-layout" style="padding: 20px 25px 0px 25px;height: 70px;">
        <a class="am-btn am-btn-warning" href="#" onclick="onCommit();">
          <span class="btn">确认</span>
        </a>
    </div>
    
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>    
    <script type="text/javascript" src="./assets/js/amazeui.js"></script>
    <script type="text/javascript" src="./js/global.js"></script>
    <script type="text/javascript" src="./js/loading.js"></script>

    <script src="./js/jquery.ellipsis.js"></script>
    <script src="./js/jquery.ellipsis.unobtrusive.js"></script>
</body>		

<script type="text/javascript">

    //Jump to 详细
    function onCommit(){
		var to_user_id = $("#currency_user").val();
    //alert(to_user_id);
    var member = /^\d+(\.\d+)?$/;
    if(to_user_id==='' || !member.test(to_user_id)){
      alert("请输入正确的用户ID");
      return false;
    }else{
      window.location.href='currency_send.php?to_user_id='+to_user_id;
    }
   
   
	} 

</script>

</body>

</html>