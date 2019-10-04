<div class="row"><div id="content" class="col-sm-12"> 
    <div class="well">
        <h2><?php echo $heading_title; ?></h2>
        
        <div class="content">
            <p><?php echo $text_confirm_pass; ?></p>
            
            <label class="control-label" for="input-pass"><?php echo $entry_confirm_pass; ?></label>
            <input type="password" name="confirm_pass" value="" id="input-pass" class="form-control"/>
        </div>
        <div style="margin-top: 10px">
            <input type="button" value="<?php echo $button_cancel; ?>" class="btn btn-primary" onclick="socl_login_actions.cancelConfirmPass();" />           
            <input id="socl_btn_confirm" type="button" value="<?php echo $button_confirm; ?>" class="btn btn-primary" onclick="socl_login_actions.confirmPassword();" />
        </div>
</div></div>
</div>