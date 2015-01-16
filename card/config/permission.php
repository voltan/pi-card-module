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
    // Front section
    'front' => array(
        'checkout'       => array(
            'title'         => _a('Checkout'),
            'access'        => array(
                'guest',
                'member',
            ),
        ),
    ),
    // Admin section
    'admin' => array(
        'product'       => array(
            'title'         => _a('Product'),
            'access'        => array(
                //'admin',
            ),
        ),
        'detail'       => array(
            'title'         => _a('Detail'),
            'access'        => array(
                //'admin',
            ),
        ),
        'category'       => array(
            'title'         => _a('Category'),
            'access'        => array(
                //'admin',
            ),
        ),
        'order'       => array(
            'title'         => _a('Orders'),
            'access'        => array(
                //'admin',
            ),
        ),
    ),
);