<?php

namespace XuanHieu\MailOtp\Models;

use Illuminate\Database\Eloquent\Model;

class MailOtp extends Model
{
    protected $fillable = [
        'hash',
        'email',
        'otp',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public $timestamps = false;
}