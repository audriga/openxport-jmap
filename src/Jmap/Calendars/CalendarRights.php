<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;
use OpenXPort\Util\Logger;

class CalendarRights implements JsonSerializable
{
    private $mayReadFreeBusy;
    private $mayReadItems;
    private $mayAddItems;
    private $mayUpdatePrivate;
    private $mayRSVP;
    private $mayUpdateOwn;
    private $mayUpdateAll;
    private $mayRemoveOwn;
    private $mayRemoveAll;
    private $mayAdmin;
    private $mayDelete;

    public function getMayReadFreeBusy()
    {
        return $this->mayReadFreeBusy;
    }

    public function setMayReadFreeBusy($mayReadFreeBusy)
    {
        $this->mayReadFreeBusy = $mayReadFreeBusy;
    }

    public function getMayReadItems()
    {
        return $this->mayReadItems;
    }

    public function setMayReadItems($mayReadItems)
    {
        $this->mayReadItems = $mayReadItems;
    }

    public function getMayAddItems()
    {
        return $this->mayAddItems;
    }

    public function setMayAddItems($mayAddItems)
    {
        $this->mayAddItems = $mayAddItems;
    }

    public function getMayUpdatePrivate()
    {
        return $this->mayUpdatePrivate;
    }

    public function setMayUpdatePrivate($mayUpdatePrivate)
    {
        $this->mayUpdatePrivate = $mayUpdatePrivate;
    }

    public function getMayRSVP()
    {
        return $this->mayRSVP;
    }

    public function setMayRSVP($mayRSVP)
    {
        $this->mayRSVP = $mayRSVP;
    }

    public function getMayUpdateOwn()
    {
        return $this->mayUpdateOwn;
    }

    public function setMayUpdateOwn($mayUpdateOwn)
    {
        $this->mayUpdateOwn = $mayUpdateOwn;
    }

    public function getMayUpdateAll()
    {
        return $this->mayUpdateAll;
    }

    public function setMayUpdateAll($mayUpdateAll)
    {
        $this->mayUpdateAll = $mayUpdateAll;
    }

    public function getMayRemoveOwn()
    {
        return $this->mayRemoveOwn;
    }

    public function setMayRemoveOwn($mayRemoveOwn)
    {
        $this->mayRemoveOwn = $mayRemoveOwn;
    }

    public function getMayRemoveAll()
    {
        return $this->mayRemoveAll;
    }

    public function setMayRemoveAll($mayRemoveAll)
    {
        $this->mayRemoveAll = $mayRemoveAll;
    }

    public function getMayAdmin()
    {
        return $this->mayAdmin;
    }

    public function setMayAdmin($mayAdmin)
    {
        $this->mayAdmin = $mayAdmin;
    }

    public function getMayDelete()
    {
        return $this->mayDelete;
    }

    public function setMayDelete($mayDelete)
    {
        $this->mayDelete = $mayDelete;
    }

    /**
     * Parses a CalendarRights object from the given JSON representation.
     *
     * @param mixed $json String/Array/Object containing calendar rights.
     *
     * @return CalendarRights
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            $json = json_decode($json);
        }

        if ($json instanceof \stdClass) {
            $json = (array) $json;
        }

        $classInstance = new self();

        foreach ((array) $json as $key => $value) {
            if (!property_exists($classInstance, $key)) {
                $logger = Logger::getInstance();
                $logger->warning("File contains property not existing in " . self::class . ": $key");
                continue;
            }

            $setPropertyMethod = "set" . ucfirst($key);

            if (!method_exists($classInstance, $setPropertyMethod)) {
                $logger = Logger::getInstance();
                $logger->warning(
                    self::class . " is missing a setter for $key."
                );
                continue;
            }

            $classInstance->{$setPropertyMethod}($value);
        }

        return $classInstance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "mayReadFreeBusy" => $this->getMayReadFreeBusy(),
            "mayReadItems" => $this->getMayReadItems(),
            "mayAddItems" => $this->getMayAddItems(),
            "mayUpdatePrivate" => $this->getMayUpdatePrivate(),
            "mayRSVP" => $this->getMayRSVP(),
            "mayUpdateOwn" => $this->getMayUpdateOwn(),
            "mayUpdateAll" => $this->getMayUpdateAll(),
            "mayRemoveOwn" => $this->getMayRemoveOwn(),
            "mayRemoveAll" => $this->getMayRemoveAll(),
            "mayAdmin" => $this->getMayAdmin(),
            "mayDelete" => $this->getMayDelete()
        ], function ($val) {
            return !is_null($val);
        });
    }
}