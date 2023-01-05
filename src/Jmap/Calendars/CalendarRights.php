<?php

namespace OpenXPort\Jmap\Calendar;

use JsonSerializable;

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
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
        ];
    }
}
