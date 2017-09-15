<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/12/2017
 * Time: 3:28 PM
 */
namespace App\Niz\Facades;

use Illuminate\Support\Facades\Facade;

class Search extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'search';
    }

}