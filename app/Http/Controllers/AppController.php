<?php

namespace App\Http\Controllers;

use App\Call;
use App\Caller;
use App\Config;
use App\Niz\Transformers\CallerTransformer;
use App\PhoneNumber;
use App\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

            $this->validator( $request->all() );

            /* Current Programme */
            $programme = Config::where('property','programme_id')->first();

            /* save phone number  */
            Call::create([
                'phone_number' => htmlspecialchars($phone),
                'user_id' => Auth::user()->id,
                'programme_id' => $programme->value
            ]);

            $number = PhoneNumber::where('number',$phone)->first();
            //$number->programme;

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

    public function settings( Request $request )
    {
        $config = Config::where('property',$request->post('property'))->first();
        if( $config ){
            $label = $request->post('label');
            $config->value = $request->post('value');
            $config->save();
            return $this->respond([
                'data' => $config,
                'success' => true,
                'message' => $label.' successfully updated'
            ]);
        }
        return $this->respondWithError('Not found');

    }

    public function getSettings( Request $request )
    {
        $settings = array(
            'programme'=>'programme_id',
            'competition'=>'competition_id'
        );
        $config = Config::whereIn('property',array_values($settings))->get();
        $output = array();
        foreach($config as $k=>$val){
            if( $val['value'] ){
                $output[array_search($val['property'],$settings)] = $this->getSettingsObjects( $val['property'], $val['value'] );
            }
        }
        return $this->respond([
            'data' => $output,
            'success' => true,
        ]);

    }

    private function getSettingsObjects( $type, $value )
    {
        switch( $type ){
            case 'programme_id':
                return Programme::find($value);
                break;
            default;
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

    /**
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {

        $validation = Validator::make($data, [
            'phone' => 'required',
            'programme_id' => 'int'
        ]);
        if($validation->fails()){
            $errors = $validation->errors();
            return $this->validationFailed('Invalid Parameters',$errors);
        }

    }


}
