<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/9/2017
 * Time: 12:12 AM
 */
namespace App\Niz\Transformers;

class PhoneNumberTransformer extends Transformer
{

    /**
     * @param $phone_number
     * @return array
     */
    public function transform($phone_number){
        return [
            'number' => $phone_number['number'],
            'caller' => $phone_number['caller_id'],
            'created_user' => $phone_number['created_user_id'],
            'created_time' => $phone_number['created_at'],
            'updated_time' => $phone_number['updated_at'],
            'deleted' => $phone_number['is_deleted']
        ];
    }

}