<?php

namespace App\Exceptions;

use Exception;

class EnforceTwoFactorAuthException extends Exception
{
    protected string $email;
    protected string $password;
    protected string $remember;

    public function __construct(array $data) {
        $this->email = $data['credentials']['email'];
        $this->password = $data['credentials']['password'];
        $this->remember = $data['remember'];

        parent::__construct('Two Factor Required', 403,null);
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRemember(): string {
        return $this->remember;
    }

}
