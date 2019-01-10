<?php
/**
 * Created by PhpStorm.
 * User: BSS
 * Date: 12/27/2018
 * Time: 2:34 PM
 */

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
trait Encryptable
{
//    /**
//     * If the attribute is in the encryptable array
//     * then decrypt it.
//     *
//     * @param  $key
//     *
//     * @return $value
//     */
//    public function getAttribute($key)
//    {
//        $value = parent::getAttribute($key);
//        if (in_array($key, $this->encryptable) && $value !== '') {
//            $value = decrypt($value);
//        }
//        return $value;
//    }
//    /**
//     * If the attribute is in the encryptable array
//     * then encrypt it.
//     *
//     * @param $key
//     * @param $value
//     */
//    public function setAttribute($key, $value)
//    {
//        if (in_array($key, $this->encryptable)) {
//            $value = encrypt($value);
//        }
//        return parent::setAttribute($key, $value);
//    }
//    /**
//     * When need to make sure that we iterate through
//     * all the keys.
//     *
//     * @return array
//     */
//    public function attributesToArray()
//    {
//        $attributes = parent::attributesToArray();
//        foreach ($this->encryptable as $key) {
//            if (isset($attributes[$key])) {
//                $attributes[$key] = decrypt($attributes[$key]);
//            }
//        }
//        return $attributes;
//    }
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt))
        {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->encrypt))
        {
            try {
                return Crypt::decrypt($this->attributes[$key]);

            } catch (Exception $e) {
                Log::debug("myDecrypt " . print_r($e->getMessage(), 1));
                Log::debug("myDecrypt " . print_r($key, 1));

            }
        }

        return parent::getAttribute($key);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($attributes as $key => $value)
        {
            if (in_array($key, $this->encrypt))
            {
                try {
                    $attributes[$key] = Crypt::decrypt($value);

                } catch (Exception $e) {
                    Log::debug("myDecrypt " . print_r($e->getMessage(), 1));
                    Log::debug("myDecrypt " . print_r($key, 1));

                }
                
            }
        }
        return $attributes;
    }
}