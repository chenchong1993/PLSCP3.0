<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>大众位置服务云平台</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('static/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('static/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('static/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('static/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    {{--HUI的图标库--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/dijit/themes/tundra/tundra.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/esri/css/esri.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/Ips/css/widget.css') }}" />
    <script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>
    <script src="{{ asset('static/vendor/jquery/jquery.min.js') }}"></script>


    <style type="text/css">
        /*.user-msg{position:absolute;left:810px;top:10px;z-index:auto;width:500px;background-color:#f6f6f6}*/
        .map1-col{position:absolute;left:10px;top:10px;z-index:0;width:1200px;background-color:#f6f6f6}
        .map2-col{position:absolute;left:10px;top:350px;z-index:1;width:1200px;background-color:#f6f6f6}
        .map3-col{position:absolute;left:10px;top:740px;z-index:3;width:600px;background-color:#f6f6f6}
    </style>
</head>
<body style="height: 100%; margin: 0">
<style>
    /*html, body, #map1,map2,map3{*/
        /*margin: 0;*/
        /*padding: 0;*/
        /*width: 100%;*/
        /*height: 100%;*/
    /*}*/

    #showbigger{
        position: fixed;top:30px;left:1000px;font-size: 18px;

    }
    #showsmaller{
        position: fixed;top:30px;left:1100px;font-size: 18px;
    }
</style>
<script>
    function returnNormalMap() {
        window.location.href = '/normalMap';
    }
    var INTERVAL_TIME = 1; //数据刷新间隔时间
    var POINTSIZE = 15;    //默认图片大小为15*15
    require([
        "Ips/map",
        "Ips/widget/IpsMeasure",
        "Ips/layers/DynamicMapServiceLayer",
        "Ips/layers/FeatureLayer",
        "Ips/layers/GraphicsLayer",
        "esri/graphic",
        "esri/geometry/Point",
        "esri/geometry/Polyline",
        "esri/geometry/Polygon",
        "esri/InfoTemplate",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
        "esri/symbols/PictureMarkerSymbol",
        "esri/symbols/TextSymbol",
        "dojo/colors",
        "dojo/on",
        "dojo/dom",
        "dojo/domReady!"
    ], function (Map, IpsMeasure,DynamicMapServiceLayer,FeatureLayer, GraphicsLayer, Graphic, Point, Polyline, Polygon, InfoTemplate, SimpleMarkerSymbol, SimpleLineSymbol,
                 SimpleFillSymbol, PictureMarkerSymbol, TextSymbol, Color, on, dom) {
        var map1 = new Map("map1", {
            logo:false,
            center: [114.3489254,38.24769],
        });
        var map2 = new Map("map2", {
            logo:false,
            center: [114.3489254,38.24769],
        });
        var map3 = new Map("map3", {
            logo:false,
            center: [114.3486414,38.24770],
        });
        //初始化F1楼层平面图
        var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
        var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
        var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
        map1.addLayer(f1);
        map2.addLayer(f2);
        map3.addLayer(f3);
        var pointLayerF1 = new GraphicsLayer();
        var pointLayerF2 = new GraphicsLayer();
        var pointLayerF3= new GraphicsLayer();
        on(dom.byId("showbigger"),"click",function () {
            POINTSIZE++;
            pointLayerF1.clear();
            pointLayerF2.clear();
            pointLayerF3.clear();
            console.log(POINTSIZE);
            addPointToMap();
        });
        on(dom.byId("showsmaller"),"click",function () {
            POINTSIZE--;
            pointLayerF1.clear();
            pointLayerF2.clear();
            pointLayerF3.clear();
            console.log(POINTSIZE);
            addPointToMap();
        });

        function addUserPoint(id,uid, time,lng, lat,floor,status) {

            var name = '当前用户';
            var picpoint = new Point(lng,lat);
            // //定义点的图片符号
            var picSymbol;
            if (status == 'normal')
                picSymbol = new PictureMarkerSymbol("{{ asset('static/Ips_api_javascript/Ips/image/marker.png') }}",POINTSIZE,POINTSIZE);
            else if (status == 'danger')
                picSymbol = new PictureMarkerSymbol("{{ asset('static/Ips_api_javascript/Ips/image/marker.png') }}",24,24);
            //定义点的图片符号
            var attr = {"name": name, "time": time};
            //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('用户');
            infoTemplate.setContent(
                "<b>名称:</b><span>${name}</span><br>"
                + "<b>时间:</b><span>${time}</span><br>"
                + "<button class='' onclick='returnNormalMap()' >返回查看用户分布图</button>"
            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            if (floor == 1){
                pointLayerF1.add(picgr);
                map1.addLayer(pointLayerF1);
            }
            if (floor == 2){
                pointLayerF2.add(picgr);
                map2.addLayer(pointLayerF2);
            }
            if (floor == 3){
                pointLayerF3.add(picgr);
                map3.addLayer(pointLayerF3);
            }
        }
        /**
         * 从数据库读取用户列表和用户最新坐标并更新界面
         */
        function addPointToMap() {
            @foreach($userPositionLists as $userPositionList)
                var lng={{$userPositionList->lng}};
                var lat={{$userPositionList->lat}};
                var floor={{$userPositionList->floor}};
            if (floor==3){
                if ((38.24766<lat)&&(lat<38.2478) &&(114.3485<lng)&&(lng<114.34871))
                {
                    addUserPoint(
                            {{$userPositionList->id}},
                            {{$userPositionList->uid}},
                        '{{$userPositionList->updated_at}}',
                            {{$userPositionList->lng}},
                            {{$userPositionList->lat}},
                            {{$userPositionList->floor}},
                        'normal'
                    );
                }
            } else {
                if ((38.24766<lat)&&(lat<38.2478) &&(114.3485<lng)&&(lng<114.349238))
                {
                    console.log({{$userPositionList->floor}});
                    addUserPoint(
                            {{$userPositionList->id}},
                            {{$userPositionList->uid}},
                        '{{$userPositionList->updated_at}}',
                            {{$userPositionList->lng}},
                            {{$userPositionList->lat}},
                            {{$userPositionList->floor}},
                        'normal'
                    );
                }
            }


            @endforeach
        }
        addPointToMap();
    });


</script>

<div class="row">
    <div class="map1-col">
        <div id="map1"></div>
    </div>
    <div class="map2-col">
        <div id="map2"></div>
        <button id="showbigger">放大点</button>
        <button id="showsmaller">缩小点</button>
    </div>
    <div class="map3-col">
        <div id="map3"></div>
    </div>
</div>
</body>
</html>