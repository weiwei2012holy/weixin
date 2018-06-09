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
        return Model\Weather::where('city', $this->city)->get();
    }
}