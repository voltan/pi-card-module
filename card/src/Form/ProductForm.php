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

namespace Module\Card\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class ProductForm  extends BaseForm
{
    protected $thumbUrl = '';

    public function __construct($name = null, $option = array())
    {
        $this->category = array(0 => '');
        $this->thumbUrl = (isset($option['thumbUrl'])) ? $option['thumbUrl'] : '';
        $this->removeUrl = (isset($option['removeUrl'])) ? $option['removeUrl'] : '';
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new ProductFilter;
        }
        return $this->filter;
    }

    public function init()
    {
        // extra_general
        $this->add(array(
            'name' => 'extra_general',
            'type' => 'fieldset',
            'options' => array(
                'label' => __('General options'),
            ),
        ));
        // id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // title
        $this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => __('Title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // slug
        $this->add(array(
            'name' => 'slug',
            'options' => array(
                'label' => __('slug'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // text_description
        $this->add(array(
            'name' => 'text_description',
            'options' => array(
                'label' => __('Description'),
                'editor' => 'html',
            ),
            'attributes' => array(
                'type' => 'editor',
                'description' => '',
            )
        ));
        // status
        $this->add(array(
            'name' => 'status',
            'type' => 'select',
            'options' => array(
                'label' => __('Status'),
                'value_options' => array(
                    1 => __('Published'),
                    2 => __('Pending review'),
                    3 => __('Draft'),
                    4 => __('Private'),
                    5 => __('Delete'),
                ),
            ),
        ));
        // category
        $this->add(array(
            'name' => 'category',
            'type' => 'Module\Card\Form\Element\Category',
            'options' => array(
                'label' => __('Category'),
                'category' => '',
            ),
        ));
        // Image
        if ($this->thumbUrl) {
            $this->add(array(
                'name' => 'imageview',
                'type' => 'Module\Card\Form\Element\Image',
                'options' => array(
                    //'label' => __('Image'),
                ),
                'attributes' => array(
                    'src' => $this->thumbUrl,
                ),
            ));
            $this->add(array(
                'name' => 'remove',
                'type' => 'Module\Card\Form\Element\Remove',
                'options' => array(
                    'label' => __('Remove image'),
                ),
                'attributes' => array(
                    'link' => $this->removeUrl,
                ),
            ));
            $this->add(array(
                'name' => 'image',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            ));
        } else {
            $this->add(array(
                'name' => 'image',
                'options' => array(
                    'label' => __('Image'),
                ),
                'attributes' => array(
                    'type' => 'file',
                    'description' => '',
                )
            ));
        }
        // extra_price
        $this->add(array(
            'name' => 'extra_price',
            'type' => 'fieldset',
            'options' => array(
                'label' => __('Price options'),
            ),
        ));
        // price
        $this->add(array(
            'name' => 'price',
            'options' => array(
                'label' => __('Price'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // price_title
        $this->add(array(
            'name' => 'price_title',
            'options' => array(
                'label' => __('Price title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // extra_seo
        $this->add(array(
            'name' => 'extra_seo',
            'type' => 'fieldset',
            'options' => array(
                'label' => __('SEO options'),
            ),
        ));
        // seo_title
        $this->add(array(
            'name' => 'seo_title',
            'options' => array(
                'label' => __('SEO Title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // seo_keywords
        $this->add(array(
            'name' => 'seo_keywords',
            'options' => array(
                'label' => __('SEO Keywords'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // seo_description
        $this->add(array(
            'name' => 'seo_description',
            'options' => array(
                'label' => __('SEO Description'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                
            )
        ));
        // extra_field
        $this->add(array(
            'name' => 'extra_field',
            'type' => 'fieldset',
            'options' => array(
                'label' => __('Fields options'),
            ),
        ));
        // field_1_title
        $this->add(array(
            'name' => 'field_1_title',
            'options' => array(
                'label' => __('Field 1 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_2_title
        $this->add(array(
            'name' => 'field_2_title',
            'options' => array(
                'label' => __('Field 2 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_3_title
        $this->add(array(
            'name' => 'field_3_title',
            'options' => array(
                'label' => __('Field 3 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_4_title
        $this->add(array(
            'name' => 'field_4_title',
            'options' => array(
                'label' => __('Field 4 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_5_title
        $this->add(array(
            'name' => 'field_5_title',
            'options' => array(
                'label' => __('Field 5 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_6_title
        $this->add(array(
            'name' => 'field_6_title',
            'options' => array(
                'label' => __('Field 6 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_7_title
        $this->add(array(
            'name' => 'field_7_title',
            'options' => array(
                'label' => __('Field 7 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_8_title
        $this->add(array(
            'name' => 'field_8_title',
            'options' => array(
                'label' => __('Field 8 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_9_title
        $this->add(array(
            'name' => 'field_9_title',
            'options' => array(
                'label' => __('Field 9 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // field_10_title
        $this->add(array(
            'name' => 'field_10_title',
            'options' => array(
                'label' => __('Field 10 title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
            )
        ));
    }
}