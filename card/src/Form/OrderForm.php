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

class OrderForm  extends BaseForm
{
    public function __construct($name = null, $option = array())
    {
        $this->config = Pi::service('registry')->config->read('card', 'order');
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new OrderFilter;
        }
        return $this->filter;
    }

    public function init()
    {
        // name
        if ($this->config['order_name']) {
            // first_name
            $this->add(array(
                'name' => 'first_name',
                'options' => array(
                    'label' => __('First Name'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true,
                )
            ));
            // last_name
            $this->add(array(
                'name' => 'last_name',
                'options' => array(
                    'label' => __('Last name'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true,
                )
            ));
        }
        // email
        if ($this->config['order_email']) {
            $this->add(array(
                'name' => 'email',
                'options' => array(
                    'label' => __('Email'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true,
                )
            ));
        }
        // phone
        if ($this->config['order_phone']) {
            $this->add(array(
                'name' => 'phone',
                'options' => array(
                    'label' => __('Phone'),
                ),
                    'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // mobile
        if ($this->config['order_mobile']) {
            $this->add(array(
                'name' => 'mobile',
                'options' => array(
                    'label' => __('Mobile'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true, 
                )
            ));
        }
        // company
        if ($this->config['order_company']) {
            $this->add(array(
                'name' => 'company',
                'options' => array(
                    'label' => __('Company'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // address
        if ($this->config['order_address']) {
            $this->add(array(
                'name' => 'address',
                'options' => array(
                    'label' => __('Address'),
                ),
                'attributes' => array(
                    'type' => 'textarea',
                    'rows' => '3',
                    'cols' => '40',
                    'required' => true,
                    'description' => '',
                )
            ));
        }
        // country
        if ($this->config['order_country']) {
            $this->add(array(
                'name' => 'country',
                'options' => array(
                    'label' => __('Country'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true, 
                )
            ));
        }
        // city
        if ($this->config['order_city']) {
            $this->add(array(
                'name' => 'city',
                'options' => array(
                    'label' => __('City'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true, 
                )
            ));
        }
        // zip_code
        if ($this->config['order_zip']) {
            $this->add(array(
                'name' => 'zip_code',
                'options' => array(
                    'label' => __('Zip code'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                    'required' => true, 
                )
            ));
        }
        // payment_adapter
        $this->add(array(
            'name' => 'payment_adapter',
            'type' => 'Module\Card\Form\Element\Gateway',
            'options' => array(
                'label' => __('Adapter'),
            ),
            'attributes' => array(
                'required' => true, 
            )
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Confirm and pay'),
                'class' => 'btn btn-primary',
            )
        ));
    }
}