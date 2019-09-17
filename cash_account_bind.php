<!DOCTYPE html>
<html>
<head>
    <title>提现账号管理</title>
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
    

    
    <link rel="stylesheet" id="wp-pagenavi-css" href="./css/list_css/pagenavi-css.css" type="text/css" media="all">
	  <link rel="stylesheet" id="twentytwelve-style-css" href="./css/list_css/style.css" type="text/css" media="all">
    <link rel="stylesheet" id="twentytwelve-style-css" href="./css/goods_css/dialog.css" type="text/css" media="all">
	  <link type="text/css" rel="stylesheet" href="./css/list_css/r_style.css" />
    <link type="text/css" rel="stylesheet" href="./css/password.css" />
    
<style>  
   .selected{border-bottom: 5px solid black; color:black; }
   .list {margin: 10px 5px 0 3px;	overflow: hidden;}
   .area-line{height:25px;width:1px;float:left;margin-top: 10px;padding-top: 20px;border-left:1px solid #cdcdcd;}
   .topDivSel{width:100%;height:45px;top:50px;padding-top:0px;background-color:white;}
   .infoBox{width:90%;margin:10px auto;;background-color:white;color:white;box-shadow: 3px 5px 3px #888888;position: relative;}
   .infoBox .ele{height: 40px;width:90%;line-height: 40px;margin:0 auto;}
   .red{color:red;}
   .black{color:black}
   .content_top{height: 45px;line-height:45px;background-color:#f8f8f8;}
   .info_header{position:absolute;height:50px;line-height: 50px;border-top-left-radius:5px;border-top-right-radius:5px;z-index: 999;width: 100%;}
   .content_bottom{height: 22px;line-height:22px;background-color:#f8f8f8;}
   .btn span{width:100%;color:white;height:45px;line-height:45px; padding:10px;letter-spacing:3px;}
   .info_header_left{float:left;padding-left:20px;font-size:20px;width:70%;}
   .info_header_right{float:right;padding-right:10px;text-decoration: underline;}
   .info_header_left span{vertical-align: middle;margin-left: 10px;}
   .border-bottom-color-green{border-bottom: 4px solid #189c3a;}
   .border-bottom-color-blue{border-bottom: 4px solid #1b709f;}
   .border-bottom-color-yellow{border-bottom: 4px solid #cb6920;}
   .border-bottom-color-red{border-bottom: 4px solid #ac3d4a;}
   .info_content{margin:10px auto;;background-color:white;padding-bottom:10px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;display:block;}
   .info_content .ele{height: 30px;width:90%;line-height: 30px;margin:0 auto;}
   .ele .left{width:40%;float:left;color:#707070}
   .ele .right{width:60%;float:left;color:#707070}
   .ele img{width: 20px;height: 20px;vertical-align:middle;}
   .repair_btn{position: absolute;float:right;right:15px;top:0px;}
   .pop{position: absolute;float:right;right:50px;top:-21px;font-size: 25px;}
   .info_middle{height:50px;}
   .repair_btn img{width: 20px;height: 15px;vertical-align:middle;}
   
</style>


</head>
<!-- Loading Screen -->
<div id='loading' class='loadingPop' style="display: none;"><img src='./images/loading.gif' style="width:40px;"/><p class=""></p></div>

<body data-ctrl=true style="background:#f8f8f8;">
<!-- 	<header data-am-widget="header" class="am-header am-header-default">
		<div class="am-header-left am-header-nav" onclick="goBack();">
			<img class="am-header-icon-custom" src="./images/center/nav_bar_back.png" style="vertical-align:middle;"/><span style="margin-left:5px;">返回</span>
		</div>
	    <h1 class="am-header-title" style="font-size:18px;">提现账号管理</h1>
	</header>
	<div class="topDiv"></div> --><!-- 暂时隐藏头部导航栏 -->
	<div class="content_top">
		<div style="width:100%;padding-left:20px;text-align: left;">
            <img src="./images/info_image/xiugai.png" alt="" style="width: 20px;height: 15px;vertical-align:middle;"/>
            <span style="vertical-align: middle;">提现账号管理</span>
        </div>
    </div>
    
    
    
    <!-- 微信零钱 start -->
    <div class="infoBox"  id="weixin_info">
         <div class="info_header border-bottom-color-green" style="background-color: #21ac45;">
            <div class="info_header_left">
               <img src="./images/info_image/weixin_white.png" alt="" style="width: 30px;height: 25px;vertical-align:middle;"/>
               <span>微信零钱</span> 
            </div>
         </div>
         <div class="info_middle"></div>
         <div class="info_content" style="position: relative;">
            <div class="ele">
                <div class="left">真实姓名:</div>
                <div class="right">兽医 </div>
            </div>
            <div class="ele">
                <div class="left">手机号码:</div>
                <div class="right">159****0142</div>
            </div>
            <div class="repair_btn" onclick="editInfo('weixin');">
                <img src="./images/info_image/xiugai.png" />
            </div>
            <div class="pop">
                <span class="menu_selected" id="arrow_1" style="color:#21ac45;">◆</span>
            </div>
        </div>
    </div>
    <!-- 微信零钱 end -->
    
    
    <!-- 支付宝零钱 start -->
    <div class="infoBox"  id="zhifubao_info">
         <div class="info_header border-bottom-color-blue" style="background-color: #2286bd;">
            <div class="info_header_left">
               <img src="./images/info_image/zhifubao-white.png" alt="" style="width: 30px;height: 25px;vertical-align:middle;"/>
               <span>支付宝</span> 
            </div>
         </div>
         <div class="info_middle"></div>
         <div class="info_content" style="position: relative;">
            <div class="ele">
                <div class="left">真实姓名:</div>
                <div class="right">兽医 </div>
            </div>
            <div class="ele">
                <div class="left">手机号码:</div>
                <div class="right">159****0142</div>
            </div>
            <div class="ele">
                <div class="left">支付宝账户:</div>
                <div class="right">159****0142</div>
            </div>
            
            <div class="repair_btn" onclick="editInfo('zhifubao');">
                <img src="./images/info_image/xiugai.png" alt="" style=""/>
            </div>
            <div class="pop">
                <span class="menu_selected" id="arrow_1" style="color:#2286bd;">◆</span>
            </div>
        </div>
    </div>
    <!-- 支付宝零钱 end -->
    
    <!-- 财付通零钱 start -->
    <div class="infoBox"  id="caifutong_info">
         <div class="info_header border-bottom-color-yellow" style="background-color: #fb862f;">
            <div class="info_header_left">
               <img src="./images/info_image/caifutong_white.png" alt="" style="width: 30px;height: 25px;vertical-align:middle;"/>
               <span>财付通</span> 
            </div>
         </div>
         <div class="info_middle"></div>
         <div class="info_content" style="position: relative;">
            <div class="ele">
                <div class="left">真实姓名:</div>
                <div class="right">兽医 </div>
            </div>
            <div class="ele">
                <div class="left">手机号码:</div>
                <div class="right">159****0142</div>
            </div>
            <div class="ele">
                <div class="left">财付通账户:</div>
                <div class="right">159****0142</div>
            </div>
            <div class="repair_btn" onclick="editInfo('caifutong');">
                <img src="./images/info_image/xiugai.png" />
            </div>
            <div class="pop">
                <span class="menu_selected" id="arrow_1" style="color:#fb862f;">◆</span>
            </div>
        </div>
    </div>
    <!-- 财付通零钱 end -->
    <!-- 银行卡零钱 start -->
    <div class="infoBox"  id="card_info">
         <div class="info_header border-bottom-color-red" style="background-color: #c2505d;">
            <div class="info_header_left">
               <img src="./images/info_image/card_white.png" alt="" style="width: 30px;height: 25px;vertical-align:middle;"/>
               <span>银行卡</span> 
            </div>
         </div>
         <div class="info_middle"></div>
         <div class="info_content" style="position: relative;">
            <div class="ele">
                <div class="left">真实姓名:</div>
                <div class="right">兽医 </div>
            </div>
            <div class="ele">
                <div class="left">手机号码:</div>
                <div class="right">159****0142</div>
            </div>
            <div class="ele">
                <div class="left">开户银行:</div>
                <div class="right">建设银行</div>
            </div>
            <div class="ele">
                <div class="left">开户账户:</div>
                <div class="right">62253025432****4520 </div>
            </div>
            <div class="repair_btn" onclick="editInfo('card');">
                <img src="./images/info_image/xiugai.png" />
            </div>
            <div class="pop">
                <span class="menu_selected" id="arrow_1" style="color:#c2505d;">◆</span>
            </div>
        </div>
    </div>
    <!-- 银行卡零钱 end -->
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>    
    <script type="text/javascript" src="./assets/js/amazeui.js"></script>
    <script type="text/javascript" src="./js/global.js"></script>
    <script type="text/javascript" src="./js/loading.js"></script>
    <script src="./js/jquery.ellipsis.js"></script>
    <script src="./js/jquery.ellipsis.unobtrusive.js"></script>
    <script src="./js/r_global_brain.js" type="text/javascript"></script>
    <script type="text/javascript" src="./js/r_jquery.mobile-1.2.0.min.js"></script>
    <script src="./js/sliding.js"></script>
</body>		

<script type="text/javascript">
   function editInfo(type){
       window.location.href=type+"_zhanghu.html";
   }
</script>
</html>