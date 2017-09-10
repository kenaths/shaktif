<?php

namespace App\Http\Controllers;

use App\Niz\Transformers\PhoneNumberTransformer;
use App\PhoneNumber;
use Illuminate\Http\Request;


class PhoneNumberController extends ApiController
{

    protected $phoneNumberTransformer;

    public function __construct( PhoneNumberTransformer $phoneNumberTransformer)
    {
        $this->phoneNumberTransformer = $phoneNumberTransformer;
    }

    /**
     * Display all numbers.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if( $pageSize = $request->get('pageSize')){
            $this->per_page = $pageSize;
        }

        $numbers =  PhoneNumber::paginate($this->per_page);

        return $this->respond([
            'data' =>  $numbers->all(),
            'paginator' => [
                'total_count' => $numbers->total(),
            ]
        ]);
    }


}
