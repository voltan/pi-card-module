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
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Pi\File\Transfer\Upload;
use Module\Card\Form\ProductForm;
use Module\Card\Form\ProductFilter;

class ProductController extends ActionController
{
    /**
     * Product Image Prefix
     */
    protected $ImageProductPrefix = 'product_';

    /**
     * Product Columns
     */
    protected $productColumns = array(
    	'id', 'category', 'title', 'slug', 'text_description', 'image', 'path', 'order', 'hits', 'status', 
    	'time_create', 'time_update', 'sales', 'stock', 'price', 'price_title', 'field_1_title', 
    	'field_2_title', 'field_3_title', 'field_4_title', 'field_5_title', 'field_6_title', 
    	'field_7_title', 'field_8_title', 'field_9_title', 'field_10_title', 'seo_title', 'seo_keywords', 'seo_description'
    );

	public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Set info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        $list = array();
        // Set info
        $column = array('id', 'title', 'slug', 'status', 'time_create', 'time_update');
        // Get list of product
        $select = $this->getModel('product')->select()->columns($column)->order($order);
        $rowset = $this->getModel('product')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $product[$row->id] = $row->toArray();
            $product[$row->id]['time_create_view'] = _date($product[$row->id]['time_create']);
            $product[$row->id]['time_update_view'] = _date($product[$row->id]['time_update']);
            $product[$row->id]['productUrl'] = Pi::url($this->url('card', array(
                'module'        => $module,
                'controller'    => 'product',
                'slug'          => $product[$row->id]['slug'],
            )));
        }
        // Go to update page if empty
        if (empty($product) && empty($status)) {
            return $this->redirect()->toRoute('', array('action' => 'update'));
        }
        // Set paginator
        $countLink = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)'));
        $select = $this->getModel('product')->select()->columns($countLink);
        $count = $this->getModel('product')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'product',
                'action'        => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('product-index');
        $this->view()->assign('list', $product);
        $this->view()->assign('paginator', $paginator);
    }

    public function updateAction()
    {
        // check category
        $categoryCount = Pi::api('category', 'card')->categoryCount();
        if (!$categoryCount) {
            return $this->redirect()->toRoute('', array(
                'controller'  => 'category',
                'action'      => 'update'
            ));
        }
        // Get id
        $id = $this->params('id');
        $module = $this->params('module');
        $option = array();
        // Find Product
        if ($id) {
            $product = $this->getModel('product')->find($id)->toArray();
            $option['edit'] = 1;
            if ($product['image']) {
                $thumbUrl = sprintf('upload/%s/thumb/%s/%s', $this->config('image_path'), $product['path'], $product['image']);
                $option['thumbUrl'] = Pi::url($thumbUrl);
                $option['removeUrl'] = $this->url('', array('action' => 'remove', 'id' => $product['id']));
            }
        }
        // Set form
        $form = new ProductForm('product', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
        	$data = $this->request->getPost();
            $file = $this->request->getFiles();
            // Set slug
            $slug = ($data['slug']) ? $data['slug'] : $data['title'];
            $filter = new Filter\Slug;
            $data['slug'] = $filter($slug);
            // Form filter
            $form->setInputFilter(new ProductFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
            	$values = $form->getData();
                // upload image
                if (!empty($file['image']['name'])) {
                    // Set upload path
                    $values['path'] = sprintf('%s/%s', date('Y'), date('m'));
                    $originalPath = Pi::path(sprintf('upload/%s/original/%s', $this->config('image_path'), $values['path']));
                    // Image name
                    $imageName = Pi::api('image', 'card')->rename($file['image']['name'], $this->ImageProductPrefix, $values['path']);
                    // Upload
                    $uploader = new Upload;
                    $uploader->setDestination($originalPath);
                    $uploader->setRename($imageName);
                    $uploader->setExtension($this->config('image_extension'));
                    $uploader->setSize($this->config('image_size'));
                    if ($uploader->isValid()) {
                        $uploader->receive();
                        // Get image name
                        $values['image'] = $uploader->getUploaded('image');
                        // process image
                        Pi::api('image', 'card')->process($values['image'], $values['path']);
                    } else {
                        $this->jump(array('action' => 'update'), __('Problem in upload image. please try again'));
                    }
                } elseif (!isset($values['image'])) {
                    $values['image'] = '';  
                }
            	// Set just product fields
            	foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->productColumns)) {
                        unset($values[$key]);
                    }
                }
                // Set seo_title
                $title = ($values['seo_title']) ? $values['seo_title'] : $values['title'];
                $filter = new Filter\HeadTitle;
                $values['seo_title'] = $filter($title);
                // Set seo_keywords
                $keywords = ($values['seo_keywords']) ? $values['seo_keywords'] : $values['title'];
                $filter = new Filter\HeadKeywords;
                $filter->setOptions(array(
                    'force_replace_space' => true
                ));
                $values['seo_keywords'] = $filter($keywords);
                // Set seo_description
                $description = ($values['seo_description']) ? $values['seo_description'] : $values['title'];
                $filter = new Filter\HeadDescription;
                $values['seo_description'] = $filter($description);
                // Set time
                if (empty($values['id'])) {
                    $values['time_create'] = time();
                    $values['uid'] = Pi::user()->getId();
                }
                $values['time_update'] = time();
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('product')->find($values['id']);
                } else {
                    $row = $this->getModel('product')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Add / Edit sitemap
                /* if (Pi::service('module')->isActive('sitemap')) {
                    // Set loc
                    $loc = Pi::url($this->url('card', array(
                        'module'      => $module, 
                        'controller'  => 'product', 
                        'slug'        => $values['slug']
                    )));
                    // Update sitemap
                    Pi::api('sitemap', 'sitemap')->singleLink($loc, $row->status, $module, 'product', $row->id);         
                } */
                // Check it save or not
                $message = __('Product data saved successfully.');
                $this->jump(array('action' => 'index'), $message);
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }	
        } else {
            if ($id) {
                // Set data 
                $form->setData($product);
            }
        }   
        // Set view
        $this->view()->setTemplate('product-update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Add product'));
    }

    public function removeAction()
    {
        // Get id and status
        $id = $this->params('id');
        // set product
        $product = $this->getModel('product')->find($id);
        // Check
        if ($product && !empty($id)) {
            // remove file
            /* $files = array(
                Pi::path(sprintf('upload/%s/original/%s/%s', $this->config('image_path'), $product->path, $product->image)),
                Pi::path(sprintf('upload/%s/large/%s/%s', $this->config('image_path'), $product->path, $product->image)),
                Pi::path(sprintf('upload/%s/medium/%s/%s', $this->config('image_path'), $product->path, $product->image)),
                Pi::path(sprintf('upload/%s/thumb/%s/%s', $this->config('image_path'), $product->path, $product->image)),
            );
            Pi::service('file')->remove($files); */
            // clear DB
            $product->image = '';
            $product->path = '';
            // Save
            if ($product->save()) {
                $message = sprintf(__('Image of %s removed'), $product->title);
                $status = 1;
            } else {
                $message = __('Image not remove');
                $status = 0;
            }
        } else {
            $message = __('Please select product');
            $status = 0;
        }
        return array(
            'status' => $status,
            'message' => $message,
        );
    }
}