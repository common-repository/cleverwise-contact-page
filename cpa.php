<?php
/*
* Copyright 2014 Jeremy O'Connell  (email : cwplugins@cyberws.com)
* License: GPL2 .:. http://opensource.org/licenses/GPL-2.0
*/

////////////////////////////////////////////////////////////////////////////
//	Verify admin panel is loaded, if not fail
////////////////////////////////////////////////////////////////////////////
if (!is_admin()) {
	die();
}

////////////////////////////////////////////////////////////////////////////
//	Menu call
////////////////////////////////////////////////////////////////////////////
add_action('admin_menu', 'cw_contact_page_aside_mn');

////////////////////////////////////////////////////////////////////////////
//	Load admin menu option
////////////////////////////////////////////////////////////////////////////
function cw_contact_page_aside_mn() {
	add_submenu_page('options-general.php','Contact Page Panel','Contact Page','manage_options','cw-contact-page','cw_contact_page_aside');
}

////////////////////////////////////////////////////////////////////////////
//	Load admin functions
////////////////////////////////////////////////////////////////////////////
function cw_contact_page_aside() {
Global $wpdb,$cp_wp_option,$cwfa_cp;

	////////////////////////////////////////////////////////////////////////////
	//	Load options for plugin
	////////////////////////////////////////////////////////////////////////////
	$cp_wp_option_array=get_option($cp_wp_option);
	$cp_wp_option_array=unserialize($cp_wp_option_array);

	////////////////////////////////////////////////////////////////////////////
	//	Set action value
	////////////////////////////////////////////////////////////////////////////
	if (isset($_REQUEST['cw_action'])) {
		$cw_action=$_REQUEST['cw_action'];
	} else {
		$cw_action='main';
	}

	////////////////////////////////////////////////////////////////////////////
	//	Previous page link
	////////////////////////////////////////////////////////////////////////////
	$pplink='<a href="javascript:history.go(-1);">Return to previous page...</a>';

	////////////////////////////////////////////////////////////////////////////
	//	Define Variables
	////////////////////////////////////////////////////////////////////////////
	$cw_contact_page_action='';
	$cw_contact_page_html='';

	$cp_frm_title_def='Web Contact Form';
	$cp_frm_email_def='Your Email';
	$cp_frm_name_def='Your Name';
	$cp_frm_topic_def='Pick A Topic';
	$cp_frm_comments_def='Enter Comments';
	$cp_frm_submit_def='Send Message';
	$cp_frm_captcha_def='Check The I\'m Not A Robot Box';
	$cp_frm_css_text_def='s';
	$cp_frm_css_select_def='s';
	$cp_frm_css_submit_def='submit';
	$cp_error_fields_msg_def='Oops! Please fill out the following information:';
	$cp_error_technical_msg_def='This is embarrassing but a technical error has occurred!';
	$cp_error_layout_def='<div style="padding: 0px; margin: 10px auto 20px auto; border: 1px solid #ef6363; background-color: #fce4e4; font-family: tahoma; font-size: 14px; -moz-border-radius: 5px; border-radius: 5px; text-align: center;"><div style="padding: 5px;">{{error}}</div></div>';
	$cp_success_layout_def='<div style="padding: 0px; margin: 10px auto 20px auto; border: 1px solid #96b751; background-color: #e0eacc; font-family: tahoma; font-size: 14px; -moz-border-radius: 5px; border-radius: 5px; text-align: center;"><div style="padding: 5px;">Success! Your message has been sent.  If necessary we will reply shortly.  Thank you!</div></div>';
	$cp_frm_info_layout_def='{{organization}}{{address}}{{hours}}{{email}}{{phone}}{{fax}}';

	////////////////////////////////////////////////////////////////////////////
	//	Language & Layouts
	////////////////////////////////////////////////////////////////////////////
	if ($cw_action == 'llsettings') {
		$cw_contact_page_action='Language & Layouts';

		$cp_frm_title=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_title']);
		$cp_frm_email=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_email']);
		$cp_frm_name=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_name']);
		$cp_frm_topic=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_topic']);
		$cp_frm_comments=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_comments']);
		$cp_frm_submit=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_submit']);
		$cp_frm_captcha=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_captcha']);
		$cp_frm_css_text=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_css_text']);
		$cp_frm_css_select=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_css_select']);
		$cp_frm_css_submit=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_css_submit']);
		$cp_error_fields_msg=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_error_fields_msg']);
		$cp_error_technical_msg=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_error_technical_msg']);
		$cp_error_layout=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_error_layout']);
		$cp_success_layout=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_success_layout']);
		$cp_frm_info_layout=$cwfa_cp->cwf_fmt_striptrim($cp_wp_option_array['cp_frm_info_layout']);

		if (!$cp_frm_title) {
			$cp_frm_title=$cp_frm_title_def;
		}
		if (!$cp_frm_email) {
			$cp_frm_email=$cp_frm_email_def;
		}
		if (!$cp_frm_name) {
			$cp_frm_name=$cp_frm_name_def;
		}
		if (!$cp_frm_topic) {
			$cp_frm_topic=$cp_frm_topic_def;
		}
		if (!$cp_frm_comments) {
			$cp_frm_comments=$cp_frm_comments_def;
		}
		if (!$cp_frm_submit) {
			$cp_frm_submit=$cp_frm_submit_def;
		}
		if (!$cp_frm_captcha) {
			$cp_frm_captcha=$cp_frm_captcha_def;
		}

		if (!$cp_frm_css_text) {
			$cp_frm_css_text=$cp_frm_css_text_def;
		}
		if (!$cp_frm_css_select) {
			$cp_frm_css_select=$cp_frm_css_select_def;
		}
		if (!$cp_frm_css_submit) {
			$cp_frm_css_submit=$cp_frm_css_submit_def;
		}

		if (!$cp_error_fields_msg) {
			$cp_error_fields_msg=$cp_error_fields_msg_def;
		}
		if (!$cp_error_technical_msg) {
			$cp_error_technical_msg=$cp_error_technical_msg_def;
		}
		if (!$cp_error_layout) {
			$cp_error_layout=$cp_error_layout_def;
		}
		if (!$cp_success_layout) {
			$cp_success_layout=$cp_success_layout_def;
		}
		if (!$cp_frm_info_layout) {
			$cp_frm_info_layout=preg_replace('/}}/',"}}\n",$cp_frm_info_layout_def);
		}

$cw_contact_page_html .=<<<EOM
<script>
function disp_form() {
	document.getElementById('disp_form').style.display='';
	document.getElementById('disp_layout').style.display='none';
}
function disp_layout() {
	document.getElementById('disp_form').style.display='none';
	document.getElementById('disp_layout').style.display='';
}
</script>
<p>Note: Enter <b>default</b> in any block to have system load original setting.</p>
<p>View: <a href="javascript:void(0);" onclick="disp_form();">Form Language</a>  |  <a href="javascript:void(0);" onclick="disp_layout();">Layouts</a></p>
<form method="post" style="margin: 0px; padding: 0px;">
<input type="hidden" name="cw_action" value="llsettingsv">
<div id="disp_form" name="disp_form">
<p><b>Form Language:</b></p>
<div style="margin-left: 20px;"><p>Note: You may alter the CSS classes used by the form.</p></div>
<p>Form Title: <input type="text" name="cp_frm_title" value="$cp_frm_title" style="width: 300px;"></p>
<p>Your Email: <input type="text" name="cp_frm_email" value="$cp_frm_email" style="width: 300px;"></p>
<p>Your Name: <input type="text" name="cp_frm_name" value="$cp_frm_name" style="width: 300px;"></p>
<p>Pick A Topic: <input type="text" name="cp_frm_topic" value="$cp_frm_topic" style="width: 300px;"></p>
<p>Enter Comments: <input type="text" name="cp_frm_comments" value="$cp_frm_comments" style="width: 300px;"></p>
<p>Submit Button: <input type="text" name="cp_frm_submit" value="$cp_frm_submit" style="width: 300px;"></p>
<p>Captcha Error: <input type="text" name="cp_frm_captcha" value="$cp_frm_captcha" style="width: 300px;"></p>
</div>
<div id="disp_layout" name="disp_layout" style="display: none;">
<p><b>Layouts:</b></p>
<p><b>Web Form CSS:</b></p>
<p>Textbox CSS class: <input type="text" name="cp_frm_css_text" value="$cp_frm_css_text" style="width: 100px;"></p>
<p>Select CSS class: <input type="text" name="cp_frm_css_select" value="$cp_frm_css_select" style="width: 100px;"></p>
<p>Submit CSS class: <input type="text" name="cp_frm_css_submit" value="$cp_frm_css_submit" style="width: 100px;"></p>
<p><b>Error Screen:</b></p>
<p>Missing Fields: <input type="text" name="cp_error_fields_msg" value="$cp_error_fields_msg" style="width: 300px;"></p>
<p>Technical Error: <input type="text" name="cp_error_technical_msg" value="$cp_error_technical_msg" style="width: 300px;"></p>
<p>HTML:<div style="margin-left: 20px;">{{error}} = Insert </div></p>
<p><textarea name="cp_error_layout" style="width: 400px; height: 300px;">$cp_error_layout</textarea></p>
<p><b>Success Screen HTML:</b></p>
<p><textarea name="cp_success_layout" style="width: 400px; height: 300px;">$cp_success_layout</textarea></p>
<p><b>Contact Page Layout Order:</b><div style="margin-left: 20px;">{{organization}} = Inserts organization name<br>{{address}} = Inserts addresses<br>{{hours}} = Inserts hours<br>{{email}} = Inserts email addresses<br>{{phone}} = Inserts phone numbers<br>{{fax}} = Inserts fax numbers</div></p>
<p><textarea name="cp_frm_info_layout" style="width: 400px; height: 150px;">$cp_frm_info_layout</textarea></p>
</div>
</font>
<p><input type="submit" value="Save" class="button"></p>
</form>
EOM;

	////////////////////////////////////////////////////////////////////////////
	//	Language & Layouts Save
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'llsettingsv') {
		$cp_frm_title=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_title']);
		$cp_frm_email=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_email']);
		$cp_frm_name=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_name']);
		$cp_frm_topic=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_topic']);
		$cp_frm_comments=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_comments']);
		$cp_frm_submit=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_submit']);
		$cp_frm_captcha=$cwfa_cp->cwf_san_all($_REQUEST['cp_frm_captcha']);
		$cp_frm_css_text=$cwfa_cp->cwf_san_alls($_REQUEST['cp_frm_css_text']);
		$cp_frm_css_select=$cwfa_cp->cwf_san_alls($_REQUEST['cp_frm_css_select']);
		$cp_frm_css_submit=$cwfa_cp->cwf_san_alls($_REQUEST['cp_frm_css_submit']);
		$cp_error_fields_msg=$cwfa_cp->cwf_san_alls($_REQUEST['cp_error_fields_msg']);
		$cp_error_technical_msg=$cwfa_cp->cwf_san_alls($_REQUEST['cp_error_technical_msg']);
		$cp_error_layout=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_error_layout']);
		$cp_success_layout=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_success_layout']);
		$cp_frm_info_layout=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_frm_info_layout']);
		
		$error='';

		if (!$cp_frm_title) {
				$error .='<li>No Form Title Text</li>';
		}
		if ($cp_frm_title == 'default') {
			$cp_frm_title=$cp_frm_title_def;
		}

		if (!$cp_frm_email) {
				$error .='<li>No Your Email Text</li>';
		}
		if ($cp_frm_email == 'default') {
			$cp_frm_email=$cp_frm_email_def;
		}

		if (!$cp_frm_name) {
				$error .='<li>No Your Name Text</li>';
		}
		if ($cp_frm_name == 'default') {
			$cp_frm_name=$cp_frm_name_def;
		}

		if (!$cp_frm_topic) {
				$error .='<li>No Pick A Topic Text</li>';
		}
		if ($cp_frm_topic == 'default') {
			$cp_frm_topic=$cp_frm_topic_def;
		}

		if (!$cp_frm_comments) {
				$error .='<li>No Enter Comments Text</li>';
		}
		if ($cp_frm_comments == 'default') {
			$cp_frm_comments=$cp_frm_comments_def;
		}

		if (!$cp_frm_submit) {
				$error .='<li>No Submit Button Text</li>';
		}
		if ($cp_frm_submit == 'default') {
			$cp_frm_submit=$cp_frm_submit_def;
		}
		
		if (!$cp_frm_captcha) {
				$error .='<li>No Captcha Error Text</li>';
		}
		if ($cp_frm_captcha == 'default') {
			$cp_frm_captcha=$cp_frm_captcha_def;
		}

		if (!$cp_frm_css_text) {
			$cp_frm_css_text=$cp_frm_css_text_def;
		}
		if (!$cp_frm_css_select) {
			$cp_frm_css_select=$cp_frm_css_select_def;
		}
		if (!$cp_frm_css_submit) {
			$cp_frm_css_submit=$cp_frm_css_submit_def;
		}

		if (!$cp_error_fields_msg) {
				$error .='<li>No Missing Fields Text</li>';
		}
		if ($cp_error_fields_msg == 'default') {
			$cp_error_fields_msg=$cp_error_fields_msg_def;
		}

		if (!$cp_error_technical_msg) {
				$error .='<li>No Technical Error Text</li>';
		}
		if ($cp_error_technical_msg == 'default') {
			$cp_error_technical_msg=$cp_error_technical_msg_def;
		}
		if (!$cp_error_layout) {
				$error .='<li>No Error Screen HTML</li>';
		}
		if ($cp_error_layout == 'default') {
			$cp_error_layout=$cp_error_layout_def;
		}

		if (!$cp_success_layout) {
				$error .='<li>No Success Screen HTML</li>';
		}
		if ($cp_success_layout == 'default') {
			$cp_success_layout=$cp_success_layout_def;
		}

		if (!$cp_frm_info_layout) {
				$error .='<li>No Contact Page Layout Order</li>';
		}
		if ($cp_frm_info_layout == 'default') {
			$cp_frm_info_layout=$cp_frm_info_layout_def;
		}
		$cp_frm_info_layout=preg_replace("/\n/",'',$cp_frm_info_layout);

		if ($error) {
			$cw_contact_page_action='Error';
			$cw_contact_page_html='Please fix the following in order to save settings:<br><ul style="list-style: disc; margin-left: 25px;">'. $error .'</ul>'.$pplink;
		} else {
			$cw_contact_page_action='Success';

			$cp_wp_option_array['cp_frm_title']=$cp_frm_title;
			$cp_wp_option_array['cp_frm_email']=$cp_frm_email;
			$cp_wp_option_array['cp_frm_name']=$cp_frm_name;
			$cp_wp_option_array['cp_frm_topic']=$cp_frm_topic;
			$cp_wp_option_array['cp_frm_comments']=$cp_frm_comments;
			$cp_wp_option_array['cp_frm_submit']=$cp_frm_submit;
			$cp_wp_option_array['cp_frm_captcha']=$cp_frm_captcha;
			$cp_wp_option_array['cp_frm_css_text']=$cp_frm_css_text;
			$cp_wp_option_array['cp_frm_css_select']=$cp_frm_css_select;
			$cp_wp_option_array['cp_frm_css_submit']=$cp_frm_css_submit;
			$cp_wp_option_array['cp_error_fields_msg']=$cp_error_fields_msg;
			$cp_wp_option_array['cp_error_technical_msg']=$cp_error_technical_msg;
			$cp_wp_option_array['cp_error_layout']=$cp_error_layout;
			$cp_wp_option_array['cp_success_layout']=$cp_success_layout;
			$cp_wp_option_array['cp_frm_info_layout']=$cp_frm_info_layout;

			$cp_wp_option_array=serialize($cp_wp_option_array);
			$cp_wp_option_chk=get_option($cp_wp_option);

			if (!$cp_wp_option_chk) {
				add_option($cp_wp_option,$cp_wp_option_array);
			} else {
				update_option($cp_wp_option,$cp_wp_option_array);
			}

			$cw_contact_page_html='<p>Language & Layouts information has been successfully saved!</p><p><a href="?page=cw-contact-page&cw_action=mainpanel">Continue</a></p>';
		}

	////////////////////////////////////////////////////////////////////////////
	//	Mail Account & Anti-Spam
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'masettings') {
		$cw_contact_page_action='Mail Settings & Anti-Spam';

		$cp_mail_server=$cp_wp_option_array['cp_mail_server'];
		$cp_mail_port=$cp_wp_option_array['cp_mail_port'];
		$cp_mail_conn_type=$cp_wp_option_array['cp_mail_conn_type'];
		$cp_mail_email=$cp_wp_option_array['cp_mail_email'];
		$cp_mail_passwd=$cp_wp_option_array['cp_mail_passwd'];
		$cp_frm_topic_box=$cp_wp_option_array['cp_frm_topic_box'];
		$cp_frm_honeypot=$cp_wp_option_array['cp_frm_honeypot'];
		$cp_google_recaptcha_site_key=$cp_wp_option_array['cp_google_recaptcha_site_key'];
		$cp_google_recaptcha_secret_key=$cp_wp_option_array['cp_google_recaptcha_secret_key'];
		
		if (!$cp_mail_port) {
			$cp_mail_port='25';
		}
		if (!$cp_mail_conn_type) {
			$cp_mail_conn_type='standard';
		}

		$cp_mail_conn_type_options=array('standard','ssl','tls');
		$cp_mail_conn_type_list='';
		foreach ($cp_mail_conn_type_options as $cp_mail_conn_type_option) {
			$cp_mail_conn_type_list .='<option value="'.$cp_mail_conn_type_option.'"';
			if ($cp_mail_conn_type_option == $cp_mail_conn_type) {
				$cp_mail_conn_type_list .=' selected';
			}
			$cp_mail_conn_type_list .='>'.$cp_mail_conn_type_option.'</option>';
		}

$cw_contact_page_html .=<<<EOM
<script>
function disp_server() {
	document.getElementById('disp_server').style.display='';
	document.getElementById('disp_email').style.display='none';
	document.getElementById('disp_spam').style.display='none';
}
function disp_email() {
	document.getElementById('disp_server').style.display='none';
	document.getElementById('disp_email').style.display='';
	document.getElementById('disp_spam').style.display='none';
}
function disp_spam() {
	document.getElementById('disp_server').style.display='none';
	document.getElementById('disp_email').style.display='none';
	document.getElementById('disp_spam').style.display='';
}
</script>
<p>View: <a href="javascript:void(0);" onclick="disp_server();">Mail Server Information</a>  |  <a href="javascript:void(0);" onclick="disp_email();">E-mail Account Information</a>  |  <a href="javascript:void(0);" onclick="disp_spam();">Anti-Spam Settings</a></p>
<form method="post" style="margin: 0px; padding: 0px;">
<input type="hidden" name="cw_action" value="masettingsv">
<div id="disp_server" name="disp_server">
<p><b>Mail Server Information:</b><div style="margin-left: 20px;">You need to enter your mail server (SMTP) information.  The server address may be an IP or subdomain.</div></p>
<p>Server Address: <input type="text" name="cp_mail_server" value="$cp_mail_server" style="width: 300px;"></p>
<p>Server Port: <input type="text" name="cp_mail_port" value="$cp_mail_port" style="width: 100px;"></p>
<p>Server Connection: <select name="cp_mail_conn_type">$cp_mail_conn_type_list</select></p>
</div>
<div id="disp_email" name="disp_email" style="display: none;">
<p><b>E-mail Account Information:</b><div style="margin-left: 20px;">You need to enter an email address that will be used as the from address.  It must be accessible from the mail server listed in these settings.</div></p>
<p>E-mail Address: <input type="text" name="cp_mail_email" value="$cp_mail_email" style="width: 300px;"></p>
<p>E-mail Password: <input type="password" name="cp_mail_passwd" value="$cp_mail_passwd" style="width: 300px;"></p>
</div>
<div id="disp_spam" name="disp_spam" style="display: none;">
<p><b>Anti-Spam Settings:</b><div style="margin-left: 20px;">These are form value names that trip up SPAM bots.  If you start having SPAM issues simply regenerate these values by deleting the current information and saving this form.</div></p>
<p>Topic Box Name: <input type="text" name="cp_frm_topic_box" value="$cp_frm_topic_box" style="width: 200px;"></p>
<p>Spam Honeypot: <input type="text" name="cp_frm_honeypot" value="$cp_frm_honeypot" style="width: 200px;"></p>

<p><b>Optional:</b> Google reCAPTCHA</p>

<p>This plugin supports Google's reCAPTCHA system.  You'll need to signup for an API key using a Google account (both are free) at <a href="https://www.google.com/recaptcha/admin#site/" target="_blank">https://www.google.com/recaptcha/admin#site/</a> (New window).</p>

<p>Site Key: <input type="text" name="cp_google_recaptcha_site_key" value="$cp_google_recaptcha_site_key" style="width: 300px;"></p>
<p>Secret Key: <input type="text" name="cp_google_recaptcha_secret_key" value="$cp_google_recaptcha_secret_key" style="width: 300px;"></p>

</div>
<p><input type="submit" value="Save" class="button"></p>
</form>
EOM;

	////////////////////////////////////////////////////////////////////////////
	//	Mail Account & Anti-Spam Save
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'masettingsv') {
		$cp_mail_server=$cwfa_cp->cwf_san_all($_REQUEST['cp_mail_server']);
		$cp_mail_port=$cwfa_cp->cwf_san_int($_REQUEST['cp_mail_port']);
		$cp_mail_conn_type=$cwfa_cp->cwf_san_an($_REQUEST['cp_mail_conn_type']);
		$cp_mail_email=$cwfa_cp->cwf_san_all($_REQUEST['cp_mail_email']);
		$cp_mail_passwd=$cwfa_cp->cwf_san_all($_REQUEST['cp_mail_passwd']);
		$cp_frm_topic_box=$cwfa_cp->cwf_san_an($_REQUEST['cp_frm_topic_box']);
		$cp_frm_honeypot=$cwfa_cp->cwf_san_an($_REQUEST['cp_frm_honeypot']);
		$cp_google_recaptcha_site_key=$cwfa_cp->cwf_san_filename($_REQUEST['cp_google_recaptcha_site_key']);
		$cp_google_recaptcha_secret_key=$cwfa_cp->cwf_san_filename($_REQUEST['cp_google_recaptcha_secret_key']);
		
		$error='';

		if (!$cp_mail_server) {
			$error .='<li>No Server Address</li>';
		}

		if (!$cp_mail_server) {
			$error .='<li>No Server Port</li>';
		}

		if (!$cp_mail_email) {
			$error .='<li>No E-mail Address</li>';
		}

		if (!$cp_mail_passwd) {
			$error .='<li>No E-mail Password</li>';
		}

		if ($error) {
			$cw_contact_page_action='Error';
			$cw_contact_page_html='Please fix the following in order to save settings:<br><ul style="list-style: disc; margin-left: 25px;">'. $error .'</ul>'.$pplink;
		} else {
			$cw_contact_page_action='Success';

			$cp_random_num=mt_rand(15,30);

			if (!$cp_frm_topic_box) {
				$cp_frm_topic_box=$cwfa_cp->cwf_gen_randstr($cp_random_num);
			}

			if (!$cp_frm_honeypot) {
				$cp_frm_honeypot=$cwfa_cp->cwf_gen_randstr($cp_random_num);
			}

			$cp_wp_option_array['cp_mail_server']=$cp_mail_server;
			$cp_wp_option_array['cp_mail_port']=$cp_mail_port;
			$cp_wp_option_array['cp_mail_conn_type']=$cp_mail_conn_type;
			$cp_wp_option_array['cp_mail_email']=$cp_mail_email;
			$cp_wp_option_array['cp_mail_passwd']=$cp_mail_passwd;
			$cp_wp_option_array['cp_frm_topic_box']=$cp_frm_topic_box;
			$cp_wp_option_array['cp_frm_honeypot']=$cp_frm_honeypot;
			$cp_wp_option_array['cp_google_recaptcha_site_key']=$cp_google_recaptcha_site_key;
			$cp_wp_option_array['cp_google_recaptcha_secret_key']=$cp_google_recaptcha_secret_key;

			$cp_wp_option_array=serialize($cp_wp_option_array);
			$cp_wp_option_chk=get_option($cp_wp_option);

			if (!$cp_wp_option_chk) {
				add_option($cp_wp_option,$cp_wp_option_array);
			} else {
				update_option($cp_wp_option,$cp_wp_option_array);
			}

			$cw_contact_page_html='<p>Mail Settings & Anti-Spam information has been successfully saved!</p><p><a href="?page=cw-contact-page&cw_action=mainpanel">Continue</a></p>';
		}

	////////////////////////////////////////////////////////////////////////////
	//	What Is New?
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'settingsnew') {
		$cw_contact_page_action='What Is New?';

		$cw_contact_page_whats_new=array(
			'2.4'=>'All SSL certificates now supported including self signed|Altered code for loading mailing library',
			'2.2'=>'Updated key library location that changed with WP 5.5',
			'2.0'=>'Fixed minor notice errors|Theme Changes',
			'1.8'=>'Minor theme changes',
			'1.7.1'=>'Fixed 1.7 removal files.',
			'1.7'=>'Forced update by WordPress to remove PHPMailer libraries despite patching security flaws weeks ahead of core.',
			'1.6'=>'Another update to PHPMailer libraries to fix continuing security flaws',
			'1.5'=>'Updated PHPMailer libraries due to security bug',
			'1.4'=>'Altered the way Google\'s reCAPTCHA keys are handled',
			'1.3'=>'Now supports Google\'s reCAPTCHA program for enhanced anti-spam|Added site name to email to help with those maintaining multiple sites at same email address|Fixed: Clearing of user typed data in form when reselecting',
			'1.2'=>'Background edits to eliminate some PHP notice messages',
			'1.1'=>'Fixed: Backslash was appearing when certain characters were used.',
			'1.0'=>'Initial release of plugin'
		);
		$cw_contact_page_whats_new_build='';
		foreach ($cw_contact_page_whats_new as $cw_contact_page_whats_new_version => $cw_contact_page_whats_new_news) {
			$cw_contact_page_whats_new_build .='<p>Version: <b>'.$cw_contact_page_whats_new_version.'</b></p>';
			$cw_contact_page_whats_new_news=preg_replace('/\|/','</li><li>',$cw_contact_page_whats_new_news);
			$cw_contact_page_whats_new_build .='<ul style="list-style: disc; margin-left: 25px;"><li>'.$cw_contact_page_whats_new_news.'</li></ul>';
		}

$cw_contact_page_html .=<<<EOM
<p>The following lists the new changes from version-to-version.</p>
$cw_contact_page_whats_new_build
EOM;

	////////////////////////////////////////////////////////////////////////////
	//	Help Guide
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'settingshelp') {
		$cw_contact_page_action='Help Guide';

$cw_contact_page_html .=<<<EOM
<div style="margin: 10px 0px 5px 0px; width: 400px; border-bottom: 1px solid #c16a2b; padding-bottom: 5px; font-weight: bold;">Introduction:</div>
<p>This system allows you to easily display a structured contact page complete with web form.  You are able to add unlimited topics to the drop down list in the web form that may be emailed to different addresses.  All this is done with anti-bot technology baked in.  Plus you have control over what information is displayed to your visitors, including the order.  In addition you are able to modify the text displayed to your visitors along with the ability to alter the theming.  Finally the code generated by this plugin is mobile ready using responsive design.</p>
<p>Steps:</p>
<ol>
<li>On the main screen you will find the various blocks of information such as your organization's name, web contact form topics, physical addresses, email addresses, hours, phone number(s), and fax number(s) along with some check boxes to capture visitors' ip and/or agent. You may use HTML code in all blocks short of the checkboxes.  When you are done editing the information click on the <b>Save</b> button.
<div style="margin: 10px 0px 0px 20px;">
Let's review a few key points:
<ol style="margin-top: 5px;">
<li>You are able to remove blocks of information from appearing on the contact page in the <b>Language & Layouts</b> link.</li>
<li>Email addresses in the web form will not be displayed in the code or anywhere on the page.  This will prevent bots from grabbing your email addresses.</li>
<li>In the email block section where you can display email addresses of your choosing you should use the noted code to better protect them.  The technique works by changing your addresses into ASCII code, which most bots don't read.</li>
<li>The checkboxes allow you to include additional information from your visitors when they submit their messages.  This includes their IP and agent.  If you aren't familiar with agent this means their operating system (Windows, Mac, Linux, etc), the current browser along with version (Internet Explorer, Chrome, Opera, etc), and some other key information.</li>
</ol>
</div>
</li>
<li><p>Now click on the link called <b>Mail Settings & Anti-Spam</b> which is where you setup your sending email account and server along with the Anti-Spam/Bot settings.  The Anti-Spam settings work by creating unique values for your Wordpress site.  The first block generates the field name for the topics list.  If this section is left blank then no message will be sent.  The second block generates what is called a honeypot.  This field must be left blank.  Since many bots will generate a value for every field their submission will fail.  All of this is transparent to your visitors and requires no annoying captchas.  Finally there are two optional fields for the Google reCAPTCHA program.  If you fill out both the site and security keys this will enable Google's just click I am not a bot box.  So once again no annoying hard to read captcha images.  You'll need to signup for a free API key which the link is provided on the page.  Also if you wish to remove Google's reCAPTCHA simply delete the site and secret keys and save. If you are upgrading from version 1.2 or earlier make sure you visit the <b>Language & Layouts</b> section and click Save to add in the new captcha error text.</p></li>
<li><p>Next click on the link titled <b>Language & Layouts</b>.  This is where you alter the language displayed in the web form along with the layouts which include the form errors messages, form success message, and which information is displayed and its order.</p>
<li>Finally add the shortcode <b>[cw_contact_page]</b> to your page(s)/post(s) where you wish the form to be displayed.  It is highly recommended you use a page over a post.  Obviously you may add additional information before and/or after the shortcode as desired.</li>
</ol>
EOM;

	////////////////////////////////////////////////////////////////////////////
	//	Settings Save
	////////////////////////////////////////////////////////////////////////////
	} elseif ($cw_action == 'settingsv') {
		$cp_organization=$cwfa_cp->cwf_san_all($_REQUEST['cp_organization']);
		$cp_topics=$cwfa_cp->cwf_fmt_striptrim(strip_tags($_REQUEST['cp_topics']));
		$cp_address=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_address']);
		$cp_email=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_email']);
		$cp_hours=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_hours']);
		$cp_phone=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_phone']);
		$cp_fax=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_fax']);
		$cp_inc_ip=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_inc_ip']);
		$cp_inc_agent=$cwfa_cp->cwf_fmt_striptrim($_REQUEST['cp_inc_agent']);

		$error='';

		if (!$cp_organization) {
			$error .='<li>No Organization Name</li>';
		}
		if (!$cp_topics) {
			$error .='<li>No Web Contact Form Topics</li>';
		} else {
			if (substr_count($cp_topics,'@') == '0' or substr_count($cp_topics,'.') == '0' or substr_count($cp_topics,'|') == '0') {
				$error .='<li>No Invalid Web Contact Form Topics</li>';
			}
		}

		if ($error) {
			$cw_contact_page_action='Error';
			$cw_contact_page_html='Please fix the following in order to save settings:<br><ul style="list-style: disc; margin-left: 25px;">'. $error .'</ul>'.$pplink;
		} else {
			$cw_contact_page_action='Success';

			//	Save information
			$cp_wp_option_array['cp_organization']=$cp_organization;
			$cp_wp_option_array['cp_topics']=$cp_topics;
			$cp_wp_option_array['cp_address']=$cp_address;
			$cp_wp_option_array['cp_email']=$cp_email;
			$cp_wp_option_array['cp_hours']=$cp_hours;
			$cp_wp_option_array['cp_phone']=$cp_phone;
			$cp_wp_option_array['cp_fax']=$cp_fax;
			$cp_wp_option_array['cp_inc_ip']=$cp_inc_ip;
			$cp_wp_option_array['cp_inc_agent']=$cp_inc_agent;

			$cp_wp_option_array=serialize($cp_wp_option_array);
			$cp_wp_option_chk=get_option($cp_wp_option);

			if (!$cp_wp_option_chk) {
				add_option($cp_wp_option,$cp_wp_option_array);
			} else {
				update_option($cp_wp_option,$cp_wp_option_array);
			}

			$cw_contact_page_html='<p>Information has been successfully saved!</p><p><a href="?page=cw-contact-page&cw_action=mainpanel">Continue</a></p>';
		}

	////////////////////////////////////////////////////////////////////////////
	//	Main panel
	////////////////////////////////////////////////////////////////////////////
	} else {
		$cp_inc_ip_status='';
		$cp_inc_agent_status='';

		$cp_ascii_status='Off - Your host must enable mbstring in PHP';
		if (function_exists('mb_convert_encoding')) {
			$cp_ascii_status='On';
		}

		$cp_organization=stripslashes($cp_wp_option_array['cp_organization']);
		$cp_topics=stripslashes($cp_wp_option_array['cp_topics']);
		$cp_address=stripslashes($cp_wp_option_array['cp_address']);
		$cp_email=stripslashes($cp_wp_option_array['cp_email']);
		$cp_hours=stripslashes($cp_wp_option_array['cp_hours']);
		$cp_phone=stripslashes($cp_wp_option_array['cp_phone']);
		$cp_fax=stripslashes($cp_wp_option_array['cp_fax']);
		$cp_inc_ip=$cp_wp_option_array['cp_inc_ip'];
		$cp_inc_agent=$cp_wp_option_array['cp_inc_agent'];

		if ($cp_inc_ip == '1') {
			$cp_inc_ip_status=' checked';
		}
		if ($cp_inc_agent == '1') {
			$cp_inc_agent_status=' checked';
		}

$cw_contact_page_action='Main Panel';
$cw_contact_page_html .=<<<EOM
<p>Important Notes: Bold items are required, line breaks will be converted to HTML, HTML is supported in all boxes except form topics</p>
<form method="post" style="margin: 0px; padding: 0px;">
<input type="hidden" name="cw_action" value="settingsv">
<p><b>Organization Name:</b> <input type="text" name="cp_organization" value="$cp_organization" style="width: 400px;"></p>
<p><b>Web Contact Form Topics:</b><div style="margin-left: 20px;">Syntax: Email address pipe topic/subject enter<br><br>Example:<br>support@mysite.tld|Get Technical Support<br>orders@mysite.tld|Billing Questions<br><br>You may repeat email addresses for different topics</div></p>
<p><textarea name="cp_topics" style="width: 400px; height: 300px;">$cp_topics</textarea></p>
<p>Address(es) Box:<div style="margin-left: 20px;">{{organization}} = to insert your organization's name from above</div></p>
<p><textarea name="cp_address" style="width: 400px; height: 100px;">$cp_address</textarea></p>
<p>Email Address(es) Box:<div style="margin-left: 20px;">ASCII conversion: <i>$cp_ascii_status</i><br><br>To protect email accounts using ASCII encoding place email address between the tags &lt;ascii&gt;&lt;/ascii&gt;<br><br>Examples:<br>&lt;ascii&gt;support@mydomain.tld&lt;/ascii&gt;<br>&lt;ascii&gt;billing@mydomain.tld&lt;/ascii&gt;</div></p>
<p><textarea name="cp_email" style="width: 400px; height: 100px;">$cp_email</textarea></p>
<p>Hour(s) Box:</p>
<p><textarea name="cp_hours" style="width: 400px; height: 75px;">$cp_hours</textarea></p>
<p>Phone Number(s) Box:</p>
<p><textarea name="cp_phone" style="width: 400px; height: 50px;">$cp_phone</textarea></p>
<p>Fax Number(s) Box:</p>
<p><textarea name="cp_fax" style="width: 400px; height: 50px;">$cp_fax</textarea></p>
<p>Check to add information to message:<br><input type="checkbox" name="cp_inc_ip" value="1"$cp_inc_ip_status> Visitor's IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="cp_inc_agent" value="1"$cp_inc_agent_status> Visitor's Agent</p>
<p><input type="submit" value="Save" class="button"></p>
</form>
EOM;
	}

	////////////////////////////////////////////////////////////////////////////
	//	Send to print out
	////////////////////////////////////////////////////////////////////////////
	cw_contact_page_admin_browser($cw_contact_page_html,$cw_contact_page_action);
}

