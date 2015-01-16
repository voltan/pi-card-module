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
 * Pi::api('product', 'card')->getProduct($parameter, $type, $number);
 * Pi::api('product', 'card')->productList($category);
 * Pi::api('product', 'card')->updateStock($id);
 * Pi::api('product', 'card')->viewPrice($price);
 * Pi::api('product', 'card')->canonizeProduct($product, $categoryList);
 */

class Product extends AbstractApi
{
    public function getProduct($parameter, $type = 'id', $number = 1)
    {
        // Get product
        $product = Pi::model('product', $this->getModule())->find($parameter, $type);
        $product = $this->canonizeProduct($product, $number);
        return $product;
    }

    public function productList($category)
    {
        $list = array();
        $where = array('category' => $category, 'status' => 1);
        $select = Pi::model('product', $this->getModule())->select()->where($where);
        $rowset = Pi::model('product', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
            $list[$row->category][$row->id] = $this->canonizeProduct($row);
        }
        return $list;
    }

    public function updateStock($id)
    {
        // set info
        $where = array('product' => $id, 'sales_is' => 0, 'status' => 1);
        $columns = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)'));
        // Get attach count
        $select = Pi::model('detail', $this->getModule())->select()->columns($columns)->where($where);
        $count = Pi::model('detail', $this->getModule())->selectWith($select)->current()->count;
        // Set attach count
        Pi::model('product', $this->getModule())->update(array('stock' => $count), array('id' => $id));
    }

    public function viewPrice($price)
    {
        if ($price > 0) {
            $viewPrice = _currency($price);
        } else {
            $viewPrice = 0;
        }
        return $viewPrice;

    }

    public function marketable($product)
    {
        if ($product['price'] > 0 && $product['stock'] > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function canonizeProduct($product, $number = 1)
    {
        // Check
        if (empty($product)) {
            return '';
        }
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // boject to array
        $product = $product->toArray();
        // Set text_description
        $product['text_description'] = Pi::service('markup')->render($product['text_description'], 'html', 'html');
        // Set times
        $product['time_create_view'] = _date($product['time_create']);
        $product['time_update_view'] = _date($product['time_update']);
        // Set product url
        /* $product['productUrl'] = Pi::url(Pi::service('url')->assemble('card', array(
            'module'        => $this->getModule(),
            'controller'    => 'product',
            'slug'          => $product['slug'],
        ))); */
        // Set cart url
        $product['cartUrl'] = Pi::url(Pi::service('url')->assemble('card', array(
            'module'        => $this->getModule(),
            'controller'    => 'checkout',
            'action'        => 'add',
            'id'            => $product['id'],
        )));
        // Set price
        $product['price_view'] = $this->viewPrice($product['price']);
        // Set marketable
        $product['marketable'] = $this->marketable($product);
        // Set number
        $number =  (in_array($number, array(1,2,3,4,5))) ? $number : 1;
        $product['number'] = $number;
        $product['number_view'] = _number($number);
        // Set total
        $total = $product['price'] * $number;
        $product['total'] = $total;
        $product['total_view'] = $this->viewPrice($total);
        // Set image url
        if ($product['image']) {
            // Set image original url
            $product['originalUrl'] = Pi::url(
                sprintf('upload/%s/original/%s/%s', 
                    $config['image_path'], 
                    $product['path'], 
                    $product['image']
                ));
            // Set image large url
            $product['largeUrl'] = Pi::url(
                sprintf('upload/%s/large/%s/%s', 
                    $config['image_path'], 
                    $product['path'], 
                    $product['image']
                ));
            // Set image medium url
            $product['mediumUrl'] = Pi::url(
                sprintf('upload/%s/medium/%s/%s', 
                    $config['image_path'], 
                    $product['path'], 
                    $product['image']
                ));
            // Set image thumb url
            $product['thumbUrl'] = Pi::url(
                sprintf('upload/%s/thumb/%s/%s', 
                    $config['image_path'], 
                    $product['path'], 
                    $product['image']
                ));
        }
        // return product
        return $product; 
    }

    /* public function sitemap()
    {
        if (Pi::service('module')->isActive('sitemap')) {
            // Remove old links
            Pi::api('sitemap', 'sitemap')->removeAll($this->getModule(), 'product');
            // find and import
            $columns = array('id', 'slug', 'status');
            $select = Pi::model('product', $this->getModule())->select()->columns($columns);
            $rowset = Pi::model('product', $this->getModule())->selectWith($select);
            foreach ($rowset as $row) {
                // Make url
                $loc = Pi::url(Pi::service('url')->assemble('card', array(
                    'module'        => $this->getModule(),
                    'controller'    => 'product',
                    'slug'          => $row->slug,
                )));
                // Add to sitemap
                Pi::api('sitemap', 'sitemap')->groupLink($loc, $row->status, $this->getModule(), 'product', $row->id);
            }
        }
    } */
}	