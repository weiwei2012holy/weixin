<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test ws</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
{{--<div class="jumbotron text-center" style="margin-bottom:0">--}}
    {{--<h1>国内天气采集系统</h1>--}}
{{--</div>--}}
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <a class="navbar-brand" href="#">导航</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="http://tianqi.2345.com/js/citySelectData.js">查看城市编码</a>
            </li>

        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>采集数据,最早2011年</h2>
            <form>
                <div class="form-group">
                    <label for="startYear">开始年份</label>
                    <input type="number" class="form-control" id="startYear" value="2016" placeholder="请输入采集开始的年份">
                </div>
                <div class="form-group">
                    <label for="endYear">结束年份</label>
                    <input type="number" class="form-control" id="endYear" value="2018">
                </div>
                <div class="form-group">
                    <label for="code">采集地区代码</label>
                    <input type="number" name="code" class="form-control" id="code" value="60025">
                </div>
                <div class="text-center">
                    <input type="button" class="btn btn-primary" name="" value="开始采集" id="get">
                </div>
            </form>
        </div>
        <div class="col">
            <h2>导出日期:不填全部导出</h2>
            <div class="form-group">
                <label for="stime">开始日期</label>
                <input type="date" class="form-control" name="stime" id="stime" value="2014-01-01">
            </div>
            <div class="form-group">
                <label for="etime">结束日期</label>
                <input type="date" class="form-control" name="etime" id="etime" value="">
            </div>
            <div class="form-group">
                <label for="city">下载的城市名称</label>
                <input type="text" class="form-control" name="" placeholder="请输入需要下载的城市" id="city">

            </div>
            <div class="text-center">
                <input class="btn-danger btn" type="button" value="点击下载" id="download">

            </div>
        </div>
    </div>
    <div class="col">

        <strong id="showMsg" style="color: green"></strong>

        <div id="msg_box">

        </div>
    </div>
</div>
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>敬请期待...</p>
</div>
</body>


<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

{{--<script src="address.js"></script>--}}


<script type="">
    // var url = 'http://tianqi.2345.com/t/wea_history/js/201802/59287_201802.js'
    var storUrl = 'api/getWeather'
    // var addressUrl = 'http://local.weixin.com:8080/api/saveWeatherAddress'


    $('#download').click(function () {
        var city = $('#city').val()
        var stime = $('#stime').val()
        var etime = $('#etime').val()
        if (city) {
            window.open('downloadWeather?city=' + city + '&stime=' + stime + '&etime=' + etime)

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


    const curDate = new Date(Date.now())
    const year = curDate.getFullYear()
    const month = `0${curDate.getMonth() + 1}`.slice(-2)
    const date = `0${curDate.getDate()}`.slice(-2)
    const hours = `0${curDate.getHours()}`.slice(-2)
    const mins = `0${curDate.getMinutes()}`.slice(-2)
    const seconds = `0${curDate.getSeconds()}`.slice(-2)

    console.log(month)
    $('#get').click(function () {
        var cityCode = $('#code').val()
        console.log(cityCode)

        // for (var i in citys) {
        //     var cityCode = citys[i]
        var startYear = $('#startYear').val()
        var endYear = $('#endYear').val()

        endYear = endYear >= year ? year : endYear
        startYear = startYear <= endYear ? startYear : endYear
        $('#showMsg').text('采集周期:' + startYear + '-' + endYear + ',地区代码:' + cityCode)


        for (startYear; startYear <= endYear; startYear++) {
            for (var month = 1; month <= 12; month++) {
                // if (startYear >= 2018 && month >= 6) break

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