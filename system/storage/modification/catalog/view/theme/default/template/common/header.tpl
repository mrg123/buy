<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css?20190106" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

          <style>
            #menu .dropdown .dropdown-toggle {
              padding-right: 20px;
            }

            .ochow-menu-item-toggle {
              position: absolute;
              top: 0;
              right: 0;
              z-index: 1;
              color: #FFF;
              padding: 10px 15px;
            }

            .ochow-menu-item-toggle:hover {
              background-color: rgba(144, 128, 128, 0.5);
              cursor: pointer;
            }

            .ochow-menu-item-toggle.ochow-close .fa-plus {
              display: inline-block;
            }

            .ochow-menu-item-toggle.ochow-close .fa-minus {
              display: none;
            }

            .ochow-menu-item-toggle.ochow-open .fa-plus {
              display: none;
            }

            .ochow-menu-item-toggle.ochow-open .fa-minus {
              display: inline-block;
            }

            .ochow-menu-item-arrow {
              position: absolute;
              top: 12px;
              right: 5px;
              color: #fff;
            }
          </style>
          <script>
            $(document).ready(function () {
              var $menu = $('#menu');

              $('.ochow-menu-item-toggle').on('click', function () {
                var $btn = $(this);

                $menu
                  .find('.dropdown')
                    .removeClass('open')
                      .find('.ochow-open')
                        .removeClass('ochow-open')
                        .addClass('ochow-close');

                if ($btn.hasClass('ochow-close')) {
                  $btn
                    .removeClass('ochow-close')
                    .addClass('ochow-open')
                      .parent()
                        .addClass('open')
                } else {
                  $btn
                    .removeClass('ochow-open')
                    .addClass('ochow-close')
                      .parent()
                        .removeClass('open')
                }
              });
			  
			  $(document).scroll(function () {
					
					if($(this).scrollTop()==0){
						$('.fixed_cover').hide();
						$('#top').css({
							'position':'relative'
						});
						$('header').css({
							'position':'relative'
						});
						$('.jumbotron').css({
							'position':'relative'
						});
					}else{
						$('.fixed_cover').show();
						$('#top').css({
							'position':'fixed',
							'z-index':'999',
							'width':'100%'
						});
						$('header').css({
							'position':'fixed',
							'z-index':'998',
							'width':'100%',
							'background-color':'#fff'
						});
						$('.jumbotron').css({
							'position':'fixed',
							'z-index':'997',
							'width':'100%'
						});
					}
			  });
            });
          </script>
        
</head>
<body class="<?php echo $class; ?>">
<nav id="top" style="margin:0;">
  <div class="container">
   
    <?php echo $language; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
       
        <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
        <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_shopping_cart; ?></span></a></li>
        <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_checkout; ?></span></a></li>
    
				<?php if($wholesaleform_showlinkheader) { ?>
				<li><a href="<?php echo $wholesalelink; ?>" title="<?php echo $text_wholesale; ?>"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wholesale; ?></span></a></li>
				<?php } ?>
				
      </ul>
    </div>
  
   <?php echo $currency; ?>
  </div>
  	
</div> 
	       
</nav>
<div class="fixed_cover" style="width:100%;height:44px;margin:0;padding:0;display:none;"></div>
<header>
<div style="width:100%;height:20px;margin:0;padding:0;"></div>
  <div class="container" style="padding-top:10px">
    <div class="row">
      <div class="col-sm-4">
        <div id="logo" style="margin: -10px 0 0 0;">
          <?php if ($logo) { ?>
          <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
      <div class="col-sm-6"><?php echo $search; ?>
      </div>
      <div class="col-sm-2"><?php echo $cart; ?></div>
    </div>
  </div>
</header>
<div class="fixed_cover" style="width:100%;height:70px;margin:0;padding:0;display:none;"></div>
<?php if ($categories) { ?>
<div class="jumbotron" style="margin-bottom:10px;padding:0;">		  
	<div style="width:100%;height:20px;margin:0;padding:0;background-color:#fff"></div>       
  <nav id="menu" class="navbar" style="margin:0">
	
            <div class="container"> 
	       
    <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
<li><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
        <?php foreach ($categories as $category) { ?>
        <?php if ($category['children']) { ?>
        	
	       <li class="dropdown"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
	  

          <span class="ochow-menu-item-toggle ochow-close visible-xs">
            <i class="fa fa-plus"></i>
            <i class="fa fa-minus"></i>
          </span>
          <span class="ochow-menu-item-arrow hidden-xs">
            <i class="fa fa-angle-down"></i>
          </span>
        
          <div class="dropdown-menu">
            <div class="dropdown-inner">
              <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
              <ul class="list-unstyled">
                <?php foreach ($children as $child) { ?>
                <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </div>
            </div>
        </li>
        <?php } else { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
	
            </div> 
	       
  </nav>
</div>
<div class="fixed_cover" style="width:100%;height:40px;margin:0;padding:0;display:none;"></div>
<?php } ?>