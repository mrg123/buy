<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
	<title><?php echo $heading_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE-Edge,chrome">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0, user-scalable=no, minimal-ui">
	<base href="<?php echo $base; ?>" />
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/template/payment/mycheckout/css/styles.css" />
</head>
<body>
<div class="page">
	<div class="header">
		<h1><?php echo $heading_title; ?></h1>
	</div>
	<div class="main">
		<div class="title">
			<p><?php echo $entry_order_number; ?>: <span><?php echo $order_id; ?></span></p>
			<p><?php echo $entry_status; ?>: <span><?php if ($status == 1) { ?><font color="green"><?php echo $text_successful; ?></font><?php } else { ?><font color="red"><?php echo $text_failure; ?></font><?php } ?></span></p>
			<p class="last"><?php echo $entry_amount; ?>: <span><?php echo $currency; ?><?php echo $amount; ?></span></p>
		</div>
	</div>
	<div class="footer"></div>
</div>
<script type="text/javascript">
(function(){
var wait = 5;
var interval = setInterval(function(){
	var time = --wait;
	if(time <= 0) {
		top.location.href = '<?php echo $return_url; ?>';
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
