<?php 
header("Content-type: text/html; charset=utf-8"); 
require('../config.php');
require('../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
mysql_query("SET NAMES UTF8");
/*$customer_id = $configutil->splash_new($_GET["customer_id"]);
$customer_id = passport_decrypt($customer_id); */ //引入文件中已获取
$name =$_SESSION['username'];
if(!empty($_SESSION['curr_login'])){
$name =$_SESSION['curr_login'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>数据统计</title>
<link href="css/statistics.css" rel="stylesheet" type="text/css">
<!-- <script src="../js/Chart.js"></script> -->
<script type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
<script src="js/echarts/echarts.js"></script>
<!-- <script type="text/javascript" src="../common/js/highcharts.js"></script> -->
<script type="text/javascript" src="js/statistics_chart.js"></script>
<script type="text/javascript" src="js/statistics.js"></script>
</head>

<body>
<div class="WSY_columnbox">
	<div class="WSY_column_header">
    	<div class="WSY_columnnav">
          	<a class="white1">数据统计</a>
        </div>
    </div>
    <div class="statisticsbox">
        <div class="statistics_div01">
            <dl class="statistics_ul01">
                <dt>
                    <a>当前账号：<span><?php echo $name;?></span></a>
                </dt>
                <dd class="data_dd01">
                    <a>分销商数：<b class="qrsell_num"><img src="images/qushiicon/loging.gif"></b></a>
                    <a>待审核分销商数：<b class="stay_qrsell_num"><img src="images/qushiicon/loging.gif"></b></a>
                </dd>
                <dd class="data_dd02">
                    <a>已支出佣金：<b class="post_expense"><img src="images/qushiicon/loging.gif"></b>元</a>
                    <a>待提现佣金笔数：<b class="stay_expense_num"><img src="images/qushiicon/loging.gif"></b>笔</a>
                </dd>
            </dl>
            <dl class="statistics_ul02">
                <dt>
                    <a>库存提醒：<span>有<b class="stock_num"><img src="images/qushiicon/loging.gif"></b>件商品已达到警戒库存</span></a>
                </dt>
                <dd class="data_dd01">
                    <a>出售中的商品数：<b class="sell_pro_num"><img src="images/qushiicon/loging.gif"></b></a>
                    <a>仓库中商品数：<b class="isout_pro_num"><img src="images/qushiicon/loging.gif"></b></a>
                    <a>已售磬的商品数：<b class="sell_out_pro_num"><img src="images/qushiicon/loging.gif"></b></a>
                </dd>
                <dd class="data_dd02">
                    <a>待付款订单数：<b class="stay_payment_order_num"><img src="images/qushiicon/loging.gif"></b>笔</a>
                    <a>待发货订单数：<b class="stay_send_order_num"><img src="images/qushiicon/loging.gif"></b>笔</a>
                    <a>待退/换货订单数：<b class="return_order_num"><img src="images/qushiicon/loging.gif"></b>笔</a>
                    <a>已完成订单数：<b class="complete_order_num"><img src="images/qushiicon/loging.gif"></b>笔</a>
                </dd>
            </dl>
        </div>
        <div class="statistics_div02">
            <dl class="statistics_ul03">
                <dt><a>数据统计</a></dt>
                <div class="data_div">
                <dd class="data_dd03">
                    <ul>
                        <li>今天总计订单（笔）</li>
                        <li class="tj total_order_num"><img src="images/qushiicon/loging.gif"></li>
                        <li>环比增幅<b class="rise total_order_amplitude"><img src="images/qushiicon/loging.gif"></b><!--<i class="s_icon"></i>--></li>
                    </ul>
                    <ul>
                        <li>今天总消费金额（元）</li>
                        <li class="tj total_consumption"><img src="images/qushiicon/loging.gif"></li>
                        <li>环比增幅<b class="rise total_consumption_amplitude"><img src="images/qushiicon/loging.gif"></b><!--<i class="s_icon"></i>--></li>
                    </ul>
	            </dd>
                <dd>
                    <ul>
                        <li>本月订单（笔）</li>
                        <li class="tj this_month_order_num"><img src="images/qushiicon/loging.gif"></li>
                        <li>环比增幅<b class="rise this_month_order_amplitude"><img src="images/qushiicon/loging.gif"></b><!--<i class="s_icon"></i>--></li>
                    </ul>
                    <ul>
                        <li>本月消费金额（笔）</li>
                        <li class="tj this_month_consumption"><img src="images/qushiicon/loging.gif"></li>
                        <li>环比增幅<b class="rise  this_month_consumption_amplitude"><img src="images/qushiicon/loging.gif"></b><!--<i class="j_icon"></i>--></li>
                    </ul>
                </dd>
                </div>
            </dl>
        </div>
        <div class="statistics_div03">
            <dl class="statistics_ul04">
                <dt><a>订单笔数趋势图</a></dt>
                <div class="bishu">
                    <dd class="jr_tongji">
                        <a>今日订单数（笔）</a>
                        <a class="tj total_order_num"><img src="images/qushiicon/loging.gif"></a>
                    </dd>
                    <dd class="zr_tongji">
                        <a>昨日订单数（笔）</a>
                        <a class="tj yes_total_order_num"><img src="images/qushiicon/loging.gif"></a>
                    </dd>
                    <div class="chart" style="margin: 8px; float:left">
						<div id="container_charts" style="height:205px;"></div>
					</div>
                </div>
            </dl>
            <dl class="statistics_ul05">
                <dt><a>付款订单笔数趋势图</a></dt>
                <div class="bishu">
                    <dd class="jr_tongji">
                        <a>今日付款订单数（笔）</a>
                        <a class="tj pay_total_order_num"><img src="images/qushiicon/loging.gif"></a>
                    </dd>
                    <dd class="zr_tongji">
                        <a>昨日付款订单数（笔）</a>
                        <a class="tj yes_pay_total_order_num"><img src="images/qushiicon/loging.gif"></a>
                    </dd>
                    <div class="chart" style="margin: 8px; float:left">
						<div id="pay_charts" style="height:205px;"></div>
                    </div>
                </div>
            </dl>  
            <dl class="statistics_ul06">
                <dt><a>订单金额统计</a></dt>
                <div class="bishu1">
                    <div class="chart" style="margin: 8px; float:left">
						<div id="total_consumption_charts" style="height:205px;"></div>
                    </div>
                </div>
            </dl>
            <dl class="statistics_ul07">
                <dt><a>订单统计</a></dt>
                <div class="bishu1 bishu_tj">
                    <div class="chart" style="margin: 8px; float:left">
						<div id="consumption_cake_charts" style="height:205px;"></div>
                    </div>
                </div>
            </dl>
        </div>
    </div>
</div>
<input type=hidden id="customer_id" value="<?php echo $customer_id_en?>">
</body>
</html>