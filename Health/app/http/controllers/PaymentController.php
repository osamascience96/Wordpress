<?php

/**
* PaymentController
*/
use Omnipay\Omnipay;
require DIR_BUILDER.'vendor/autoload.php';
class PaymentController extends Controller
{
	public function index()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = (int)$this->url->get('invoice');
		if (empty($id)) {
			$this->url->redirect('user/invoices');
		}

		$this->load->model('payment');
		$invoice = $this->model_payment->getInvoice($id);
		if (empty($invoice)) {
			$this->url->redirect('user/invoices');
		}

		$this->load->controller('common');
		$this->load->model('payment');
		$common = $this->controller_common->index();
		$credentials = $this->model_payment->getPaymentGateway();
		$credentials = json_decode($credentials, true);

		if (!isset($credentials['paypal']['status']) || $credentials['paypal']['status'] == '0') {
			$this->session->data['message'] = 'Paypal payment gateway is disabled.';
			$this->url->redirect('payment/cancel');
		}

		if ($credentials['paypal']['mode'] == '0') {
			$paypalMode = true; 
		} else {
			$paypalMode = false;
		}

		$params = array(
			'cancelUrl'     => URL.DIR_ROUTE.'invoice/cancelpay',
			'returnUrl'     => URL.DIR_ROUTE.'invoice/successpay',
			'invoice_id'    => $invoice['id'],
			'name'      	=> 'Invoice Payment',
			'description'   => 'Patient Charges',
			'amount'    	=> $invoice['due'],
			'currency'  	=> $common['siteinfo']['currency'],
			//'amount'    	=> '.1',
			//'currency'  	=> 'USD',
			'custom'        => $this->token_generator(64),
			'email' 		=> $invoice['email'],
		);

		$this->session->data['params'] = $params;

		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUsername($credentials['paypal']['username']);
		$gateway->setPassword($credentials['paypal']['password']);
		$gateway->setSignature($credentials['paypal']['signature']);
		$gateway->setTestMode($paypalMode);
		$response = $gateway->purchase($params)->send();

