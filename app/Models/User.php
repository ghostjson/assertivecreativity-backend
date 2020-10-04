<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed id
 * @property mixed email
 * @property mixed password
 * @property mixed role_id
 * @property mixed phone
 * @property mixed profession
 * @property mixed company_details
 * @property string first_name
 * @property string last_name
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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


    /**
     * Hash password before saving to database #mutator
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get role of the current user
     * @return BelongsTo #Role
     */
    public function role() : BelongsTo #Role
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    /**
     * Create new User
     * @param array $user
     * @return User
     */
    public static function createUser(array $user) : User
    {
        $u = new User;
        $u->first_name = $user['first_name'];
        $u->last_name = $user['last_name'];
        $u->email = $user['email'];
        $u->password = $user['password'];
        $u->company_details = in_array('company_details', $user) ? $user['company_details'] : null;
        $u->profession = in_array('profession', $user) ? $user['profession'] : null;
        $u->phone = in_array('phone', $user) ? $user['phone'] : null;
        $u->role_id = Role::getUserRoleID();
        $u->save();

        return $u;
    }

    /**
     * Create new Vendor
     * @param array $user
     * @return User
     */
    public static function createVendor(array $user) : User
    {
        $u = new User;
        $u->first_name = $user['firstname'];
        $u->lastname_name = $user['last_name'];
        $u->email = $user['email'];
        $u->password = $user['password'];
        $u->company_details = in_array('company_details', $user) ? $user['company_details'] : null;
        $u->profession = in_array('profession', $user) ? $user['profession'] : null;
        $u->phone = in_array('phone', $user) ? $user['phone'] : null;
        $u->role_id = Role::getVendorRoleID();
        $u->save();

        return $u;
    }


    /**
     * Check the current user is admin or not
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role_id == Role::getAdminRoleID();
    }

    /**
     * Check the current user is vendor or not
     * @return bool
     */
    public function isVendor() : bool
    {
        return (($this->role_id == Role::getVendorRoleID()) || ($this->role_id == Role::getAdminRoleID()));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
