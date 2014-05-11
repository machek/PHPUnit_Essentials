<?php

class FakeLogger implements ILogger
{
    public function log($request, $priority)
    {
        return true;
    }
}