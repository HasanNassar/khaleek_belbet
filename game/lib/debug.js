/android/gi.test(navigator.appVersion)&&(console={_log:[],log:function(){for(var a=[],b=0;b<arguments.length;b++)a.push(arguments[b]);this._log.push(a.join(", "))},trace:function(){var a;try{throw Error();}catch(b){a=b.stack}console.log("console.trace()\n"+a.split("\n").slice(2).join("  \n"))},dir:function(a){console.log("Content of "+a);for(var b in a)console.log(' -"'+b+'" -> "'+("function"===typeof a[b]?"function":a[b])+'"')},show:function(){alert(this._log.join("\n"));this._log=[]}},window.onerror=
function(a,b,c){console.log('ERROR: "'+a+'" at "", line '+c)},window.addEventListener("touchstart",function(a){3===a.touches.length&&console.show()}));
