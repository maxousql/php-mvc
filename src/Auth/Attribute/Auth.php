<?php

namespace App\Auth\Attribute;

use App\Services\SessionManager;

class AuthAttribute
{
    private $requiresAuthentication;
    public function __construct(bool $requiresAuthentication = true)
    {
        $this->requiresAuthentication = $requiresAuthentication;
    }

    public function authorize()
    {
        if ($this->requiresAuthentication) {
            $sessionManager = new SessionManager();
            return $sessionManager->get('user');
        }
        return true;
    }
}
