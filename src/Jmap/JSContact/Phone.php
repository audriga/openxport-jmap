<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Phone extends TypeableEntity implements JsonSerializable
{
    /**
     * @var string|null
     */
    private $number;

    /**
     * @var array|null
     */
    private $contexts;

    /**
     * @var int|string|null
     */
    private $pref;

    /**
     * @var array|null  // e.g. ['voice' => true, 'fax' => true]
     */
    private $features;

    /**
     * @var string|null // free-form label for TEL types that don’t map to features
     */
    private $label;


    public function __construct($number = null, $contexts = null, $pref = null)
    {
        $this->setAtType('Phone');

        if ($number !== null) {
            $this->number = $number;
        }
        if ($contexts !== null) {
            $this->contexts = $contexts;
        }
        if ($pref !== null) {
            $this->pref = $pref;
        }
    }


    public function getNumber()
    {
        return $this->number;
    }


    public function setNumber($number)
    {
        $this->number = $number;
    }


    public function getContexts()
    {
        return $this->contexts;
    }


    public function setContexts($contexts)
    {
        $this->contexts = $contexts;
    }


    public function getPref()
    {
        return $this->pref;
    }


    public function setPref($pref)
    {
        $this->pref = $pref;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures($features)
    {
        $this->features = $features;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            '@type'    => $this->getAtType(),
            'number'   => $this->getNumber(),
            'contexts' => $this->getContexts(),
            'pref'     => $this->getPref(),
            'features' => $this->getFeatures(),
            'label'    => $this->getLabel(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
