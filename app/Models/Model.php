<?php

namespace App\Models;

use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use HasUuid;

    /**
     * @var array $guarded
     */
    protected $guarded = [];

    protected $perPage = 10;

    public function resolveRouteBinding($value)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)
                ->withTrashed()
                ->first()
            : parent::resolveRouteBinding($value);
    }
}
