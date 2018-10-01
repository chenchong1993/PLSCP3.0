// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.17/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/DataBrowser/KeywordFilter",["dojo/_base/declare","dojo/_base/array","dojo/_base/lang"],function(d,c,e){return d(null,{isKeywordFilter:!0,searchString:"",searchFields:null,constructor:function(a,b){this.update(a);this.searchFields=!b?["alias","description","fieldCategory"]:"string"==typeof b?[b]:b},update:function(a){this.searchString=e.trim(a||"");this._keywords=!this.searchString||"*"==this.searchString?null:this.searchString.toLowerCase().split(/(\s+|,\s*)/)},_keywords:null,
isActive:function(){return!!this._keywords},match:function(a){return!this._keywords||c.some(this.searchFields,function(b){return this._matchField(a[b])},this)},_matchField:function(a){if(!a)return!1;a=a.toLowerCase();return c.every(this._keywords,function(b){return 0<=a.indexOf(b)})}})});