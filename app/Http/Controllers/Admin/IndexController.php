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

    /**
     * 保存天气
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|null|string
     */
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

    /**
     * 采集页面
     * @return \Illuminate\Http\Response
     */
    public function gatherWeather()
    {
        return response()->view('gatherWeather')->header('Content-Type','gbk');
    }

    /**
     * 下载天气
     * @param Request $request
     * @return \Maatwebsite\Excel\BinaryFileResponse|string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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
