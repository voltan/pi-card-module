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
    // route name
    'department' => array(
        'name'     => 'card',
        'type'     => 'Module\Card\Route\Card',
        'options'  => array(
            'route'     => '/card',
            'defaults'  => array(
                'module'     => 'card',
                'controller'  => 'index',
                'action'      => 'index'
            )
        ),
    )
);