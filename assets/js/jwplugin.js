var global_jw_var=new Array;var keyStr="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";function _get_file(c){var a="";var k,h,f="";var j,g,e,d="";var b=0;c=c.replace(/[^A-Za-z0-9\+\/\=]/g,"");do{j=keyStr.indexOf(c.charAt(b++));g=keyStr.indexOf(c.charAt(b++));e=keyStr.indexOf(c.charAt(b++));d=keyStr.indexOf(c.charAt(b++));k=(j<<2)|(g>>4);h=((g&15)<<4)|(e>>2);f=((e&3)<<6)|d;a=a+String.fromCharCode(k);if(e!=64){a=a+String.fromCharCode(h)}if(d!=64){a=a+String.fromCharCode(f)}k=h=f="";j=g=e=d=""}while(b<c.length);return unescape(a)}var jw_register=function(k,e,a){var j=false;var d=e.gaq;var b=false;function g(m){c();a.className="alert alert-block";a.style.display="none";a.style.padding="15px 10px";a.style.textAlign="center";if($.browser.webkit){a.style.backgroundColor="#fff"}if(e.validate&&!j){var n='<fieldset><div>Silahkan login terlebih dahulu</div><a href="'+e.back_url+'" class="btn btn-inverse" style="margin-top:20px;"> OK </a></fieldset>';if(e.token){var o={token:e.token};if(global_jw_var.getUserByToken){global_jw_var.getUserByToken.abort()}var p=xhost+"services/getUserByToken";global_jw_var.getUserByToken=$.ajax({url:p,data:o,type:"post",dataType:"json",success:function(q){if(q.result){j=true;if(k.getState()!="PLAYING"){k.play()}}else{a.style.display="";a.innerHTML=n}}})}else{a.style.display="";a.innerHTML=n}}else{j=true}d.push(["stats._setAccount",GA_STATS_ACCOUNT])}function h(){var m=k.getPlaylistItem();var n=m.title;if(!n){n=m.description}if(!j){k.stop()}if(!n){n=e.vd_name}d.push(["stats._trackEvent","Video","Playing - "+n,e.vd_name])}function i(){var m=k.getPlaylistItem();var n=m.title;if(!n){n=m.description}if(!n){n=e.vd_name}d.push(["stats._trackEvent","Video","Pause - "+n,e.vd_name])}function f(){var m=k.getPlaylistItem();var n=m.title;if(!n){n=m.description}d.push(["stats._trackEvent","Video","Complete - "+n,e.vd_name]);b=true}function l(){var m=k.getPlaylistItem();var n=m.title;if(!n){n=m.description}if(!n){n=e.vd_name}$(window).bind("beforeunload",function(){if(!b){d.push(["stats._trackEvent","Video","Leave - "+n,e.vd_name])}})}k.onBeforePlay(g);k.onPlay(h);k.onPause(i);k.onTime(l);k.onComplete(f);function c(){var n=k.getWidth();var m=k.getHeight();a.style.position="absolute";a.style.width="278px";a.style.height="80px";a.style.left=(n/2-(278/2))+"px";a.style.top=(m/2-80)+"px"}};function jw_call_player(g,c){var d=600;var a=538;var f=0;if(c.width){d=c.width}if(c.height){a=c.height}if(c.startparam){f=c.startparam}var b=jwplayer(g).setup({file:_get_file(c.utoken),width:d,height:a,autostart:true,idlehide:true,primary:"flash",startparam:f});var e=document.createElement("div");$("#"+g).parent().append(e);jw_register(b,c,e)};