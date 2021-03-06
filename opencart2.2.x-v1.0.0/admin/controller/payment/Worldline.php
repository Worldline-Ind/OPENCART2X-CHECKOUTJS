<?php
class ControllerPaymentWorldline extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/Worldline');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
        $this->load->model('payment/Worldline');

        $merchant_details = $this->model_payment_Worldline->get();
        $data['error_warning'] = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		    if(count($this->validate()) == 0){
    		    $this->model_setting_setting->editSetting('Worldline', $this->request->post);
    		    $this->session->data['success'] = $this->language->get('text_success');

    		    if(is_array($merchant_details) && !isset($merchant_details[0])){
    		        $response = $this->model_payment_Worldline->add($this->request->post);
    		    }else{
    		        $response = $this->model_payment_Worldline->edit($this->request->post);
    		    }

    		    if($response === true){
    			    $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
    		    }
		    }else if (isset($this->error['warning'])) {
		        $data['error_warning'] = $this->error['warning'];
		    }
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_for_Worldline'] = $this->language->get('text_for_Worldline');

		//values from text box
		$data['request_type_T'] = $this->language->get('request_type_T');
		$data['verification_enabled_Y'] = $this->language->get('verification_enabled_Y');
		$data['verification_enabled_N'] = $this->language->get('verification_enabled_N');
		$data['verification_type_S'] = $this->language->get('verification_type_S');
		$data['verification_type_O'] = $this->language->get('verification_type_O');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['merchant_code'] = $this->language->get('merchant_code');
        $data['verification_enabled'] = $this->language->get('verification_enabled');
        $data['verification_type'] = $this->language->get('verification_type');
        $data['key'] = $this->language->get('key');
        $data['verification_enabled'] = $this->language->get('verification_enabled');
        $data['verification_type'] = $this->language->get('verification_type');
        $data['amount'] = $this->language->get('amount');
        $data['bank_code'] = $this->language->get('bank_code');
        $data['webservice_locator'] = $this->language->get('webservice_locator');
        $data['status'] = $this->language->get('status');
        $data['sort_order'] = $this->language->get('sort_order');
        $data['merchant_scheme_code'] = $this->language->get('merchant_scheme_code');

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();


		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/amazon_checkout', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/Worldline', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token']);

	    if (isset($this->request->post['Worldline_merchant_code'])) {
		    $data['Worldline_merchant_code'] = $this->request->post['Worldline_merchant_code'];
		} else {
		    $data['Worldline_merchant_code'] = $this->config->get('Worldline_merchant_code');
		}
	

		if (isset($this->request->post['Worldline_key'])) {
		    $data['Worldline_key'] = $this->request->post['Worldline_key'];
		} else {
		    $data['Worldline_key'] = $this->config->get('Worldline_key');
		}
		

		if (isset($this->request->post['Worldline_webservice_locator'])) {
		    $data['Worldline_webservice_locator'] = $this->request->post['Worldline_webservice_locator'];
		} else {
		    $data['Worldline_webservice_locator'] = $this->config->get('Worldline_webservice_locator');
		}


		if (isset($this->request->post['Worldline_status'])) {
		    $data['Worldline_status'] = $this->request->post['Worldline_status'];
		} else {
		    $data['Worldline_status'] = $this->config->get('Worldline_status');
		}

		if (isset($this->request->post['Worldline_sort_order'])) {
		    $data['Worldline_sort_order'] = $this->request->post['Worldline_sort_order'];
		} else {
		    $data['Worldline_sort_order'] = $this->config->get('Worldline_sort_order');
		}

		if (isset($this->request->post['Worldline_primary_color_code'])) {
			$data['Worldline_primary_color_code'] = $this->request->post['Worldline_primary_color_code'];
		} else {
			$data['Worldline_primary_color_code'] = $this->config->get('Worldline_primary_color_code');
		}

		if (isset($this->request->post['Worldline_secondary_color_code'])) {
			$data['Worldline_secondary_color_code'] = $this->request->post['Worldline_secondary_color_code'];
		} else {
			$data['Worldline_secondary_color_code'] = $this->config->get('Worldline_secondary_color_code');
		}

		if (isset($this->request->post['Worldline_button_color_code_1'])) {
			$data['Worldline_button_color_code_1'] = $this->request->post['Worldline_button_color_code_1'];
		} else {
			$data['Worldline_button_color_code_1'] = $this->config->get('Worldline_button_color_code_1');
		}

		if (isset($this->request->post['Worldline_button_color_code_2'])) {
			$data['Worldline_button_color_code_2'] = $this->request->post['Worldline_button_color_code_2'];
		} else {
			$data['Worldline_button_color_code_2'] = $this->config->get('Worldline_button_color_code_2');
		}

		if (isset($this->request->post['Worldline_merchant_logo_url'])) {
			$data['Worldline_merchant_logo_url'] = $this->request->post['Worldline_merchant_logo_url'];
		} else {
			$data['Worldline_merchant_logo_url'] = $this->config->get('Worldline_merchant_logo_url');
		}

		if (isset($this->request->post['Worldline_enableExpressPay'])) {
			$data['Worldline_enableExpressPay'] = $this->request->post['Worldline_enableExpressPay'];
		} else {
			$data['Worldline_enableExpressPay'] = $this->config->get('Worldline_enableExpressPay');
		}

		if (isset($this->request->post['Worldline_separateCardMode'])) {
			$data['Worldline_separateCardMode'] = $this->request->post['Worldline_separateCardMode'];
		} else {
			$data['Worldline_separateCardMode'] = $this->config->get('Worldline_separateCardMode');
		}

		if (isset($this->request->post['Worldline_enableNewWindowFlow'])) {
			$data['Worldline_enableNewWindowFlow'] = $this->request->post['Worldline_enableNewWindowFlow'];
		} else {
			$data['Worldline_enableNewWindowFlow'] = $this->config->get('Worldline_enableNewWindowFlow');
		}

		if (isset($this->request->post['Worldline_merchantMsg'])) {
			$data['Worldline_merchantMsg'] = $this->request->post['Worldline_merchantMsg'];
		} else {
			$data['Worldline_merchantMsg'] = $this->config->get('Worldline_merchantMsg');
		}

		if (isset($this->request->post['Worldline_disclaimerMsg'])) {
			$data['Worldline_disclaimerMsg'] = $this->request->post['Worldline_disclaimerMsg'];
		} else {
			$data['Worldline_disclaimerMsg'] = $this->config->get('Worldline_disclaimerMsg');
		}

		if (isset($this->request->post['Worldline_paymentMode'])) {
			$data['Worldline_paymentMode'] = $this->request->post['Worldline_paymentMode'];
		} else {
			$data['Worldline_paymentMode'] = $this->config->get('Worldline_paymentMode');
		}

		if (isset($this->request->post['Worldline_paymentModeOrder'])) {
			$data['Worldline_paymentModeOrder'] = $this->request->post['Worldline_paymentModeOrder'];
		} else {
			$data['Worldline_paymentModeOrder'] = $this->config->get('Worldline_paymentModeOrder');
		}

		if (isset($this->request->post['Worldline_enableInstrumentDeRegistration'])) {
			$data['Worldline_enableInstrumentDeRegistration'] = $this->request->post['Worldline_enableInstrumentDeRegistration'];
		} else {
			$data['Worldline_enableInstrumentDeRegistration'] = $this->config->get('Worldline_enableInstrumentDeRegistration');
		}

		if (isset($this->request->post['Worldline_txnType'])) {
			$data['Worldline_txnType'] = $this->request->post['Worldline_txnType'];
		} else {
			$data['Worldline_txnType'] = $this->config->get('Worldline_txnType');
		}

		if (isset($this->request->post['Worldline_hideSavedInstruments'])) {
			$data['Worldline_hideSavedInstruments'] = $this->request->post['Worldline_hideSavedInstruments'];
		} else {
			$data['Worldline_hideSavedInstruments'] = $this->config->get('Worldline_hideSavedInstruments');
		}

		if (isset($this->request->post['Worldline_saveInstrument'])) {
			$data['Worldline_saveInstrument'] = $this->request->post['Worldline_saveInstrument'];
		} else {
			$data['Worldline_saveInstrument'] = $this->config->get('Worldline_saveInstrument');
		}

		if (isset($this->request->post['Worldline_displayErrorMessageOnPopup'])) {
			$data['Worldline_displayErrorMessageOnPopup'] = $this->request->post['Worldline_displayErrorMessageOnPopup'];
		} else {
			$data['Worldline_displayErrorMessageOnPopup'] = $this->config->get('Worldline_displayErrorMessageOnPopup');
		}

		if (isset($this->request->post['Worldline_embedPaymentGatewayOnPage'])) {
			$data['Worldline_embedPaymentGatewayOnPage'] = $this->request->post['Worldline_embedPaymentGatewayOnPage'];
		} else {
			$data['Worldline_embedPaymentGatewayOnPage'] = $this->config->get('Worldline_embedPaymentGatewayOnPage');
		}

		if (isset($this->request->post['Worldline_merchant_scheme_code'])) {
		    $data['Worldline_merchant_scheme_code'] = $this->request->post['Worldline_merchant_scheme_code'];
		} else {
		    $data['Worldline_merchant_scheme_code'] = $this->config->get('Worldline_merchant_scheme_code');
		}

		$data['button_colours'] = array(
			'orange' => $this->language->get('text_orange'),
			'tan'    => $this->language->get('text_tan')
		);

		$data['button_backgrounds'] = array(
			'white' => $this->language->get('text_white'),
			'light' => $this->language->get('text_light'),
			'dark'  => $this->language->get('text_dark'),
		);

		$data['button_sizes'] = array(
			'medium'  => $this->language->get('text_medium'),
			'large'   => $this->language->get('text_large'),
			'x-large' => $this->language->get('text_x_large'),
		);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['verification'] = $this->url->link('custom/verification', 'token=' . $this->session->data['token'], 'SSL');
		$data['reconciliation'] = $this->url->link('custom/reconciliation', 'token=' . $this->session->data['token'], 'SSL');
		$this->response->setOutput($this->load->view('payment/Worldline.tpl', $data));
	}

	public function install() {
		$this->load->model('payment/Worldline');
		$this->model_payment_Worldline->install();
	}

	public function uninstall() {
		$this->load->model('payment/Worldline');
		$this->model_payment_Worldline->uninstall();
	}

	public function order() {
		$data['order_id'] = $this->request->get['order_id'];
		
		$this->load->model('sale/order');
	
        $query = $this->db->query("SELECT
  		o.comment,
  		DATE(o.date_added) AS mydate
		FROM
  		" . DB_PREFIX . "order_history o
		WHERE o.order_id = '" . $data['order_id'] . "'
  		AND o.order_status_id = '2'
		LIMIT 0, 1;");
            if(isset($query->rows[0]['comment']) != ''){
            $data['status'] = 'success';	
            $data['token'] = $query->rows[0]['comment'];
            $data['date'] = $query->rows[0]['mydate'];
            $data['mcode'] = $this->config->get('Worldline_merchant_code');
            $order_info = $this->model_sale_order->getOrder($data['order_id']);
            $data['currency'] = $order_info['currency_code'];
            $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        }else{
        	$data['status'] = 'fail';
        }
        
		return $this->load->view('payment/Worldline_order.tpl', $data);

		
	}

	protected function validate() {
		if (!trim($this->request->post['Worldline_merchant_code'])) {
			$this->error['warning']['merchant_code'] = $this->language->get('error_merchant_code');
		}
		

		if (!trim($this->request->post['Worldline_key'])) {
			$this->error['warning']['access_key'] = $this->language->get('error_key');
		}
		

		if (!trim($this->request->post['Worldline_webservice_locator'])) {
		    $this->error['warning']['access_webservice_locator'] = $this->language->get('error_webservice_locator');
		}
		

		if (!trim($this->request->post['Worldline_sort_order'])) {
		    $this->error['warning']['access_sort_order'] = $this->language->get('error_sort_order');
		}

		if (!trim($this->request->post['Worldline_merchant_scheme_code'])) {
		    $this->error['warning']['merchant_scheme_code'] = $this->language->get('error_merchant_scheme_code');
		}

		return $this->error;
	}
}