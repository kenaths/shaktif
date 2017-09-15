<?php

namespace App\Http\Controllers;

use App\Caller;
use App\Http\Requests\StoreProgramme;
use App\Niz\Facades\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProgrammeController extends ApiController
{


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        $programmes = Search::programmes( $request->get('q') )
            ->paginate($this->per_page);

        return $this->respond([
            'data' => $programmes->all(),
            'paginator' => [
                'total_count' => $programmes->total(),
            ]
        ]);
    }

    /**
     * Save Programme
     *
     * @param StoreProgramme $programme
     * @return mixed
     */
    public function store( StoreProgramme $programme )
    {

        $programme_data = $programme->all();

        $programme_data['created_user_id'] = Auth::user()->id;

        if( $programmeObj = Caller::create($programme_data)){

            return $this->respondCreated('Caller successfully created ', $programmeObj);
        }

    }

    /**
     * Show the specified Programme information.
     *
     * @param $id
     * @return mixed
     */
    public function show( $id )
    {

        $programme =  Program::find($id);

        if( !$programme ){

            return $this->respondNotFound('Programme does not exists');

        }
        return $this->respond([
            'data' => $programme
        ]);

    }


    /*
     * TODO : update delete methods
     *
     * */


}
