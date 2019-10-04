<?php
include_once(DIR_SYSTEM."library/phpmailer/PHPMailerAutoload.php");
final class Mail {
	protected $to;
	protected $from;
	protected $sender;
	protected $reply_to;
	protected $subject;
	protected $text;
	protected $html;
	protected $attachments = array();
	public $protocol = 'mail';
	public $smtp_hostname;
	public $smtp_username;
	public $smtp_password;
	public $smtp_port = 25;
	public $smtp_timeout = 5;
	public $verp = FALSE;
	public $parameter = '';
	
	public function __construct($config = array()) {
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}

	public function setTo($to) {
		$this->to = $to;
	}
   
	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	public function setReplyTo($reply_to) {
		$this->reply_to = $reply_to;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setText($text) {
		$text = nl2br($text);
		$this->text = $text;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function addAttachment($filename) {
		$this->attachments[] = $filename;
	}
	
	public function send() {   
		if (!$this->to) {
			throw new \Exception('Error: E-Mail to required!');
		}
	
		if (!$this->from) {
			throw new \Exception('Error: E-Mail from required!');
		}
	
		if (!$this->sender) {
			throw new \Exception('Error: E-Mail sender required!');
		}
	
		if (!$this->subject) {
			throw new \Exception('Error: E-Mail subject required!');
		}
	
		if ((!$this->text) && (!$this->html)) {
			throw new \Exception('Error: E-Mail message required!');
		}
		
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}
		
		if ($this->protocol == 'smtp'&&$this->smtp_hostname&&$this->smtp_username) {
			if (!$this->html) {
				$message =$this->text;
			} else {
				$message = $this->html;
			}
			
			$mail  = new PHPMailer();
			$mail->IsSMTP();
			
			$mail->CharSet       = "utf-8";
			$mail->Host       = $this->smtp_hostname;
			$mail->Port       = $this->smtp_port;
			$mail->SMTPAuth       = true;
			$mail->Username       = $this->smtp_username;
			$mail->Password       = $this->smtp_password;
			
			$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				)
			);
			
			$mail->setFrom($this->from,$this->sender);
			$mail->AddReplyTo($this->from,$this->sender);
			$mail->Sender       = $this->smtp_username;
			$mail->From = $this->from;
			$mail->FromName = $this->sender;
			$mail->Subject = $this->subject;
			$mail->MsgHTML($message);
			
			foreach ($this->attachments as $attachment) {
				$mail->AddAttachment($attachment['file'],$attachment['filename']);
			}
			
			$to = explode(',',$to);
			foreach($to as $t){
				$mail->AddAddress($t);
			}
			
			
			$mail->Send();
		}else{
		
		$boundary = '----=_NextPart_' . md5(time());

		$header = 'MIME-Version: 1.0' . PHP_EOL;

		if ($this->protocol != 'mail') {
			$header .= 'To: <' . $to . '>' . PHP_EOL;
			$header .= 'Subject: =?UTF-8?B?' . base64_encode($this->subject) . '?=' . PHP_EOL;
		}

		$header .= 'Date: ' . date('D, d M Y H:i:s O') . PHP_EOL;
		$header .= 'From: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . PHP_EOL;
		
		if (!$this->reply_to) {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . PHP_EOL;
		} else {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->reply_to) . '?= <' . $this->reply_to . '>' . PHP_EOL;
		}
		
		$header .= 'Return-Path: ' . $this->from . PHP_EOL;
		$header .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
		$header .= 'Content-Type: multipart/related; boundary="' . $boundary . '"' . PHP_EOL . PHP_EOL;

		if (!$this->html) {
			$message  = '--' . $boundary . PHP_EOL;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;
			$message .= $this->text . PHP_EOL;
		} else {
			$message  = '--' . $boundary . PHP_EOL;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . PHP_EOL . PHP_EOL;
			$message .= '--' . $boundary . '_alt' . PHP_EOL;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;

			if ($this->text) {
				$message .= $this->text . PHP_EOL;
			} else {
				$message .= 'This is a HTML email and your email client software does not support HTML email!' . PHP_EOL;
			}

			$message .= '--' . $boundary . '_alt' . PHP_EOL;
			$message .= 'Content-Type: text/html; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;
			$message .= $this->html . PHP_EOL;
			$message .= '--' . $boundary . '_alt--' . PHP_EOL;
		}
		
		foreach ($this->attachments as $attachment) {
			if (file_exists($attachment)) {
				$handle = fopen($attachment, 'r');

				$content = fread($handle, filesize($attachment));

				fclose($handle);

				$message .= '--' . $boundary . PHP_EOL;
				$message .= 'Content-Type: application/octet-stream; name="' . basename($attachment) . '"' . PHP_EOL;
				$message .= 'Content-Transfer-Encoding: base64' . PHP_EOL;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment) . '"' . PHP_EOL;
				$message .= 'Content-ID: <' . basename(urlencode($attachment)) . '>' . PHP_EOL;
				$message .= 'X-Attachment-Id: ' . basename(urlencode($attachment)) . PHP_EOL . PHP_EOL;
				$message .= chunk_split(base64_encode($content));
			}
		}

		$message .= '--' . $boundary . '--' . PHP_EOL;
		
			ini_set('sendmail_from', $this->from);

			if ($this->parameter) {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
			} else {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
			}
			
		}
	}
}
?>