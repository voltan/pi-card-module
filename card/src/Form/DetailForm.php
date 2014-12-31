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

class DetailForm  extends BaseForm
{
	public function __construct($name = null, $option = array())
    {
        $this->option = $option;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new DetailFilter($this->option);
        }
        return $this->filter;
    }

    public function init()
    {
        // id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // field_1
        if (isset($this->option['field_1_title'])) {
            $this->add(array(
                'name' => 'field_1',
                'options' => array(
                    'label' => $this->option['field_1_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_2
        if (isset($this->option['field_2_title'])) {
            $this->add(array(
                'name' => 'field_2',
                'options' => array(
                    'label' => $this->option['field_2_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_3
        if (isset($this->option['field_3_title'])) {
            $this->add(array(
                'name' => 'field_3',
                'options' => array(
                    'label' => $this->option['field_3_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_4
        if (isset($this->option['field_4_title'])) {
            $this->add(array(
                'name' => 'field_4',
                'options' => array(
                    'label' => $this->option['field_4_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_5
        if (isset($this->option['field_5_title'])) {
            $this->add(array(
                'name' => 'field_5',
                'options' => array(
                    'label' => $this->option['field_5_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_6
        if (isset($this->option['field_6_title'])) {
            $this->add(array(
                'name' => 'field_6',
                'options' => array(
                    'label' => $this->option['field_6_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_7
        if (isset($this->option['field_7_title'])) {
            $this->add(array(
                'name' => 'field_7',
                'options' => array(
                    'label' => $this->option['field_7_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_8
        if (isset($this->option['field_8_title'])) {
            $this->add(array(
                'name' => 'field_8',
                'options' => array(
                    'label' => $this->option['field_8_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_9
        if (isset($this->option['field_9_title'])) {
            $this->add(array(
                'name' => 'field_9',
                'options' => array(
                    'label' => $this->option['field_9_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
        // field_10
        if (isset($this->option['field_10_title'])) {
            $this->add(array(
                'name' => 'field_10',
                'options' => array(
                    'label' => $this->option['field_10_title'],
                ),
                'attributes' => array(
                    'type' => 'text',
                    'description' => '',
                )
            ));
        }
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