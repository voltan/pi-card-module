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
    ),
);