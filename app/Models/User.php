<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'position',
        'company',
        'inn',
        'kpp',
        'category_id',
        'role_id',
        'position_id',
        'organization_id',
        'verification_token'
    ];
    protected $appends = ['position_name'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function findForPassport($username)
    {
        return $this->where('phone', $username)->first();
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getPositionNameAttribute()
    {
        return $this->position ? $this->position->name : null;
    }

    public function getOrganizationNameAttribute()
    {
        return $this->organization ? $this->organization->name : null;
    }
}
