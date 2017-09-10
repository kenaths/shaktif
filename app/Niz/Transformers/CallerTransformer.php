<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/9/2017
 * Time: 12:12 AM
 */
namespace App\Niz\Transformers;

class CallerTransformer extends Transformer
{

    /**
     * @param $caller
     * @return array
     */
    public function transform($caller){
        return [
            'first_name' => $caller['first_name'],
            'last_name' => $caller['last_name'],
            'gender' => $caller['gender'],
            'email' => $caller['email'],
            'address' => $caller['address'],
            'city' => $caller['city'],
            'dob' => $caller['dob'],
            'nic' => $caller['nic'],
            'phone_numbers' => $caller['phoneNumbers']
        ];
    }

}