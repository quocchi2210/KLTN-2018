<?php

namespace App\Common;



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
