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
namespace Module\Card\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Module\Card\Form\DetailForm;
use Module\Card\Form\DetailFilter;
use Module\Card\Form\DetailEditForm;
use Module\Card\Form\DetailEditFilter;

class DetailController extends ActionController
{
    
    /**
     * Product Columns
     */
    protected $detailColumns = array(
    	'id', 'product', 'uid', 'sales_is', 'sales_price', 'time_create', 'time_sales', 'status', 'order',
    	'field_1', 'field_2', 'field_3', 'field_4', 'field_5', 'field_6', 'field_7', 'field_8', 'field_9', 'field_10'
    );

    public function indexAction()
    {

    }

    public function viewAction()
    {
        // Get info
        $page = $this->params('page', 1);
        $product = $this->params('product');
        $module = $this->params('module');
        // Check
        if (!$product) {
            $message = __('Please select product.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Get product
    	$product = Pi::api('product', 'card')->getProduct($product);
    	// Check product
        if (empty($product)) {
            $message = __('Your product have error.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Set info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        $where = array('product' => $product['id']);
        $list = array();
        // Get list of product
        $select = $this->getModel('detail')->select()->where($where)->order($order);
        $rowset = $this->getModel('detail')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['time_create_view'] = _date($row->time_create);
            $list[$row->id]['time_sales_view'] = ($row->time_sales) ? _date($row->time_sales) : ' - ';
            $list[$row->id]['sales_is_view'] = ($row->sales_is) ? __('Yes') : __('No');
            $list[$row->id]['sales_price_view'] = ($row->sales_price > 0) ? Pi::api('product', 'card')->viewPrice($row->sales_price) : ' - ';
        }
        // Set paginator
        $countLink = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)'));
        $select = $this->getModel('detail')->select()->columns($countLink)->where($where);
        $count = $this->getModel('detail')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'detail',
                'action'        => 'index',
                'product'       => $product['id'],
            )),
        ));
        // Set view
        $this->view()->setTemplate('detail-view');
        $this->view()->assign('product', $product);
        $this->view()->assign('list', $list);
        $this->view()->assign('title', sprintf(__('List of detail on %s'), $product['title']));
        $this->view()->assign('paginator', $paginator);
    }

    public function addAction()
    {
        // Get info
        $product = $this->params('product');
        $module = $this->params('module');
        // Check
        if (!$product) {
            $message = __('Please select product.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Get product
    	$product = Pi::api('product', 'card')->getProduct($product);
    	// Check product
        if (empty($product)) {
            $message = __('Your product have error.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Set option
        $option = array();
        // Set field_1_title
        if (!empty($product['field_1_title'])) {
        	$option['field_1_title'] = $product['field_1_title'];
        }
        // Set field_2_title
        if (!empty($product['field_2_title'])) {
        	$option['field_2_title'] = $product['field_2_title'];
        }
        // Set field_3_title
        if (!empty($product['field_3_title'])) {
        	$option['field_3_title'] = $product['field_3_title'];
        }
        // Set field_4_title
        if (!empty($product['field_4_title'])) {
        	$option['field_4_title'] = $product['field_4_title'];
        }
        // Set field_5_title
        if (!empty($product['field_5_title'])) {
        	$option['field_5_title'] = $product['field_5_title'];
        }
        // Set field_6_title
        if (!empty($product['field_6_title'])) {
        	$option['field_6_title'] = $product['field_6_title'];
        }
        // Set field_7_title
        if (!empty($product['field_7_title'])) {
        	$option['field_7_title'] = $product['field_7_title'];
        }
        // Set field_8_title
        if (!empty($product['field_8_title'])) {
        	$option['field_8_title'] = $product['field_8_title'];
        }
        // Set field_9_title
        if (!empty($product['field_9_title'])) {
        	$option['field_9_title'] = $product['field_9_title'];
        }
        // Set field_10_title
        if (!empty($product['field_10_title'])) {
        	$option['field_10_title'] = $product['field_10_title'];
        }
        // Set form
        $form = new DetailForm('detail', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
        	$data = $this->request->getPost();
            $form->setInputFilter(new DetailFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
            	$values = $form->getData();
            	// Set just detail fields
            	foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->detailColumns)) {
                        unset($values[$key]);
                    }
                }
                // Set values
                $values['product'] = $product['id'];
                $values['uid'] = Pi::user()->getId();
                $values['time_create'] = time();
                $values['sales_is'] = 0;
                $values['status'] = 1;
                // Save
                $row = $this->getModel('detail')->createRow();
                $row->assign($values);
                $row->save();
                // update Stock
                Pi::api('product', 'card')->updateStock($product['id']);
                // redirect
                $message = __('Information data saved successfully.');
                $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }
        }
        // Set view
        $this->view()->setTemplate('detail-add');
        $this->view()->assign('product', $product);
        $this->view()->assign('form', $form);
        $this->view()->assign('title', sprintf(__('Add detail to %s'), $product['title']));
    }

    public function editAction()
    {
        // Get info
        $id = $this->params('id');
        $product = $this->params('product');
        $module = $this->params('module');
        // Check
        if (!$product || !$id) {
            $message = __('Please select product and detail.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Get product
    	$product = Pi::api('product', 'card')->getProduct($product);
    	// Get detail
    	$detail = $this->getModel('detail')->find($id)->toArray();
    	// Check product
        if (empty($product) || empty($detail)) {
            $message = __('Your product or detail have error.');
            $this->jump(array('controller' => 'product', 'action' => 'index'), $message);
        }
        // Set option
        $option = array();
        // Set field_1_title
        if (!empty($product['field_1_title'])) {
        	$option['field_1_title'] = $product['field_1_title'];
        }
        // Set field_2_title
        if (!empty($product['field_2_title'])) {
        	$option['field_2_title'] = $product['field_2_title'];
        }
        // Set field_3_title
        if (!empty($product['field_3_title'])) {
        	$option['field_3_title'] = $product['field_3_title'];
        }
        // Set field_4_title
        if (!empty($product['field_4_title'])) {
        	$option['field_4_title'] = $product['field_4_title'];
        }
        // Set field_5_title
        if (!empty($product['field_5_title'])) {
        	$option['field_5_title'] = $product['field_5_title'];
        }
        // Set field_6_title
        if (!empty($product['field_6_title'])) {
        	$option['field_6_title'] = $product['field_6_title'];
        }
        // Set field_7_title
        if (!empty($product['field_7_title'])) {
        	$option['field_7_title'] = $product['field_7_title'];
        }
        // Set field_8_title
        if (!empty($product['field_8_title'])) {
        	$option['field_8_title'] = $product['field_8_title'];
        }
        // Set field_9_title
        if (!empty($product['field_9_title'])) {
        	$option['field_9_title'] = $product['field_9_title'];
        }
        // Set field_10_title
        if (!empty($product['field_10_title'])) {
        	$option['field_10_title'] = $product['field_10_title'];
        }
        // Set form
        $form = new DetailEditForm('detail', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
        	$data = $this->request->getPost();
            $form->setInputFilter(new DetailEditFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
            	$values = $form->getData();
            	// Set just detail fields
            	foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->detailColumns)) {
                        unset($values[$key]);
                    }
                }
                // Save
                $row = $this->getModel('detail')->find($values['id']);
                $row->assign($values);
                $row->save();
                // update Stock
                Pi::api('product', 'card')->updateStock($product['id']);
                // redirect
                $message = __('Information data saved successfully.');
                $this->jump(array('controller' => 'detail', 'action' => 'view', 'product' => $product['id']), $message);
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }
        } else {
        	$form->setData($detail);
        }
        // Set view
        $this->view()->setTemplate('detail-edit');
        $this->view()->assign('product', $product);
        $this->view()->assign('detail', $detail);
        $this->view()->assign('form', $form);
        $this->view()->assign('title', sprintf(__('Edit detail to %s'), $product['title']));
    }
}