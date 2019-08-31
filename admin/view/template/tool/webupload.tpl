<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $heading_title; ?></title>
    <link rel="stylesheet" type="text/css" href="view/javascript/webupload/css/webuploader.css" />
    <link rel="stylesheet" type="text/css" href="view/javascript/webupload/image-upload/style.css" />
</head>
<body>
    <div id="wrapper">
        <div id="container">
            <!--头部，相册选择和格式选择-->

            <div id="uploader">
                <div class="queueList">
                    <div id="dndArea" class="placeholder">
                        <div id="filePicker"></div>
                        <p>或将照片拖到这里，单次最多可选300张</p>
                    </div>
                </div>
                <div class="statusBar" style="display:none;">
                    <div class="progress">
                        <span class="text">0%</span>
                        <span class="percentage"></span>
                    </div><div class="info"></div>
                    <div class="btns">
                        <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      var order_id = <?php echo $order_id; ?>;
      var num = <?php echo $num; ?>;
      var fileupload = 'index.php?route=tool/webupload/upload&order_id=<?php echo $order_id; ?>&token=<?php echo $token; ?>';
      var preview = 'index.php?route=tool/webupload/preview&order_id=<?php echo $order_id; ?>&token=<?php echo $token; ?>';
      var catalog_preview = '<?php echo $catalog_preview_url; ?>';

       function changeOrder(order_id,$num){
           $.ajax({
		url: '<?php echo $catalog_url; ?>index.php?route=api/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
        async: true,
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent("<?php echo $upload_status_id; ?>") + '&notify=1&override=0&append=0' + '&comment=' + encodeURIComponent("<?php echo $message; ?>" + "&order_id="+order_id + "&num="+num ) + "&order_id="+order_id +"&qc_photo=1",
		success: function(json) {
         
		},
        complete: function(json){
           
        },
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
        }

    </script>
    <script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="view/javascript/webupload/dist/webuploader.js"></script>
    <script type="text/javascript" src="view/javascript/webupload/image-upload/upload.js"></script>

   
</body>
</html>
