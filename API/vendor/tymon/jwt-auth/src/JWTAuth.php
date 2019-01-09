<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tymon\JWTAuth;

use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Log;

class JWTAuth extends JWT
{
    /**
     * The authentication provider.
     *
     * @var \Tymon\JWTAuth\Contracts\Providers\Auth
     */
    protected $auth;

    /**
     * Constructor.
     *
     * @param  \Tymon\JWTAuth\Manager  $manager
     * @param  \Tymon\JWTAuth\Contracts\Providers\Auth  $auth
     * @param  \Tymon\JWTAuth\Http\Parser\Parser  $parser
     *
     * @return void
     */
    public function __construct(Manager $manager, Auth $auth, Parser $parser)
    {
        parent::__construct($manager, $parser);
        $this->auth = $auth;
    }

    /**
     * Attempt to authenticate the user and return the token.
     *
     * @param  array  $credentials
     *
     * @return false|string
     */
    public function attempt(array $credentials)
    {
        if (! $this->auth->byCredentials($credentials)) {

            $email = $credentials['email'];
            $password = $credentials['password'];

            $count = 0;
            $user_id = -1;
            $users = User::all();

            foreach ($users as $user) {
                if ($email === $user['email'] && Hash::check($password, $user['password'])) {
                    Log::debug("not fun ". print_r($user['idUser'],1));
                    $user_id = $user['idUser'];
                    $count++;
                }
            }

            if($count == 0){
                return false;
            }

            $user = User::where('idUser', '=', $user_id)->first();

            return $this->fromUser($user);

           return true;
        }

       
        //return $this->fromUser($user);
      

        
        //Log::debug("helo".print_r($user,1));
        
        //return $this->fromUser($this->user());
    }

    public function test(array $credentials){
              $email = $credentials['email'];
            $password = $credentials['password'];

            $count = 0;
            $users = User::all();
            foreach ($users as $user) {
                if ($email === $user['email'] && Hash::check($password, $user['password'])) {
                    $count++;
                }
            }

            if($count == 0){
                return false;
            }

            $user = User::where('email', '=', "admin@admin.com")->first();

            return $this->fromUser($user);
    }

    /**
     * Authenticate a user via a token.
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject|false
     */
    public function authenticate()
    {
        $id = $this->getPayload()->get('sub');

        if (! $this->auth->byId($id)) {
            return false;
        }

        return $this->user();
    }

    /**
     * Alias for authenticate().
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject|false
     */
    public function toUser()
    {
        return $this->authenticate();
    }

    /**
     * Get the authenticated user.
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject
     */
    public function user()
    {
        return $this->auth->user();
    }
}
