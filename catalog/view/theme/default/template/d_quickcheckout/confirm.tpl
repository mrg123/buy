<div id="confirm_view" class="qc-step" data-col="<?php echo $col; ?>" data-row="<?php echo $row; ?>"></div>
<script type="text/html" id="confirm_template">
<div id="confirm_wrap">
	<div class="panel panel-default">
		<div class="panel-body">
		<p><b><font color="#FF0000">***************************Read the following content before order submission***************************</font></b></p><p></p><p>1, Please provide <b>your e-mail of PayPal account</b> in below field. And then we will send you an e-mail of invoice payment request after order submission.</p><p>2, Pay the invoice with your PayPal.</p><p>3, Your order will be processed once payment confirmed.</p><p>4, You will receive QC photo via Whatsapp and your order status will be updated accordingly.</p><p>5, Wait to receive your products :)</p><b>Note: Your order will be ignored if below field left blank.</b> 
			<form id="confirm_form" class="form-horizontal">
			</form>
			
			<button id="qc_confirm_order" class="btn btn-primary btn-lg btn-block " <%= model.show_confirm ? '' : 'disabled="disabled"' %>><% if(Number(model.payment_popup)) { %><?php echo $button_continue; ?><% }else{ %><?php echo $button_confirm; ?><% } %></span></button>

		</div>
	</div>
</div>
</script>
<script>

$(function() {
	qc.confirm = $.extend(true, {}, new qc.Confirm(<?php echo $json; ?>));
	qc.confirmView = $.extend(true, {}, new qc.ConfirmView({
		el:$("#confirm_view"), 
		model: qc.confirm, 
		template: _.template($("#confirm_template").html())
	}));
});

</script>