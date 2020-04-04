<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response | \Inertia\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof EnforceTwoFactorAuthException) {
            return Inertia::render('Auth/TwoFactor', [
                'email' => $exception->getEmail(),
                'password' => $exception->getPassword(),
                'remember' => $exception->getRemember(),
            ]);
        }

        return parent::render($request, $exception);
    }
}
