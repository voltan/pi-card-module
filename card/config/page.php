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
            'title'         => _a('Category'),
            'controller'    => 'category',
            'permission'    => 'category',
        ),
        array(
            'label'         => _a('Orders'),
            'controller'    => 'order',
            'permission'    => 'order',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'title'         => _a('Checkout'),
            'controller'    => 'checkout',
            'permission'    => 'checkout',
            'block'         => 1,
        ),
    ),
);