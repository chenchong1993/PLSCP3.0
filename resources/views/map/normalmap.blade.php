@extends('common.layouts')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">基础地图</h4>

        </div>


    </div>
       <style>
        html, body, #map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        #render1{
            position: absolute;top:30px;left:200px;font-size: 18px;
        }
        #render2{
            position: absolute;top:30px;left:240px;font-size: 18px;
        }
        #render3{
            position: absolute;top:30px;left:280px;font-size: 18px;
        }
    </style>

    <script>
        require([
            "Ips/map",
            "Ips/layers/DynamicMapServiceLayer",
            "Ips/layers/FeatureLayer",
            "Ips/renderers/HeatmapRenderer",
            "dojo/on",
            "dojo/dom",
            "dojo/domReady!"
        ], function (Map,DynamicMapServiceLayer,FeatureLayer,HeatmapRenderer,on,dom){
            var map = new Map("map", {
                logo:false
            });
            //初始化F1楼层平面图
            var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorone/MapServer");
            var f2 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floortwo/MapServer");
            var f3 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/331/floorthree/MapServer");
            map.addLayer(f1);
            map.addLayer(f2);
            map.addLayer(f3);
            f2.hide();
            f3.hide();
            on(dom.byId("render1"),"click",function () {

                f1.show();
                f2.hide();
                f3.hide();

            });
            on(dom.byId("render2"),"click",function () {

                f1.hide();
                f3.hide();
                f2.show();

            });
            on(dom.byId("render3"),"click",function () {

                f1.hide();
                f2.hide();
                f3.show()

            })
        });
    </script>
    <div class="row">
        <div class="map-col">
            <div id="map"></div>
            <button id="render1">F1</button>
            <button id="render2">F2</button>
            <button id="render3">F3</button>
        </div>
    </div>
@stop