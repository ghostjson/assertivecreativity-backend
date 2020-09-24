<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @method static where(string $string, string $string)
 */
class Role extends Model
{
    use HasFactory;

    /**
     * Get role id of the user
     * @return int roleID
     * */
    public static function getUserRoleID() : int
    {
        return Role::where('name', 'user')->first()->id;
    }


    /**
     * Get role id of the vendor
     * @return int roleID
     * */
    public static function getVendorRoleID() : int
    {
        return Role::where('name', 'vendor')->first()->id;
    }

    /**
     * Get role id of the admin
     * @return int roleID
     * */
    public static function getAdminRoleID() : int
    {
        return Role::where('name', 'admin')->first()->id;
    }


    /**
     * Return users of a selected role
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id', 'role_id');
    }
}
