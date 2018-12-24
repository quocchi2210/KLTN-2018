<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class Encrypt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $requestData = $request->all();
         foreach($requestData as $key => $value){
        
            $request->merge([
                $key => encrypt($value),
            ]);
         }
       
        Log::debug('testtttttt '. print_r($request->all(),1));
        return $next($request);
    }
}
