//>>built
define("xstyle/ext/dgrid","dojo/_base/declare dojo/promise/all dojo/Deferred dojo/when ./widget ../core/expression".split(" "),function(q,l,r,m,e,n){var f={selectionMode:"Selection",columns:"Grid",keyboard:"Keyboard"},p={selectionMode:function(b,a){b.selectionMode=a},keyboard:function(b,a){b.cellNavigation="cell"==a},collection:function(b,a,c){a=n.evaluate(c,a);return m(a.valueOf(),function(a){b.collection=a})},columns:function(b,a){var c=b.columns={};a[0].eachProperty(function(a,b){var k=e.parse(b[0]);
k.className=b[0].selector.slice(1);c[a]=k});return c}};return{put:function(b,a,c){c=c.slice(6);a.constructors||(a.constructors=["dgrid/OnDemandList"],a.handlers=[]);var g=b[0],h=[];g.eachProperty(function(b,c){var d=p[b];d&&(d=d(g.values,c,a))&&h.push(d);f[b]&&a.constructors.push("dgrid/"+f[b])});l(h).then(function(){e.parse(b[0],function(b){a.elements(b)},a.constructors)})}}});