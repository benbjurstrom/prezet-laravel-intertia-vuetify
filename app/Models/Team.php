<?php

namespace App\Models;

use BenBjurstrom\EloquentPostgresUuids\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use Notifiable, HasUuid;

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'owner_id' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Get the owner's email address.
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->owner->email;
    }

    /**
     * Get the team photo URL attribute.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function getPhotoUrlAttribute($value)
    {
        return empty($value)
            ? 'https://www.gravatar.com/avatar/' . md5($this->name . '@prezet.com') . '.jpg?s=200&d=identicon'
            : url($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * Get the owner of the team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all of the users that belong to the team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_users', 'team_id', 'user_id')->withPivot('role');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    |
    */

    //

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * Detach all of the users from the team and delete the team.
     *
     * @return void
     */
    public function detachUsersAndDestroy()
    {
        $this->users()
            ->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->detach();

        $this->delete();
    }
}
