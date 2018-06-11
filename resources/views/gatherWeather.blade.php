<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test ws</title>
</head>
<form>
    <p>采集日期</p>
    <input type="text" id="startYear" value="2016">年-
    <input type="text" id="endYear" value="2018">年
    ,采集地区代码:<input type="text" name="code" id="code" value="60025">
    <input type="button" name="" value="开始采集" id="get">

</form>
<p>
    <input type="text" name="" id="city">
    <input type="button" value="点击下载" id="download">
</p>
<p>采集结果</p>

<div id="msg_box">

</div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
{{--<script src="address.js"></script>--}}


<script type="">
    // var url = 'http://tianqi.2345.com/t/wea_history/js/201802/59287_201802.js'
    var storUrl = 'http://local.weixin.com:8080/api/getWeather'
    // var addressUrl = 'http://local.weixin.com:8080/api/saveWeatherAddress'


    $('#download').click(function () {
        var city = $('#city').val()
        if (city) {
            window.open('downloadWeather?city=' + city)

        }

    })

    function store(data) {
        $.ajax({
            url: storUrl,
            type: 'POST',
            data: data,
            success: function (data) {
                console.log(data.city, data.ymd, '操作成功!')
                var html = '<p>' + data.city + data.ymd + '操作成功' + '</p>'

                $('#msg_box').prepend(html)
                $('#msg_box .media').filter(function (index) {
                    if (index >= 20)
                        this.remove()
                })
            }
        })
    }

    function callback() {
        console.log(0)
    }

    var citys = [
        59287,//广州
        59312,//潮州
        59289,//东莞
        59288,//佛山
        59293,//河源
        59297,//惠州
        59473,//江门
        59315,//揭阳
        59109,//梅州
        59659,//茂名
        59280,//清远
        59493,//深圳
        59316,//汕头
        59082,//韶关
        59501,//汕尾
        59663,//阳江
        59471,//云浮
        59488,//珠海
        59485,//中山
        59658,//湛江
        59278,//肇庆
        59249,//贵港
        57816,//贵阳
        57741,//铜仁-57741
    ]
    var cityCode = 59287;


    // for (var i in prov) {
    //     if (i != 15){
    //         continue
    //     }
    //     var province = prov[i].split("|")
    //     for (var j in province) {
    //         var info = province[j].split(' ')[1].split('-')
    //         var name = info[0]
    //         var code = info[1]
    //         // $.ajax({
    //         //     url: addressUrl,
    //         //     type: 'POST',
    //         //     data: {
    //         //         name: name,
    //         //         code: code
    //         //     },
    //         //     success: function (data) {
    //         //         console.log(data.city, data.ymd, '操作成功!')
    //         //     }
    //         // })
    //         console.log(code+',//'+name)
    //     }
    //     // console.log(prov[i].split("|"))
    // }


    $('#get').click(function () {
        var cityCode = $('#code').val()
        console.log(cityCode)

        // for (var i in citys) {
        //     var cityCode = citys[i]
        var startYear = $('#startYear').val()
        var endYear = $('#endYear').val()

        startYear = startYear ? startYear : 2016
        endYear = endYear ? endYear : 2018
        for (startYear; startYear <= endYear; startYear++) {
            for (var month = 1; month <= 12; month++) {
                if (startYear >= 2018 && month >= 6) break

                var str = startYear + '' + `0${month}`.slice(-2)
                //201602月之前的 url格式不一样
                if (str <= 201602) {
                    str = startYear + '' + month
                    var url = 'http://tianqi.2345.com/t/wea_history/js/' + cityCode + '_' + str + '.js'
                } else {
                    var url = 'http://tianqi.2345.com/t/wea_history/js/' + str + '/' + cityCode + '_' + str + '.js'
                }

                console.log(str, 'start')
                console.log(url)
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "jsonp", //指定服务器返回的数据类型
                    jsonpCallback: 'callback',
                    success: function (data) {
                        console.log('success')
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.log(XMLHttpRequest)
                        console.log(errorThrown)
                        store(weather_str)
                    }
                });
            }
            // }
        }
        console.log('采集完成!!!')


    })


</script>