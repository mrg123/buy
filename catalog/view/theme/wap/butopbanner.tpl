<?php if($status) { ?>
	<?php foreach ($butopbanner as $key => $banner) { ?>
        <div >
            <div class="view" style="margin-bottom:20px;">
                
                <?php if (isset($banner['link']) && $banner['link'] != '') { ?>
                <a class="top_banner_url" href="<?php echo $banner['link']; ?>"><img width="100%" class="top_banner_img main_img" src="<?php echo HTTPS_SERVER .'image/' . $banner['image']; ?>"/></a>
                <?php } else { ?>
                <a class="top_banner_url" href="#"><img width="100%" class="top_banner_img main_img" src="<?php echo HTTPS_SERVER .'image/' . $banner['image']; ?>" /></a>
                <?php } ?>
                
            </div>
        </div>
        <?php } ?>
<?php } ?>