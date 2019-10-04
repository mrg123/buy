<form action="<?php echo str_replace ( '&', '&amp;', $action );?>" method="post" id="95checkout">
	<input type="hidden" name="TxnType" value="01"/> 
        <input type="hidden" name="CMSName" value="opencart"/> 
	<input type="hidden" name="AcctNo" value="<?php echo $AcctNo;?>" /> 
	<input type="hidden" name="OrderID" value="<?php echo $OrderID;?>" />
        <input type="hidden" name="Amount" value="<?php echo $Amount;?>" /> 
        <input type="hidden" name="CurrCode" value="<?php echo $CurrCode;?>" /> 
        <input type="hidden" name="Telephone" value="<?php echo $Telephone;?>" /> 
        <input name="IPAddress" type="hidden" value="<?php echo $IPAddress;?>" />
        <input name="HashValue" type="hidden" value="<?php echo $MD5Info;?>" />
	<input name="Email" type="hidden"  value="<?php echo $Email; ?>" />
        <input name="BCity" type="hidden"  value="<?php echo $BCity; ?>" />
	<input name="PostCode" type="hidden"  value="<?php echo $PostCode; ?>" />
	<input name="BAddress" type="hidden"  value="<?php echo $BAddress; ?>" />
        <input name="CName" type="hidden"  value="<?php echo $CName; ?>" />
        <input name="Bcountry" type="hidden"  value="<?php echo $Bcountry; ?>" />
        <input name="Bstate" type="hidden"  value="<?php echo $Bstate; ?>" />
        
        <input name="ShipName" type="hidden"  value="<?php echo $ShipName; ?>" />
        <input name="ShipAddress" type="hidden"  value="<?php echo $ShipAddress; ?>" />
	<input name="ShipCity" type="hidden"  value="<?php echo $ShipCity; ?>" />
	<input name="Shipstate" type="hidden"  value="<?php echo $Shipstate; ?>" />
        <input name="ShipPostCode" type="hidden"  value="<?php echo $ShipPostCode; ?>" />
        <input name="ShipCountry" type="hidden"  value="<?php echo $ShipCountry; ?>" />
        <input name="Shipphone" type="hidden"  value="<?php echo $Shipphone; ?>" />
        
        <input name="Url" type="hidden"  value="<?php echo $Url; ?>" />
        <input name="PName" type="hidden"  value="<?php echo $PName;?>" />


<div class="buttons" align="right">
    <div class="pull-right"><input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" /></div>

</div>
	</form>