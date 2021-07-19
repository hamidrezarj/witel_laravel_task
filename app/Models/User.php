<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRole()
    {
        $role = Role::Where('id', $this->role_id)->first();
        return $role;
    }

    # this method works for update and delete only.
    public function hasPermission(Student $student)
    {
        $role = $this->getRole();
        
        switch ($role->name) {
            case 'admin':
                $has_perm = true;
                break;

            case 'owner_user':
                $has_perm = ($this->id === $student->user_id);
                break;

            case 'guest_user':
                $has_perm = false;
                break;

            default:
                $has_perm = false;
        }
        
        return $has_perm;
    }
}
