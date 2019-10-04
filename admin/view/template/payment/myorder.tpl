<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-myorder" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">

<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>
<div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
  <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-myorder">
        
      <table class="form">
        <tr>
	        <td > <?php echo $entry_merchantid; ?></td>
        	<td> <input size="10" type="text" name="myorder_merchant" value="<?php echo empty($myorder_merchant)?'1002':$myorder_merchant; ?>" />
            <?php if ($error_merchant) { ?>
            <span class="error"><?php echo $error_merchant; ?></span>
            <?php } ?>
            </td>
	</tr>
	<tr>
           <td> <?php echo $entry_md5key; ?></td>
	   <td>
            <input size="20" type="text" name="myorder_md5key" value="<?php echo empty($myorder_md5key)?'12345678':$myorder_md5key; ?>" />
            <?php if ($error_md5key) { ?>
            <span class="error"><?php echo $error_md5key; ?></span>
            <?php } ?>
            </td>
	  </tr>
	  <tr>
	    
            <td><?php echo $entry_status; ?></td>
           <td> <select name="myorder_status">
              <?php if ($myorder_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>          
            </td>
	    </tr>
	    <tr>
	    <td>
          <?php echo $entry_geo_zone; ?></td>
	  <td>
          <select name="myorder_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $myorder_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            </td>
	    </tr>
	    <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="myorder_sort_order" value="<?php echo $myorder_sort_order; ?>" size="1" />
        	</td>
        </tr>  
        
        <tr>
          <td><?php echo $entry_currency; ?></td>
          <td><select name="myorder_currency">
              <?php if ($myorder_currency == '1') { ?>
              <option value="1" selected="selected"><?php echo $text_usd; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_usd; ?></option>
              <?php } ?>
              <?php if ($myorder_currency == '2') { ?>
              <option value="2" selected="selected"><?php echo $text_eur; ?></option>
              <?php } else { ?>
              <option value="2"><?php echo $text_eur; ?></option>
              <?php } ?>
              <?php if ($myorder_currency == '3') { ?>
              <option value="3" selected="selected"><?php echo $text_rmb; ?></option>
              <?php } else { ?>
              <option value="3"><?php echo $text_rmb; ?></option>
              <?php } ?>
			  
			  <?php if ($myorder_currency == '4') { ?>
              <option value="4" selected="selected"><?php echo $text_gbp; ?></option>
              <?php } else { ?>
              <option value="4"><?php echo $text_gbp; ?></option>
              <?php } ?>
              
               <?php if ($myorder_currency == '5') { ?>
              <option value="5" selected="selected"><?php echo $text_hkd; ?></option>
              <?php } else { ?>
              <option value="5"><?php echo $text_hkd; ?></option>
              <?php } ?>
              <?php if ($myorder_currency == '6') { ?>
              <option value="6" selected="selected"><?php echo $text_jpy; ?></option>
              <?php } else { ?>
              <option value="6"><?php echo $text_jpy; ?></option>
              <?php } ?>
               <?php if ($myorder_currency == '9') { ?>
              <option value="9" selected="selected"><?php echo $text_nok; ?></option>
              <?php } else { ?>
              <option value="9"><?php echo $text_nok; ?></option>
              <?php } ?>
			  
			  <?php if ($myorder_currency == '10') { ?>
              <option value="10" selected="selected"><?php echo $text_dkk; ?></option>
              <?php } else { ?>
              <option value="10"><?php echo $text_dkk; ?></option>
              <?php } ?>
			   <?php if ($myorder_currency == '11') { ?>
              <option value="11" selected="selected"><?php echo $text_nzd; ?></option>
              <?php } else { ?>
              <option value="11"><?php echo $text_nzd; ?></option>
              <?php } ?>
              
              
            </select></td>
        </tr>

	 <tr>
         <td><?php echo $entry_transactionurl; ?></td>
         <td><input type="text" name="myorder_transactionurl" value="<?php echo empty($myorder_transactionurl)?'./payonline.php' : $myorder_transactionurl; ?>" style="width:600px;"></td>
       </tr>

        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="myorder_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $myorder_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        
         <tr>
          <td><?php echo $entry_pay_success_order_status; ?></td>
          <td><select name="myorder_pay_success_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $myorder_pay_success_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
         <tr>
          <td><?php echo $entry_pay_fail_order_status; ?></td>
          <td><select name="myorder_pay_fail_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $myorder_pay_fail_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
       
       
      </table>
    </form>
  </div>
</div>
</div>
<?php echo $footer; ?>