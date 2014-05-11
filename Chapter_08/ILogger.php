<?php

Interface ILogger
{
    public function log($request, $priority);

    const PRIORITY_ERROR = 1;
    const PRIORITY_INFO = 2;
    const PRIORITY_WARNING = 3;
}