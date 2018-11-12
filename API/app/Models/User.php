<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Token;

class User extends Authenticatable {
	use Notifiable;

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
		'tokenPasswordRecovery',
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
//    public function feed(){
	//        return $this->hasMany('App\Feed');
	//    }
	public function token() {
		return $this->belongsTo('App\Token');
	}
	public function role() {
		return $this->belongsToMany('App\Role');
	}

    public function getJWTIdentifier() {
        return $this->getKey(); // Eloquent Model method
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
//    public function friendsOfMine()
	//    {
	//        return $this->belongsToMany(User::class, 'user_friend', 'user_id', 'friend_id');
	//    }
	//    public function friendOf()
	//    {
	//        return $this->belongsToMany(User::class, 'user_friend', 'friend_id', 'user_id');
	//    }
	//
	//    public function friendRequestsPending()
	//    {
	//        return $this->friendOf()->wherePivot('accepted', false)->get();
	//    }
	//    public function unFollowed()
	//    {
	//        return $this->friendsOfMine()->wherePivot('followed', true)->get()
	//            ->merge($this->friendOf()->wherePivot('followed', true)->get());
	//    }
	//    public function acceptUnfollow(User $user)
	//    {
	//        $this->unFollowed()->where('id', $user->id)->first()->pivot->update([
	//            'followed' => false
	//        ]);
	//    }
	//    public function unFollowedResponse()
	//    {
	//        return $this->friendsOfMine()->wherePivot('followed', false)->get()
	//            ->merge($this->friendOf()->wherePivot('followed', false)->get());
	//    }
	//    public function hasFollowResponse(user $user)
	//    {
	//        return (bool) $this->unFollowed()->where('id', $user->id)->count();
	//    }
	//    public function hasUnfollowResponse(user $user)
	//    {
	//        return (bool) $this->unFollowedResponse()->where('id', $user->id)->count();
	//    }
	//    public function acceptFollow(User $user)
	//    {
	//        $this->unFollowedResponse()->where('id', $user->id)->first()->pivot->update([
	//            'followed' => true
	//        ]);
	//    }
	//
	//    public function unblock()
	//    {
	//        return $this->friendsOfMine()->wherePivot('blocked', true)->get()
	//            ->merge($this->friendOf()->wherePivot('blocked', true)->get());
	//    }
	//    public function acceptUnblock(User $user)
	//    {
	//        $this->unblock()->where('id', $user->id)->first()->pivot->update([
	//            'blocked' => false
	//        ]);
	//    }
	//    public function unblockedResponse()
	//    {
	//        return $this->friendsOfMine()->wherePivot('blocked', false)->get()
	//            ->merge($this->friendOf()->wherePivot('blocked', false)->get());
	//    }
	//    public function hasUnblockResponse(user $user)
	//    {
	//        return (bool) $this->unblockedResponse()->where('id', $user->id)->count();
	//    }
	//    public function acceptBlock(User $user)
	//    {
	//        $this->unblockedResponse()->where('id', $user->id)->first()->pivot->update([
	//            'blocked' => true
	//        ]);
	//    }
	//    public function hasBlockResponse(user $user)
	//    {
	//        return (bool) $this->unblock()->where('id', $user->id)->count();
	//    }
	//    public function blockList()
	//    {
	//        return $this->friendsOfMine()->wherePivot('blocked', true)->get()
	//            ->merge($this->friendOf()->wherePivot('blocked', true)->get());
	//
	//    }
	//    public function friendList()
	//    {
	//        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
	//            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
	//
	//    }
	//    public function hasFriendRequestPending(User $user)
	//    {
	//        return (bool) $this->friendRequests()->where('id', $user->id)->count();
	//    }
	//    public function friendRequests()
	//    {
	//        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
	//    }
	//    public function hasFriendRequestReceived(user $user)
	//    {
	//        return (bool) $this->friendRequests()->where('id', $user->id)->count();
	//    }
	//    public function friendResponse()
	//    {
	//        return $this->friendOf()->wherePivot('accepted', true)->get();
	//    }
	//    public function hasFriendResponse(user $user)
	//    {
	//        return (bool) $this->friendResponse()->where('id', $user->id)->count();
	//    }
	//    public function disabledPending()
	//    {
	//        return $this->friendOf()->wherePivot('disabled', false)->get();
	//    }
	//    public function acceptDisabled(User $user)
	//    {
	//        $this->disabledPending()->where('id', $user->id)->first()->pivot->update([
	//            'disabled' => true,
	//        ]);
	//    }
	//    public function addFriend(User $user)
	//    {
	//        $this->friendsOfMine()->attach($user->id);
	//    }
	//    public function removeFriend(User $user)
	//    {
	//        $this->friendsOfMine()->detach($user->id);
	//    }
	//    public function acceptFriendRequest(User $user)
	//    {
	//        $this->friendRequestsPending()->where('id', $user->id)->first()->pivot->update([
	//            'accepted' => true,
	//            'followed' => true,
	//        ]);
	//    }

	protected $hidden = [
		'password',
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
