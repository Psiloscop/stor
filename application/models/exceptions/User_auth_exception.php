<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/3/16
 * Time: 9:22 PM
 */

class User_auth_exception extends Exception
{
    function __construct($message)
    {
        parent::__construct($message);
    }
}