<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
	
	<?php if ($categories) { ?>
      <div class="row">
            <?php foreach ($categories as $category) { ?>
			<div class="col-xs-4">
            <?php if($category['thumb']) { ?>
			<a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" /></a>
				<?php }else{ ?>
			<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>	
				<?php } ?>
				</div>
            <?php } ?>
      </div>
      <?php } ?>
	  <hr>
      <?php if ($products) { ?>
      <div class="row">
        <div class="col-xs-2">
          <label class="control-label" for="input-sort" style="padding:7px;margin:0;">Sort</label>
		</div>
		<div class="col-xs-10">
          <select id="input-sort" class="form-control" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <br />
      <div class="row" id="downpage">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
				<?php if ($product['price']) { ?>
                <p class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
				  
				  <span onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" class="add-wishlist">
				  <i class="fa fa-heart"></i>
				  </span>
                </p>
                <?php } ?>
                <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                
              </div>
              <div class="button-group hide">
                <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
		
      </div>
	  <div class="col-sm-12" id="loading" style="text-align:center;style:none;">
		<img src="catalog/view/theme/wap/loading.gif"/>
	  </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<input type="hidden" value="<?php echo $category_id; ?>" id="category_id"/>
<input type="hidden" value="2" id="page"/>
<script>
$(function(){
	var flag = true;
	var stop = true;
	loadMore();
    //加载更多
        function loadMore(){
            
                child_id = $('#category_id').val(),
                page = $('#page').val();
            $(window).scroll(function(){
                var docHeight = $(document).height()-50,
                scrollHeight = $(window).height()+$(window).scrollTop();
                if(docHeight<scrollHeight && flag && stop){
                        $.ajax({
                            url: 'index.php?route=product/category/down&child_id=' + child_id + '&page=' + page,
                            dataType: 'json',
                            beforeSend: function() {
								stop = false;
								$("#loading").show();
                            },
                            complete: function() {
								stop = true;
								$("#loading").hide();
                            },
                            success: function(json) {
                                if (json['error']){
									var _html = '';
									_html += '<div class="product-layout product-list col-xs-12">';
									_html += '<div class="dropload-noData">End</div>';
									_html += '</div>';
									$('#downpage').append(_html);
									flag = false;
                                }else{
									var _html = '';
									for(var i=0,l=json.length;i<l;i++){
									_html += '<div class="product-layout product-list col-xs-12">';
									_html += '<div class="product-thumb">';
										if(json[i].thumb){
									_html += '<div class="image"><a href="'+json[i].href+'"><img src="'+json[i].thumb+'" class="img-responsive" /></a></div>';
										}
									_html += '<div>';
									_html += '<div class="caption">';
					if(json[i].price){
						_html += '<p class="price">';
						if(!json[i].special){
							_html += json[i].price;
						}else{
							_html += '<span class="price-new">'+json[i].special+'</span> <span class="price-old">'+json[i].price+'</span>';
						}
						
						if(json[i].tax){
							_html += '<span class="price-tax"><?php echo $text_tax; ?> '+json[i].tax+'</span>';
						}
                  
						_html += '</p>';
					}				
                _html += '<a href="'+json[i].href+'">'+json[i].name+'</a>';
					if(json[i].rating){
						 _html += '<div class="rating">';
						 for(var k=1; k<=5; k++){
							if(json[i].rating<k){
								_html += '<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>';
							}else{
								_html += '<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>';
							} 
						 }
                _html += '</div>';  	
					}
					
                _html += '</div>';
				
				_html += '<div class="button-group hide">';
				_html += '<button type="button" onclick="cart.add(\''+json[i].product_id+'\', \''+json[i].minimum+'\');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>';
                _html += '<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add(\''+json[i].product_id+'\');"><i class="fa fa-heart"></i></button>';
                _html += '<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add(\''+json[i].product_id+'\');"><i class="fa fa-exchange"></i></button>';
                _html += '</div>';
				_html += '</div>';
				_html += '</div>';
				_html += '</div>';
              
									}
									$('#downpage').append(_html);
									page++;
								}
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    
                }
            });
        }
});
</script>

<?php echo $footer; ?>
