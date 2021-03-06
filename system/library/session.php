<?php
class Session {
	public $data = array();

	public function __construct($session_id = '',  $key = 'default') {
		if (!session_id()) {
			ini_set('session.use_only_cookies', 'Off');
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			ini_set('session.cookie_httponly', 'On');

			if (isset($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $_COOKIE[session_name()])) {
				exit();
			}

			if ($session_id) {
				session_id($session_id);
			}else{
			    /**  去除永久登录
				if(isset($_COOKIE['cart_session'])){
					session_id($_COOKIE['cart_session']);
				}
				*/
			}

			session_set_cookie_params(0, '/');
			session_start();
		}

		if (!isset($_SESSION[$key])) {
			$_SESSION[$key] = array();
		}

		$this->data =& $_SESSION[$key];
	}

	public function getId() {
	    /* 去除永久登录
		if(!isset($_COOKIE['cart_session'])){
			setcookie('cart_session', session_id(), time() + 31536000, '/');
		}
	    */
		return session_id();
	}

	public function start() {
		return session_start();
	}

	public function destroy() {
		return session_destroy();
	}
}
