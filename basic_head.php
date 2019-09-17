<div class="WSY_column_header">
	<div class="WSY_columnnav">
		<a href="set_up.php?customer_id=<?php echo $customer_id_en; ?>">基本设置</a>
		<a href="charitable_detail.php?customer_id=<?php echo $customer_id_en; ?>">公益明细</a>					
		<a href="rank.php?customer_id=<?php echo $customer_id_en; ?>">慈善排名</a>					
		<a href="supply_rank.php?customer_id=<?php echo $customer_id_en; ?>">供应商排名</a>					
		<a href="charity.php?customer_id=<?php echo $customer_id_en; ?>">慈善机构</a>					
	</div>
</div>
<script>
var head = <?php echo $head; ?>;
$(".WSY_columnnav").find("a").eq(head).addClass('white1');
</script>