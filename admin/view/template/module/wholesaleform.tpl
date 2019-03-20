<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
          <h1><i class="fa fa-check-square-o"></i> <?php echo $heading_title; ?></h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="pull-right">
          
            <a data-toggle="tooltip" title="<?php echo $text_support; ?>" class="btn btn-primary" target="_blank" href="http://support.cartbinder.com/open.php"><i class="fa fa-life-ring"></i> <?php echo $text_support; ?></a>
         </div>
    </div>
  </div>
  <div class="page-header">
    <div class="container-fluid">
          <div class="pull-right">
        <a onclick="$('#form').submit();"  class="btn btn-primary"><i class="fa fa-save"></i></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-danger"><i class="fa fa-reply"></i></a>
        </div>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
    <div class="panel panel-default">
     <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $headerinfo2; ?></h3>
      </div>
     <div class="panel-body">
      <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_showlinkheader; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($showlinkheader) { ?>
                <input type="radio" name="showlinkheader" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="showlinkheader" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$showlinkheader) { ?>
                <input type="radio" name="showlinkheader" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="showlinkheader" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>


         <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_showlinkfooter; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($showlinkfooter) { ?>
                <input type="radio" name="showlinkfooter" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="showlinkfooter" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$showlinkfooter) { ?>
                <input type="radio" name="showlinkfooter" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="showlinkfooter" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

   
    </div>

   <div class="panel panel-default">
     <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $headerinfo1; ?></h3>
      </div>
     <div class="panel-body">
  
        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_name; ?></label>
           <div class="col-sm-2">
              <label class="radio-inline">
                  <?php if ($setting['companyname']) { ?>
                <input type="radio" name="companyname" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="companyname" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['companyname']) { ?>
                <input type="radio" name="companyname" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="companyname" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
          <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['companyname']) { ?>
                <input type="radio" name="companynamer" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="companynamer" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['companyname']) { ?>
                <input type="radio" name="companynamer" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="companynamer" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

         <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_address; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['address']) { ?>
                <input type="radio" name="address" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="address" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['address']) { ?>
                <input type="radio" name="address" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="address" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
          <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['address']) { ?>
                <input type="radio" name="addressr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="addressr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['address']) { ?>
                <input type="radio" name="addressr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="addressr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_city; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['city']) { ?>
                <input type="radio" name="city" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="city" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['city']) { ?>
                <input type="radio" name="city" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="city" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
          <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['city']) { ?>
                <input type="radio" name="cityr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="cityr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['city']) { ?>
                <input type="radio" name="cityr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="cityr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_state; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['state']) { ?>
                <input type="radio" name="state" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="state" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['state']) { ?>
                <input type="radio" name="state" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="state" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
          <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['state']) { ?>
                <input type="radio" name="stater" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="stater" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['state']) { ?>
                <input type="radio" name="stater" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="stater" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_country; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['country']) { ?>
                <input type="radio" name="country" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="country" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['country']) { ?>
                <input type="radio" name="country" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="country" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['country']) { ?>
                <input type="radio" name="countryr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="countryr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['country']) { ?>
                <input type="radio" name="countryr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="countryr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>

        </div>


        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_pincode; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['pincode']) { ?>
                <input type="radio" name="pincode" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="pincode" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['pincode']) { ?>
                <input type="radio" name="pincode" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="pincode" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['pincode']) { ?>
                <input type="radio" name="pincoder" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="pincoder" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['pincode']) { ?>
                <input type="radio" name="pincoder" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="pincoder" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_phone; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['phone']) { ?>
                <input type="radio" name="phone" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="phone" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['phone']) { ?>
                <input type="radio" name="phone" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="phone" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['phone']) { ?>
                <input type="radio" name="phoner" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="phoner" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['phone']) { ?>
                <input type="radio" name="phoner" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="phoner" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_mobile; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['mobile']) { ?>
                <input type="radio" name="mobile" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="mobile" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['mobile']) { ?>
                <input type="radio" name="mobile" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mobile" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['mobile']) { ?>
                <input type="radio" name="mobiler" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="mobiler" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['mobile']) { ?>
                <input type="radio" name="mobiler" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mobiler" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_email; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['email']) { ?>
                <input type="radio" name="email" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="email" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['email']) { ?>
                <input type="radio" name="email" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="email" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['email']) { ?>
                <input type="radio" name="emailr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="emailr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['email']) { ?>
                <input type="radio" name="emailr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="emailr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

          <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_nameperson; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['nameperson']) { ?>
                <input type="radio" name="nameperson" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="nameperson" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['nameperson']) { ?>
                <input type="radio" name="nameperson" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="nameperson" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['nameperson']) { ?>
                <input type="radio" name="namepersonr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="namepersonr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['nameperson']) { ?>
                <input type="radio" name="namepersonr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="namepersonr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

          <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_contacttitle; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['contacttitle']) { ?>
                <input type="radio" name="contacttitle" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="contacttitle" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['contacttitle']) { ?>
                <input type="radio" name="contacttitle" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="contacttitle" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['contacttitle']) { ?>
                <input type="radio" name="contacttitler" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="contacttitler" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['contacttitle']) { ?>
                <input type="radio" name="contacttitler" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="contacttitler" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>

        </div>

          <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_tin; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['vattin']) { ?>
                <input type="radio" name="vattin" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="vattin" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['vattin']) { ?>
                <input type="radio" name="vattin" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="vattin" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['vattin']) { ?>
                <input type="radio" name="vattinr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="vattinr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['vattin']) { ?>
                <input type="radio" name="vattinr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="vattinr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>


         <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_business; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['business']) { ?>
                <input type="radio" name="business" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="business" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['business']) { ?>
                <input type="radio" name="business" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="business" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['business']) { ?>
                <input type="radio" name="businessr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="businessr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['business']) { ?>
                <input type="radio" name="businessr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="businessr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

         <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_specify; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['specify']) { ?>
                <input type="radio" name="specify" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="specify" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['specify']) { ?>
                <input type="radio" name="specify" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="specify" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['specify']) { ?>
                <input type="radio" name="specifyr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="specifyr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['specify']) { ?>
                <input type="radio" name="specifyr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="specifyr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

         <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_formation; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['formation']) { ?>
                <input type="radio" name="formation" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="formation" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['formation']) { ?>
                <input type="radio" name="formation" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="formation" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['formation']) { ?>
                <input type="radio" name="formationr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="formationr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['formation']) { ?>
                <input type="radio" name="formationr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="formationr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_sales; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['sales']) { ?>
                <input type="radio" name="sales" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="sales" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['sales']) { ?>
                <input type="radio" name="sales" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="sales" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['sales']) { ?>
                <input type="radio" name="salesr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="salesr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['sales']) { ?>
                <input type="radio" name="salesr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="salesr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_otherbrands; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['brands']) { ?>
                <input type="radio" name="brands" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="brands" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['brands']) { ?>
                <input type="radio" name="brands" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="brands" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['brands']) { ?>
                <input type="radio" name="brandsr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="brandsr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['brands']) { ?>
                <input type="radio" name="brandsr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="brandsr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_websiteurl; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['url']) { ?>
                <input type="radio" name="url" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="url" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['url']) { ?>
                <input type="radio" name="url" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="url" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['url']) { ?>
                <input type="radio" name="urlr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="urlr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['url']) { ?>
                <input type="radio" name="urlr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="urlr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>


        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_product; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['products']) { ?>
                <input type="radio" name="products" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="products" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['products']) { ?>
                <input type="radio" name="products" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="products" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['products']) { ?>
                <input type="radio" name="productsr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="productsr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['products']) { ?>
                <input type="radio" name="productsr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="productsr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_category; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['category']) { ?>
                <input type="radio" name="category" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="category" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['category']) { ?>
                <input type="radio" name="category" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="category" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['category']) { ?>
                <input type="radio" name="categoryr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="categoryr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['category']) { ?>
                <input type="radio" name="categoryr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="categoryr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>

        <div class="form-group">
         <label for="status" class="col-sm-2 control-label"><?php echo $text_enquiry; ?></label>
         <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($setting['enquiry']) { ?>
                <input type="radio" name="enquiry" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="enquiry" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$setting['enquiry']) { ?>
                <input type="radio" name="enquiry" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="enquiry" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
           <label for="status" class="col-sm-2 control-label"><?php echo $text_required; ?></label>
          <div class="col-sm-2">
            <label class="radio-inline">
                <?php if ($required['enquiry']) { ?>
                <input type="radio" name="enquiryr" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="enquiryr" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                 <?php if (!$required['enquiry']) { ?>
                <input type="radio" name="enquiryr" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="enquiryr" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
          </div>
        </div>


        

        

        
    </form>
  </div>
</div>
</div>
<div class="remodal" data-remodal-id="modal">
    <h1>Remodal</h1>
    <p>
      Flat, responsive, lightweight, fast, easy customizable modal window plugin
      with declarative state notation and hash tracking.
    </p>
    <br>
    <a class="remodal-cancel" href="#">Cancel</a>
    <a class="remodal-confirm" href="#">OK</a>
</div>

  
<?php echo $footer; ?>
</div>
<script type="text/javascript" src="view/javascript/jquery/remodal.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' async rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="view/stylesheet/imdev.css">