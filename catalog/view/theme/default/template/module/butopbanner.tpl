<?php if($status) { ?>
<div class="row bu_top_banners">
	<?php
            $count  = count($butopbanner);
            if($count == 1)
            {
                $class = "col-lg-12 col-md-12 col-sm-12 col-xs-12 bu_top_custom_banner";
            }
            elseif($count == 2)
            {
                $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12 bu_top_custom_banner";
            }
            elseif($count == 3)
            {
                $class = "col-lg-4 col-md-4 col-sm-4 col-xs-12 bu_top_custom_banner";
            }
            elseif($count == 4)
            {
                $class = "col-lg-3 col-md-3 col-sm-6 col-xs-12 bu_top_custom_banner";
            }
            else
            {
                $class = "col-lg-2 col-md-2 col-sm-3 col-xs-12 bu_top_custom_banner";
            }
            foreach ($butopbanner as $key => $banner) { 
        ?>
        
        <div class="<?php echo $class; ?>">
            <div class="view">
                
                <?php if (isset($banner['link']) && $banner['link'] != '') { ?>
                <a class="top_banner_url" href="<?php echo $banner['link']; ?>"><img width="100%" class="top_banner_img main_img" src="<?php echo HTTPS_SERVER .'image/' . $banner['image']; ?>" alt="no image" /></a>
                <?php } else { ?>
                <a class="top_banner_url" href="#"><img width="100%" class="top_banner_img main_img" src="<?php echo HTTPS_SERVER .'image/' . $banner['image']; ?>" alt="no image" /></a>
                <?php } ?>
                
            </div>
        </div>
        <?php } ?>
</div>
<?php } ?>