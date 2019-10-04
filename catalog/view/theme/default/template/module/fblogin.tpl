

<div style="margin-bottom:10px">
	  <div id="fb-root"></div>
	  <fb:login-button scope="email" onlogin="validateAuth()" show-faces="false" width="200" max-rows="1"><?php echo $button_text; ?></fb:login-button>
</div>

<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
	  appId      : '<?php echo $app_id; ?>', // App ID
	  channelUrl : '//connect.facebook.net/en_US/all.js', // Channel File
	  status     : false, 
	  cookie     : true, 
	  xfbml      : true  
	});
};

function validateAuth() {
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected')  {
			auth();
		} else if (response.status === 'not_authorized') {
			authoriseLogin();
		} else {
			authoriseLogin();
		}
	});
}

function authoriseLogin() {
	FB.login(function(response){
		if(response.status == 'connected'){
			auth();
		}
	},{scope: 'email'});
}

// Load the SDK asynchronously
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function auth() {
	FB.api('/me?fields=email,first_name,last_name', function(response) {
		$.ajax({
			url: 'index.php?route=module/fblogin/auth',
			type: 'post',
			dataType: 'json',
			data: {firstname: response.first_name, lastname: response.last_name, email: response.email}, 	
			success: function(json) {
				if (json['reload']) {
					location = window.location.href;
				} else if (json['redirect']) {
					location = json['redirect'];
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
}

<?php if ($facebook_error) { ?>
alert('<?php echo addslashes($facebook_error); ?>');
<?php } ?>
</script>