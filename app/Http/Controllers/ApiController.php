<?php
/**
 * Created by PhpStorm.
 * User: kenath
 * Date: 8/11/2017
 * Time: 7:32 AM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @var
     */
    protected $statusCode = 200;

    /**
     * @var int
     */
    protected $per_page = 10;


    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return  $this->setStatusCode(404)->respondWithError($message);

    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return  $this->setStatusCode(500)->respondWithError($message);

    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json( $data, $this->getStatusCode(), $headers);
    }


    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondCreated( $message = 'Successfully created')
    {
        return $this->setStatusCode(201)->respond([
            'message' => $message
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function validationFailed( $message = 'Validation failed')
    {
        return $this->setStatusCode(422)->respond([
            'message' => $message
        ]);
    }


    public function respondWithPaginator()
    {
        
    }
}