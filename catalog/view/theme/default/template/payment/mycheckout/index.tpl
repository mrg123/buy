<?php if (isset($continue)) { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="MCButton" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript">
$('#MCButton').bind('click', function() {
	location = '<?php echo $continue; ?>';
});
</script>
<?php } else { ?>
<form id="MCForm" method="post" action="<?php echo str_replace('&', '&amp;', $action); ?>">
<fieldset>
    <legend><img src="catalog/view/theme/default/template/payment/mycheckout/images/VMJ.png" alt="Credit Card Payment"/></legend>
	<div class="form-group required clearfix">
		<label class="col-sm-2 control-label" for="txtCardNumber"><?php echo $entry_cc_number; ?></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="card_number" id="txtCardNumber" maxlength="16" onkeyup="checkCardNumber();" oninput="checkCardNumber();" />
		</div>
	</div>
	<div class="form-group required clearfix">
		<label class="col-sm-2 control-label"><?php echo $entry_cc_expire_date; ?></label>
        <div class="col-sm-3">
			<select class="form-control" name="card_month" id="selCardMonth">
				<option value=""><?php echo $entry_cc_expire_month; ?></option>
				<?php for ($i = 1; $i <= 12; $i++) { ?>
				<option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<select class="form-control" name="card_year" id="selCardYear">
				<option value=""><?php echo $entry_cc_expire_year; ?></option>
				<?php $year = date('Y'); ?>
				<?php for ($i = 0; $i < 25; $i++) { ?>
				<option value="<?php echo substr($year + $i, -2, 2); ?>"><?php echo $year + $i; ?></option>
				<?php } ?>
				</select>
	    </div>
	</div>
	<div class="form-group required clearfix">
		<label class="col-sm-2 control-label" for="txtCardCvv"><?php echo $entry_cc_cvv2;?></label>
		<div class="col-sm-3">
			<input class="form-control" type="password" name="card_cvv" id="txtCardCvv" maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" oninput="this.value=this.value.replace(/\D/g,'')" />
		</div>
        <div class="col-sm-2">
            <span onclick="whatsCvv()" style="vertical-align: middle;color:#FF0000;"><?php echo $whats_cvv; ?><img style="display:none;position:absolute;left:-180px;top:-169px;" id="whatCvv" src="catalog/view/theme/default/template/payment/mycheckout/images/cvv.png" /></span>
        </div>
	</div>
</fieldset>
</form>
<div class="buttons">
	<div class="pull-right">
		<input type="button" value="<?php echo $button_confirm; ?>" id="btnSubmit" class="btn btn-primary" />
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
        var txtCardNumber = document.getElementById('txtCardNumber');
        txtCardNumber.value = txtCardNumber.value.replace(/\D/g, '');
        if (txtCardNumber.value.length != 16
            || !((/^[4]{1}/).test(txtCardNumber.value) || (/^[5]{1}[1-5]{1}/).test(txtCardNumber.value) || (/^[3]{1}[5]{1}/).test(txtCardNumber.value))) {
            txtCardNumber.style.borderColor = '#FF0000';
            txtCardNumber.focus();
            return false;
        } else {
            txtCardNumber.style.borderColor = '#CCCCCC';
        }

        var selCardMonth = document.getElementById('selCardMonth');
        if (selCardMonth.value.length != 2) {
            selCardMonth.style.borderColor = '#FF0000';
            selCardMonth.focus();
            return false;
        } else {
            selCardMonth.style.borderColor = '#CCCCCC';
        }

        var selCardYear = document.getElementById('selCardYear');
        if (selCardYear.value.length != 2) {
            selCardYear.style.borderColor = '#FF0000';
            selCardYear.focus();
            return false;
        } else {
            selCardYear.style.borderColor = '#CCCCCC';
        }

        var txtCardCvv = document.getElementById('txtCardCvv');
        txtCardCvv.value = txtCardCvv.value.replace(/\D/g, '');
        if (txtCardCvv.value.length != 3) {
            txtCardCvv.style.borderColor = '#FF0000';
            txtCardCvv.focus();
            return false;
        } else {
            txtCardCvv.style.borderColor = '#CCCCCC';
            return true;
        }
    }

    $('#btnSubmit').bind('click', function() {
        if (checkForm()) {
            var btnSubmit = document.getElementById('btnSubmit');
            if (btnSubmit.value == "<?php echo $button_confirm; ?>") {
                btnSubmit.value = "<?php echo $text_processing; ?>";
                $("#MCForm").submit();
            } else {
                alert("<?php echo $text_processing; ?>");
            }
        }
    });
</script>
<?php } ?>