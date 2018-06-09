<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class LocalTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'localtest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'artisan本地测试脚本';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $city_code = 59287;
        $date = 201803;
        $url = "http://tianqi.2345.com/t/wea_history/js/{$date}/{$city_code}_{$date}.js";
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $res_body =  $res->getBody();
        $content = $res_body->getContents();
        file_put_contents(storage_path().'/test.js',$content);
        print_r(storage_path().'/test.js');die;

        iconv('GB2312', 'UTF-8', $content);

        dd($content);


        dd($res_body->getContents());
        dd(json_decode((string)mb_substr($res_body,16,-1)));
        $res_body = strstr('weather_str',$res_body);
        die($res_body);
// '{"id": 1420053, "name": "guzzle", ...}'

// Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        $promise->wait();


        $res = file_get_contents($url);
        dd($res);
        $res = \DB::table('chengyu')->inRandomOrder()->first();
        dd($res);
    }
}
