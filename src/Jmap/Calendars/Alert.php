<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

class Alert implements JsonSerializable
{
    private $type;
    private $trigger;
    private $acknowledged;
    private $relatedTo;
    private $action;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTrigger()
    {
        return $this->trigger;
    }

    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }

    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = $acknowledged;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Parses an Alert object from the given JSON representation.
     * 
     * @param string|array|object $json string/array/object containing an alert in the JSCalendar format.
     * 
     * @return array Alert array containing any properties that can be
     * parsed from the given JSON string/array/object.
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        $alerts = [];


        // In JSCalendar, alerts are stored in an Id[Alert] array. Therefore we must loop through
        // each entry in that array and create an Alert object for that specific one.
        foreach ($json as $id => $object) {

            $classInstance = new Alert();

            foreach ($object as $key => $value) {
                if (!property_exists($classInstance, $key)) {
                    // TODO: Should probably add a logger to each class that can be called here.
                    continue;
                }

                // Since all of the properties are private, using this will allow acces to the setter
                // functions of any given property. 
                // Caution! In order for this to work, every setter method needs to match the property
                // name. So for a var fooBar, the setter needs to be named setFooBar($fooBar).
                $setPropertyMethod = "set" . ucfirst($key);

                if (!method_exists($classInstance, $setPropertyMethod)) {
                    // TODO: same as with property check, add a logger maybe.
                    continue;
                }

                // Triggers need to be parsed from their own fromJson() method.
                if ($key == "trigger") {

                    if (!property_exists($value, "@type")) {
                        continue;
                    }

                    if ($value->{"@type"} = "AbsoluteTrigger") {
                        $value = AbsoluteTrigger::fromJson($value);
                    } else if ($value->{"@type"} = "OffsetTrigger") {
                        $value = OffsetTrigger::fromJson($value);
                    } else {
                        $value = UnknownTrigger::fromJson($value);
                    }
                }

                // Set the property in the class' instance.
                $classInstance->{"$setPropertyMethod"}($value);
            }

            $participants[$id] = $classInstance;
        }

        return $participants;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "@type" => $this->getType(),
            "trigger" => $this->getTrigger(),
            "acknowledged" => $this->getAcknowledged(),
            "relatedTo" => $this->getRelatedTo(),
            "action" => $this->getAction()
        ];
    }
}
