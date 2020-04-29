<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\systemRouteModel;
use Session;
use App;
use View;
use Request;
use ReflectionMethod;
use ReflectionParameter;
use Illuminate\Http\Request as HttpRequest;

class RouteController extends Controller
{

    public function __construct()
    {

    }

    /**
     * api統一用
     * @param  [string] $code       [代碼]
     * @param  [int] $id            [顯示子列表使用]
     * @param  [HttpRequest] $request
     * @return [object] page
     */
    public function apiRoute($code = NULL, $mode = NULL, $token = NULL, HttpRequest $request)
    {

        // 路由代碼
        $selectData =[
            'select'            => '*',
            'system_route_code' =>  $code,

        ];

        $getData = systemRouteModel::listData($selectData);


        // 有代碼抓出該資訊
        if(isset($getData[0])){

            $content                            = $getData[0];
            $tPath                              = "\\App\\Http\\Controllers\\".$content->system_route_controllers;
            $tController                        = App::make($tPath);
            $tPath = NULL;
            unset($tPath);

            // 傳function data  代碼
            $data['parameters']['code']         = $content->system_route_code;
            $data['parameters']['request']      = $request;

            return $this->dispatchMethod($tController,$content->system_route_function.$mode,$data['parameters']);


        }else{
            return false;
        }

    }


    /**
     * 呼叫Function核心
     * @param  [string] $controller
     * @param  [string] $method
     * @param  [array] $parameters
     * @return [object]
     */

    protected function dispatchMethod($controller, $method, $parameters = NULL)
    {

        // 取得原 Function 資訊
        $reflection                                 = new ReflectionMethod($controller, $method);
        // 取得原 Function 參數
        $getParameters                              = $reflection->getParameters();
        // 原參數總數
        $originalParameterCount                     = count($getParameters);
        // 丟入參數總數
        $getParameterCount                          = count($parameters);
        // 丟入暫存值
        $tParameters                                = $parameters;
        if($originalParameterCount > 0) {
            // 比對參數
            foreach ($getParameters as $key => $val) {
                // 是否為 Class function
                $class = $val->getClass();
                foreach ($tParameters as $key2 => $val2) {
                    if ($class && $val2 instanceof $class->name) {
                        // Class: Request...
                        $arrParam[$val->name] = $val2;
                        unset($tParameters[$key2]);
                    } else {
                        // 一般參數
                        if (isset($tParameters[$val->name])) {
                            $arrParam[$val->name] = $parameters[$val->name];
                            unset($tParameters[$key2]);
                        }
                    }
                }
                if (!isset($arrParam[$val->name])) {
                    $arrParam[$val->name] = ($val->isDefaultValueAvailable()) ? ($val->getDefaultValue()) : NULL;
                }
            }
            $tParameters = NULL;
            unset($tParameters);
            // 如果都未配對到，則依序帶入參數
            if (!isset($arrParam)) {
                $tParameters = $parameters;
                foreach ($getParameters as $key => $val) {
                    $arrParam[$val->name] = array_shift($tParameters);
                }
            }
            $tParameters = NULL;
            unset($tParameters);
        }

        return (isset($arrParam))? $controller->{$method}(...array_values($arrParam)):$controller->{$method}();
    }

}
