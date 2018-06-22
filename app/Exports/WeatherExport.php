<?php
/**
 * Desc:
 * Author: 余伟<weiwei2012holy@hotmail.com>
 * Date: 2018/6/9,下午6:11
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model;

class WeatherExport implements FromCollection
{
    private $city;
    public function __construct($city)
    {
        $this->city = $city;
    }


    public function collection()
    {
        $stime = request('stime');
        $etime = request('etime');
        $query = Model\Weather::query()->where('city', $this->city);
        if ($stime){
            $query = $query->where('ymd','>=',$stime);
        }
        if ($etime){
            $query = $query->where('ymd','<=',$etime);
        }
        return $query->get();
    }
}