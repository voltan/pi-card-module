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
return array(
    // Admin section
    'admin' => array(
        array(
            'label'         => _a('Product'),
            'controller'    => 'product',
            'permission'    => 'product',
        ),
        array(
            'title'         => _a('Detail'),
            'controller'    => 'detail',
            'permission'    => 'detail',
        ),
        array(
            'label'         => _a('Orders'),
            'controller'    => 'order',
            'permission'    => 'order',
        ),
        array(
            'label'         => _a('Customers'),
            'controller'    => 'customer',
            'permission'    => 'customer',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'title'         => _a('List of products'),
            'controller'    => 'index',
            'permission'    => 'public',
            'block'         => 1,
        ),
        array(
            'title'         => _a('Single product'),
            'controller'    => 'product',
            'permission'    => 'public',
            'block'         => 1,
        ),
        array(
            'title'         => _a('Checkout'),
            'controller'    => 'checkout',
            'permission'    => 'checkout',
            'block'         => 1,
        ),
        array(
            'title'         => _a('Customer'),
            'controller'    => 'customer',
            'permission'    => 'customer',
            'block'         => 1,
        ),
    ),
);