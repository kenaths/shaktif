<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/12/2017
 * Time: 3:31 PM
 */

namespace App\Niz\Search;


use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->bind('search',\App\Niz\Search\Search::class);
    }

}