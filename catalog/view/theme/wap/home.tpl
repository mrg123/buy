<?php echo $header; ?>
<?php echo $content_top; ?>
<?php echo $content_bottom; ?>
<?php echo $column_left; ?>	
<?php echo $column_right; ?>

<div id="get-lastest">
	
</div>

	<div class="loaders">
      <div class="loader">
        <div class="loader-inner ball-pulse">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	</div>
	

	
<script type="text/javascript">
$(function() {
	// 加载新产品
	var start = 0;
	var validate = true;
	$(document).scroll(function(){  
		var bottom_val = $(document).height() - $(document).scrollTop() - window.innerHeight;
		
        if( bottom_val <= 100 && validate )   
        {  
			var request_data = {
                start : start
            };
			if(validate) {
            $.ajax({
                type: 'post',
                url: '/index.php?route=product/product/getLastest',
                data: request_data,
                dataType: 'json',
				beforeSend: function(json){
					validate = false;
				},
                success: function (json) {
                    start += 20;
					
					if(json.state){
					var _html = '';
					$.each(json.products,function(k,v){
						_html += '<div class="product">';
						_html += '<div class="product-thumb">';
						_html += '<a href="'+v.href+'"><img src="'+v.thumb+'"/></a></div>';
						_html += '<div class="info">';
						if(v.special){
							_html += '<span class="new-price">'+v.special+'</span>';
						_html += '<span class="old-price">'+v.price+'</span>';	
						}else{
							_html += '<span class="new-price">'+v.price+'</span>';
					
						}
						
						_html += '<span class="product-name">'+v.name+'</span>';
						_html += '</div></div>';	
					});
					$('#get-lastest').append(_html);
					validate = true;
					}else{
						validate = false;
					}
                }
            });
			}
        }  
        else  
        {  
			
        }  
    });  
	
});
</script>
	
<?php echo $footer; ?> 


