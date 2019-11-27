<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable implements JWTSubject
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'created_at', 'updated_at'];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public static function create(Request $request)
    {
        $user = new User();
        if (!empty($request->get('username'))) {
            $user->username = $request->get('username');
        }
        if (!empty($request->get('password'))) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        return $user;
    }


    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }






}