////////////////////////////////////////////////////////////////////////////
//	Print out to browser (wp)
////////////////////////////////////////////////////////////////////////////
function cw_contact_page_admin_browser($cw_contact_page_html,$cw_contact_page_action) {
$cw_plugin_name='cleverwise-contact-page';
$cw_plugin_hname='Cleverwise Contact Page';
print <<<EOM
<style type="text/css">
#cws-wrap {margin: 20px 20px 20px 0px;}
#cws-wrap a {text-decoration: none; color: #3991bb;}
#cws-wrap a:hover {text-decoration: underline; color: #ce570f;}
#cws-nav {padding: 5px 0px 7px 0px; margin-bottom: 10px; border-top: 1px solid #ab5c23; border-bottom: 1px solid #ab5c23;}
#cws-resources {padding-top: 5px; margin: 30px 0px 20px 0px;  border-top: 1px solid #ab5c23; font-size: 12px; line-height: 1.9em;}
#cws-resources a:hover {text-decoration: none; background-color: #28394d; color: #ffffff;}
#cws-inner {padding: 5px;}
</style>
<div id="cws-wrap" name="cws-wrap">
<h2 style="padding: 0px; margin: 0px;">$cw_plugin_hname Management</h2>
<div style="margin: 15px; width: 90%; font-size: 10px; line-height: 1;">Allows for the easy creation of a structured contact page complete with web form (including unlimited departments) that contains anti-bot technology baked in.  You have total control over the layout order and text displayed to your visitors.</div>
<div style="margin: 0px 15px 10px 15px; font-size: 12px;">&#9851; <a href="https://wordpress.org/support/view/plugin-reviews/$cw_plugin_name" target="_blank">Share your experience with $cw_plugin_hname by leaving a review!</a> (new window).</div>
<div id="cws-nav" name="cws-nav">&#10058; <a href="?page=cw-contact-page">Main Panel</a> &#10058; <a href="?page=cw-contact-page&cw_action=settingshelp">Help Guide</a> &#10058; <a href="?page=cw-contact-page&cw_action=settingsnew">What Is New?</a><br>Settings: &#10058; <a href="?page=cw-contact-page&cw_action=llsettings">Language & Layouts</a> &#10058; <a href="?page=cw-contact-page&cw_action=masettings">Mail Settings & Anti-Spam</a></div>
<p style="font-size: 13px; font-weight: bold;">Current: <span style="color: #ab5c23;">$cw_contact_page_action</span></p>
<p>$cw_contact_page_html</p>
<div id="cws-resources" name="cws-resources"><i>Resources open in new windows:</i>
<p>&#10004; <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7VJ774KB9L9Z4" target="_blank">Donate - Thank You!</a>  &#10004; <a href="https://www.cyberws.com/professional-technical-consulting/" target="_blank">Professional Wordpress, PHP, Server Consulting</a><br>
&#10004;<a href="https://wordpress.org/support/plugin/$cw_plugin_name" target="_blank">Get $cw_plugin_hname Support</a>  &#10004; <a href="https://wordpress.org/support/view/plugin-reviews/$cw_plugin_name" target="_blank">Review $cw_plugin_hname</a>  &#10004; <a href="https://www.cyberws.com/cleverwise-plugins" target="_blank">See Other Cleverwise Plugins</a></p></div>
</div>
EOM;
}

////////////////////////////////////////////////////////////////////////////
//	Activate
////////////////////////////////////////////////////////////////////////////
function cw_contact_page_activate() {
	Global $wpdb,$cp_wp_option_version_txt,$cp_wp_option_version_num;
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');

	$cp_wp_option_db_version=get_option($cp_wp_option_version_txt);

//	Insert version number
	if (!$cp_wp_option_db_version) {
		add_option($cp_wp_option_version_txt,$cp_wp_option_version_num);
	}
}
