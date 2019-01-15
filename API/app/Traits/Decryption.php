<?php
/**
 * Created by PhpStorm.
 * User: ToxicBoiz
 * Date: 12/27/2018
 * Time: 11:42 PM
 */

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Log;

trait Decryption {

	public function getAttribute($key) {
		$value = parent::getAttribute($key);
		if (in_array($key, $this->fillable) && !is_null($value) && !is_numeric($value) && !preg_match('/^\$2y\$/', $value)) {
			try {
				return Crypt::decrypt($this->attributes[$key]);

			} catch (Exception $e) {
				Log::debug("myDecrypt " . print_r($e->getMessage(), 1));
				Log::debug("myDecrypt " . print_r($key, 1));

			}

		}

		return parent::getAttribute($key);
	}

	public function attributesToArray() {
		$attributes = parent::attributesToArray();

		foreach ($attributes as $key => $value) {
			if (in_array($key, $this->fillable)) {
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

//    public function attributesToArray() {
	//        $attributes = parent::attributesToArray();
	//        foreach($this->getEncrypts() as $key) {
	//            if(array_key_exists($key, $attributes)) {
	//                $attributes[$key] = decrypt($attributes[$key]);
	//            }
	//        }
	//        return $attributes;
	//    }
	//
	//    public function getAttributeValue($key) {
	//        if(in_array($key, $this->getEncrypts())) {
	//            return decrypt($this->attributes[$key]);
	//        }
	//        return parent::getAttributeValue($key);
	//    }
	//
	//    public function setAttribute($key, $value) {
	//        if(in_array($key, $this->getEncrypts())) {
	//            $this->attributes[$key] = encrypt($value);
	//        } else {
	//            parent::setAttribute($key, $value);
	//        }
	//        return $this;
	//    }

//    protected function getEncrypts() {
	//        return property_exists($this, 'fillable') ? $this->fillable : [];
	//    }

//    protected function getEncrypts() {
	//        return property_exists($this, 'fillable') ? $this->fillable : [];
	//    }
	//    public function setAttribute($key, $value)
	//    {
	//        if (in_array($key, $this->fillable))
	//        {
	//            $value = Crypt::encrypt($value);
	//        }
	//
	//        return parent::setAttribute($key, $value);
	//    }
	//
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
	//        dd($value);
	//        if (in_array($key, $this->fillable) && $value !== '') {
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
	////    public function setAttribute($key, $value)
	////    {
	////        if (in_array($key, $this->fillable)) {
	////            $value = encrypt($value);
	////        }
	////        return parent::setAttribute($key, $value);
	////    }
	//    /**
	//     * When need to make sure that we iterate through
	//     * all the keys.
	//     *
	//     * @return array
	//     */
	//    public function attributesToArray()
	//    {
	//        $attributes = parent::attributesToArray();
	//        foreach ($this->fillable as $key) {
	//            if (isset($attributes[$key])) {
	//                $attributes[$key] = decrypt($attributes[$key]);
	//            }
	//        }
	//        return $attributes;
	//    }

}