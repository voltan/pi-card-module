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
        $number = _get('number');
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
                // Set session
                $_SESSION['card']['order'] = $row->id;
                $_SESSION['card']['user'] = Pi::user()->getId();
                $_SESSION['card']['ip'] = Pi::user()->getIp();
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
                if ($result['status'] > 0) {
                    $this->jump($result['pay_url'], $result['message'], 'success');
                }
                // Test
                //$url = Pi::api('order', 'card')->updatePayment($order['id'], $order['amount'], $order['adapter']);
                //$this->jump($url, __('Test order'), 'success');
            }
        }
        // Set view
        $this->view()->setTemplate('checkout-add');
        $this->view()->assign('form', $form);
        $this->view()->assign('product', $product);
    }

	public function finishAction()
    {
        // Get info from url
        $id = $this->params('id');
        $module = $this->params('module');
        // Find order
        $order = $this->getModel('order')->find($id);
        // Check session
        if (!isset($_SESSION['card']['order']) 
            || empty($_SESSION['card']['order']) 
            || !isset($_SESSION['card']['ip']) 
            || empty($_SESSION['card']['ip']))
        {
            $this->jump(Pi::url(), __('Order not set 1.'));
        }
        // Check order
        if (!$order->id) {
            $this->jump(Pi::url(), __('Order not set 2.'));
        }
        // Check order
        if ($_SESSION['card']['order'] != $order->id) {
            $this->jump(Pi::url(), __('It not your order.'));
        }
        // Check user
        if (Pi::user()->getId() > 0) {
            if ($order->uid != Pi::user()->getId()) {
                $this->jump(Pi::url(), __('It not your order.'));
            }
        }
        // Check ip
        if ($order->ip != Pi::user()->getIp()) {
            $this->jump(Pi::url(), __('It not your order.'));
        }
        // Check status payment
        if ($order->payment_method == 'online' && $order->status_payment != 2) {
            $this->jump(Pi::url(), __('This order not pay'));
        }
        // Check time payment
        $time = time() - 3600;
        if ($time > $order->time_payment) {
            $this->jump(Pi::url(), __('This is old order and you pay it before'));
        }
        // Set order
        $order = $order->toArray();
        // Get detail
        $details = Pi::api('order', 'card')->getDetails($order);
        // product
        $product = Pi::api('product', 'card')->getProduct($order['product_id']);
        // Set view
        $this->view()->setTemplate('checkout-finish');
        $this->view()->assign('order', $order);
        $this->view()->assign('details', $details);
        $this->view()->assign('product', $product);
    }
}