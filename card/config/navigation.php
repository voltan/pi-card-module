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
    'front'   => array(
        'index' => array(
            'label'         => _a('Index'),
            'permission'    => array(
                'resource'  => 'public',
            ),
            'route'         => 'card',
            'module'        => 'card',
            'controller'    => 'index',
            'action'        => 'index',
        ),
        'customer' => array(
            'label'         => _a('My Orders'),
            'permission'    => array(
                'resource'  => 'customer',
            ),
            'route'         => 'card',
            'module'        => 'card',
            'controller'    => 'customer',
            'action'        => 'index',
        ),
    ),
    'admin' => array(
        'product' => array(
            'label'       => _a('Product'),
            'permission'  => array(
                'resource'  => 'product',
            ),
            'route'       => 'admin',
            'controller'  => 'product',
            'action'      => 'index',
        ),
        'detail' => array(
            'label'       => _a('Detail'),
            'permission'  => array(
                'resource'  => 'detail',
            ),
            'route'       => 'admin',
            'controller'  => 'detail',
            'action'      => 'index',
        ),
        'category' => array(
            'label'       => _a('Category'),
            'permission'  => array(
                'resource'  => 'category',
            ),
            'route'       => 'admin',
            'controller'  => 'category',
            'action'      => 'index',
        ),
        'order' => array(
            'label'       => _a('Orders'),
            'permission'  => array(
                'resource'  => 'order',
            ),
            'route'       => 'admin',
            'controller'  => 'order',
            'action'      => 'index',
        ),
        'customer' => array(
            'label'       => _a('Customer'),
            'permission'  => array(
                'resource'  => 'customer',
            ),
            'route'       => 'admin',
            'controller'  => 'customer',
            'action'      => 'index',
        ),
    ),
);