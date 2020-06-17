<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>QC PHOTO</title>


<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="catalog/view/theme/default/stylesheet/stylesheet.css?20190302" rel="stylesheet">


<style type="text/css">
img{
  margin:20px auto;
}
.img-responsive{
  display: block;
max-width: 100%;
height: auto
}
#batch-window{
    display:none;
}
.upBg{
    transform: translateX(-50%) scale(0.8,0.8);
    left: 50%;
    top: 20%;
    border-radius: 3px;
    position: fixed;
    width: 50%;
    height: 450px;
    overflow-y: auto;
    z-index: 1111;
    transition: all .3s;
    visibility: hidden;
    background: #f2f2f2;
    opacity: 0;
    padding:10px;
}
.show{
    transform: translateX(-50%) scale(1,1);
    visibility: visible;
    opacity: 1;
    box-shadow: 100px 100px 200px 300px #888;
}
</style>
</head>
<body>


<div class="container">
<div class="row">
  <h2 style="text-align:center;margin-top:100px">
  <?php echo $welcome; ?>
  </h2>

    <?php foreach($img_arr as $arr) { ?>
    <div class="col-sm-12">
      <img class="img-responsive" src="<?php echo $arr['url']; ?>">
    </div>
    <?php } ?>
  
  <br/>
  <br/>

  <div style="text-align:center; margin-bottom:100px;">
   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-photo" class="form-horizontal">

      <div class="form-group">
        <div class="col-sm-6" style="text-align: right;">
      <button type="button" class="btn btn-primary btn-lg" id="gl" style="width: 100px;">GL</button> 
        </div>

        <div class="col-sm-6" style="text-align: left;">
      <button type="button" class="btn btn-lg" id="rl" style="width: 100px;">RL</button>
      </div>
      </div>

      <div class="row">
        <div class="form-group">
      <textarea placeholder="say something" class="form-control" name="message" style="width:400px;height:200px;margin:20px auto;"></textarea>
      </div>
      </div>
      <input type="hidden" name="choose" value="gl" id="choose"/>
      <input type="hidden" name="from" value="<?php echo $from; ?>" id="from"/>
      <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />

      <div class="layui-form-item">
      <button class="btn btn-primary btn-lg" type="submit" >Subbmit</button>


  </form>
</div>



  </div>
</div>
</div>

<div id="batch-window" class="upBg show">
    <div class="container-fluid">
        <p style="margin-top:20px;text-align:center;font-size:14px;">Before going to the next webpage please read the following content with full attention.</p>

        <p style="font-weight: bold;font-size:14px;">    1, If the next webpage contains ALL the products you’ve ordered and you are satisfied after viewing all the pictures, please write ‘GL FULL ORDER’ in the comment area and click the GL button to submit your review. If you are not satisfied with some of the items for whatever reason, please write comment as GL item XXXXXX RL item XXXXXX. Be sure to tell us why you are not satisfied with the item you RL and click the RL button to submit your review. The XXXXXX stands for the Product code of the item you’ve ordered. </p>

         <p style="font-weight: bold;font-size:14px;">   2 If the next webpage contains PART of the products you’ve ordered and you are satisfied after viewing all the pictures, then please write ‘GL ALL ITEMS FROM CURRENT LINK’ in the comment area and click the GL button to submit your review. If you are not satisfied with some of the items for whatever reason, please write comment as GL item XXXXXX RL item XXXXX. Be sure to tell us why you are not satisfied with the item you RL and click the RL button to submit your review. The XXXXX stands for the Product code of the item you’ve ordered. QC on remaining products in this order will be sent to you within 1-2 days please be paitent.

        </p>

        <div style="text-align:center;position:absolute;bottom:20px;left:50%;width:400px;margin-left:-200px;">
            <button class="btn btn-primary btn-lg " id="close">
                Continue
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('#gl').click(function(){
    $('#choose').val('gl');
    $(this).addClass('btn-primary');
    $('#rl').removeClass('btn-primary');
  });
    $('#rl').click(function(){
    $('#choose').val('rl');
    $(this).addClass('btn-primary');
    $('#gl').removeClass('btn-primary');
  });


  $('#close').click(function(){
      $('#batch-window').removeClass('upBg show');
  });
</script>
</body></html> 