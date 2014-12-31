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
namespace Module\Card\Block;

use Pi;
use Zend\Db\Sql\Predicate\Expression;

class Block
{
    public static function product($options = array(), $module = null)
    {
        // Set options
        $block = array();
        $block = array_merge($block, $options);
        // List of categoryes
        $block['category'] = Pi::api('category', 'card')->categoryList();
        // Set id list
        $categoryId = array();
        foreach ($block['category'] as $category) {
            $categoryId[$category['id']] = $category['id'];
        }
        // List of product
        $block['product'] =Pi::api('product', 'card')->productList($categoryId);


        return $block;
    }
}