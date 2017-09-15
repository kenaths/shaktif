<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/12/2017
 * Time: 3:04 PM
 */

namespace App\Niz\Search;


use App\Caller;
use App\Program;

class Search
{

    public function callers( $search )
    {
        return Caller::search($search);
    }


    public function programmes( $search )
    {
        return Program::search($search);
    }




}