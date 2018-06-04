<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Chengyu;
use EasyWeChat\Factory;

class IndexController extends Controller
{
    //

    public function test(Request $request)
    {
        $keys = $request->keys();
        $res = \DB::table('chengyu')->select()->selectRaw('view_count + ? as view_new',[99])->limit(5)->get();
        $res = \DB::table('chengyu')->select(\DB::raw('view_count + 99 as view_new'))->limit(5)->get();
        $res = \DB::table('chengyu')->forPage(2)->get();
        $res = \DB::table('chengyu')->inRandomOrder()->first();

        $chengyu = new Chengyu();
        $data = $chengyu->find(30906);
        $data->view_count = 1;
        $res = $data->save();
        $chengyu::destroy();
        dd($res);
    }

    public function callback()
    {
        echo 'success';
    }

}
