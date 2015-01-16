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

namespace Module\Card\Form\Element;

use Pi;
use Zend\Form\Element\Select;

class Gateway extends Select
{
    /**
     * @return array
     */
    public function getValueOptions()
    {
        $this->valueOptions = array();
        if (Pi::service('module')->isActive('payment')) {
            $this->valueOptions = Pi::api('gateway', 'payment')->getActiveGatewayName();
        } else {
            $this->valueOptions['offline'] = __('Offline'); 
        }
        return $this->valueOptions;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $this->Attributes = array(
            'class' => 'form-control',
        );
        // check form size
        if (isset($this->attributes['size'])) {
            $this->Attributes['size'] = $this->attributes['size'];
        }
        // check form multiple
        if (isset($this->attributes['multiple'])) {
            $this->Attributes['multiple'] = $this->attributes['multiple'];
        }
        return $this->Attributes;
    }
}