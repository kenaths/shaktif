<?php

namespace App\Http\Controllers;

use App\Call;
use App\Caller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends ApiController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        if( $caller = $request->get('caller')){
            $calls = $this->getCallerCalls( $caller );
        } else {
            $calls = $this->getCalls( $request->get('phone') );
        }

        $callData = $calls->paginate($this->per_page);

        return $this->respond([
            'data' =>  $callData->all(),
            'paginator' => [
                'total_count' => $callData->total(),
            ]
        ]);
    }

    private function getCallerCalls( $caller_id )
    {
        if( $caller_id ){

            $caller =  Caller::findOrFail($caller_id);
            $allPhoneNubers = $caller->phoneNumbers()->get();
            $numbers = array_column($allPhoneNubers->toArray(),'number');

            return Call::where('is_deleted',false)
                ->whereIn('phone_number', $numbers)
                ->with('programme')
                ->with([
                    'operator'=>function($query){
                        $query->select(array('id','name'));
                    }
                ])->orderBy('id','DESC');
        }
    }

    private function getCalls( $phone , $caller_id = false )
    {

        if( $phone ){

            return Call::where('is_deleted',false)
                ->where('phone_number',$phone)
                ->with('programme')
                ->with([
                    'operator'=>function($query){
                        $query->select(array('id','name'));
                    }
                ])->orderBy('id','DESC');


           // dd(  $query->toSql() );
        }

        return Call::where('is_deleted',false)
            ->with('programme')
            ->where('user_id',Auth::user()->id)
            ->with([
            'phone'=>function($query){
                $query->with('caller');
            }
        ])->orderBy('id','DESC');

    }


}
