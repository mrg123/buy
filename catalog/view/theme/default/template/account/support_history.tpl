<?php echo $header; ?>
<style type="text/css">
.list-unstyled li{ font-size:16px;line-height:25px;font-weight:600}
    #support-table{
        font-size:18px;
        text-align:center;
    }
    #support-table th{
        text-align:center;
    }
    #support-table td{
        font-size:16px;
    }
    a.blue{
      color: #3f94ff;
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

      <div class="col-md-12">
      <div class="panel panel-default">
        <?php if($support_rows){ ?>

        <div class="table-responsive">
          <table class="table" id="support-table">
            <thead>
            <tr>
              <th>Ticket ID</th>
              <th width="500">Subject</th>
              <th>Status</th>
              <th width="200">Last Updated</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($support_rows as $key => $item) { ?>
            <tr>
                <td>
                  <a href="<?php echo $item['url']; ?>"><b><?php echo $item['ticket_id'] ?><b></a>
                </td>
                <td>

                  <a href="<?php echo $item['url']; ?>" class="blue"> <?php echo $item['subject'] ?></a>

                </td>
                <td><?php echo $item['status'] ?></td>
                <td><?php echo $item['update_time'] ?></td>
            </tr>
            <?php } ?>

            <tr>

            </tr>

            </tbody>
          </table>
        </div>
        </div>

          <?php }else{ ?>
          <div class="table-responsive">
              <h3 style="text-align:center">No Ticket Data</h3>
          </div>
          <?php } ?>
      </div>
     
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
