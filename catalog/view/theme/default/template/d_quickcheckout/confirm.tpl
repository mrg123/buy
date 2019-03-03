<div id="confirm_view" class="qc-step" data-col="<?php echo $col; ?>" data-row="<?php echo $row; ?>"></div>
<script type="text/html" id="confirm_template">
<div id="confirm_wrap">
	<div class="panel panel-default">
		<div class="panel-body">
		<p>$$$ Attention: Read the following content before hitting " Submit Order " $$$</p><p></p><p>1, Please provide your email address of PayPal payment in below field.</p><p>2, Leave your comment in below field if you do have something to tell us.</p><p>3, Click "Submit Order" to confirm what you have chosen.</p><p>4, Copy your order ID to notepad shown on the page for later use (we will send you order confirmation email with this order ID as well).</p><p>5, We will send you an invoice via PayPal to the email you just provided.</p><p>6, Pay the invoice.</p><p>7, Leave us a message from "Contact Us" locates at the website footer with "order ID" and " Last 6 digits of PayPal transaction ID"<p>8, We are now starting to process your order.....</p><p>9, Delivery Information will be updated from time to time in your account until package received.</p>
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