<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	class Franchise_constants {
		/***** Franchise Uri *****/

		const franchise_url 						= "franchise";
		const get_franchise_url 					= "get-franchise";
		const add_franchise_url 					= "add-franchise";
		const view_franchise_url 					= "view-franchise";
		const edit_franchise_url 					= "edit-franchise";
		const change_franchise_status_url 			= "change-franchise-status";
		const check_franchise_email_url 			= "franchise_check_unique_email";
		const check_franchise_mobile_url 			= "franchise_check_unique_mobile";

		const manage_kyc_url 						= "manage-kyc";
		const get_kyc_url 							= "get-kyc";
		const save_kyc_status_url 					= "save-kyc-status";
		const process_kyc_url 						= "process-kyc";
		const handle_kyc_url 						= "handle-kyc";
		const change_kyc_status_url 				= "change-kyc-status";

		const messages_url 							= "messages";
		const get_messages_url 						= "get-messages";
		const add_message_url 						= "add-message";
		const edit_message_url 						= "edit-message";
		const change_message_status_url 			= "change-message-status";
	}