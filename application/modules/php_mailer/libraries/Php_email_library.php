<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH.'modules/php_mailer/third_party/vendor/phpmailer/src/PHPMailer.php';
	require APPPATH.'modules/php_mailer/third_party/vendor/phpmailer/src/SMTP.php';
	require APPPATH.'modules/php_mailer/third_party/vendor/phpmailer/src/Exception.php';
	require APPPATH.'modules/php_mailer/third_party/vendor/autoload.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Php_email_library {
		private $mail;
		private $mail_config;
		public function __construct() {
			$this->CI 			= get_instance();
			$this->mail 		= new PHPMailer(true);
			$this->mail_config 	= [
									'send_from_name' 	=> 'myheavenmarketing',
									'send_from_email' 	=> 'info@myheavenmarketing.com',
									'email_secret' 		=> 'info123$123',
									'smtp_host' 		=> '162.222.225.153',
									'smtp_debug' 		=> 0, //SMTP::DEBUG_SERVER,
									'smtp_auth' 		=> true,
									'smtp_port' 		=> 587, //465,
									'smtp_secure' 		=> PHPMailer::ENCRYPTION_STARTTLS,
								];
		}

		function send($email_data)
		{
			$response 					= ['error' => 1, 'message' => 'Unable to send an email'];

			$to 						= isset($email_data['to']) ? $email_data['to'] : [];
			$cc 						= isset($email_data['cc']) ? $email_data['cc'] : [];
			$bcc 						= isset($email_data['bcc']) ? $email_data['bcc'] : [];
			$subject 					= isset($email_data['subject']) ? $email_data['subject'] : '';
			$message 					= isset($email_data['message']) ? $email_data['message'] : '';
			$altbody 					= isset($email_data['altbody']) ? $email_data['altbody'] : '';
			$attachments 				= isset($email_data['attachments']) ? $email_data['attachments'] : [];
			$html 						= isset($email_data['html']) ? $email_data['html'] : false;

			if(!empty($to))
			{
				try {
					$this->mail->SMTPDebug 		= $this->mail_config['smtp_debug'];
				    $this->mail->isSMTP();
				    $this->mail->Host       	= $this->mail_config['smtp_host'];
				    $this->mail->SMTPAuth   	= $this->mail_config['smtp_auth'];
				    $this->mail->Username   	= $this->mail_config['send_from_email'];
				    $this->mail->Password   	= $this->mail_config['email_secret'];
				    $this->mail->SMTPSecure 	= $this->mail_config['smtp_secure'];
				    $this->mail->Port       	= $this->mail_config['smtp_port'];

				    $this->mail->setFrom($this->mail_config['send_from_email'], $this->mail_config['send_from_name']);

				    // Send email to
				    foreach ($to as $key => $value) {
						$this->mail->addAddress($value['email'], $value['name']);
					}
					$this->mail->addReplyTo($this->mail_config['send_from_email'], $this->mail_config['send_from_name']);

				    // Send email to cc
				    if(!empty($cc))
				    {
				    	foreach ($cc as $key => $value) {
							$this->mail->addCC($value['email']);
						}
				    }

				    // Send email to bcc
				    if(!empty($bcc))
				    {
					    foreach ($bcc as $key => $value) {
							$this->mail->addBCC($value['email']);
						}
					}

				    // Send email attachments
				    if(!empty($attachments))
				    {
					    foreach ($attachments as $key => $value) {
					    	$this->mail->addAttachment($value['attachment']);
						}
					}

					$this->mail->isHTML($html);
				    $this->mail->Subject 		= $subject;
				    $this->mail->Body    		= $message;
				    
				    if(!empty($altbody))
				    {
				    	$this->mail->AltBody 	= $altbody;
				    }

				    $this->mail->send();
				    $response 			= ['error' => 0, 'message' => 'Email sent'];
				    return $response;
				} catch (Exception $e) {
				    echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";exit;
				}
			}
			return $response;
		}
	}