<?php

class Irbis_exception extends Exception
{
    function __construct($message = null)
    {
        if(isset($message))
        {
            parent::__construct($message);
        }
    }
}