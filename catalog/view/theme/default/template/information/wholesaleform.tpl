<?php echo $header; ?>
<div id="container" class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
     <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
      <h1><?php echo $heading_title; ?></h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <h3><?php echo $text_wholesaleform; ?></h3>
          <br>
          <?php if ($setting['companyname']) { ?>
          <div class="form-group <?php if($required['companyname'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-name"><?php echo $text_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="companyname" value="<?php echo $companyname; ?>" id="input-name" class="form-control" />
                <?php if ($error_companyname) { ?>
                <div class="text-danger"><?php echo $error_companyname; ?></div>
                <?php } ?>
              </div>
          </div>
          <?php } ?>

         <?php if ($setting['address']) { ?>
         <div class="form-group <?php if($required['address'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-address"><?php echo $text_address; ?></label>
         <div class="col-sm-10">
              <input type="text" name="address" value="<?php echo $address; ?>" id="input-address" class="form-control" />
              <?php if ($error_address) { ?>
              <div class="text-danger"><?php echo $error_address; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['city']) { ?>
         <div class="form-group <?php if($required['city'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-city"><?php echo $text_city; ?></label>
         <div class="col-sm-10">
              <input type="text" name="city" value="<?php echo $city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <div class="text-danger"><?php echo $error_city; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['state']) { ?>
         <div class="form-group <?php if($required['state'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-state"><?php echo $text_state; ?></label>
         <div class="col-sm-10">
              <input type="text" name="state" value="<?php echo $state; ?>" id="input-state" class="form-control" />
              <?php if ($error_state) { ?>
              <div class="text-danger"><?php echo $error_state; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['country']) { ?>
         <div class="form-group <?php if($required['country'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-country"><?php echo $text_country; ?></label>
         <div class="col-sm-10">
              <input type="text" name="country" value="<?php echo $country; ?>" id="input-country" class="form-control" />
              <?php if ($error_country) { ?>
              <div class="text-danger"><?php echo $error_country; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['pincode']) { ?>
         <div class="form-group <?php if($required['pincode'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-pincode"><?php echo $text_pincode; ?></label>
         <div class="col-sm-10">
              <input type="text" name="pincode" value="<?php echo $pincode; ?>" id="input-pincode" class="form-control" />
              <?php if ($error_pincode) { ?>
              <div class="text-danger"><?php echo $error_pincode; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['phone']) { ?>
         <div class="form-group <?php if($required['phone'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-phone"><?php echo $text_phone; ?></label>
         <div class="col-sm-10">
              <input type="text" name="phone" value="<?php echo $phone; ?>" id="input-phone" class="form-control" />
              <?php if ($error_phone) { ?>
              <div class="text-danger"><?php echo $error_phone; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['mobile']) { ?>
         <div class="form-group <?php if($required['mobile'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-mobile"><?php echo $text_mobile; ?></label>
         <div class="col-sm-10">
              <input type="text" name="mobile" value="<?php echo $mobile; ?>" id="input-mobile" class="form-control" />
              <?php if ($error_mobile) { ?>
              <div class="text-danger"><?php echo $error_mobile; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['email']) { ?>
         <div class="form-group <?php if($required['email'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-email"><?php echo $text_email; ?></label>
         <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['nameperson']) { ?>
         <div class="form-group <?php if($required['nameperson'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-nameperson"><?php echo $text_nameperson; ?></label>
         <div class="col-sm-10">
              <input type="text" name="nameperson" value="<?php echo $nameperson; ?>" id="input-nameperson" class="form-control" />
              <?php if ($error_nameperson) { ?>
              <div class="text-danger"><?php echo $error_nameperson; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['contacttitle']) { ?>
         <div class="form-group <?php if($required['contacttitle'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-contacttitle"><?php echo $text_contacttitle; ?></label>
         <div class="col-sm-10">
              <select class="form-control" name="contacttitle">
                <?php foreach ($titles as $key => $value) { ?>
                  <?php if($contacttitle == $key) { ?>
                  <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                <?php } else { ?>
                 <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
               <?php } ?>
              </select>

              <?php if ($error_contacttitle) { ?>
              <div class="text-danger"><?php echo $error_contacttitle; ?></div>
              <?php } ?>
           </div>
        </div>
        <?php } ?>

         <?php if ($setting['vattin']) { ?>
         <div class="form-group <?php if($required['vattin'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-vattin"><?php echo $text_tin; ?></label>
         <div class="col-sm-10">
              <input type="text" name="vattin" value="<?php echo $vattin; ?>" id="input-vattin" class="form-control" />
              <?php if ($error_vattin) { ?>
              <div class="text-danger"><?php echo $error_vattin; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['business']) { ?>
         <div class="form-group <?php if($required['business'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" ><?php echo $text_business; ?></label>
         <div class="col-sm-10">
             <select class="form-control" name="business">
                <?php foreach ($businesses as $key => $value) { ?>
                  <?php if($business == $key) { ?>
                  <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                <?php } else { ?>
                 <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
               <?php } ?>
              </select>
              <?php if ($error_business) { ?>
              <div class="text-danger"><?php echo $error_business; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['specify']) { ?>
         <div class="form-group <?php if($required['specify'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-specify"><?php echo $text_specify; ?></label>
         <div class="col-sm-10">
              <input type="text" name="specify" value="<?php echo $specify; ?>" id="input-specify" class="form-control" />
              <?php if ($error_specify) { ?>
              <div class="text-danger"><?php echo $error_specify; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['formation']) { ?>
         <div class="form-group <?php if($required['formation'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-formation"><?php echo $text_formation; ?></label>
         <div class="col-sm-10">
              <input type="text" name="formation" value="<?php echo $formation; ?>" id="input-formation" class="form-control" />
              <?php if ($error_formation) { ?>
              <div class="text-danger"><?php echo $error_formation; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['sales']) { ?>
         <div class="form-group <?php if($required['sales'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-sales"><?php echo $text_sales; ?></label>
         <div class="col-sm-10">
              <input type="text" name="sales" value="<?php echo $sales; ?>" id="input-sales" class="form-control" />
              <?php if ($error_sales) { ?>
              <div class="text-danger"><?php echo $error_sales; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['brands']) { ?>
         <div class="form-group <?php if($required['brands'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-brands"><?php echo $text_brands; ?></label>
         <div class="col-sm-10">
              <input type="text" name="brands" value="<?php echo $brands; ?>" id="input-brands" class="form-control" />
              <?php if ($error_brands) { ?>
              <div class="text-danger"><?php echo $error_brands; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['url']) { ?>
         <div class="form-group <?php if($required['url'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-url"><?php echo $text_websiteurl; ?></label>
         <div class="col-sm-10">
              <input type="text" name="url" value="<?php echo $url; ?>" id="input-url" class="form-control" />
              <?php if ($error_url) { ?>
              <div class="text-danger"><?php echo $error_url; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['products']) { ?>
         <div class="form-group <?php if($required['products'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-products"><?php echo $text_product; ?></label>
         <div class="col-sm-10">
               <input type="text" name="product" value="" placeholder="Enter Product Name"  class="form-control" />
                <div id="enquiry-product" class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($enquiryproducts as $product) { ?>
                  <div id="enquiryproduct<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                    <input type="hidden" name="enquiryproducts[]" value="<?php echo $product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
              <?php if ($error_products) { ?>
              <div class="text-danger"><?php echo $error_products; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

         <?php if ($setting['category']) { ?>
         <div class="form-group <?php if($required['category'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-category"><?php echo $text_category; ?></label>
         <div class="col-sm-10">
               <input type="text" name="category" value="" placeholder="Enter category Name"  class="form-control" />
                <div id="enquiry-category" class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($enquirycategories as $category) { ?>
                  <div id="enquirycategory<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                    <input type="hidden" name="enquirycategories[]" value="<?php echo $category['category_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
              <?php if ($error_category) { ?>
              <div class="text-danger"><?php echo $error_category; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

        <?php if ($setting['enquiry']) { ?>
         <div class="form-group <?php if($required['enquiry'])  { echo "required"; } ?>">
          <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $text_enquiry; ?></label>
         <div class="col-sm-10">
              <textarea  name="enquiry"  id="input-enquiry" class="form-control" /><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
        </div>
        <?php } ?>

          <?php if ($site_key) { ?>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                <?php if ($error_captcha) { ?>
                  <div class="text-danger"><?php echo $error_captcha; ?></div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </fieldset>
        <div class="buttons">
          <div class="pull-right">
            <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=information/wholesaleform/autocomplete&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',     
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'product\']').val('');
    
    $('#enquiry-product' + item['value']).remove();
    
    $('#enquiry-product').append('<div id="enquiry-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="enquiryproducts[]" value="' + item['value'] + '" /></div>');  
  } 
});
$('#enquiry-product').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
</script>

<script type="text/javascript"><!--
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=information/wholesaleform/autocompletec&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',     
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');
    
    $('#enquiry-category' + item['value']).remove();
    
    $('#enquiry-category').append('<div id="enquiry-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="enquirycategories[]" value="' + item['value'] + '" /></div>');  
  } 
});
$('#enquiry-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
</script>