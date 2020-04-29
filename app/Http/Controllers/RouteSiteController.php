<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use test\Mockery\ReturnTypeObjectTypeHint;
use Session;
use App;
use View;
use Illuminate\Http\Request;

use App\Model\systemRouteModel;

class RouteSiteController extends Controller
{

    /**
     * 腳本語言建檔
     * @param  [string] $routeList
     * @return [object] $routeList
     */
    public function RouteSiteShell($code)
    {

    }

    /**
     * 列出路由
     * @param  [string] $routeList
     * @return [object] $routeList
     */

    public function RouteSiteList($code, Request $request)
    {

        $getData = systemRouteModel::listData();

        if (isset($getData[0])) {
            foreach ($getData as $key => $val) {
                $routeList[$key]['id']          = $val->system_route_id;
                $routeList[$key]['name']        = $val->system_route_name;
                $routeList[$key]['code']        = $val->system_route_code;
                $routeList[$key]['namespace']   = $val->system_route_namespace;
                $routeList[$key]['controllers'] = $val->system_route_controllers;
                $routeList[$key]['function']    = $val->system_route_function;
                $routeList[$key]['order']       = $val->system_route_order;
                $routeList[$key]['upBtn']       = false;
            }
        }
        return isset($routeList) ? $routeList : false;
    }

    /**
     * 新增路由
     * @param  [Request] $request
     * @param  [array]  $setData
     */

    public function RouteSiteAdd($code, Request $request)
    {

        if (
            $request->name != null &&
            $request->sitecode != null &&
            $request->namespace != null &&
            $request->controllers != null &&
            $request->function != null
        ) {
            $setData = [
                'system_route_id'          => '',
                'system_route_name'        => $request->name,
                'system_route_code'        => $request->sitecode,
                'system_route_namespace'   => $request->namespace,
                'system_route_controllers' => $request->controllers,
                'system_route_function'    => $request->function,
                'system_route_order'       => $request->order,
            ];

            systemRouteModel::add($setData);

        }
    }

    /**
     * 更新路由
     * @param  [object]  $request
     * @return [boolean] $result
     */

    public function RouteSiteUp($code, Request $request)
    {
        if (
            $request->id != null &&
            $request->name != null &&
            $request->sitecode != null &&
            $request->namespace != null &&
            $request->controllers != null &&
            $request->function != null &&
            $request->order != null
        ) {

            $upData = [
                'system_route_id'          => $request->id,
                'system_route_name'        => $request->name,
                'system_route_code'        => $request->sitecode,
                'system_route_namespace'   => $request->namespace,
                'system_route_controllers' => $request->controllers,
                'system_route_function'    => $request->function,
                'system_route_order'       => $request->order,
            ];


           $result = systemRouteModel::up($upData);


        }

    }

    /**
     * 刪除路由
     * @param  [object]  $request
     * @return [boolean] $result
     */

    public function RouteSiteDel($code, Request $request)
    {
        if($request->id != null){
            $delData = [
                'system_route_id'          => $request->id,
            ];
            $result = systemRouteModel::del($delData);
        }
    }


}
