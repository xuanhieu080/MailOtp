<?php

namespace Xuanhieu080\MailOtp\Facades;

use Illuminate\Support\Facades\Facade;

class MailOtp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MailOtp';
    }
}