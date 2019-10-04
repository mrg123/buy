<input type="hidden" name="socl_id" value="<?php echo $socl_id; ?>" />
<input type="hidden" name="network" value="<?php echo $network; ?>" />
<input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
<input type="hidden" name="password" value="" />
<input type="hidden" name="address_2" value="" />

<div class="row"><div id="content" class="col-sm-12"> 
    <div class="well">  
    <h2><?php echo $heading_title; ?></h2>     
    <p id="text_fill_all"><strong><?php echo $text_fill_all; ?></strong></p>
    
    <div id="account">
    <?php if($display_email == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
            <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
        </div>
        <input type="hidden" name="validate_email" value="<?php echo $display_email; ?>" />
    <?php } else { ?>
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
    <?php } ?>
    
    <?php if(isset($display_firstname) && $display_firstname == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
            <input type="text" name="firstname" value="" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
        </div>
        <input type="hidden" name="validate_firstname" value="<?php echo $display_firstname; ?>" />
    <?php } else { ?>
        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
    <?php } ?>
    
    <?php if(isset($display_lastname) && $display_lastname == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <input type="text" name="lastname" value="" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
        </div>
        <input type="hidden" name="validate_lastname" value="<?php echo $display_lastname; ?>" />
    <?php } else { ?>
        <input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
    <?php } ?>
    
    <?php if(isset($display_telephone) && $display_telephone == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <input type="text" name="telephone" value="" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="telephone" value="" />
    <?php } ?>
    
    <?php if(isset($display_fax) && $display_fax == 1) { ?>
        <div class="form-group">
            <label class="control-label" for="input-fax"><?php echo $entry_fax; ?></label>
            <input type="text" name="fax" value="" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="fax" value="" />
    <?php } ?>
    
    <?php foreach ($custom_fields as $custom_field) { ?>
      <?php if ($custom_field['location'] == 'account') { ?>
      <?php if ($custom_field['type'] == 'select') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
          <?php } ?>
        </select>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'radio') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <div id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="radio">
            <label>
              <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'checkbox') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <div id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'text') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'textarea') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <textarea name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php echo $custom_field['value']; ?></textarea>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'file') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <br />
        <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default" onclick="socl_login_actions.uploadFile('<?php echo $custom_field['custom_field_id']; ?>')"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
        <input type="hidden" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'date') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group date">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'time') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group time">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'datetime') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group datetime">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </div>
    
    <div id="address">            
    <?php if(isset($display_company) && $display_company == 1) { ?>
        <div class="form-group">
            <label class="control-label" for="input-company"><?php echo $entry_company; ?></label>
            <input type="text" name="company" value="" placeholder="<?php echo $entry_company; ?>" id="input-company" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="company" value="" />
    <?php } ?>
                
    <?php if(isset($display_address) && $display_address == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-address"><?php echo $entry_address; ?></label>
            <input type="text" name="address_1" value="" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="address_1" value="" />
    <?php } ?>
                
    <?php if(isset($display_city) && $display_city == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-city"><?php echo $entry_city; ?></label>
            <input type="text" name="city" value="" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="city" value="" />
    <?php } ?>   
                    
    <?php if(isset($display_postcode) && $display_postcode == 1) { ?>                
        <div class="form-group required">
            <label class="control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
            <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
        </div>
    <?php } else { ?>
        <input type="hidden" name="postcode" value="" />
    <?php } ?>
                
    <?php if(isset($display_country) && $display_country == 1) { ?>                
        <div class="form-group required">
            <label class="control-label" for="input-country"><?php echo $entry_country; ?></label>
            <select name="country_id" id="input-country" class="form-control" onchange="socl_login_actions.changeSelectCountry()">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </div>
    <?php } else { ?>
        <input type="hidden" name="country_id" value="" />
    <?php } ?>
                
    <?php if(isset($display_region) && $display_region == 1) { ?>
        <div class="form-group required">
            <label class="control-label" for="input-zone"><?php echo $entry_zone; ?></label>
            <select name="zone_id" id="input-zone" class="form-control">
            </select>
        </div>
    <?php } else { ?>
        <input type="hidden" name="zone_id" value="" />
    <?php } ?>
    
    <?php foreach ($custom_fields as $custom_field) { ?>
      <?php if ($custom_field['location'] == 'address') { ?>
      <?php if ($custom_field['type'] == 'select') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
          <?php } ?>
        </select>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'radio') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <div id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="radio">
            <label>
              <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'checkbox') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <div id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'text') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'textarea') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <textarea name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php echo $custom_field['value']; ?></textarea>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'file') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label"><?php echo $custom_field['name']; ?></label>
        <br />
        <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default" onclick="socl_login_actions.uploadFile('<?php echo $custom_field['custom_field_id']; ?>')"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
        <input type="hidden" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'date') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group date">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'time') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group time">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php if ($custom_field['type'] == 'datetime') { ?>
      <div id="payment-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field <?php echo ($custom_field['required']) ? 'required' : '';  ?>" data-sort="<?php echo $custom_field['sort_order']; ?>">
        <label class="control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
        <div class="input-group datetime">
          <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </div>   
         
      <input id="socl_save_new_cus" type="button" value="<?php echo $button_save; ?>" class="btn btn-primary" onclick="socl_login_actions.validateAndSaveNewCustomerInfo()" />
    </div></div>
</div>