<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject {
	use Notifiable;
	protected $primaryKey = 'idUser';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	public $table = 'users';
	protected $fillable = [
		'username',
		'email',
		'fullName',
		'idNumber',
		'phoneNumber',
		'avatar',
		'dateOfBirth',
		'gender',
		'addressUser',
		'activationCode',
		'isActivated',
		'tokenExpirationTime',
		'password',
		'pinCode',
		'roleId',

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */

	public function token() {
		return $this->hasOne('App\Token','user_token_id','idUser');
	}
	public function role() {
		return $this->belongsToMany('App\Role');
	}


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function store(){
        return $this->hasOne('App\Store','idUser','idUser');
    }
    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser','user_id','idUser');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */


	protected $hidden = [
		'password','tokenPasswordRecovery',
	];
	public $ruleCustom = [
		'RULE_USERS_CREATE' => [
			'name' => 'required|alpha|max:255',
//            'username'      => 'required',
			'email' => 'required|email|regex:/^(?=[^@]{2,}@)([a-zA-Z0-9]*@(?=.{2,}\.[^.]*$)[\w\.-]*[a-zA-Z]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z])$/',
			'password' => 'required|min:6|',
			'date_of_birth' => ['required', 'date'],
			'gender' => ['required', 'regex:/^male|female$/'],

			'address' => 'max:60',
			'about' => 'max:255',
		],
		'RULE_USERS_CHANGE_PASSWORD' => [
			'password' => 'required|min:6|',
		],
		'RULE_USERS_CREATE_PHONE' => [
			'phone_number' => 'required|regex:/^\D*(?:\d\D*){9,}$/',
			'name' => 'required|alpha|max:255',
			'country_code' => 'required|numeric',
			'password' => 'required|min:6|',
		],
		'RULE_USERS_UPDATE_PROFILE' => [
			'date_of_birth' => ['required', 'date'],
			'gender' => ['required', 'regex:/^male|female$/'],
			'init_lat' => ['required', 'regex:/^(\+|-)?((\d((\.)|\.\d{1,6})?)|(0*?[0-8]\d((\.)|\.\d{1,6})?)|(0*?90((\.)|\.0{1,6})?))$/'],
			'init_lng' => ['required', 'regex:/^(\+|-)?((\d((\.)|\.\d{1,6})?)|(0*?\d\d((\.)|\.\d{1,6})?)|(0*?1[0-7]\d((\.)|\.\d{1,6})?)|(0*?180((\.)|\.0{1,6})?))$/'],
			'address' => 'max:60',
			'about' => 'max:255',
		],
		'RULE_USER_CHECK' => [
			'email' => 'email',
		],
		'RULE_USER_CHECK_PHONE' => [
			'country_code' => 'required|numeric',
			'phone_number' => 'required|regex:/^\D*(?:\d\D*){9,}$/',
		],
	];
}
