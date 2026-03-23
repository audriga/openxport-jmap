<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

class Phone extends TypeableEntity implements JsonSerializable
{
    private $type = 'Phone';
    /**
     * @var string $number (mandatory)
     */
    private $number;

    /**
     *  @var array<string, boolean> $contexts (optional)
     * The string keys of the array are of type Context
     */
    private $contexts;

    /**
     * @var int $pref (optional)
     * The int here is the Preference type
     */
    private $pref;

    /**
     * @var array<string, boolean> $features (optional)
     */
    private $features;

    /**
     * @var string $label (optional)
     */
    private $label;


    public function __construct($number = null, $contexts = null, $pref = null)
    {
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

    public function getType(){
        return $this->type;
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
