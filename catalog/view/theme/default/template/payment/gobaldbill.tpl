<b style="margin-bottom: 3px; display: block;"><?php echo $text_credit_card ?></b>
<div id="GobaldbillDirect" style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
    <table width="100%">
        <tr>
            <td align='right' style="width:25%;font: 12px/20px Verdana;color: #666666;"><?php echo $entry_cc_type ?></td>
            <td ><img src="<?php echo HTTP_SERVER ?>catalog/view/theme/default/template/image/gobaldbill.gif"/></td>
        </tr>
        <tr>
            <td align='right' style="font: 12px/20px Verdana;color: #666666;"><?php echo $entry_cc_number ?></td>
            <td><input type="text" name="cc_number" id="gobaldbill_number" maxlength="16" autocomplete="off" style="border: 1px solid #BBBBBB;float: left;margin: 5px 10px 5px 0;height:20px;font: 12px/20px Verdana;color: #666666;"/></td>
        </tr>
        <tr>
            <td align='right' style="font: 12px/20px Verdana;color: #666666;"><?php echo $entry_cc_expire_date ?></td>
            <td><select name="cc_expire_date_month" id="gobaldbill_expire_month" style="border: 1px solid #BBBBBB;float: left;margin: 5px 10px 5px 0;font: 12px/20px Verdana;color: #666666;">
                   <?php foreach ($months as $month) { ?>
				  <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
				  <?php } ?>
                </select>
                <select name="cc_expire_date_year" id="gobaldbill_expire_year" style="border: 1px solid #BBBBBB;float: left;margin: 5px 10px 5px 0;font: 12px/20px Verdana;color: #666666;">
                    <?php foreach ($year_expire as $year) { ?>
					  <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
					  <?php } ?>
                </select>
            </td>
        </tr>
        <tr float="center">
            <td style="font: 12px/20px Verdana;color: #666666;" align='right'><?php echo $entry_cc_cvv2 ?></td>
            <td><input type="password" name="cc_cvv2" id="gobaldbill_cvv2" maxlength="3" autocomplete="off" onpaste="return false" oncopy="return false"  size="4" style="border: 1px solid #BBBBBB;float: left;margin: 5px 10px 5px 0;height:20px;font: 12px/20px Verdana;color: #666666;"/> <img src="<?php echo HTTP_SERVER ?>catalog/view/theme/default/template/image/cvv.gif"  alt="cvv" style="position: relative;float: left;margin-top: 4px;margin-left: 5px;line-height: 15px;" /></td>
        </tr>
        <tr>
            <td style="padding-left: 100px"></td>
            <td style="text-align: right"><input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" /></td>
        </tr>
		
    </table>
</div>

<script type="text/javascript"><!--

function checkCardNum(cardNumber) {
	if (cardNumber == null || cardNumber == "" || cardNumber.length > 16 || cardNumber.length < 13) {
		return false;
	} else if (cardNumber.charAt(0) != 3 && cardNumber.charAt(0) != 4 && cardNumber.charAt(0) != 5) {
		return false;
	} else {
		return gobaldbillCheckCard(cardNumber);
	}
}
function gobaldbillCheckCard(cardNumber) {
	var sum = 0;
	var digit = 0;
	var addend = 0;
	var timesTwo = false;
	for (var i = cardNumber.length - 1; i >= 0; i--) {
		digit = parseInt(cardNumber.charAt(i));
		if (timesTwo) {
			addend = digit * 2;
			if (addend > 9) {
				addend -= 9;
			}
		} else {
			addend = digit;
		}
		sum += addend;
		timesTwo = !timesTwo;
	}
	return sum % 10 == 0;
}
function checkExpdate(expdate) {
	if (expdate == null || expdate == "" || expdate == "0" || expdate.length < 1) {
		return false;
	} else {
		return true;
	}
}
function checkCvv(cvv) {
	if (cvv == null || cvv == "" || cvv.length < 3 || cvv.length > 4 || isNaN(cvv)) {
		return false;
	} else {
		return true;
	}
}
			
$('#button-confirm').bind('click', function() {
	var cc_number = document.getElementById('gobaldbill_number').value;
	var cc_expires_month = document.getElementById('gobaldbill_expire_month').value;
	var cc_expires_year = document.getElementById('gobaldbill_expire_year').value;
	var cc_checkcode = document.getElementById('gobaldbill_cvv2').value;
	if (!checkCardNum(cc_number)) {
		alert('Card Number is wrong');
	} else if (!checkExpdate(cc_expires_month) || !checkExpdate(cc_expires_year)) {
		alert('Card Expiry Date is wrong');
	} else if (!checkCvv(cc_checkcode)) {
		alert('CVV2 is wrong');
	} else {
		$.ajax({
			url: 'index.php?route=payment/gobaldbill/send',
			type: 'post',
			data: $('#GobaldbillDirect :input'),
			dataType: 'json',		
			beforeSend: function() {
				$('#button-confirm').attr('disabled', true);
				$('#GobaldbillDirect').before('<div class="attention"><img src="<?php echo HTTP_SERVER; ?>catalog/view/theme/default/template/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button-confirm').attr('disabled', false);
				$('.attention').remove();
			},				
			success: function(json) {			
				if (json['url']) {
					location = json['url'];
				}
			}
		});
	}
});
//--></script>