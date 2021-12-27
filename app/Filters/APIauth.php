<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class APIauth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    
    public function before(RequestInterface $request, $arguments = null)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        // print_r($_SERVER);
        // die();
        $userM = new UserModel;
        if(isset($_SERVER['HTTP_AUTHORIZATION'])):
                
                if(!($userM->matchToken($_SERVER['HTTP_AUTHORIZATION'])))
                {
                 
                    $response = [
                        'status'    =>401,
                        'error'     =>true,
                        'messages'  =>'Access denied',
                        'data'      =>[]
                    ];
                    echo json_encode($response);
                    die();
                };
        else:
                $response = [
                    'status'    =>401,
                    'error'     =>true,
                    'messages'  =>'Access denied',
                    'data'      =>[]
                ];
                echo json_encode($response);
                    die();      
        endif;    
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
