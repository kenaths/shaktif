<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoneNumber;
use App\Niz\Transformers\PhoneNumberTransformer;
use App\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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


    /**
     * Save phone number
     *
     * @param StorePhoneNumber $storePhoneNumber
     * @return mixed
     */
    public function store(StorePhoneNumber $storePhoneNumber)
    {

        $storePhoneNumber['created_user_id'] = Auth::user()->id;

        PhoneNumber::create($storePhoneNumber->all());

        return $this->respondCreated('Phone Number successfully added ');
    }

}
