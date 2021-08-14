<?php

namespace Latus\Laravel\Exceptions;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}