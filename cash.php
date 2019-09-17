<?php
header("Content-type: text/html; charset=utf-8");     
require('../config.php');
require('../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
//require('../back_init.php'); 
require('../common/utility_fun.php');

$link = mysql_connect(DB_HOST,DB_USER,DB_PWD); 
mysql_select_db(DB_NAME) or die('Could not select database');
require('select_skin.php');
//头文件----start
require('../common/common_from.php');
//头文件----end
// $customer_id = 3243;
// $user_id=195203;

$cash_name = "";    //提现到
$choose_type = $configutil->splash_new($_GET["c_type"]);//提现类型
switch ($choose_type) {
    case '0':
        $cash_name = "微信零钱";
        $cahs_logo = "./images/info_image/weixin.png";
    break;

    case '1':
        $cash_name = "支付宝";
        $cahs_logo = "./images/info_image/zhifubao.png";
    break;

    case '2':
        $cash_name = "财付通";
        $cahs_logo = "./images/info_image/caifutong.png";
    break;

    case '3':
        $cash_name = "银行卡";
        $cahs_logo = "./images/info_image/card.png";
    break;
    
    default:
         $cash_name = "未知";
         $cahs_logo = "./images/order_image/icon_comment_bad_sel.png";
        break;
}


//查询钱包提现规则------------------------------------------------start
$isOpen_callback    = 0;//是否开启零钱提现
$start_time         = 1;//每月提现开始日期
$end_time           = 30;//每月提现结束日期
$week_time          = 0;//提现可设置按每周几提现 0：周日；1-6；周一-周六
$mini_callback      = 0;//最低提现金额
$max_callback       = 0;//不能提现金额
$callback_currency  = 0;//提现反购物币 0：不返 大于0则反千分之几
$callback_fee       = 0;//提现手续费 0：不收，大于0则收千分之几手续费
$full_vpscore       = 0;//提现vp值限制

$query = "SELECT isOpen_callback,
                 start_time,
                 end_time,
                 week_time,
                 mini_callback,
                 max_callback,
                 callback_currency,
                 callback_fee,
                 full_vpscore 
          FROM moneybag_rule 
          WHERE customer_id=".$customer_id." AND isvalid=true LIMIT 1";

$query = mysql_query($query) or die('Query failed 32: ' . mysql_error());
while( $row = mysql_fetch_object($query) ){
    $isOpen_callback    = $row->isOpen_callback;
    $start_time         = $row->start_time;
    $end_time           = $row->end_time;
    $week_time          = $row->week_time;
    $mini_callback      = $row->mini_callback;
    $max_callback       = $row->max_callback;
    $callback_currency  = $row->callback_currency;
    $callback_fee       = $row->callback_fee;
    $full_vpscore       = $row->full_vpscore;
}   
//查询钱包提现规则------------------------------------------------end

//查询个人钱包------------------------------------------------start
$balance = 0;
$query = "SELECT balance FROM moneybag_t WHERE isvalid=true AND customer_id=".$customer_id." AND user_id=".$user_id." LIMIT 1";
$result= mysql_query($query) or die('Query failed 32: ' . mysql_error());
while( $row = mysql_fetch_object($result) ){
    $balance = $row->balance;
    $balance = cut_num($balance,2);
}
$weixin_name = "";  //微信名
$account     = "";  //绑定手机号
$query = "SELECT weixin_name FROM weixin_users WHERE isvalid=true AND id=".$user_id." LIMIT 1";
$result= mysql_query($query) or die('Query failed 32: ' . mysql_error());
while( $row = mysql_fetch_object($result) ){
    $weixin_name = $row->weixin_name; 
}


$query = "SELECT account FROM system_user_t WHERE isvalid=true AND user_id=$user_id LIMIT 1";
$result= mysql_query($query) or die('Query failed 104: ' . mysql_error());
while( $row = mysql_fetch_object($result) ){
    $account = $row->account;
    $account     = substr($account, 0, 3).'****'.substr($account, 7);//隐藏中间号码
}

//查询个人钱包------------------------------------------------start

//判断当前用户提现条件
//print_r(getdate(time()));die;
$allow_cash = 0;        //允许提现的金额 初始化
$my_vpscore = 0;        //最低提现个人vp值
$mtime = array();
$mtime = getdate(time());
$todays= $mtime["mday"];//当前月天数 1~31
$wday  = $mtime["wday"];//今天是当星期的星期几 0~6
$allow_cash = cut_num($balance-$max_callback,2);

if($allow_cash<=0){
    $allow_cash=0;
}


$sql = "SELECT my_vpscore FROM weixin_user_vp WHERE isvalid=true AND customer_id=".$customer_id." AND user_id=".$user_id." LIMIT 1";
$res = mysql_query($sql) or die('Query failed 32: ' . mysql_error());
while( $row = mysql_fetch_object($res) ){
    $my_vpscore = $row->my_vpscore;
}

//各项条件------------start
$vp_boole = 0;
if( $my_vpscore >= $full_vpscore ){   //---如果 自己的vp值>= 系统最低所需vp值。则符合
        $vp_boole = 1;
}
//echo $vp_boole."==";die;
$start_boole = 0;
if( $start_time <= $todays ){        //---是否满足可期限日期 则符合
        $start_boole = 1;
}
$end_boole =0;                      //---提现结束日期是否满足
if( $end_time >= $todays ){
    $end_boole = 1;
}
$week_boole = 0;
if( $week_time = $wday || $$week_time = -1 ){
    $week_boole = 1;
}

$is_allow = 0;
if($vp_boole == 1 && $start_boole == 1 && $end_boole == 1 && $week_boole == 1){
    $is_allow = 1;
}
//各项条件------------end


?>
<!DOCTYPE html>
<html>
<head>
    <title>提现 </title>
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
    
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>    
    
    <link rel="stylesheet" id="wp-pagenavi-css" href="./css/list_css/pagenavi-css.css" type="text/css" media="all">
    <link rel="stylesheet" id="twentytwelve-style-css" href="./css/list_css/style.css" type="text/css" media="all">
    <link rel="stylesheet" id="twentytwelve-style-css" href="./css/goods/dialog.css" type="text/css" media="all">
    
    <link type="text/css" rel="stylesheet" href="./css/list_css/r_style.css" />
    <link type="text/css" rel="stylesheet" href="./css/password.css" />
    
<style>  
   .selected{border-bottom: 5px solid black; color:black; }
   .list {margin: 10px 5px 0 3px;   overflow: hidden;}
   .area-line{height:25px;width:1px;float:left;margin-top: 10px;padding-top: 20px;border-left:1px solid #cdcdcd;}
   .topDivSel{width:100%;height:45px;top:50px;padding-top:0px;background-color:white;}
   .infoBox{width:90%;margin:10px auto;;background-color:white;border:1px solid #ddd;}
   .infoBox .ele{height: 40px;width:90%;line-height: 40px;margin:0 auto;}
   .ele .left{width:40%;float:left;color:#727272}
   .ele .right{width:60%;float:left;}
   .ele img{width: 20px;height: 20px;vertical-align:middle;}
   .red{color:red;}
   .black{color:black}
   .line{background-color: #DEDBD5;margin-left: 10px;height: 1px;}
   .content_top{padding-top:20px;background-color:#f8f8f8;}
   .content_bottom{height: 22px;line-height:22px;background-color:#f8f8f8;}
   .btn{width:80%;margin:20px auto;text-align:center;}
   .btn span{width:100%;color:white;height:45px;line-height:45px; padding:10px;letter-spacing:3px;}
   .content_top .detail{width:100%;text-align: center;font-size:20px;height: 35px;line-height:35px;}
   .detail img{width: 20px;height: 20px;vertical-align:middle;}
   .sharebg{opacity: 1}
</style>


</head>
<!-- Loading Screen -->
<div id='loading' class='loadingPop'style="display: none;"><img src='./images/loading.gif' style="width:40px;"/><p class=""></p></div>

<body data-ctrl=true style="background:#f8f8f8;">

    <div class="topDiv"></div>


    <div class="sharebg"></div><!--半透明背景-->
    <div class="am-share" id="pass_w" style="width:100%;position: absolute;top:30%;z-index: 1111;display:none;height:201px">
        <div class="box">
            <h1>输入支付密码</h1>
            <label for="ipt">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </label>
            <input type="tel" id="ipt" maxlength="6">
            <div style="width:100%;text-align: right;;"> <a onclick='xiugai_pass();'>密码管理</a></div>
            <a class="commtBtn" onclick="commitBtn();" style="display:none;">确认</a>
        </div>
    </div>


    <div class="content_top">
        <div class="detail" ><span><?php echo $weixin_name;?></span></div>
        <div class="detail" ><span><?php echo $account;?></span></div>
        <div class="detail">
            <img src="<?php echo $cahs_logo;?>" alt="" style=""/>
            <span style="vertical-align: middle;font-size:14px;"><?php echo $cash_name;?></span>
        </div>
    </div>
 
    <div class="infoBox">
        <div class="ele">提现金额</div>
        <div class="ele" style="font-size:22px;height:42px;line-height:40px;">
            <!-- <span style="width:6%;color:#ff8430;font-size:30px;vertical-align:middle;height:50px;">￥</span><input type='number' value="" id="price" placeholder="请输入提现金额" style="width:100%;border:none;"/> -->
            <span class="ele_coinstyle_cash" style="width:6%;font-size:22px;vertical-align:middle;height:42px;">￥</span><input type='number' value="" id="price" placeholder="请输入提现金额" style="background-color:#ffffff !important;width:88%;border:none;font-size:22px;float:right;"/>
        </div>
        <div class="line" style="margin-right: 10px;"></div>
        <div class="ele">总余额 <span class="black"><?php echo $balance;?>元</span>，可提现余额 <span class="red"><?php echo $allow_cash;?>元</span></div>
        <div class="ele_coinstyle_cash" style="text-align: right;padding: 10px;" onclick="get_all();">全部提现</div>
    </div>
    <div class="btn" onclick="commit();"><span>提现</span></div>
    
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
    var customer_id = "<?php echo $customer_id_en?>";
    $(document).ready(function(){
        if($("#price").val()!="") 
            $("#price").css("background","#fffff");
        else
            $("#price").css("background","#fffff");
    });
    
    $(".sharebg").click(function() {
		$('#ipt').val("");
		$('li').text("");
        $("#pass_w").hide();
        $(".sharebg").hide();
    });
    //jump to 输入密码
    function xiugai_pass(){
        window.location.href="modify_password.php?customer_id="+customer_id;
    }

    var num     = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
    
    
    var customer_id = "<?php echo $customer_id_en;?>";

    function commit(){
        //先验证用户是否有密码
        $(".sharebg").hide();
        $(".sharebg").css({"opacity":"1"});
        var pw = $('input').val();
        var type    = "<?php echo $choose_type?>";
        var to_cash = $("#price").val(); 
        var save_type = 'check';      
        if( !num.test(to_cash)){
            showAlertMsg ("提示：","请输入正确的金额","知道了");
            return false;
        }
        $(".sharebg").show();
        $.ajax({
            url     :   'save_tocash.php',
            dataType:   'json',
            type    :   "post",
            data    :{
                        'to_cash':to_cash,
                        'type':type,
                        'customer_id':customer_id,//加密后的customer_id
                        'save_type':save_type
            },
            success:function(data){

                if(data.msg==10000){//无密码
                    function callbackfunc(){
                        window.location.href="modify_password.php?customer_id=<?php echo $customer_id_en;?>";
                    }
                    showConfirmMsg("提示","您尚未设置支付密码，是否立即前往设置？","确定","取消",callbackfunc);

                }else if(data.msg==30066){//首轮验证通过
                    $("#pass_w").show();
                    $(".am-share").addClass("am-modal-active");    
                    $(".sharebg-active").click(function(){	

                        $(".am-share").removeClass("am-modal-active");
                        $(".sharebg").hide();
                        $('#ipt').val("");
                        $("#pass_w").hide();
                        return false;
                    }) 
 
                }else{
                   var conten = data.msg;
                   showAlertMsg("提示",conten,"知道了");
                   return false;

                }
            }
        });
      
    }

    function commitBtn(){
       
        var pw      = $('input').val();
        var to_cash = $("#price").val();
        var type    = "<?php echo $choose_type?>";
        $("body").append('<div class="sharebg"></div>');
        $.ajax({
            url:'save_tocash.php',
            dataType: 'json',
            type: "post",
            data:{
                    'to_cash':to_cash,
                    'type':type,
                    'customer_id':customer_id,//加密后的customer_id
                    'pw':pw
                },
            success:function(data){
                var content     = data.remark;
                function callbackfunc(){
                    window.location.href="my_moneybag.php?customer_id=<?php echo $customer_id_en;?>";
                }
                $(".sharebg").hide();
                $(".alert").hide();
                $("#pass_w").hide(); 
                if(data.msg==405||data.msg==406||data.msg==407){
                    
                    
                    $(".sharebg").addClass("sharebg-active");
                    showConfirmMsg("提示","申请已提交至商家","确定","取消",callbackfunc); 

                }else if(data.msg==388){
                    
                    function callbackfunc(){
                    window.location.href="my_moneybag.php?customer_id=<?php echo $customer_id_en;?>";
                } 
                   showConfirmMsg("提示",content,"确定","取消",callbackfunc); 
                }else{
                    //alert(1);
                    
                    $('#ipt').val("");
                    $('li').text("");
                    $(".sharebg").show();
                    $(".commtBtn").hide();
                    showAlertMsg ("提示：",content,"知道了");                             
                } 
            }
        });
    }

    function get_all(){
        var all_money = <?php echo $allow_cash?>;
        $("#price").val(all_money);
    }

    function xiugai_pass(){
        window.location.href="modify_password.php?customer_id=<?php echo $customer_id_en;?>";
    }
    $('input').on('input', function (e){
        var numLen = 6;
        var pw = $('input').val();
        var list = $('li');
        for(var i=0; i<numLen; i++){
            if(pw[i]){
                $(list[i]).text('·');
            }else{
                $(list[i]).text('');
            }
        }
    });
    $('#ipt').on('keyup', function (e){
        var num_len = $('input').val().length;
        if(num_len == 6){
            $(".commtBtn").show();
        }else{
            $(".commtBtn").hide();
        }
    });
</script>
<!--引入侧边栏 start-->
<?php  include_once('float.php');?>
<!--引入侧边栏 end-->
</html>