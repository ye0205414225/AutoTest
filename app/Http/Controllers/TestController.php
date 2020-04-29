<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use App;
use View;
use App\Model\testModel;

use Illuminate\Http\Request;

class TestController extends Controller
{

    // API /mytest/api/get
    public function Testget($code,Request $request)
    {

        $data = testModel::listData();

        foreach ($data as $key => $val){
            $getData[$key]['name'] = $val->test_name;
        }
        return $getData;
    }

    public function iTest()
    {
        return '好極了,yes';
    }

        #https://hot2.shop/mytest/api/gettest

}
