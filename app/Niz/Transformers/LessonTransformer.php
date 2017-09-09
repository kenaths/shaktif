<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 9/9/2017
 * Time: 12:12 AM
 */
namespace App\Niz\Transformers;

class LessonTransformer extends Transformer
{

    /**
     *
     * @param $lesson
     * @return array
     */
    public function transform($lesson){
        return [
            'title' => $lesson['title'],
            'body' => $lesson['body'],
            'active' => (boolean) $lesson['some_bool'],
        ];
    }

}