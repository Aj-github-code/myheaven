<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifications
{
	private $error = array();
	function __construct()
	{
		$this->ci =& get_instance();
	}

	function sendSmsCurlCall($hostUrl){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $hostUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		//curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		$result = curl_exec($ch);
		return $result;
	}

	public function sendSms($smsData=[])
	{
		$response 		= ['error' => 1, 'message' => 'Access denied'];

		if(isset($smsData['mobile']) && !empty($smsData['mobile']))
		{
			$response 	= ['error' => 1, 'message' => 'Unable to send sms'];
			$user 		= $this->ci->config->item('sms')['user'];
			$apikey 	= $this->ci->config->item('sms')['apikey'];
			$senderid 	= $this->ci->config->item('sms')['senderid'];
			
	        $to 		= $smsData['mobile'];
	        $message 	= urlencode($smsData['sms']);

			$url 		= 'http://smshorizon.co.in/api/sendsms.php?user='.$user.'&apikey='.$apikey.'&mobile='.$to.'&message='.$message.'&senderid='.$senderid.'&type=txt'; // API URL

			$result 	= $this->sendSmsCurlCall($url);

			if(!empty($result))
			{
				$response 		= ['error' => 0, 'message' => 'Success'];
			}
			else
			{
				$response 		= ['error' => 1, 'message' => 'Unable to send sms'];
			}
		}
		return $response;
	}

	public function sendEmail($emailData=[])
	{
		$response = ['error' => 1, 'message' => 'Access denied'];

		$this->ci->load->library('email');
		if(isset($emailData['email']) && !empty($emailData['email']))
		{
			$this->ci->email->from($this->ci->config->item('no_reply'), $this->ci->config->item('email_from'));
			$this->ci->email->to($emailData['email']);
			$this->ci->email->subject($emailData['subject']);
			$this->ci->email->message($emailData['message']);

			if(isset($emailData['mailtype']) && $emailData['mailtype'] == 'html')
			{
				$this->ci->email->set_mailtype("html");
			}

			if(isset($emailData['attachment']) && !empty($emailData['attachment']))
			{
				$this->ci->email->attach($emailData['attachment']);
			}

			if($this->ci->email->send()){
				$response = ['error' => 0, 'message' => 'Success'];
			}else{
				$error_message = $this->ci->email->print_debugger();
				// foreach ($this->ci->email->get_debugger_messages() as $debugger_message) {
				// 	$separator = '';
				// 	if(!empty($error_message))
				// 	{
				// 		$separator = ', ';
				// 	}
				// 	$error_message .= $error_message.$separator.$debugger_message;
				// }

				$save_notification['from'] 			= $this->ci->config->item('notification_handlers')['system']; // SYSTEM
				$save_notification['from_user_id'] 	= $this->ci->config->item('default_system_id'); // SYSTEM ID
				$save_notification['to'] 			= $this->ci->config->item('notification_handlers')['superadmin']; // SUPERADMIN
				$save_notification['to_user_id'] 	= $this->ci->config->item('default_user_id'); // SUPERADMIN ID
				$save_notification['category'] 		= $this->ci->config->item('notification_categories')['email'];
				$save_notification['type'] 			= $this->ci->config->item('notification_types')['error'];
				$save_notification['priority_id'] 	= 1;
				$save_notification['subject'] 		= $this->ci->config->item('notification_subjects')['email_service_failure'];
				$save_notification['message'] 		= $error_message;
				$save_notification['response'] 		= NULL;
				$save_notification['image'] 		= NULL;
				$save_notification['is_read'] 		= 0;
				$save_notification['read_on'] 		= NULL;
				$save_notification['status'] 		= 1;
				$save_notification['created_on'] 	= date('Y-m-d H:i:s');
				$save_notification['modified_on'] 	= date('Y-m-d H:i:s');
				Modules::run("notification_management/generate/index", $save_notification);

				$response = ['error' => 1, 'message' => 'Unable to send an email'];
			}
		}
		return $response;
	}
}