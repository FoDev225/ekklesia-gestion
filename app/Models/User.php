<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_active',
        'believer_id',

        'deactivated_at',
        'deactivated_by',
        'deactivation_reason',

        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation with Role model
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Relation with Believer model
    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }

    // Check if user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    // Assign a role to the user
    public function assignRole($role)
    {
        $roleModel = Role::where('slug', $role)->first();
        if ($roleModel) {
            $this->roles()->attach($roleModel); // Attach the role to the user
        }
    }

    // Relation with LoginHistory model
    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }
}
