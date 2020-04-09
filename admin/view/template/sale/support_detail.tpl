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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $ticket_id; ?> - <?php echo $support_main['subject']; ?></h3>
      </div>
      <div class="panel-body">

  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>


        <form role="form" id="support" enctype="multipart/form-data">
          <div class="table-responsive">
              <div class="col-md-12">
                <div class="form-group" id="subject-group" >
                  <p class="p-title">
                    Ticket Submitted <br/>
                    <?php echo date('l, F, Y (H:m:s)',strtotime($support_main['add_time'])); ?>
                  </p>
                  <p class="p-title">
                    Related Order <br/>
                    <?php echo $support_main['order_id']; ?>
                  </p>
                  <p class="p-title">
                    Priority <br/>
                    <?php echo $priority[$support_main['priority']]; ?>
                  </p>
                  <p class="p-title">
                    Status <br/>
                    <span id="priority"><?php echo $status[$support_main['status']]; ?></span>
                  </p>

                  <p class="p-title clear">
                    Subject <br/>
                    <?php echo $support_main['subject']; ?>
                  </p>
                </div>

                  <?php foreach($support_img as $time => $item){ ?>
                <div class="form-group clear" style="border:1px solid #ddd;margin-bottom:20px;padding-top:0;">
                  <div style="background-color:#ddd;padding:10px;">
                    <p class="pull-right" style="font-size:16px;padding-top:10px">
                      <?php echo date('l, F, Y (H:m:s)',strtotime($item['add_time']));?>
                    </p>
                    <i class="fa fa-user pull-left" style="font-size:40px"></i>
                    <?php if($item['client']){ ?>
                    <span><?php echo $name; ?></span> <br/>
                    <b>Client</b>
                    <?php }else{ ?>
                    <span><?php echo $store_name; ?></span> <br/>
                    <b>Administrator</b>
                    <?php } ?>

                  </div>
                  <div style="padding:10px;font-size:14px;" class="clear">
                    <pre><?php echo $item['message']; ?></pre>
                    <?php foreach($item['img_url'] as $url){ ?>
                    <img width="200" src="<?php echo $url; ?>"/>
                    <?php } ?>
                  </div>
                </div>
                  <?php } ?>




                <div class="form-group">
                  <label class="control-label" for="message">Message</label>
                  <textarea name="message" class="form-control" id="message" rows="10"></textarea>
                </div>
                <div class="form-group">

                  <label class="control-label" for="notify">Notify Customer</label>
                  <input type="checkbox" value="1" name="notify" id="notify" style="vertical-align: top;margin-left:10px;" checked>
                </div>
                <div class="form-group">
                  <label class="control-label" for="status">Ticket Status</label>
                  <select name="status" id="status" class="form-control" style="width:200px">
                    <option value="1">Answered</option>
                    <option value="0">In Progress</option>
                    <option value="2">Resolved</option>
                  </select>
                </div>
                <div class="form-group" id="file-group">
                  <p id="size"></p>
                  <label class="control-label" for="file1">Attachments</label>
                  <input type="file" class="form-control-file btn-default" id="file1" name="file1" onchange="Filevalidation(this)">
                </div>
                <div class="form-group">
                  <a class="btn btn-default" id="add-more">Add More</a>
                </div>

                <input type="hidden" value="<?php echo $ticket_id; ?>" name="ticket_id" />
                <input type="hidden" value="<?php echo $time; ?>" name="time" id="time" />
                <div class="form-group" style="text-align:center;">
                  <button type="button" class="btn btn-primary btn-lg" id="check" style="margin-right:50px">
                    Submit
                  </button>
                  <a href="<?php echo $support; ?>" class="btn btn-default btn-lg">Cancel</a>
                </div>
              </div>
            </div>
          </form>



      </div>
    </div>
  </div>

  <style type="text/css">
    #support label{
      font-size:14px;
      font-weight:700;
    }
    input[type="file"]{
      margin-top:10px;
    }
    .p-title{
      display:inline-block;
      float:left;
      font-size:14px;
      margin-right:40px;
      font-weight:700;
    }
    .clear{
      clear:both;
    }
    pre{
      background-color:#fff;
      padding:0;
      font-size:14px;
      line-height:20px;
      border:0;
    }
  </style>
<script type="text/javascript">


  var file_validate = 1;
  $('#add-more').click(function() {
      if(file_validate > 9){
          alert('Mix upload attachments 10 piece');
          return;
      }
      file_validate ++;
      _html = '<input type="file" class="form-control-file btn-default" id="file'+file_validate+'" name="file'+file_validate+'" onchange="Filevalidation(this)">';
      $('#file-group').append(_html);
  });

  function Filevalidation(up){

      var fi = up;
      // Check if any file is selected.
      if (fi.files.length > 0) {
          for (var i = 0; i <= fi.files.length - 1; i++) {

              var fsize = fi.files.item(i).size;
              var file = Math.round((fsize / 1024));
              // The size of the file.
              if (file >= 5125) {
                  alert("File too Big, please select a file less than 5mb");
              }
          }
      }
console.log(up);
console.log(up.id);
      var ext = $('#'+up.id).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
          alert('Only gif png jpg jpeg Support');
      }
  }

  var validate = 1;
  $('#check').click(function() {

      var message = $('#message').val();
      if ($.trim(message) === '') {
          alert('Please Input Message');
          return;
      }

      var form = $('#support');
      var formdata = new FormData(form[0]);
      if (validate) {
          $.ajax({
              type: 'post',
              url: 'index.php?route=sale/support/editsupport&token=<?php echo $token;?>',
              data: formdata,
              cache: false,
              async: false,
              processData: false,
              contentType: false,
              beforeSend: function () {
                  validate = 0;
                  $('#check').attr("disabled", true);
                  $('#check').text("Sending");
              },
              success: function (json) {
                  if (json['state']) {
                      $time = $('#time').val();
                      $time ++;
                      $('#time').val($time);
                      $('#priority').text('In Progress');
                      validate = 1;
                      //_html = '<div class="alert alert-success"><i class="fa fa-check-circle"></i> Edit Ticket Success </div>';
                      //$('.breadcrumb').after(_html);
                      window.location.reload();
                  } else {
                      alert(json['message']);
                      $('#check').attr("disabled", false).text("Submit");
                      validate = 1;
                  }

              },
              complete: function () {
                  validate = 1;
                  $('#check').attr("disabled", false).text("Submit");
              },
              error: function () {
                  validate = 1;
                  $('#check').attr("disabled", false).text("Sending");

              }
          });
      }
  });
</script>
<?php echo $footer; ?>
