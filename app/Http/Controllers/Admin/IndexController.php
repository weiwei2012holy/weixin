<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WeatherExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Chengyu;
use EasyWeChat\Factory;
use App\Model;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{


    //

    public function test(Request $request)
    {
//        $keys = $request->keys();
//        $res = \DB::table('chengyu')->select()->selectRaw('view_count + ? as view_new',[99])->limit(5)->get();
        $res = \DB::table('chengyu')->select(\DB::raw('view_count + 99 as view_new'))->limit(5)->get();
        dd($res);
//        $res = \DB::table('chengyu')->forPage(2)->get();
//        $res = \DB::table('chengyu')->inRandomOrder()->first();

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

    public function getWeather(Request $request)
    {
        $data = $request->all();

        foreach ($data['tqInfo'] as $k => $v) {
            $v['city'] = $data['city'];
            $v['bWendu'] = (int)$v['bWendu'];
            $v['yWendu'] = (int)$v['yWendu'];
            $res = Model\Weather::firstOrCreate(['city' => $data['city'], 'ymd' => $v['ymd']], $v);
        }

        return $res;
    }


    public function saveAddress(Request $request)
    {
        return Model\WeatherAddress::firstOrCreate($request->all());
    }

    public function gatherWeather()
    {
        return response()->view('gatherWeather')->header('Content-Type','gbk');
    }

    public function downloadWeather(Request $request)
    {
        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟
        $city = $request->get('city')?:'广州';
        if(Model\Weather::where('city', $city)->count() <= 0){
            return $city.'暂无数据,请先输入地区代码采集:<a href="http://tianqi.2345.com/js/citySelectData.js">地区查询地址</a>';
        }
        return Excel::download(new WeatherExport($city), $city.'_weather.xlsx');
    }

}
