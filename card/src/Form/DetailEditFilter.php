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
use Zend\InputFilter\InputFilter;

class DetailEditFilter extends InputFilter
{
    public function __construct($option = array())
    {
        // id
        $this->add(array(
            'name' => 'id',
            'required' => true,
        ));
        // product
        $this->add(array(
            'name' => 'product',
            'required' => true,
        ));
        // status
        $this->add(array(
            'name' => 'status',
            'required' => true,
        ));
        // field_1
        if (isset($option['field_1_title'])) {
        	$this->add(array(
            	'name' => 'field_1',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_2
        if (isset($option['field_2_title'])) {
        	$this->add(array(
            	'name' => 'field_2',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_3
        if (isset($option['field_3_title'])) {
        	$this->add(array(
            	'name' => 'field_3',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_4
        if (isset($option['field_4_title'])) {
        	$this->add(array(
            	'name' => 'field_4',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_5
        if (isset($option['field_5_title'])) {
        	$this->add(array(
            	'name' => 'field_5',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_6
        if (isset($option['field_6_title'])) {
        	$this->add(array(
            	'name' => 'field_6',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_7
        if (isset($option['field_7_title'])) {
        	$this->add(array(
            	'name' => 'field_7',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_8
        if (isset($option['field_8_title'])) {
        	$this->add(array(
            	'name' => 'field_8',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_9
        if (isset($option['field_9_title'])) {
        	$this->add(array(
            	'name' => 'field_9',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
        // field_10
        if (isset($option['field_10_title'])) {
        	$this->add(array(
            	'name' => 'field_10',
            	'required' => true,
            	'filters' => array(
                	array(
                    	'name' => 'StringTrim',
                	),
            	),
        	));
        }
    }
}    