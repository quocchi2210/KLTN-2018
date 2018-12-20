<?php

namespace App\Common\Http\Controllers;



class ErrorFormat
{
    public $errorMessage;
    public $errorCode;
    public function __construct($errorMessage,$errorCode)
    {
        $this->errorMessage=$errorMessage;
        $this->errorCode=$errorCode;
    }
}
