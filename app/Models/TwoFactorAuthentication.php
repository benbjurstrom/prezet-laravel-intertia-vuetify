<?php

namespace App\Models;

use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthentication extends \DarkGhostHunter\Laraguard\Eloquent\TwoFactorAuthentication
{
    use HasUuid;

    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * Sets the Shared Secret attribute to its binary form.
     *
     * @param string $value
     */
    protected function setSharedSecretAttribute($value)
    {
        $this->attributes['shared_secret'] = $value;
    }
}
