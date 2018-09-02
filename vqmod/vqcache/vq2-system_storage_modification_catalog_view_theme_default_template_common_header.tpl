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
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
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

			
			
			$(".ochow-close").click(function(){
				$(this).parent().children(".dropdown-menu").toggle();
				$(this).parent().children(".dropdown-menu").css("overflow","auto");
				$(this).children('.fa-plus').toggle();
				$(this).children('.fa-minus').toggle();
				
			});
			$(".fa-plus").click(function(){
				console.log(1);
				$('header').css("position","absolute");
				$(window).scrollTop(0);
			});
			$(".fa-minus").click(function(){
				console.log(2);
				$('header').css("position","fixed");
			});
		
			
			$(window).scroll(function() {
				if($(window).scrollTop()<40){
					$("header").animate({top:"40px"},"fast");
				}else{
					$("header").animate({top:"0"},"fast");
				}
				 
			});
			
			
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
            });
          </script>
        
        
        <?php global $config; if ($config->get('config_smartsupp_enabled')) { ?>
          <script type="text/javascript">   
            var _smartsupp = _smartsupp || {};
            _smartsupp.key = '<?php echo $config->get('config_smartsupp_key') ?>';
            _smartsupp.cookieDomain = ".<?php $smartsupp_host = parse_url($base); echo $smartsupp_host['host']; ?>";
            window.smartsupp||(function(d) {
              var o=smartsupp=function(){ o._.push(arguments)},s=d.getElementsByTagName('script')[0],c=d.createElement('script');o._=[];
              c.async=true;c.type='text/javascript';c.charset='utf-8';c.src='//www.smartsuppchat.com/loader.js';s.parentNode.insertBefore(c,s);
            })(document);
          </script>
        <?php } ?>
      
</head>
<body class="<?php echo $class; ?>">
<nav id="top">
  <div class="container">
    <?php echo $currency; ?>
    <?php echo $language; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="<?php echo $contact; ?>"><i class="fa fa-phone hidden-sm hidden-xs"></i></a> <span class="hidden-xs hidden-sm hidden-md"><?php echo $telephone; ?></span></li>
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
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart hidden-sm hidden-xs"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
        <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><i class="fa fa-shopping-cart" style="font-size:20px;color:#DC7405;"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_shopping_cart; ?></span></a></li>
        <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><i class="fa fa-share hidden-sm hidden-xs"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_checkout; ?></span></a></li>
    
				<?php if($wholesaleform_showlinkheader) { ?>
				<li><a href="<?php echo $wholesalelink; ?>" title="<?php echo $text_wholesale; ?>"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wholesale; ?></span></a></li>
				<?php } ?>
				
      </ul>
    </div>
  </div>
	
            </div> 
	       
</nav>

			<?php if($is_mobile){ ?>
			<div class="col-sm-12" style="height:80px;">&nbsp;</div>
			<header style="position:fixed;width:100%;background-color:#fff;top:45px;z-index:999;">
			<?php }else{ ?>
			<header>
			<?php } ?>
			
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        
			<div class="col-sm-12" style="height:5px;margin:0;padding:0;">&nbsp;</div>
			<div id="logo" class="hidden-sm hidden-xs">
          <?php if ($logo) { ?>
          <a href="<?php echo HTTP_SERVER; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="<?php echo HTTP_SERVER; ?>"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
      <div class="col-sm-5"><?php echo $search; ?>
      </div>
      <div class="col-sm-3"><?php echo $cart; ?></div>
    </div>
  </div>
</header>
<?php if ($categories) { ?>
	
           <div class="jumbotron" style="margin:0;padding:0;">		  
	       
  <nav id="menu" class="navbar">
	
            <div class="container"> 
	       
    <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" style="background-color:#C7C6CC;background-image: linear-gradient(to bottom, #4A4A4A, #4A4A4A);background-repeat: repeat-x;border-color: #C7C6CC #C7C6CC #C7C6CC;"><i class="fa fa-bars"></i></button>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
<li><a href="<?php echo HTTP_SERVER; ?>"><?php echo $text_home; ?></a></li>
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
        
                <?php if (isset($category['target']) && trim($category['target'])!= "") { ?>
                <li><a href="<?php echo $category['href']; ?>" target="<?php echo $category['target']; ?>"><?php echo $category['name']; ?></a></li>
                <?php } else { ?>
                <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                <?php } ?>
 
            
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
	
            </div> 
	       
  </nav>
</div>
<?php } ?>
