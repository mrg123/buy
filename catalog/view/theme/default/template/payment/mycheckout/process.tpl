<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
	<title><?php echo $heading_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE-Edge,chrome" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0, user-scalable=no, minimal-ui" />
	<base href="<?php echo $base; ?>" />
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/template/payment/mycheckout/css/styles.css" />
</head>
<body>
<div class="page">
	<div class="header">
		<h1><?php echo $heading_title; ?></h1>
	</div>
	<div class="main">
		<form id="mcForm" method="post" action="<?php echo str_replace('&', '&amp;', $action); ?>" onSubmit="return checkForm();">
			<div class="title">
				<p><?php echo $entry_order_number; ?>: <span><?php echo $order_id; ?></span></p>
				<p class="last"><?php echo $entry_amount; ?>: <span><?php echo $currency . $amount; ?></span></p>
			</div>
			<div class="content">
				<div class="field">
					<label><em>*</em><?php echo $entry_card_number; ?></label>
					<div class="box">
						<input type="text" name="card_number" id="txtCardNumber" maxLength="16" onkeyup="checkCardNumber();" oninput="checkCardNumber();" />
					</div>
				</div>
				<div class="field">
					<label><em>*</em> <?php echo $entry_expiry_date; ?></label>
					<div class="box">
						<select name="card_month" id="selCardMonth">
							<option value=""><?php echo $entry_cc_expire_month; ?></option>
							<?php for ($i = 1; $i <= 12; $i++) { ?>
								<option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
							<?php } ?>
						</select>
						<select class="f-right" name="card_year" id="selCardYear">
							<option value=""><?php echo $entry_cc_expire_year; ?></option>
							<?php $year = date('Y'); ?>
							<?php for ($i = 0; $i < 21; $i++) { ?>
								<option value="<?php echo substr($year + $i, -2, 2); ?>"><?php echo $year + $i; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="field">
					<label><em>*</em><?php echo $entry_cvv; ?><span onclick="whatsCvv()"><?php echo $whats_cvv; ?><img style="display:none;position:absolute;left:-180px;top:-169px;" id="whatCvv" src="catalog/view/theme/default/template/payment/mycheckout/images/cvv.png" /></span></label>
					<div class="box">
						<input type="password" name="card_cvv" id="txtCardCvv" maxLength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" oninput="this.value=this.value.replace(/\D/g,'')" />
					</div>
				</div>
				<div class="field a-center last">
					<button type="submit" id="btnSubmit"><?php echo $text_submit; ?></button>
				</div>
			</div>
			<script type="text/javascript">
				function checkCardNumber()
				{
					var txtCardNumber = document.getElementById('txtCardNumber');
					txtCardNumber.value = txtCardNumber.value.replace(/\D/g, '');
					if ((/^[4]{1}/).test(txtCardNumber.value)) {
						txtCardNumber.style.background = 'url("catalog/view/theme/default/template/payment/mycheckout/images/v.png") no-repeat 98% center';
					} else if ((/^[5]{1}[1-5]{1}/).test(txtCardNumber.value)) {
						txtCardNumber.style.background = 'url("catalog/view/theme/default/template/payment/mycheckout/images/m.png") no-repeat 98% center';
					} else if ((/^[3]{1}[5]{1}/).test(txtCardNumber.value)) {
						txtCardNumber.style.background = 'url("catalog/view/theme/default/template/payment/mycheckout/images/j.png") no-repeat 98% center';
					} else {
						txtCardNumber.style.background = 'url("catalog/view/theme/default/template/payment/mycheckout/images/vmj.png") no-repeat 98% center';
					}
				}

				function whatsCvv()
				{
					var whatCvv = document.getElementById('whatCvv');
					if (whatCvv.style.display == 'none'){
						whatCvv.style.display = 'block';
					} else {
						whatCvv.style.display = 'none';
					}
				}

				function checkForm()
				{
					var error = false;
					var txtCardNumber = document.getElementById('txtCardNumber');
					txtCardNumber.value = txtCardNumber.value.replace(/\D/g, '');
					if (txtCardNumber.value.length != 16
						|| !((/^[4]{1}/).test(txtCardNumber.value) || (/^[5]{1}[1-5]{1}/).test(txtCardNumber.value) || (/^[3]{1}[5]{1}/).test(txtCardNumber.value))) {
						error=true;
						txtCardNumber.style.borderColor = '#FF0000';
						txtCardNumber.focus();
						return false;
					} else {
						txtCardNumber.style.borderColor = '#CCCCCC';
					}

					var selCardMonth = document.getElementById('selCardMonth');
					if (selCardMonth.value.length != 2) {
						error = true;
						selCardMonth.style.borderColor = '#FF0000';
						selCardMonth.focus();
						return false;
					} else {
						selCardMonth.style.borderColor = '#CCCCCC';
					}

					var selCardYear = document.getElementById('selCardYear');
					if (selCardYear.value.length != 2) {
						error = true;
						selCardYear.style.borderColor = '#FF0000';
						selCardYear.focus();
						return false;
					} else {
						selCardYear.style.borderColor = '#CCCCCC';
					}

					var txtCardCvv = document.getElementById('txtCardCvv');
					txtCardCvv.value = txtCardCvv.value.replace(/\D/g, '');
					if (txtCardCvv.value.length != 3) {
						error = true;
						txtCardCvv.style.borderColor = '#FF0000';
						txtCardCvv.focus();
						return false;
					} else {
						txtCardCvv.style.borderColor = '#CCCCCC';
					}

					if (error) {
						return false;
					} else {
						var btnSubmit = document.getElementById('btnSubmit');
						if (btnSubmit.innerHTML == "<?php echo $text_submit; ?>")
						{
							btnSubmit.innerHTML = "<?php echo $text_processing; ?>";
							return true;
						}
						alert("<?php echo $text_processing; ?>");
						return false;
					}
				}
			</script>
			<script type="text/javascript" src="http://risk.hdkhdkrisk.com/csid.js"></script>
		</form>
	</div>
	<div class="footer"></div>
</div>
</body>
</html>
