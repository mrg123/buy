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
      <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />

      <div class="layui-form-item">
      <button class="btn btn-primary btn-lg" type="submit" >Subbmit</button>


  </form>
</div>



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
  

</script>
</body></html> 