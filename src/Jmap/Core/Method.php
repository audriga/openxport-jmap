<?php

namespace OpenXPort\Jmap\Core;

interface Method
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers);
}
