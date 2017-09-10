<?php

namespace App\Http\Controllers;

use App\Caller;
use App\Http\Requests\StoreCaller;
use App\Niz\Transformers\CallerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallerController extends ApiController
{

    protected $callerTransformer;

    public function __construct( CallerTransformer $callerTransformer)
    {
        $this->callerTransformer = $callerTransformer;

        /*
        $this->middleware('auth.basic',['only' => [
            'store'
        ]]); */
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $callers = Caller::with('phoneNumbers');

        if( $phone = $request->get('phone')){
            $callers->join('phone_numbers', 'callers.id', '=', 'phone_numbers.caller_id','left')
                ->where('phone_numbers.number',$phone);
        }

        $callersData = $callers->paginate($this->per_page);

        return $this->respond([
            'data' => $this->callerTransformer->transformCollection( $callersData->all()),
            'paginator' => [
                'total_count' => $callersData->total(),
            ]
        ]);
    }

    public function store(StoreCaller $caller)
    {

        $caller['created_user_id'] = Auth::user()->id;

        Caller::create($caller->all());

        return $this->respondCreated('Caller successfully created ');
    }

    /**
     * Show the specified Caller information.
     *
     * @param $id
     * @return mixed
     */
    public function show( $id )
    {
        $caller =  Caller::find($id);

        if( !$caller ){

            return $this->respondNotFound('Lesson does not exists');

        }
        return $this->respond([
            'data' => $this->callerTransformer->transform($caller)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caller $caller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caller $caller)
    {
        //
    }


}
