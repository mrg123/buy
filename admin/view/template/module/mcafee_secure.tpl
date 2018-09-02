<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
   <link href="view/stylesheet/mcafee_secure.css" type="text/css" rel="stylesheet"/>

   <div class="page-header">
      <div class="container-fluid">
         <div class="pull-right">
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
               class="btn btn-default"><i class="fa fa-reply"></i></a></div>

         <h1><?php echo $heading_title; ?></h1>

         <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
         </ul>

      </div>
   </div>

   <div class="container-fluid">
      <div class="wrap">
         <div id="mcafeesecure" data-host="<?php echo $host ?>"></div>
         <div id="iframe-container">
            <iframe src="<?php echo $endpoint; ?>app/partner2/dashboard?form=login&aff=<?php echo $affiliate; ?>&platform=9&partner=<?php echo $partner; ?>&email=<?php echo $email; ?>&host=<?php echo $host; ?>"
                    width="100%" height="1000px" seamless scrolling="no" frameborder="0">

            </iframe>
         </div>
      </div>
   </div>
</div>
<?php echo $footer; ?>