        if ($response->isSuccessful()) {
	           // payment was successful: update database
            exit('successful');
        } elseif ($response->isRedirect()) {
            $response->redirect();
        } else {
	        // payment failed: display message to customer
            exit($response->getMessage());
        }
    }

    public function indexCancel()
    {
        $this->load->model('payment');
        $credentials = $this->model_payment->getPaymentGateway();
        $credentials = json_decode($credentials, true);

        if ($credentials['paypal']['status'] == '0') {
            $this->session->data['payment_message'] = 'Paypal payment gateway is disabled.';
            $this->url->redirect('payment/cancel');
        }

        if ($credentials['paypal']['mode'] == '0') {
            $paypalMode = true; 
        } else {
            $paypalMode = false;
        }

        $params = $this->session->data['params'];
		//$this->data['set_key'] = $api_config;
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($credentials['paypal']['username']);
        $gateway->setPassword($credentials['paypal']['password']);
        $gateway->setSignature($credentials['paypal']['signature']);
        $gateway->setTestMode($paypalMode);

        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData();
        if (isset($paypalResponse['L_SHORTMESSAGE0'])) {
            $this->session->data['payment_message'] = $paypalResponse['L_SHORTMESSAGE0'];
        } else {
            $this->session->data['payment_message'] = 'Payment canceled by user.';
        }
        unset($this->session->data['params']);
        $this->url->redirect('payment/cancel');
    }

    public function indexSuccess()
    {
        $this->load->model('payment');
        $credentials = $this->model_payment->getPaymentGateway();

        $credentials = json_decode($credentials, true);

        if ($credentials['paypal']['status'] == '0') {
            $this->session->data['payment_message'] = 'Paypal payment gateway is disabled.';
            $this->url->redirect('payment/cancel');
        }

        if ($credentials['paypal']['mode'] == '0') {
            $paypalMode = true; 
        } else {
            $paypalMode = false;
        }

        $params = $this->session->data['params'];

		//$this->data['set_key'] = $api_config;
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($credentials['paypal']['username']);
        $gateway->setPassword($credentials['paypal']['password']);
        $gateway->setSignature($credentials['paypal']['signature']);
        $gateway->setTestMode($paypalMode);

        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData(); // this is the raw response object
        $purchaseId = $this->url->get('PayerID');
        
        $data['payer_id'] = $this->url->get('PayerID');
        $data['params'] = $params;

        if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
        	$this->load->model('payment');
        	if ($purchaseId) {
        		$check_txn_id = $this->model_payment->checkTransaction($params, $paypalResponse['PAYMENTINFO_0_TRANSACTIONID']);
        		if(!$check_txn_id) {
        			$invoice = $this->model_payment->getInvoice($params['invoice_id']);

        			if (!empty($invoice)) {
        				$data['txn_id'] = $paypalResponse['PAYMENTINFO_0_TRANSACTIONID'];
        				$data['amount'] = (float)$paypalResponse['PAYMENTINFO_0_AMT'];
        				if (isset($this->session->data['user_id'])) {
        					$data['patient_id'] = $this->session->data['user_id'];
        				} else {
        					$data['patient_id'] = 0;
        				}
        				
        				$data['datetime'] = date('Y-m-d H:i:s');

                        $invoice['paid'] = $invoice['paid'] + $paypalResponse['PAYMENTINFO_0_AMT'];
                        $invoice['due'] = $invoice['due'] - $paypalResponse['PAYMENTINFO_0_AMT'];

                        if ($invoice['due'] > '0') {
                            $invoice['status'] = 'Partially Paid';
                        } else {
                            $invoice['status'] = 'Paid';
                        }

                        $data['invoice'] = $invoice;
                        $this->sendMail($data);
                        $this->model_payment->createPayment($data);
                        $this->model_payment->updateInvoice($invoice);
                        $this->session->data['payment_message'] = array('error' => false, 'message' => 'Payment Recieved');
                        $this->session->data['txn_id'] = $data['txn_id'];
                        unset($this->session->data['params']);
                        $this->url->redirect('payment/success');
                    } else {
                        unset($this->session->data['params']);
                        $this->session->data['payment_message'] = 'Invalid invoice';
                        $this->url->redirect('payment/cancel');
                    }
                } else {
                    unset($this->session->data['params']);
                    $this->session->data['payment_message'] = 'Transaction ID already exist!';
                    $this->url->redirect('payment/cancel');
                }
            } else {
                unset($this->session->data['params']);
                $this->session->data['payment_message'] = 'Payer id not found!';
                $this->url->redirect('payment/cancel');
            }
        } else {
            unset($this->session->data['params']);
            $this->session->data['payment_message'] = 'Payment not success!';
            $this->url->redirect('payment/cancel');
        }
    }

    public function indexStripe()
    {
        $this->load->controller('common');
        $this->load->model('payment');
        $data = $this->controller_common->index();

        if (!empty($this->session->data['message'])) {
            $data['message'] = $this->session->data['message'];
            unset($this->session->data['message']);
        }

        $data['page']['meta_tag'] = 'Stripe | ' .$data['siteinfo']['name'];
        $data['page']['meta_description'] = 'Stripe, '.$data['siteinfo']['name'];
        $data['page']['page_title'] = 'Stripe';
        $data['page']['page_section'] = false;

        $footer['script'] = '<script src="https://js.stripe.com/v3/"></script><script type="text/javascript" src="public/js/payment.js"></script>';

        $data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
        $data['footer'] = $this->controller_common->getFooter($footer, 'footer-1');
        $this->response->setOutput($this->load->view('payment/stripe', $data));
    }

    public function indexStripeAction()
    {
        $data = $this->url->post;
        
        $gateway = Omnipay::create('Stripe');



        echo "<pre>";
        print_r($data);

        $response = $gateway->purchase([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => $data['stripeToken'],
        ])->send();

        if ($response->isSuccessful()) {
            echo "successfull";
        } else if($response->isRedirect()) {
            $response->redirect();
        } else {
            echo "failed";
        }
    }

    public function indexStripeSuccess()
    {
    }


    public function indexCancelShow()
    {
        $this->load->controller('common');
        $this->load->model('payment');
        $data = $this->controller_common->index();

        if (!empty($this->session->data['message'])) {
            $data['message'] = $this->session->data['message'];
            unset($this->session->data['message']);
        }

        $data['page']['meta_tag'] = 'Cancel | ' .$data['siteinfo']['name'];
        $data['page']['meta_description'] = 'Cancel, '.$data['siteinfo']['name'];
        $data['page']['page_title'] = 'Cancel';
        $data['page']['page_section'] = false;

        $data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
        $data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');
        $this->response->setOutput($this->load->view('payment/cancel', $data));
    }

    public function indexSuccessShow()
    {
        $this->load->controller('common');
        $this->load->model('payment');

        if (!isset($this->session->data['txn_id'])) {
            $this->url->redirect('user/invoices');
        }

        $data = $this->controller_common->index();
        $data['page']['meta_tag'] = 'Success | ' .$data['siteinfo']['name'];
        $data['page']['meta_description'] = 'Success, '.$data['siteinfo']['name'];
        $data['page']['page_title'] = 'Success';
        $data['page']['page_section'] = false;

        $data['txn_id'] = $this->session->data['txn_id'];
        unset($this->session->data['txn_id']);

        $data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
        $data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');

        $this->response->setOutput($this->load->view('payment/success', $data));
    }

    public function sendMail($data)
    {
        $this->load->model('payment');
        $result = $this->model_payment->getTemplate();
        $info = $this->model_payment->getSiteInfo();
        $info = json_decode($info, true);

        $link = '<a href="'.URL.'">Click Here</a>';
        $result['message'] = str_replace('{name}', $data['invoice']['name'], $result['message']);
        $result['message'] = str_replace('{invoice_id}', $info['invoice_prefix'].str_pad($data['invoice']['id'], 4, '0', STR_PAD_LEFT), $result['message']);

        $result['message'] = str_replace('{txn_id}', $data['txn_id'], $result['message']);
        $result['message'] = str_replace('{paid_amount}', $info['currency_abbr'].$data['invoice']['paid'], $result['message']);
        $result['message'] = str_replace('{due_amount}', $info['currency_abbr'].$data['invoice']['due'], $result['message']);
        $result['message'] = str_replace('{paid_date}', $data['datetime'], $result['message']);
        $result['message'] = str_replace('{clinic_name}', $info['name'], $result['message']);

        $mail['name'] = $data['invoice']['name'];
        $mail['email'] = $data['invoice']['email'];
        $mail['subject'] = $result['subject'];
        $mail['message'] = $result['message'];

        $this->load->controller('mail');
        $mail_result = $this->controller_mail->sendMail($mail);
        if ($mail_result == 1) {
			//$this->session->data['message'] = array('alert' => 'error', 'value' => 'Success: Message sent successfully.');
        } else {
			//$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
        }
    }

    private function token_generator( $length = 64 ) {
        $token = "";
        $charArray = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz");
        for($i = 0; $i < $length; $i++){
            $randItem = array_rand($charArray);
            $token .= "".$charArray[$randItem];
        }
        return $token;
    }
}