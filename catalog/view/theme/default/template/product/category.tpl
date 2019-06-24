<?php echo $header; ?>
<div class="container">
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
      <h2 style="text-align:center"><?php echo $heading_title; ?> <span style="color:#b0b0b0"></span></h2>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($categories) { ?>
      <div class="row">
        <div class="col-sm-12">
          <ul class="child-category">
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } ?>
      <?php if ($products) { ?>
      <!-- <p><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p> -->
      <div class="row">
        <div class="col-md-7">
          <div class="btn-group hidden-xs">
		   
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
			
          </div>
        </div>
        <div class="col-md-2 text-right">
          <label class="control-label" for="input-sort" style="line-height: 34px;"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-md-3 text-right">
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
		<!--
        <div class="col-md-1 text-right">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
        </div>
        <div class="col-md-2 text-right" style="">
          <select id="input-limit" class="form-control" onchange="location = this.value;">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
		-->
      </div>
      <br />
      <div class="row" id="downpage">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                <p><?php echo $product['description']; ?></p>
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
                </p>
                <?php } ?>
              </div>
              <div class="button-group">
                <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!--
	  <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
	  -->
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
<div class="loaders" style="display:none;">
      <div class="loader">
        <div class="loader-inner ball-pulse">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	</div>
<input type="hidden" value="<?php echo $category_id; ?>" id="category_id"/>
<input type="hidden" value="2" id="page"/>
<script type="text/javascript">
$(function(){
loadMore();
    //加载更多
        function loadMore(){
            var flag = true;
			var stop = true;
                child_id = $('#category_id').val(),
                page = $('#page').val();
            $(window).scroll(function(){
                var docHeight = $(document).height()-50,
                scrollHeight = $(window).height()+$(window).scrollTop();
                if(docHeight<scrollHeight && flag == true && stop){
                        $.ajax({
                            url: 'index.php?route=product/m_category/down&child_id=' + child_id + '&page=' + page,
                            dataType: 'json',
                            beforeSend: function() {
								stop = false;
								$('.loaders').show();
                            },
                            complete: function() {
								stop = true;
								$('.loaders').hide();
                            },
                            success: function(json) {
                                if (json['error']){
									var _html = '';
									_html += '<div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">';
									//_html += '<center><b>Empty</b></center>';
									_html += '</div>';
									$('#downpage').append(_html);
									flag = false;
									$('.loaders').hide();
                                }else{
									var _html = '';
									for(var i=0,l=json.length;i<l;i++){
									_html += '<div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">';
									_html += '<div class="product-thumb">';
										if(json[i].thumb){
									_html += '<div class="image"><a href="'+json[i].href+'"><img src="'+json[i].thumb+'" class="img-responsive" /></a></div>';
										}
									_html += '<div>';
									_html += '<div class="caption">';
									
                _html += '<h4><a href="'+json[i].href+'">'+json[i].name+'</a></h4>';
                _html += '<p></p>';
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
                _html += '</div>';
				
				_html += '<div class="button-group">';
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
