<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class GenerateIDController extends Controller
{
    static function getID($prefix)
    {
        
        $uuid4 = Uuid::uuid4();
        $randomAlphabets = substr(str_replace('-', '', $uuid4->toString()), 0, 13);
        $customID = $prefix . $randomAlphabets;

        return $customID;
    }
}