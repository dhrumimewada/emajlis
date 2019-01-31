<?php
function sendmail($to, $subject, $template_path){

	$CI = &get_instance();

    $config['protocol'] = $CI->config->item("protocol");
	$config['smtp_host'] = $CI->config->item("smtp_host");
	$config['smtp_port'] = $CI->config->item("smtp_port");
	$config['smtp_user'] = $CI->config->item("smtp_user");
	$config['smtp_pass'] = $CI->config->item("smtp_pass");
	$config['charset'] = $CI->config->item("charset");
	$config['mailtype'] = $CI->config->item("mailtype");
	$config['wordwrap'] = TRUE;

	$from = '"Emajlis" <excellentwebworld@admin.com>';
	$template = file_get_contents($template_path);


	$CI->load->library('email', $config);
	$CI->email->initialize($config);
	$CI->email->set_newline("\r\n");
	$CI->email->from($from);
	$CI->email->to($to);
	$CI->email->subject($subject);
	//$CI->email->message($message); 
	$CI->email->message($template); 
	$result = $CI->email->send();
	return $result;

}
?>