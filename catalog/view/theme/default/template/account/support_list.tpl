<?php echo $header; ?>
<style type="text/css">
.list-unstyled li{ font-size:16px;line-height:25px;font-weight:600}
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
  height: 300px;
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
  box-shadow: 1px 1px 20px 2px #888;
}
</style>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
     
     <br/><br/><br/>
      <ul class="list-unstyled" style="text-align: center; margin:0 auto; width:500px">
        <li style="margin-right:30px;float:left;">
          <a id="warm" style="cursor:pointer"><?php echo $text_add_support; ?></a>
        </li>
        <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
      </ul>
     
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>

  <div id="batch-window">
    <div class="container-fluid">
      <p style="margin-top:20px;text-align:center;">tototototototo</p>

      <div style="text-align:center;position:absolute;bottom:20px;left:50%;width:400px;margin-left:-200px;">
      <button class="btn btn-default btn-lg" id="close" style="margin-right:100px;">
        Back
      </button>
      <button class="btn btn-primary btn-lg " id="add">
        Continue
      </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#warm').click(function(){
        $('#batch-window').addClass('upBg show');
    });
    $('#close').click(function(){
        $('#batch-window').removeClass('upBg show');
    });
    $('#add').click(function(){
      window.location.href = '<?php echo $add_support; ?>';
    });
</script>



<?php echo $footer; ?>
