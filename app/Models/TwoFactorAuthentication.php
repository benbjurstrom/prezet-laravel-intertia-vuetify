<?php

namespace App\Models;

use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthentication extends \DarkGhostHunter\Laraguard\Eloquent\TwoFactorAuthentication
{
    use HasUuid;

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * Sets the Shared Secret attribute to its binary form.
     *
     * @param string $value
     */
    protected function setSharedSecretAttribute($value): void
    {
        $this->attributes['shared_secret'] = $value;
    }
}
