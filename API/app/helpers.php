<?php
	function myDecrypt($str_array){
		//Log::debug("myDecrypt ".print_r($str_array,1));

		foreach ($str_array as $key_str => $str){

			Log::debug("myDecrypt ".print_r($str,1));
			foreach($str as $key => $value){
				Log::debug("myDecrypt ".print_r($key,1));
				if($key[0]!="i" || $key[1]!="d"){
					//Log::debug("myDecrypt ".print_r($key,1));
					if($value && $key != "created_at" && $key != "updated_at"){
						
						$str->$key = decrypt($value);
					}
					
				}
			
			}
		}
		

		return $str; 
	}
?>