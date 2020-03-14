<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well" >
          <div class="row">
<div class="col-sm-4">
<button type="button" class="btn btn-primary pull-left" id="send-again">
          Send Again
          </button>
          </div>
          <div class="col-sm-4"></div>
<div class="col-sm-4" style="display:none">
          <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
          <span class="pull-right" style="display: inline-block;line-height: 35px;margin-right: 5px;"><?php echo $results; ?></span>
           <span class="pull-right" style="display: inline-block;line-height: 35px;margin-right: 5px;"><?php echo $pagination; ?></span>
            </div>
          </div>
        </div>

        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td>Order Id</td>
                  <td>Send</td>
                  <td>Message</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-left"><?php echo $order['order_id']; ?></td>
                  <td class="text-left">
                    <?php if ($order['is_send']){ ?>
                    Yes
                    <?php }else{ ?>
No
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $order['message']; ?></td> 
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>

        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>

      </div>
    </div>
  </div>

<script type="text/javascript">
var validate = 1;
$('#send-again').click(function(){
if(validate) {
            $.ajax({
                type: 'post',
                url: 'index.php?route=sale/order/sendagain&token=<?php echo $token; ?>',
                data: '',
                dataType: 'json',
                beforeSend:function(){
                  validate = 0;
                  
                },
                success: function (json) {
                  validate = 1;
                  
                  alert(json['message']);
                  
                },
                complete:function(){
                 validate = 1;
                },
                error:function(){
                 validate = 1;
                }
            });
        }
});
</script>
<?php echo $footer; ?>
