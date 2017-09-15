<?php

namespace App\Http\Controllers;

use App\Call;
use App\Caller;
use App\Niz\Transformers\CallerTransformer;
use App\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class AppController extends ApiController
{

    protected $callerTransformer;

    public function __construct( CallerTransformer $callerTransformer)
    {
        $this->callerTransformer = $callerTransformer;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if( $phone = $request->get('phone') ){
            /* save phone number  */
            Call::create([
                'phone_number' => $phone,
                'user_id' => Auth::user()->id
            ]);

            $number = PhoneNumber::where('number',$phone)->first();

            if( $number ){
                return $this->respond([
                    'data' => $number->caller()->with('phoneNumbers')->first(),
                    'user_exists' => true,
                    'message' => false
                ]);
            }
            return $this->respond([
                'data' => array(),
                'user_exists' => false,
                'message' => 'We can not find any matching caller. Would you like to save this caller now?'
            ]);



        }

    }

    public function test()
    {

        $options = array(
            'cluster' => 'ap2',
            'encrypted' => true,
            'debug' => true
        );
        $pusher = new Pusher(
            '821e65ef26a33e92f4d3',
            '116b96f7d1f394ed6ca6',
            '399585',
            $options
        );

        $data['message'] = 'hello world';
        print_r($pusher->trigger('my-channel', 'my-event', $data));
    }




}
