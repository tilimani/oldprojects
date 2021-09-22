<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'worker/queue',
        'worker/schedule',
        '/twiliowebhookhandle',
        'api/v1/webhook/twilio',
        'api/v2/webhook/twilio',
        'api/v1/webhook/get',
        'api/v1/webhook/post',
        'api/v1/webhook/get'
    ];
}
