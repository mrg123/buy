<?php if($ban) { ?>

<div style="z-index:99;background-color: rgba(0, 0, 0, 0.6);width:100%;height:100%;position: absolute;" id="ban_bg"></div>
<div style="width:380px;height:280px;position:fixed;top:50%;left:50%;margin-top:-150px;margin-left:-150px;z-index:100;background:#fff;box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);" id="ban_body">

 <div class="form-group">
 <br/>
 <p class="control-label col-sm-12"></p>
            <label class="col-sm-12 control-label" for="ban_code">Please Input Code</label>
            <div class="col-sm-12">
              <input type="text" name="code" value="" placeholder="" id="ban_code" class="form-control" />
            </div>
            
            <div class="col-sm-12">
            <br/>
           
            <input type="buttom" value="Submit" class="btn btn-primary" id="ban-submit"/>
            </div>
          </div>
</div>
<script type="text/javascript">
$(function(){
  $('#ban-submit').click(function(){
    var code = $('#ban_code').val();
    $.ajax({
                type: 'post',
                url: "<?php echo $ban_url; ?>",
                data: {'invitation_code':code},
                dataType: 'json',
                success: function (json) {
                    if(json){
                      $('#ban_bg').remove();
                      $('#ban_body').remove();
                    }else{
                      alert('wrong code');
                    }
                }
            });

  });  
});
</script>

<?php } ?>

