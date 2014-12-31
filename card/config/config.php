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
    'category' => array(
        array(
            'title'  => _a('Admin'),
            'name'   => 'admin'
        ),
        array(
            'title'  => _a('Image'),
            'name'   => 'image'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category'     => 'admin',
            'title'        => _a('Perpage'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 50
        ),
        // Image
        'image_size' => array(
            'category'     => 'image',
            'title'        => _a('Image Size'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 1000000
        ),
        'image_quality' => array(
            'category'     => 'image',
            'title'        => _a('Image quality'),
            'description'  => _a('Between 0 to 100'),
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 100
        ),
        'image_path' => array(
            'category'     => 'image',
            'title'        => _a('Image path'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => 'shop/image'
        ),
        'image_extension' => array(
            'category'     => 'image',
            'title'        => _a('Image Extension'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => 'jpg,jpeg,png,gif'
        ),
        'image_largeh' => array(
            'category'     => 'image',
            'title'        => _a('Large Image height'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 800
        ),
        'image_largew' => array(
            'category'     => 'image',
            'title'        => _a('Large Image width'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 800
        ),
        'image_mediumh' => array(
            'category'     => 'image',
            'title'        => _a('Medium Image height'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 300
        ),
        'image_mediumw' => array(
            'category'     => 'image',
            'title'        => _a('Medium Image width'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 300
        ),
        'image_thumbh' => array(
            'category'     => 'image',
            'title'        => _a('Thumb Image height'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 150
        ),
        'image_thumbw' => array(
            'category'     => 'image',
            'title'        => _a('Thumb Image width'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 150
        ),
        'image_lightbox' => array(
            'category'     => 'image',
            'title'        => _a('Use lightbox'),
            'description'  => '',
            'edit'         => 'checkbox',
            'filter'       => 'number_int',
            'value'        => 1
        ),
        'image_watermark' => array(
            'category'     => 'image',
            'title'        => _a('Add Watermark'),
            'description'  => '',
            'edit'         => 'checkbox',
            'filter'       => 'number_int',
            'value'        => 0
        ),
        'image_watermark_source' => array(
            'category'     => 'image',
            'title'        => _a('Watermark Image'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => ''
        ),
        'image_watermark_position' => array(
            'title'        => _a('Watermark Positio'),
            'description'  => '',
            'edit'         => array(
                'type'     => 'select',
                'options'  => array(
                    'options' => array(
                        'top-left'      => _a('Top Left'),
                        'top-right'     => _a('Top Right'),
                        'bottom-left'   => _a('Bottom Left'),
                        'bottom-right'  => _a('Bottom Right'),
                    ),
                ),
            ),
            'filter'       => 'text',
            'value'        => 'bottom-right',
            'category'     => 'image',
        ),
    ),
);