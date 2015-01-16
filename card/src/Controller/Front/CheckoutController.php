<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\Card\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Card\Form\OrderForm;
use Module\Card\Form\OrderFilter;
use Zend\Json\Json;

class CheckoutController extends ActionController
{
    protected $orderColumns = array(
    	'id', 'uid', 'ip', 'first_name', 'last_name', 'email', 'phone', 'mobile', 'company', 'address', 
    	'country', 'city', 'zip_code', 'status_order', 'status_payment', 'time_create', 'time_payment', 
    	'product_price', 'paid_price', 'product_id', 'product_number', 'product_detail', 'payment_method', 
    	'payment_adapter'
    );	

	public function addAction()
    {
        // Get info from url
        $module = $this->params('module');
        $id = $this->params('id');
        $number = $this->params('number', 1);
        // Get product
        $product = Pi::api('product', 'card')->getProduct($id, 'id', $number);
        // Check product
        if (!$product || $product['status'] != 1 || $product['marketable'] != 1) {
            $this->jump(Pi::url(), __('The product not found.'), 'error');
        }
        // Set order form
        $form = new OrderForm('order');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new OrderFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // Set just order fields
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->orderColumns)) {
                        unset($values[$key]);
                    }
                }
                // Get gateway
                $gateway = Pi::api('gateway', 'payment')->getGatewayInfo($values['payment_adapter']);
                $values['payment_adapter'] = $gateway['path'];
                $values['payment_method'] = $gateway['type'];
                // Set values
                $values['uid'] = Pi::user()->getId();
                $values['ip'] = Pi::user()->getIp();
                $values['status_order'] = 1;
                $values['status_payment'] = 1;
                $values['time_create'] = time();
                $values['product_id'] = $product['id'];
                $values['product_number'] = $product['number'];
                $values['product_price'] = $product['total'];
                // Save values to order
                $row = $this->getModel('order')->createRow();
                $row->assign($values);
                $row->save();
                // Set invoice description
                $description = array();
                // Set order array
                $order = array();
                $order['module'] = $this->getModule();
                $order['part'] = 'order';
                $order['id'] = $row->id;
                $order['amount'] = $row->product_price;
                $order['adapter'] = $row->payment_adapter;
                $order['description'] = Json::encode($description);
                // Payment module
                $result = Pi::api('invoice', 'payment')->createInvoice(
                    $order['module'], 
                    $order['part'], 
                    $order['id'], 
                    $order['amount'], 
                    $order['adapter'], 
                    $order['description']
                );
                // Check it save and go to bank
                if ($result['status']) {
                    $this->jump($result['invoice_url'], $result['message'], 'success');
                }

                print_r($result);
            } else {
                $this->jump(Pi::url(), __('Form'), 'error');
            }
        }
        // Set view
        $this->view()->setTemplate('checkout-add');
        $this->view()->assign('form', $form);
        $this->view()->assign('product', $product);
    }

	public function finishAction()
    {}
}