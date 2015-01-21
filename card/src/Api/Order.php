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
namespace Module\Card\Api;

use Pi;
use Pi\Application\Api\AbstractApi;
use Zend\Json\Json;

/*
 * Pi::api('order', 'card')->updatePayment($item, $amount, $adapter);
 * Pi::api('order', 'card')->setDetails($orderInfo);
 * Pi::api('order', 'card')->getDetails($orderInfo);
 */

class Order extends AbstractApi
{
    public function updatePayment($item, $amount, $adapter)
    {
        $row = Pi::model('order', $this->getModule())->find($item);
        $row->paid_price = $amount;
        $row->time_payment = time();
        $row->payment_adapter = $adapter;
        $row->status_payment = 2;
        $row->save();
        // Update product
        $product = Pi::model('product', $this->getModule())->find($row->product_id);
        $product->sales = $product->sales + 1;
        $product->stock = $product->stock - 1;
        $product->save();
        // Add details
        $this->setDetails($row->toArray(), $product->toArray());
        // Set back url
        return Pi::url(Pi::service('url')->assemble('card', array(
            'module'        => $this->getModule(),
            'controller'    => 'checkout',
            'action'        => 'finish',
            'id'            => $row->id,
        )));
    }

    public function setDetails($orderInfo, $productInfo)
    {
        // Set model
    	$detailModel = Pi::model('detail', $this->getModule());
    	// Set info
    	$where = array('product' => $orderInfo['product_id'], 'sales_is' => 0, 'status' => 1);
    	$order = array('time_create ASC', 'id ASC');
    	$limit = intval($orderInfo['product_number']);
        // Get list of product
        $select = $detailModel->select()->where($where)->order($order)->limit($limit);
        $rowset = $detailModel->selectWith($select);
        foreach ($rowset as $detail) {
        	// Update detail
        	$detail->sales_is = 1;
        	$detail->time_sales = time();
        	$detail->order = $orderInfo['id'];
        	$detail->save();
        	// Send
        	$this->sendSms($orderInfo, $productInfo, $detail->toArray());
        	$this->sendEmail($orderInfo, $productInfo, $detail->toArray());
        }
    }

    public function getDetails($orderInfo)
    {
        // Set model
    	$detailModel = Pi::model('detail', $this->getModule());
    	$details = array();
    	// Set info
    	$where = array('order' =>  $orderInfo['id'], 'product' => $orderInfo['product_id'], 'sales_is' => 1, 'status' => 1);
    	$order = array('time_create ASC', 'id ASC');
        // Get list of product
        $select = $detailModel->select()->where($where)->order($order);
        $rowset = $detailModel->selectWith($select);
        foreach ($rowset as $row) {
    		$details[$row->id] = $row->toArray();
        }
        return $details;
    }

    public function sendSms($detail)
    {}

    public function sendEmail($detail)
    {}
}    