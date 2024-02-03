<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Support\Facades\Crypt;

class GenerateIDController extends Controller
{
    static function getID($prefix)
    {
        
        $uuid4 = Uuid::uuid4();
        $randomAlphabets = substr(str_replace('-', '', $uuid4->toString()), 0, 13);
        $customID = $prefix . $randomAlphabets;

        return $customID;
    }

    static function getAuthKey()
    {
        
        $randomAlphabets = substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 5);
        $randomAlphabets = $randomAlphabets . '-'. substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 5);
        $randomAlphabets = $randomAlphabets . '-'. substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 5);
        $randomAlphabets = $randomAlphabets . '-'. substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 5);
        
        return $randomAlphabets;
    }

    static function getToken(){
        return Crypt::encrypt( Uuid::uuid4()->toString());
    }
}