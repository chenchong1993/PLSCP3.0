// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.17/esri/copyright.txt for details.
//>>built
define("esri/tasks/locator","dojo/_base/declare dojo/_base/lang dojo/_base/array dojo/_base/Deferred dojo/_base/json dojo/has ../kernel ../request ../deferredUtils ./Task ./AddressCandidate".split(" "),function(n,f,w,s,p,y,z,t,u,A,r){n=n(A,{declaredClass:"esri.tasks.Locator",_eventMap:{"address-to-locations-complete":["addresses"],"addresses-to-locations-complete":["addresses"],"location-to-address-complete":["address"],"suggest-locations-complete":["suggestions"]},constructor:function(a){this._geocodeHandler=
f.hitch(this,this._geocodeHandler);this._geocodeAddressesHandler=f.hitch(this,this._geocodeAddressesHandler);this._reverseGeocodeHandler=f.hitch(this,this._reverseGeocodeHandler);this.registerConnectEvents()},outSpatialReference:null,setOutSpatialReference:function(a){this.outSpatialReference=a},_geocodeHandler:function(a,b,k,h,c){try{var g=a.candidates,d;b=[];var e,q=g.length,l=a.spatialReference,m;for(e=0;e<q;e++){d=g[e];if(m=d.location)m.spatialReference=l;b[e]=new r(d)}this._successHandler([b],
"onAddressToLocationsComplete",k,c)}catch(f){this._errorHandler(f,h,c)}},_geocodeAddressesHandler:function(a,b,k,h,c){try{var g=a.locations;b=[];var d,e=g.length,f=a.spatialReference,l;for(d=0;d<e;d++){if(l=g[d].location)l.spatialReference=f;b[d]=new r(g[d])}this._successHandler([b],"onAddressesToLocationsComplete",k,c)}catch(m){this._errorHandler(m,h,c)}},addressToLocations:function(a,b,k,h,c){var g,d,e,q,l,m,x;a.address&&(h=k,k=b,b=a.outFields,c=a.searchExtent,x=a.countryCode,g=a.magicKey,d=a.distance,
m=a.categories,a.location&&this.normalization&&(e=a.location.normalize()),q=a.maxLocations,l=a.forStorage,a=a.address);c&&(c=c.shiftCentralMeridian());var n=this.outSpatialReference;a=this._encode(f.mixin({},this._url.query,a,{f:"json",outSR:n&&p.toJson(n.toJson()),outFields:b&&b.join(",")||null,searchExtent:c&&p.toJson(c.toJson()),category:m&&m.join(",")||null,countryCode:x||null,magicKey:g||null,distance:d||null,location:e||null,maxLocations:q||null,forStorage:l||null}));var r=this._geocodeHandler,
w=this._errorHandler,v=new s(u._dfdCanceller);v._pendingDfd=t({url:this._url.path+"/findAddressCandidates",content:a,callbackParamName:"callback",load:function(a,b){r(a,b,k,h,v)},error:function(a){w(a,h,v)}});return v},suggestLocations:function(a){var b;b=new s(u._dfdCanceller);a.hasOwnProperty("location")&&this.normalization&&(a.location=a.location.normalize());a.searchExtent&&(a.searchExtent=a.searchExtent.shiftCentralMeridian());a=this._encode(f.mixin({},this._url.query,{f:"json",text:a.text,maxSuggestions:a.maxSuggestions,
searchExtent:a.searchExtent&&p.toJson(a.searchExtent.toJson()),category:a.categories&&a.categories.join(",")||null,countryCode:a.countryCode||null,location:a.location||null,distance:a.distance||null},{f:"json"}));a=t({url:this._url.path+"/suggest",content:a,callbackParamName:"callback"});b._pendingDfd=a;a.then(f.hitch(this,function(a){a=a.suggestions||[];this.onSuggestLocationsComplete(a);b.resolve(a)}),f.hitch(this,function(a){this._errorHandler(a);b.reject(a)}));return b},addressesToLocations:function(a,
b,k){var h=this.outSpatialReference,c=[],g=a.categories,d=a.countryCode;w.forEach(a.addresses,function(a,b){c.push({attributes:a})});a=this._encode(f.mixin({},this._url.query,{category:g&&g.join(",")||null,sourceCountry:d||null},{addresses:p.toJson({records:c})},{f:"json",outSR:h&&p.toJson(h.toJson())}));var e=this._geocodeAddressesHandler,q=this._errorHandler,l=new s(u._dfdCanceller);l._pendingDfd=t({url:this._url.path+"/geocodeAddresses",content:a,callbackParamName:"callback",load:function(a,c){e(a,
c,b,k,l)},error:function(a){q(a,k,l)}});return l},_reverseGeocodeHandler:function(a,b,f,h,c){try{var g=new r({address:a.address,location:a.location,score:100});this._successHandler([g],"onLocationToAddressComplete",f,c)}catch(d){this._errorHandler(d,h,c)}},locationToAddress:function(a,b,k,h){a&&this.normalization&&(a=a.normalize());var c=this.outSpatialReference;a=this._encode(f.mixin({},this._url.query,{outSR:c&&p.toJson(c.toJson()),location:a&&p.toJson(a.toJson()),distance:b,f:"json"}));var g=this._reverseGeocodeHandler,
d=this._errorHandler,e=new s(u._dfdCanceller);e._pendingDfd=t({url:this._url.path+"/reverseGeocode",content:a,callbackParamName:"callback",load:function(a,b){g(a,b,k,h,e)},error:function(a){d(a,h,e)}});return e},onSuggestLocationsComplete:function(){},onAddressToLocationsComplete:function(){},onAddressesToLocationsComplete:function(){},onLocationToAddressComplete:function(){}});y("extend-esri")&&f.setObject("tasks.Locator",n,z);return n});