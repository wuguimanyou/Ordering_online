<?php
header("Content-type: text/html; charset=utf-8"); 
require('../../../config.php');
require('../../../customer_id_decrypt.php'); //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
require('../../../back_init.php');
$link = mysql_connect(DB_HOST,DB_USER,DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
require('../../../proxy_info.php');

mysql_query("SET NAMES UTF8");
$head=1;

//分页---start
$pagenum = 1;
$pagesize = 20;
$begintime="";
$endtime ="";
if(!empty($_GET["pagenum"])){
   $pagenum = $configutil->splash_new($_GET["pagenum"]);
}

$start = ($pagenum-1) * $pagesize;
$end = $pagesize;




$name 			= '';	//姓名
$weixin_name 	= '';	//微信名
$account 		= '';	//绑定的号码
$balance 		= 0;	//钱包余额
$getmoney 		= 0;	//申请提现金额
$cash_type 		= -1;	//提现类型 1:支付宝,2:财付通,3:银行账户,4:微信零钱
$status 		= 0;	//提现状态 0：未审核 1：已同意提现 2：审核未通过
$status_str		= '';	//提现状态 0：未审核 1：已同意提现 2：审核未通过
$createtime 	= '';	//申请提现金额
$remark 		= '';	//备注

$query = "SELECT id,getmoney,cash_type,status,createtime,remark,user_id,batchcode,remain_money FROM weixin_cash_being_log WHERE isvalid=true AND customer_id=$customer_id";


// $query = "SELECT l.id,u.name,u.weixin_name,s.account,m.balance,l.getmoney,l.cash_type,l.status,l.createtime,l.remark,l.user_id,l.batchcode,l.remain_money FROM weixin_users u LEFT JOIN moneybag_t m ON u.id=m.user_id LEFT JOIN system_user_t s ON m.user_id=s.user_id LEFT JOIN weixin_cash_being_log l ON s.user_id=l.user_id WHERE u.isvalid=true AND s.isvalid=true AND m.isvalid=true AND l.isvalid=true and l.customer_id=".$customer_id;

$query1 = $query;

//日期条件--开始时间
$begintime = "";
if( !empty($_GET['AccTime_E']) ){  //结算/发放 时间 
	$begintime = $_GET['AccTime_E'];
	$query = $query." and UNIX_TIMESTAMP(createtime)>=".strtotime($begintime);	
}
//日期条件--结束时间
$endtime = "";	
if( !empty($_GET['AccTime_B']) ){   //结算/发放 End
	$endtime = $_GET['AccTime_B'];
	$query = $query." and UNIX_TIMESTAMP(createtime)<=".strtotime($endtime);
}

if( !empty($_GET["promoter"]) ){
	 $user_id = $configutil->splash_new($_GET["promoter"]);
	 $query = $query." and user_id=".$user_id;
}

//账户类型搜索
$search_cashtype = "";
//if( !empty($_REQUEST['search_cashtype'])){  
if( $_REQUEST['search_cashtype'] != "" ){
	$search_cashtype = $_GET['search_cashtype'];
	
	$query = $query." and cash_type=".$search_cashtype;	
}

//状态搜索
$search_status = "";
/* if( !empty($_GET['search_status']) ){   */
if( $_REQUEST['search_status'] != "" ){
	$search_status = $_GET['search_status'];
	$query = $query." and status=".$search_status;	
}
$sql = $query." ORDER BY createtime desc limit ".$start.",".$end;
$query1 = $query;
//echo $query1;
$result = mysql_query($query1) or die('Query failed2: ' . mysql_error());
$rcount_q = mysql_num_rows($result);
$page=ceil($rcount_q/$end); 
 /* 输出数量结束 */
function cut_num($menber,$places){
	$places = $places+1;
	$num = substr(sprintf("%.".$places."f", $menber),0,-1); 
	return $num;	
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>待提现记录</title>
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content.css">
<link rel="stylesheet" type="text/css" href="../../../common/css_V6.0/content<?php echo $theme; ?>.css">
<link type="text/css" rel="stylesheet" rev="stylesheet" href="../../../css/inside.css" media="all">
<script type="text/javascript" src="../../../common/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../../../js/WdatePicker.js"></script>
<script type="text/javascript" src="../../../common/js/layer/layer.js"></script>
<script src="../../Common/js/Data/js/echarts/echarts.js"></script>
<script type="text/javascript" src="../../Common/js/Data/js/ichartjs/ichart.1.2.min.js"></script>
<script type="text/javascript" src="../../../common/js/inside.js"></script>
<style>

table th{color: #FFF;line-height: 30px;text-align: center;font-size: 12px; }
table td{height: 40px;line-height: 20px;font-size: 12px;color: #323232;padding: 0px 1em;text-align: center;border: 1px solid #D8D8D8; }
.display{display:none}
table td img{width: 20px;height: 20px;margin-left: 5px;}
.mlt12{margin-left: 15px;margin-top: 22px;}
.WSY_position_date select {
    width: 130px;
    height: 24px;
    background: #fefefe;
    border: 1px solid #ccc;
    color: #333;
    border-radius: 2px;
    padding-left: 5px;
}
</style>

</head>

<body id="bod" style="min-height: 580px;">
	<!--内容框架-->
	<div class="WSY_content" style="height: 100%;">

		<!--列表内容大框-->
		<div class="WSY_columnbox">
			<!--列表头部切换开始-->
			
				<?php
			include("basic_head.php"); 
			?>
		
			<!--列表头部切换结束-->
<!--门店列表开始-->
  <div  class="WSY_data">
	 <!--列表按钮开始-->
      <div class="WSY_list" id="WSY_list">

	<form action="" >

      	<div style="margin-left:40px;margin-top:0px;">
      		<span style="margin-left:10px;">用户编号：</span>
      		<input type="text" name="promoter" id="promoter_num" value="<?php echo $user_id;?>" style="width:100px;height:25px;border:1px solid #ccc;border-radius:3px;">
      	<!-- 	<span style="margin-left:20px;">会员卡编号：</span>
      		<input type="text" name="card_num" id="card_member_id" style="width:100px;height:25px;border:1px solid #ccc;border-radius:3px;"> -->
			<div class="WSY_position1" style="float:left">
				<ul>		
					<li class="WSY_position_date tate001" >
						<p>时间：<input class="date_picker" type="text" name="AccTime_E" id="begintime" value="<?php echo $begintime; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});"></p>
						<p style="margin-left:0px;">&nbsp;&nbsp;-&nbsp;&nbsp;<input class="date_picker" type="text" name="AccTime_B" id="endtime" value="<?php echo $endtime; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});"></p>
					</li>
					
					
					<li class="WSY_position_date tate001 mlt12" >账户类型：
						<select name="search_cashtype"  id="search_cashtype">
							<option value="">--全部--</option>	
							<option class="WSY_position_date input" value="0" <?php if($search_cashtype=="0"){ ?>selected <?php } ?>>微信零钱</option>
							<option class="WSY_position_date input" value="1" <?php if($search_cashtype=="1"){ ?>selected <?php } ?>>支付宝</option>
							<option class="WSY_position_date input" value="2" <?php if($search_cashtype=="2"){ ?>selected <?php } ?>>财付通</option>
							<option class="WSY_position_date input" value="3" <?php if($search_cashtype=="3"){ ?>selected <?php } ?>>银行账户</option>
						</select>
					</li>		
					
					<li class="WSY_position_date tate001 mlt12" >状态：
						<select name="search_status"  id="search_status">
							<option value="">--全部--</option>	
							<option class="WSY_position_date input" value="0" <?php if($search_status=="0"){ ?>selected <?php } ?>>未审核</option>
							<option class="WSY_position_date input" value="1" <?php if($search_status=="1"){ ?>selected <?php } ?>>已同意提现</option>
							<option class="WSY_position_date input" value="2" <?php if($search_status=="2"){ ?>selected <?php } ?>>驳回</option>
						</select>
					</li>		
				</ul>
			</div>
			
		<input type="submit" id="my_search" >
		<input type="button" style="width:100px" id="my_search" value="数据导出" onclick="exportRecord()">
		</div>

		

	</form>

             <br class="WSY_clearfloat";>
        </div> 
        <!--列表按钮开始-->
		
        <!--表格开始-->
		<div class="WSY_data" id="type1" style="margin-left: 1.5%;">
		
		<table class="WSY_t2"  width="97%"  style="border: 1px solid #D8D8D8;border-collapse: collapse;">
			<thead class="WSY_table_header">
				<tr style="border:none">
					<th width="2%" >ID</th>
					<th width="4%" >编号</th>
					<th width="6%">姓名</th>
					<th width="6%">绑定账号/手机</th>
					<th width="6%">钱包余额</th>
					<th width="6%">申请提现金额</th>
					<th width="5%">账户类型</th>
					<th width="4%">状态</th>			
					<th width="8%">提现申请时间</th>
					<th width="10%">备注信息</th>
					<th width="6%">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$result= mysql_query($sql) or die('Query failed 170: ' . mysql_error());
				while($row=mysql_fetch_object($result)){
					$id 			= $row->id;
					$getmoney 		= $row->getmoney;
					$cash_type 		= $row->cash_type;
					$user_id 		= $row->user_id;
					$batchcode 		= $row->batchcode;
					$remain_money 	= $row->remain_money;

					$query3 = "SELECT account FROM system_user_t WHERE isvalid=true AND user_id=$user_id LIMIT 1";
					$result3= mysql_query($query3) or die('Query failed 186: ' . mysql_error());
					while( $row3 = mysql_fetch_object($result3) ){
						$account = $row3->account;
					}
					$query4 = "SELECT balance FROM moneybag_t WHERE isvalid=true AND user_id=$user_id LIMIT 1";
					$result4= mysql_query($query4) or die('Query failed 186: ' . mysql_error());
					while( $row3 = mysql_fetch_object($result4) ){
						$balance = $row3->balance;
					}


					switch ($cash_type) {
						case '0':
							$cash_type = "微信零钱";
						break;
						case '1':
							$cash_type = "支付宝";
						break;
						case '2':
							$cash_type = "财付通";
						break;
						case '3':
							$cash_type = "银行账户";
						break;
						
					}
					if($account == ''){
						$account = '<span style="color:#c22439;font-weight:blod;font-size:14px;">尚未绑定</span>';
					}

					$status 		= $row->status;
					switch ($status) {
						case '0':
							$status_str = '<span style="color:#c22439;font-weight:blod;font-size:14px;">未审核</span>';
						break;

						case '1':
							$status_str = '<span style="color:#06a7e1;font-weight:blod;font-size:14px;">已同意提现</span>';
						break;

						case '2':
							$status_str = '<span style="color:#68af27;font-weight:blod;font-size:14px;">驳回</span>';
						break;

					}
					$createtime 	= $row->createtime;
					$remark 		= $row->remark;
				$query2 = "SELECT real_name,phone,bind_account,bind_band,bind_bang_address FROM moneybag_account WHERE isvalid=true AND user_id=$user_id";
				switch ($cash_type) {
					case '微信零钱':
						$sql2 = $query2." AND type = 1 LIMIT 1";
						break;
					case '支付宝':
						$sql2 = $query2." AND type = 2 LIMIT 1";
						break;
					case '财付通':
						$sql2 = $query2." AND type = 3 LIMIT 1";
						break;
					case '银行账户':
						$sql2 = $query2." AND type = 4 LIMIT 1";
						break;
				}
				$res2 = mysql_query($sql2) or die('Query failed2: ' . mysql_error());
				while( $row=mysql_fetch_object($res2) ){
					$real_name 			= $row->real_name;
					$phone 				= $row->phone;
					$bind_account 		= $row->bind_account;
					$bind_band 			= $row->bind_band;
					$bind_bang_address 	= $row->bind_bang_address;
				}

			?>
				<tr style="border:1px solid #D8D8D8" class="tr<?php echo $id;?> tr" id="tr<?php echo $batchcode;?>">
					<td><?php echo $id;?></td>
					<td><?php echo $user_id;?></td>
					<td><?php echo $real_name;?></td>
					<td>
						<?php 
							if($cash_type == "微信零钱"){
								echo "手机号：".$phone;
							}elseif($cash_type == "支付宝"){
								echo "手机号：".$phone."</br>";
								echo "支付宝：".$bind_account;
							}elseif($cash_type == "财付通"){
								echo "手机号：".$phone."</br>";
								echo "财付通：".$bind_account;
							}elseif($cash_type == "银行账户"){
								echo "银行账号：".$bind_account."</br>";
								echo "所属银行：".$bind_band."</br>";
								echo "所属支行：".$bind_bang_address;
							}
						?>
					</td>
					<td><a style="color: #06a7e1;" href="user_detail.php?customer_id=<?php echo $customer_id_en;?>&user_id=<?php echo $user_id;?>"><?php echo cut_num($balance,2);?></a></td>
					<td><?php echo cut_num($getmoney,2);?></td>
					<td><?php echo $cash_type;?></td>
					<td class="str<?php echo $id;?>"><?php echo $status_str;?></td>
					<td><?php echo $createtime;?></td>
					<td><?php echo $remark;?></td>
					<td class="images">
					<?php if( $status == 0){ ?>
						<?php if($cash_type == '微信零钱'){?>
							<a onclick="toPay(<?php echo $id;?>,<?php echo $batchcode;?>,<?php echo $getmoney;?>);" title="确定打款">
								<img src="../../../common/images_V6.0/operating_icon/icon23.png" class="<?php echo $id;?>">
							</a>
						<?php }else{?>
							<a onclick="Athor_pay(<?php echo $batchcode;?>,<?php echo $getmoney;?>,<?php echo $id;?>);" title="确定打款">
								<img src="../../../common/images_V6.0/operating_icon/icon23.png" class="<?php echo $id;?>">
							</a>
						<?php }?>
						<a title="驳回申请" onclick="false_type(<?php echo $id;?>);">
							<img src="../../../common/images_V6.0/operating_icon/icon25.png" class="<?php echo $id;?>">
						</a>
					<?php }?>
					<a title="删除申请" onclick="delete_type(<?php echo $id;?>);">
							<img src="../../../common/images_V6.0/operating_icon/icon04.png">
						</a>

					<a title="提现详情" href="./cash_detail.php?customer_id=<?php echo $customer_id_en;?>&b=<?php echo $batchcode;?>">
							<img src="../../../common/images_V6.0/operating_icon/icon44.png">
						</a>
					</td>					
				</tr>
			<?PHP }?> 
			
			</tbody>
			
			</table>
			
			<!--翻页开始-->
			<div class="WSY_page">
				
			</div>
			<!--翻页结束-->
		</div>
		<script src="../../../js/fenye/jquery.page1.js"></script>
		<script type="text/javascript">
			var customer_id_en = '<?php echo $customer_id_en ?>';
			var pagenum = <?php echo $pagenum ?>;
			var count =<?php echo $page ?>;//总页数
			//pageCount：总页数
			//current：当前页
			var user_id = $("#promoter_num").val();
			var AccTime_E = $("#begintime").val();
			var AccTime_B = $("#endtime").val();
			var search_cashtype = $("#search_cashtype").val();
			var search_status = $("#search_status").val();

			
			$(".WSY_page").createPage({
				pageCount:count,
				current:pagenum,
				backFn:function(p){
				 document.location= "cash_being.php?customer_id="+customer_id_en+"&pagenum="+p+"&promoter="+user_id+"&AccTime_E="+AccTime_E+"&AccTime_B="+AccTime_B+"&search_cashtype="+search_cashtype+"&search_status="+search_status;
			   }
			});

		  var page = <?php echo $page ?>;
		  
		  function jumppage(){
			var a=parseInt($("#WSY_jump_page").val());

			if((a<1) || (a==pagenum) || (a>page) || isNaN(a)){
				return false;
			}else{
			document.location= "cash_being.php?customer_id="+customer_id_en+"&pagenum="+a+"&promoter="+user_id+"&AccTime_E="+AccTime_E+"&AccTime_B="+AccTime_B+"&search_cashtype="+search_cashtype+"&search_status="+search_status;
			}
		  }	
		</script>
		<script type="text/javascript">

		// $(function(){
		// 	//$(".tr").css({"background-color":"blue"});
		// 	// var batchcode = "<?php echo $batchcode?>";
		// 	// if(batchcode != ''){
		// 	// 	$("#tr"+batchcode).css({"background-color":"#ccc"});
		// 	// 	return;
		// 	// }
			
		// 	//alert(0);
		// })

		function false_type(id){

			var tis_str = prompt("请输入驳回理由","余额不够");
			if(tis_str){
				var kid = id;
				var type = 'false_type';
				$.ajax({
					url:'save_cash_type.php',
					dataType:'json',
					type:'post',
					data:{
							id:kid,
							type:type,
							tis:tis_str
					},
					success:function(data){
						if(data==400){
								// document.location="cash_being.php?customer_id=<?php echo $customer_id_en;?>";
								//history.go(0);
								$("."+id).hide();
								$(".str"+id).html('<span style="color:#68af27;font-weight:blod;font-size:14px;">驳回</span>');
						}else{
							alert("未知错误");
						}
					}
				});
			}
			
		}
		function delete_type(id){
			var kid = id;
			var type = 'delete_type';
			var is_pay = confirm("您确定删除吗？");
			if( is_pay==false){
				return false;
			}
			$.ajax({
				url:'save_cash_type.php',
				dataType:'json',
				type:'post',
				data:{
						id:kid,
						type:type
				},
				success:function(data){
					if(data==400){
							//document.location="cash_being.php?customer_id=<?php echo $customer_id_en;?>";
							//history.go(0);
							$("."+id).hide();
							$(".tr"+id).remove();

					}else{
						alert("未知错误");
					}
				}
			});
		}
		function Athor_pay(batchcode,money,id){
			var batchcode = batchcode;
			//var user_id = "<?php echo $user_id;?>";
			var customer_id = "<?php echo $customer_id_en;?>";
			var is_pay = confirm("确定打款"+money+"元？");
			if( is_pay==false){
				return false;
			}
			$.ajax({
				url:'save_pay.php',
				dataType:'json',
				type:'post',
				data:{
						batchcode:batchcode,
						//user_id:user_id,
						customer_id:customer_id
				},
				success:function(data){
					var data = eval(data);
					if(data['status']==401){
							// alert(data['msg']);
							// //document.location="cash_being.php?customer_id=<?php echo $customer_id_en;?>";
							// history.go(0);
							$("."+id).hide();
							$(".str"+id).html('<span style="color:#06a7e1;font-weight:blod;font-size:14px;">已同意提现</span>');
					}else{
						alert("未知错误");
					}
				}
			});
		}

		function toPay(id,batchcode,money){
			
			var url = "../../../mshop/WeChatPay/WeChat_ToPay.php?customer_id=<?php echo $customer_id_en;?>&uid="+user_id+"&kid="+id+"&b="+batchcode+"&pagenum="+pagenum+"&AccTime_E="+AccTime_E+"&AccTime_B="+AccTime_B+"&search_cashtype="+search_cashtype+"&search_status="+search_status;
			var is_pay = confirm("确定打款"+money+"元？");
			if(is_pay==false){
				return false;
			}else{
				window.location.href=url;
			}
			
		}
		
		//零钱提现日志导出功能
		function exportRecord(){
			var user_id = $("#promoter_num").val();
			var AccTime_E = $("#begintime").val();
			var AccTime_B = $("#endtime").val();
			var search_cashtype = $("#search_cashtype").val();
			var search_status = $("#search_status").val();

			var url='/weixin/plat/app/index.php/Excel/cash_being_excel/customer_id/<?php echo $customer_id; ?>';
			if( AccTime_E !="" ){
				url=url+'/AccTime_E/'+AccTime_E;
			}
			if( AccTime_B !="" ){
				url=url+'/AccTime_B/'+AccTime_B;
			}
			if(user_id != "" ){
				url=url+'/user_id/'+user_id;
			}
			if(search_cashtype != "" ){
				url=url+'/search_cashtype/'+search_cashtype;
			}
			if(search_status != "" ){
				url=url+'/search_status/'+search_status;
			}
			console.log(url);
			document.location=url;
		}
		</script>
 
	</div>
</div>
<link type="text/css" rel="stylesheet" rev="stylesheet" href="../../../css/fenye/fenye.css" media="all">


<?php 

mysql_close($link);
?>

</body>
</html>
