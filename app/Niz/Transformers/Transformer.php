<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/9/2017
 * Time: 12:11 AM
 */
namespace App\Niz\Transformers;

abstract class Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transformCollection( array $item )
    {
        return array_map([$this,'transform'], $item);
    }

    public abstract function transform($item);


}