<?php

/**
 * StepController
 */
class StepController extends Controller
{
	public function firstStep()
	{
		if ($this->is_site_installed()) {
			$this->url->abs_redirect(HTTP_KLINIKAL);
		}

		$data = array();
		$this->response->setOutput($this->load->view('steps/step_1', $data));
	}

	public function installStep()
	{
		if ($this->is_site_installed()) {
			$this->url->abs_redirect(HTTP_KLINIKAL);
		}

        if (!empty($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }

        $data['action'] = HTTP_SERVER.'index.php?route=step_2';
        $this->response->setOutput($this->load->view('steps/step_2', $data));
    }

    public function installStepAction()
    {
        if ($this->is_site_installed()) {
            $this->url->abs_redirect(HTTP_KLINIKAL);
        }

        $data = $this->url->post;
        $error = $this->validate($data);
        if ($error[0] == 1) {
            $this->session->data['error'] = implode(',', $error[1]);
            $this->url->redirect('step_2');
        }

        $this->load->model('db');
        $checkdb = $this->model_db->checkDatabaseCredentails($data);
        if($checkdb != 1) {
            $this->session->data['error'] = $checkdb;
            $this->url->redirect('step_2');
        }

        $file = BUILDER.'klinikal.sql';
        $lines = file($file);
        if (empty($lines)) {
            $this->session->data['error'] = 'Database files does not exist.';
            $this->url->redirect('step_2');
        }

        $this->model_db->createDatabaseTable($data, $lines);
        $settings = $this->model_db->getSettings($data);

        if (empty($settings['data'])) {
            $this->session->data['error'] = 'Server Error - Table does not exist in database.';
            $this->url->redirect('step_2');
        }

        $settings = json_decode($settings['data'], true);
        $data['datetime'] = date('Y-m-d H:i:s');
        $settings['name'] = $data['name'];
        $settings['legal_name'] = $data['name'];
        $settings['mail'] = $data['email'];
        $settings['phone'] = $data['phone'];
        $settings['emergency'] = $data['phone'];
        $settings = json_encode($settings);

        $this->model_db->updateSettings($settings, $data);
        $this->model_db->updateUser($data);

        $this->write_config_files($data);
        $this->sendMail($data);

        $this->url->redirect('step_3');
    }

    public function finalStep()
    {
        $data = array();
        $this->response->setOutput($this->load->view('steps/step_3', $data));
    }

    public function is_site_installed()
    {
        if( defined('DB_HOSTNAME') && defined('DB_USERNAME') && defined('DB_PASSWORD') && defined('DB_DATABASE')) {
            if (empty(DB_HOSTNAME) || empty(DB_USERNAME) || empty(DB_PASSWORD) || empty(DB_DATABASE) || empty(DIR) ) { 
                return false; 
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    /**
    * Write configuration file
    */
    private function write_config_files($options)
    {
    	$output  = '<?php' . "\n";
    	$output .= '/*This name will represent title in auto generated mail*/' . "\n";
    	$output .= 'define(\'NAME\', \'' . $options['name'] .'\');' . "\n";
    	$output .= '/*Domain name like www.yourdomain.com*/' . "\n";
    	$output .= 'define(\'URL\', \'' . HTTP_KLINIKAL . '\');' . "\n";
    	$output .= 'define(\'URL_ADMIN\', URL.\'admin/\');' . "\n";

    	$output .= "\n\n";
    	$output .= '/*Application Address*/' . "\n";
    	$output .= 'define(\'DIR_ROUTE\', \'index.php?route=\');' . "\n";
    	$output .= 'define(\'DIR\', \'' . APPLICATION . '\');' . "\n";
    	$output .= 'define(\'DIR_ADMIN\', DIR.\'admin/\');' . "\n";
    	$output .= 'define(\'DIR_APP\', DIR.\'app/\');' . "\n";
    	$output .= 'define(\'DIR_BUILDER\', DIR.\'builder/\');' . "\n";
    	$output .= 'define(\'DIR_VIEW\', DIR_APP.\'views/\');' . "\n";
    	$output .= 'define(\'DIR_IMAGE\', DIR.\'public/images/\');' . "\n";
    	$output .= 'define(\'DIR_UPLOADS\', DIR.\'public/uploads/\');' . "\n";
    	$output .= 'define(\'DIR_STORAGE\', DIR_BUILDER.\'storage/\');' . "\n";
    	$output .= 'define(\'DIR_LIBRARY\', DIR_BUILDER.\'library/\');' . "\n";
    	$output .= 'define(\'DIR_LANGUAGE\', DIR_APP.\'language/\');' . "\n";

    	$output .= "\n\n";
    	$output .= '/** MySQL settings - You can get this info from your web host **/' . "\n";
    	$output .= '/*MySQL database host*/' . "\n";
    	$output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($options['db_hostname']) . '\');' . "\n";
    	$output .= '/*MySQL database username*/' . "\n";
    	$output .= 'define(\'DB_USERNAME\', \'' . addslashes($options['db_username']) . '\');' . "\n";
    	$output .= '/*MySQL database password*/' . "\n";
    	$output .= 'define(\'DB_PASSWORD\', \'' . addslashes($options['db_password']) . '\');' . "\n";
    	$output .= '/*MySQL database Name*/' . "\n";
    	$output .= 'define(\'DB_DATABASE\', \'' . addslashes($options['db_name']) . '\');' . "\n";
    	$output .= '/*Table Prefix*/' . "\n";
    	$output .= 'define(\'DB_PREFIX\', \'' . addslashes($options['db_prefix']) . '\');' . "\n";

    	/*Token*/
    	$output .= "\n\n";
    	$output .= 'define(\'AUTH_KEY\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'LOGGED_IN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'TOKEN\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'TOKEN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";


    	$file = fopen(APPLICATION.'config/config.php', 'w'); 
    	fwrite($file, $output); 
    	fclose($file);

    	$output  = '<?php' . "\n";
    	$output .= '/*This name will represent title in auto generated mail*/' . "\n";
    	$output .= 'define(\'NAME\', \'' . $options['name'] .'\');' . "\n";
    	$output .= '/*Domain name like www.yourdomain.com*/' . "\n";
    	$output .= 'define(\'URL\', \'' . HTTP_KLINIKAL . '\');' . "\n";
    	$output .= 'define(\'URL_ADMIN\', URL.\'admin/\');' . "\n";

    	$output .= "\n\n";
    	$output .= '/*Application Address*/' . "\n";
    	$output .= 'define(\'DIR_ROUTE\', \'index.php?route=\');' . "\n";
    	$output .= 'define(\'DIR\', \'' . APPLICATION . '\');' . "\n";
    	$output .= 'define(\'DIR_ADMIN\', DIR.\'admin/\');' . "\n";
    	$output .= 'define(\'DIR_APP\', DIR_ADMIN.\'app/\');' . "\n";
    	$output .= 'define(\'DIR_VIEW\', DIR_APP.\'views/\');' . "\n";
    	$output .= 'define(\'DIR_BUILDER\', DIR_ADMIN.\'builder/\');' . "\n";
    	$output .= 'define(\'DIR_IMAGE\', DIR_ADMIN.\'public/images/\');' . "\n";
    	$output .= 'define(\'DIR_UPLOADS\', DIR_ADMIN.\'public/uploads/\');' . "\n";
    	$output .= 'define(\'DIR_STORAGE\', DIR_BUILDER.\'storage/\');' . "\n";
    	$output .= 'define(\'DIR_LIBRARY\', DIR_BUILDER.\'library/\');' . "\n";
    	$output .= 'define(\'DIR_LANGUAGE\', DIR_APP.\'language/\');' . "\n";

    	$output .= "\n\n";
    	$output .= '/** MySQL settings - You can get this info from your web host **/' . "\n";
    	$output .= '/*Database hostname*/' . "\n";
    	$output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($options['db_hostname']) . '\');' . "\n";
    	$output .= '/*Database Username*/' . "\n";
    	$output .= 'define(\'DB_USERNAME\', \'' . addslashes($options['db_username']) . '\');' . "\n";
    	$output .= '/*Database Password*/' . "\n";
    	$output .= 'define(\'DB_PASSWORD\', \'' . addslashes($options['db_password']) . '\');' . "\n";
    	$output .= '/*Database Name*/' . "\n";
    	$output .= 'define(\'DB_DATABASE\', \'' . addslashes($options['db_name']) . '\');' . "\n";
    	$output .= '/*Table Prefix*/' . "\n";
    	$output .= 'define(\'DB_PREFIX\', \'' . addslashes($options['db_prefix']) . '\');' . "\n";

    	/*Token*/
    	$output .= "\n\n";
    	$output .= 'define(\'AUTH_KEY\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'LOGGED_IN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'TOKEN\', \'' . $this->token_generator(64) . '\');' . "\n";
    	$output .= 'define(\'TOKEN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";

    	$file = fopen(APPLICATION.'admin/config/config.php', 'w'); 
    	fwrite($file, $output); 
    	fclose($file);
    }

    public function sendMail($data)
    {
        $mailer = new Mail();
        $mailer->setFrom('support@pepdev.com', 'Pepdev');
        $mailer->addAddress($data['email'], $data['name']);
        $mailer->addAddress($data['usermail'], $data['firstname'].' '.$data['lastname']);
        $mailer->addBCC('pepdevofficial@gmail.com', 'ManasaTheme');
        $mailer->isHTML();
        $mailer->setSubject('Klinikal Web Application.');
        $message = 'Hello '.$data['name'].',<br><br>
        Your klinikal theme has been successfully set up at:<br> <a href="'.HTTP_KLINIKAL.'">'.HTTP_KLINIKAL.'</a><br /><br />
        We hope you enjoy your new Clinic management web app. Thanks!<br /><br />
        If you have any questions that are beyond the scope of help file, please feel free to contact us here <a href="http://support.pepdev.com/">pepdev</a> or mail us at pepdevofficial@gmail.com.<br /><br />
        ManasaTheme<br />
        <a href="https://themeforest.net/user/manasatheme/portfolio">themeforest</a><br />';
        $mailer->setMessage($message);
        $mailer->sendMail();
    }
    /**
    * Post variable validation
    */
    private function validate($data) 
    {
    	$error;
    	$error_status = 0;

        if (empty($data['db_hostname'])) {
            $error['db_hostname'] = 'Database Hostname';
            $error_status = 1;
        }

        if (empty($data['db_username'])) {
            $error['db_username'] = 'Database Username';
            $error_status = 1;
        }

        if (empty($data['db_password'])) {
            $error['db_password'] = 'Database Password';
            $error_status = 1;
        }

        if (empty($data['db_name'])) {
            $error['db_name'] = 'Database Name';
            $error_status = 1;
        }

        if (empty($data['db_prefix'])) {
            $error['db_prefix'] = 'Database Prefix';
            $error_status = 1;
        }

        if (empty($data['name'])) {
            $error['name'] = 'Clinic Name';
            $error_status = 1;
        }

        if (empty($data['email']) || (strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Clinic Email Address';
            $error_status = 1;
        }

        if (empty($data['phone'])) {
            $error['phone'] = 'Clinic Phone Number';
            $error_status = 1;
        }

        if (empty($data['firstname'])) {
            $error['firstname'] = 'User Firstname';
            $error_status = 1;
        }

        if (empty($data['lastname'])) {
            $error['lastname'] = 'User Lastname';
            $error_status = 1;
        }

        if (empty($data['usermail']) || (strlen($data['usermail']) > 96) || !filter_var($data['usermail'], FILTER_VALIDATE_EMAIL)) {
            $error['usermail'] = 'User Email Address';
            $error_status = 1;
        }

        if (empty($data['username'])) {
            $error['username'] = 'Username';
            $error_status = 1;
        }

        if (empty($data['password']) || strlen($data['password']) < 7) {
            $error['password'] = 'Password';
            $error_status = 1;
        }

        if($error_status === 1) {
            return array($error_status, $error);
        } else {
            return array(0, '');
        }
    }

    private function token_generator( $length = 64 )
    {
        $token = "";
        $charArray = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz#~%|<>{}())?&*-;");
        for($i = 0; $i < $length; $i++){
            $randItem = array_rand($charArray);
            $token .= "".$charArray[$randItem];
        }
        return $token;
    }
}