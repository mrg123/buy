<?php echo $header; ?>
<style type="text/css">
#support label{
  font-size:14px;
  font-weight:700;
}
  input[type="file"]{
    margin-top:10px;
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

      <div class="" id="batch-window">
        <div class="container-fluid">
          <form role="form" id="support" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="subject-group">
                  <label class="control-label" for="subject">Subject</label>
                  <input type="text" value="" name="subject" class="form-control" id="subject">
                </div>
                <div class="form-group">
                  <label class="control-label" for="order-id">Related Order</label>
                  <select name="order-id" id="order-id" class="form-control" style="width:200px">
                    <option value=""></option>
                    <?php foreach($orders as $key=>$item) { ?>
                      <option value="<?php echo $item['order_id']; ?>" > <?php echo $item['order_id']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="priority">Priority</label>
                  <select name="priority" id="priority" class="form-control" style="width:200px">
                    <option value="2">Medium</option>
                    <option value="1">Low</option>
                    <option value="3">High</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="message">Message</label>
                  <textarea name="message" class="form-control" id="message" rows="10"></textarea>
                </div>
                <div class="form-group" id="file-group">
                  <p id="size"></p>
                  <label class="control-label" for="file1">Attachments</label>
                  <input type="file" class="form-control-file btn-default" id="file1" name="file1" onchange="Filevalidation(this)">

                </div>
                <div class="form-group">
                  <a class="btn btn-default" id="add-more">Add More</a>
                </div>


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
     
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script type="text/javascript">
  $('#priority').change(function () {
      var val = $(this).val();
      console.log(val);
      if(val === '1'){
        $('#subject-group').css({
            color:"green"
        });
          $('#subject-group input').css({
              color:"green"
          });
      }
      if(val === '2'){
          $('#subject-group').css({
              color:"black"
          });
          $('#subject-group input').css({
              color:"black"
          });
      }
      if(val === '3'){
          $('#subject-group').css({
              color:"red"
          });
          $('#subject-group input').css({
              color:"red"
          });
      }
  });

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
      var order_id = $.trim($('#order-id').val());
      var subject = $('#subject').val();
      var message = $('#message').val();
      var priority = $('#priority').val();
      if ($.trim(subject) === '') {
          alert('Please Input Subject');
          return;
      }
      if (order_id === '') {
          alert('Please Choose Related Order');
          return;
      }
      if ($.trim(message) === '') {
          alert('Please Input Message');
          return;
      }

      var form = $('#support');
      var formdata = new FormData(form[0]);
      if (validate) {
          $.ajax({
              type: 'post',
              url: 'index.php?route=account/support/addsupport',
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
                    window.location.href='<?php echo $support;?>';
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
