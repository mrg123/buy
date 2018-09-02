<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>


<link rel="stylesheet" type="text/css" href="catalog/view/theme/wap/css/demo.css">
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-2.1.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/wap/css/jquery.mmenu.all.css">
<script type="text/javascript" src="catalog/view/theme/wap/js/jquery.mmenu.all.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/wap/css/jquery.mhead.css">
<script type="text/javascript" src="catalog/view/theme/wap/js/jquery.mhead.js"></script>

<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/wap/css/font/iconfont.css">



<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/wap/css/overload.css">
<script src="catalog/view/theme/wap/js/common.js" type="text/javascript"></script>
</head>
<body class="<?php echo $class; ?>">

  <div class="mh-head first Sticky">
				<span class="mh-btns-left">
					<a class="fa fa-bars" href="#menu"></a>
				</span>
				<span class="mh-btns-left2 hide"> <a href="<?php echo $wishlist; ?>"><i class="fa fa-heart"></i></a> </span>
				<span class="mh-btns-left3"> <?php echo $currency; ?> </span>
    <span class="mh-text">
	
		<a href="<?php echo $home; ?>">
		
		<img src="catalog/view/theme/wap/logo.png" alt="<?php echo $name; ?>"/>
		</a>
	
	</span>
    <span class="mh-btns-right">
	<span id="count-cart" style="font-size: 12px;position: absolute;left: 42px;top:18px;text-align:center;font-weight:700"></span>
		<a class="fa fa-shopping-cart" href="#shoppingbag"></a>
					
	</span>
  </div>
  <div class="mh-head second" id="search">
    <div class="mh-form">
      <input placeholder="Find Products" name="search" value="" style="padding-left:40px;"/>
      <a href="javascript:void(0)" class="fa fa-search" style="left:0"></a>
    </div>
  </div>

  <nav id="menu">
    <ul>
	<?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <?php } else { ?>
            <li>
            <a href="<?php echo $login; ?>" class="line"><?php echo $text_register; ?> / <?php echo $text_login; ?></a></li>
            <?php } ?>
	<li><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
	<?php if($categories) { ?>
	<?php foreach($categories as $category) { ?>
	<?php if($category['children']) { ?>
		<li><span><?php echo $category['name']; ?></span>
			<ul>
			<?php foreach ($category['children'] as $child) { ?>
				<?php if($child['thumb']) { ?>
			<li><a href="<?php echo $child['href']; ?>"><img src="<?php echo $child['thumb']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>" /></a></li>
				<?php }else{ ?>
			<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>	
				<?php } ?>
			
			<?php } ?>
			</ul>
		</li>
	<?php }else{ ?>
	<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	
		
		<div class="mmenu-footer hide">
			<i class="fa fa-phone"></i><?php echo $telephone; ?>
		</div>
	
    </ul>
	
  </nav>
  <nav id="shoppingbag">
    <div class="col-sm-12" id="bag-content">
	</div>
  </nav>

  <div class="hide" id="js_url" checkout="<?php echo $checkout ?>" home="<?php echo $home; ?>"></div>
  
  	<a href="javascript:void(0)" class="totop">
		<i class="icon iconfont icon-xiangshangjiantouquan"></i>
	</a>