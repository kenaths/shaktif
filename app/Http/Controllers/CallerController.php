<?php

namespace App\Http\Controllers;

use App\Caller;
use App\CallerNote;
use App\Http\Requests\StoreCaller;
use App\Niz\Facades\Search;
use App\Niz\Transformers\CallerTransformer;
use App\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

        if( $nic = $request->get('nic') ){
            $callers->where('nic',$nic);
        }

        if( $request->get('type') == 'first'){
            if( $caller = $callers->first() ){
                return $this->respond([
                    'data' => $this->callerTransformer->transform( $caller ),
                    'user_exists' => true
                ]);
            }
            return array();
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
        $caller_array = $caller->all();
        $caller_array['created_user_id'] = Auth::user()->id;
        $caller_array['dob'] = date("Y-m-d",strtotime($caller_array['dob']));


        $callerObj = Caller::create($caller_array);

        if( isset($caller_array['phone']) && $caller_array['phone']){
            $phone = new PhoneNumber();
            $phone->number = $caller_array['phone'];
            $phone->created_user_id  = Auth::user()->id;
            $callerObj->phoneNumbers()->save($phone);
        }

        return $this->respondCreated('Caller successfully created ', $callerObj);
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

    /**
     * @param $id
     * @return mixed
     */
    public function notes( $id )
    {

        $caller = Caller::findOrFail($id);
        $notes = $caller->callerNotes()->with('user')
            ->orderBy('id','DESC')
            ->paginate($this->per_page);

        return $this->respond([
            'data' =>  $notes->all(),
            'paginator' => [
                'total_count' => $notes->total(),
            ]
        ]);
    }

    public function addNotes( $id , Request $request)
    {

        if(  $note = $request->post('note') ){

            $callerObj = Caller::findOrFail($id);
            $callerNote = new CallerNote();
            $callerNote->note = $note;
            $callerNote->created_user_id  = Auth::user()->id;
            $callerObj->callerNotes()->save($callerNote);

            return $this->respondCreated('Note has been added');
        }

        return $this->validationFailed();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function addPhone( $id, Request $request )
    {

        if(  $phone_number = $request->post('phone') ){

            $callerObj = Caller::findOrFail($id);
            $phone = new PhoneNumber();
            $phone->number = $phone_number;
            $phone->created_user_id  = Auth::user()->id;
            $callerObj->phoneNumbers()->save($phone);

            return $this->respondCreated('Phone Number added',$callerObj);
        }

        return $this->validationFailed();

    }

    public function programmes( $id , Request $request )
    {
        $params['from'] = date('Y-m-d',strtotime('-6 months'));
        $params['to'] = date('Y-m-d',time());
        $params['all'] = $request->get('all');

        if($from_d = $request->get('from')){
            $params['from'] = date('Y-m-d',strtotime($from_d));
        }

        if($to_d = $request->get('to')){
            $params['to'] = date('Y-m-d',strtotime($to_d));
        }

        $caller = Caller::find($id);

        if( empty($caller)){
            return $this->respondNotFound('Caller not found');
        }

        $arr = $caller->programmeCount($params);

        $re = array();
        foreach( $arr->toArray() as $k=>$v){
            foreach( $v['call_count'] as $count ){
                if( !$count['programme_id'] ){
                    continue;
                }
                $re[ $count['programme']['name'] ][ $v['number'] ] = [
                    'phone' => $v['number'],
                    'count' => $count['aggregate']
                ];
            }
        }

        return $this->respond([
            'data' => $re
        ]);

    }

}
