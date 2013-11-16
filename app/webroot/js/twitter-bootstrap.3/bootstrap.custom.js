// prettify code
var q=null;window.PR_SHOULD_USE_CONTINUATION=!0;
(function(){function L(a){function m(a){var f=a.charCodeAt(0);if(f!==92)return f;var b=a.charAt(1);return(f=r[b])?f:"0"<=b&&b<="7"?parseInt(a.substring(1),8):b==="u"||b==="x"?parseInt(a.substring(2),16):a.charCodeAt(1)}function e(a){if(a<32)return(a<16?"\\x0":"\\x")+a.toString(16);a=String.fromCharCode(a);if(a==="\\"||a==="-"||a==="["||a==="]")a="\\"+a;return a}function h(a){for(var f=a.substring(1,a.length-1).match(/\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\[0-3][0-7]{0,2}|\\[0-7]{1,2}|\\[\S\s]|[^\\]/g),a=
[],b=[],o=f[0]==="^",c=o?1:0,i=f.length;c<i;++c){var j=f[c];if(/\\[bdsw]/i.test(j))a.push(j);else{var j=m(j),d;c+2<i&&"-"===f[c+1]?(d=m(f[c+2]),c+=2):d=j;b.push([j,d]);d<65||j>122||(d<65||j>90||b.push([Math.max(65,j)|32,Math.min(d,90)|32]),d<97||j>122||b.push([Math.max(97,j)&-33,Math.min(d,122)&-33]))}}b.sort(function(a,f){return a[0]-f[0]||f[1]-a[1]});f=[];j=[NaN,NaN];for(c=0;c<b.length;++c)i=b[c],i[0]<=j[1]+1?j[1]=Math.max(j[1],i[1]):f.push(j=i);b=["["];o&&b.push("^");b.push.apply(b,a);for(c=0;c<
f.length;++c)i=f[c],b.push(e(i[0])),i[1]>i[0]&&(i[1]+1>i[0]&&b.push("-"),b.push(e(i[1])));b.push("]");return b.join("")}function y(a){for(var f=a.source.match(/\[(?:[^\\\]]|\\[\S\s])*]|\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\\d+|\\[^\dux]|\(\?[!:=]|[()^]|[^()[\\^]+/g),b=f.length,d=[],c=0,i=0;c<b;++c){var j=f[c];j==="("?++i:"\\"===j.charAt(0)&&(j=+j.substring(1))&&j<=i&&(d[j]=-1)}for(c=1;c<d.length;++c)-1===d[c]&&(d[c]=++t);for(i=c=0;c<b;++c)j=f[c],j==="("?(++i,d[i]===void 0&&(f[c]="(?:")):"\\"===j.charAt(0)&&
(j=+j.substring(1))&&j<=i&&(f[c]="\\"+d[i]);for(i=c=0;c<b;++c)"^"===f[c]&&"^"!==f[c+1]&&(f[c]="");if(a.ignoreCase&&s)for(c=0;c<b;++c)j=f[c],a=j.charAt(0),j.length>=2&&a==="["?f[c]=h(j):a!=="\\"&&(f[c]=j.replace(/[A-Za-z]/g,function(a){a=a.charCodeAt(0);return"["+String.fromCharCode(a&-33,a|32)+"]"}));return f.join("")}for(var t=0,s=!1,l=!1,p=0,d=a.length;p<d;++p){var g=a[p];if(g.ignoreCase)l=!0;else if(/[a-z]/i.test(g.source.replace(/\\u[\da-f]{4}|\\x[\da-f]{2}|\\[^UXux]/gi,""))){s=!0;l=!1;break}}for(var r=
{b:8,t:9,n:10,v:11,f:12,r:13},n=[],p=0,d=a.length;p<d;++p){g=a[p];if(g.global||g.multiline)throw Error(""+g);n.push("(?:"+y(g)+")")}return RegExp(n.join("|"),l?"gi":"g")}function M(a){function m(a){switch(a.nodeType){case 1:if(e.test(a.className))break;for(var g=a.firstChild;g;g=g.nextSibling)m(g);g=a.nodeName;if("BR"===g||"LI"===g)h[s]="\n",t[s<<1]=y++,t[s++<<1|1]=a;break;case 3:case 4:g=a.nodeValue,g.length&&(g=p?g.replace(/\r\n?/g,"\n"):g.replace(/[\t\n\r ]+/g," "),h[s]=g,t[s<<1]=y,y+=g.length,
t[s++<<1|1]=a)}}var e=/(?:^|\s)nocode(?:\s|$)/,h=[],y=0,t=[],s=0,l;a.currentStyle?l=a.currentStyle.whiteSpace:window.getComputedStyle&&(l=document.defaultView.getComputedStyle(a,q).getPropertyValue("white-space"));var p=l&&"pre"===l.substring(0,3);m(a);return{a:h.join("").replace(/\n$/,""),c:t}}function B(a,m,e,h){m&&(a={a:m,d:a},e(a),h.push.apply(h,a.e))}function x(a,m){function e(a){for(var l=a.d,p=[l,"pln"],d=0,g=a.a.match(y)||[],r={},n=0,z=g.length;n<z;++n){var f=g[n],b=r[f],o=void 0,c;if(typeof b===
"string")c=!1;else{var i=h[f.charAt(0)];if(i)o=f.match(i[1]),b=i[0];else{for(c=0;c<t;++c)if(i=m[c],o=f.match(i[1])){b=i[0];break}o||(b="pln")}if((c=b.length>=5&&"lang-"===b.substring(0,5))&&!(o&&typeof o[1]==="string"))c=!1,b="src";c||(r[f]=b)}i=d;d+=f.length;if(c){c=o[1];var j=f.indexOf(c),k=j+c.length;o[2]&&(k=f.length-o[2].length,j=k-c.length);b=b.substring(5);B(l+i,f.substring(0,j),e,p);B(l+i+j,c,C(b,c),p);B(l+i+k,f.substring(k),e,p)}else p.push(l+i,b)}a.e=p}var h={},y;(function(){for(var e=a.concat(m),
l=[],p={},d=0,g=e.length;d<g;++d){var r=e[d],n=r[3];if(n)for(var k=n.length;--k>=0;)h[n.charAt(k)]=r;r=r[1];n=""+r;p.hasOwnProperty(n)||(l.push(r),p[n]=q)}l.push(/[\S\s]/);y=L(l)})();var t=m.length;return e}function u(a){var m=[],e=[];a.tripleQuotedStrings?m.push(["str",/^(?:'''(?:[^'\\]|\\[\S\s]|''?(?=[^']))*(?:'''|$)|"""(?:[^"\\]|\\[\S\s]|""?(?=[^"]))*(?:"""|$)|'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$))/,q,"'\""]):a.multiLineStrings?m.push(["str",/^(?:'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$)|`(?:[^\\`]|\\[\S\s])*(?:`|$))/,
q,"'\"`"]):m.push(["str",/^(?:'(?:[^\n\r'\\]|\\.)*(?:'|$)|"(?:[^\n\r"\\]|\\.)*(?:"|$))/,q,"\"'"]);a.verbatimStrings&&e.push(["str",/^@"(?:[^"]|"")*(?:"|$)/,q]);var h=a.hashComments;h&&(a.cStyleComments?(h>1?m.push(["com",/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,q,"#"]):m.push(["com",/^#(?:(?:define|elif|else|endif|error|ifdef|include|ifndef|line|pragma|undef|warning)\b|[^\n\r]*)/,q,"#"]),e.push(["str",/^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h|[a-z]\w*)>/,q])):m.push(["com",/^#[^\n\r]*/,
q,"#"]));a.cStyleComments&&(e.push(["com",/^\/\/[^\n\r]*/,q]),e.push(["com",/^\/\*[\S\s]*?(?:\*\/|$)/,q]));a.regexLiterals&&e.push(["lang-regex",/^(?:^^\.?|[!+-]|!=|!==|#|%|%=|&|&&|&&=|&=|\(|\*|\*=|\+=|,|-=|->|\/|\/=|:|::|;|<|<<|<<=|<=|=|==|===|>|>=|>>|>>=|>>>|>>>=|[?@[^]|\^=|\^\^|\^\^=|{|\||\|=|\|\||\|\|=|~|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\s*(\/(?=[^*/])(?:[^/[\\]|\\[\S\s]|\[(?:[^\\\]]|\\[\S\s])*(?:]|$))+\/)/]);(h=a.types)&&e.push(["typ",h]);a=(""+a.keywords).replace(/^ | $/g,
"");a.length&&e.push(["kwd",RegExp("^(?:"+a.replace(/[\s,]+/g,"|")+")\\b"),q]);m.push(["pln",/^\s+/,q," \r\n\t\xa0"]);e.push(["lit",/^@[$_a-z][\w$@]*/i,q],["typ",/^(?:[@_]?[A-Z]+[a-z][\w$@]*|\w+_t\b)/,q],["pln",/^[$_a-z][\w$@]*/i,q],["lit",/^(?:0x[\da-f]+|(?:\d(?:_\d+)*\d*(?:\.\d*)?|\.\d\+)(?:e[+-]?\d+)?)[a-z]*/i,q,"0123456789"],["pln",/^\\[\S\s]?/,q],["pun",/^.[^\s\w"-$'./@\\`]*/,q]);return x(m,e)}function D(a,m){function e(a){switch(a.nodeType){case 1:if(k.test(a.className))break;if("BR"===a.nodeName)h(a),
a.parentNode&&a.parentNode.removeChild(a);else for(a=a.firstChild;a;a=a.nextSibling)e(a);break;case 3:case 4:if(p){var b=a.nodeValue,d=b.match(t);if(d){var c=b.substring(0,d.index);a.nodeValue=c;(b=b.substring(d.index+d[0].length))&&a.parentNode.insertBefore(s.createTextNode(b),a.nextSibling);h(a);c||a.parentNode.removeChild(a)}}}}function h(a){function b(a,d){var e=d?a.cloneNode(!1):a,f=a.parentNode;if(f){var f=b(f,1),g=a.nextSibling;f.appendChild(e);for(var h=g;h;h=g)g=h.nextSibling,f.appendChild(h)}return e}
for(;!a.nextSibling;)if(a=a.parentNode,!a)return;for(var a=b(a.nextSibling,0),e;(e=a.parentNode)&&e.nodeType===1;)a=e;d.push(a)}var k=/(?:^|\s)nocode(?:\s|$)/,t=/\r\n?|\n/,s=a.ownerDocument,l;a.currentStyle?l=a.currentStyle.whiteSpace:window.getComputedStyle&&(l=s.defaultView.getComputedStyle(a,q).getPropertyValue("white-space"));var p=l&&"pre"===l.substring(0,3);for(l=s.createElement("LI");a.firstChild;)l.appendChild(a.firstChild);for(var d=[l],g=0;g<d.length;++g)e(d[g]);m===(m|0)&&d[0].setAttribute("value",
m);var r=s.createElement("OL");r.className="linenums";for(var n=Math.max(0,m-1|0)||0,g=0,z=d.length;g<z;++g)l=d[g],l.className="L"+(g+n)%10,l.firstChild||l.appendChild(s.createTextNode("\xa0")),r.appendChild(l);a.appendChild(r)}function k(a,m){for(var e=m.length;--e>=0;){var h=m[e];A.hasOwnProperty(h)?window.console&&console.warn("cannot override language handler %s",h):A[h]=a}}function C(a,m){if(!a||!A.hasOwnProperty(a))a=/^\s*</.test(m)?"default-markup":"default-code";return A[a]}function E(a){var m=
a.g;try{var e=M(a.h),h=e.a;a.a=h;a.c=e.c;a.d=0;C(m,h)(a);var k=/\bMSIE\b/.test(navigator.userAgent),m=/\n/g,t=a.a,s=t.length,e=0,l=a.c,p=l.length,h=0,d=a.e,g=d.length,a=0;d[g]=s;var r,n;for(n=r=0;n<g;)d[n]!==d[n+2]?(d[r++]=d[n++],d[r++]=d[n++]):n+=2;g=r;for(n=r=0;n<g;){for(var z=d[n],f=d[n+1],b=n+2;b+2<=g&&d[b+1]===f;)b+=2;d[r++]=z;d[r++]=f;n=b}for(d.length=r;h<p;){var o=l[h+2]||s,c=d[a+2]||s,b=Math.min(o,c),i=l[h+1],j;if(i.nodeType!==1&&(j=t.substring(e,b))){k&&(j=j.replace(m,"\r"));i.nodeValue=
j;var u=i.ownerDocument,v=u.createElement("SPAN");v.className=d[a+1];var x=i.parentNode;x.replaceChild(v,i);v.appendChild(i);e<o&&(l[h+1]=i=u.createTextNode(t.substring(b,o)),x.insertBefore(i,v.nextSibling))}e=b;e>=o&&(h+=2);e>=c&&(a+=2)}}catch(w){"console"in window&&console.log(w&&w.stack?w.stack:w)}}var v=["break,continue,do,else,for,if,return,while"],w=[[v,"auto,case,char,const,default,double,enum,extern,float,goto,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],
"catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],F=[w,"alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,dynamic_cast,explicit,export,friend,inline,late_check,mutable,namespace,nullptr,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],G=[w,"abstract,boolean,byte,extends,final,finally,implements,import,instanceof,null,native,package,strictfp,super,synchronized,throws,transient"],
H=[G,"as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,interface,internal,into,is,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var"],w=[w,"debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN"],I=[v,"and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],
J=[v,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],v=[v,"case,done,elif,esac,eval,fi,function,in,local,set,then,until"],K=/^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)/,N=/\S/,O=u({keywords:[F,H,w,"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END"+
I,J,v],hashComments:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0}),A={};k(O,["default-code"]);k(x([],[["pln",/^[^<?]+/],["dec",/^<!\w[^>]*(?:>|$)/],["com",/^<\!--[\S\s]*?(?:--\>|$)/],["lang-",/^<\?([\S\s]+?)(?:\?>|$)/],["lang-",/^<%([\S\s]+?)(?:%>|$)/],["pun",/^(?:<[%?]|[%?]>)/],["lang-",/^<xmp\b[^>]*>([\S\s]+?)<\/xmp\b[^>]*>/i],["lang-js",/^<script\b[^>]*>([\S\s]*?)(<\/script\b[^>]*>)/i],["lang-css",/^<style\b[^>]*>([\S\s]*?)(<\/style\b[^>]*>)/i],["lang-in.tag",/^(<\/?[a-z][^<>]*>)/i]]),
["default-markup","htm","html","mxml","xhtml","xml","xsl"]);k(x([["pln",/^\s+/,q," \t\r\n"],["atv",/^(?:"[^"]*"?|'[^']*'?)/,q,"\"'"]],[["tag",/^^<\/?[a-z](?:[\w-.:]*\w)?|\/?>$/i],["atn",/^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=\s*([^\s"'>]*(?:[^\s"'/>]|\/(?=\s)))/],["pun",/^[/<->]+/],["lang-js",/^on\w+\s*=\s*"([^"]+)"/i],["lang-js",/^on\w+\s*=\s*'([^']+)'/i],["lang-js",/^on\w+\s*=\s*([^\s"'>]+)/i],["lang-css",/^style\s*=\s*"([^"]+)"/i],["lang-css",/^style\s*=\s*'([^']+)'/i],["lang-css",
/^style\s*=\s*([^\s"'>]+)/i]]),["in.tag"]);k(x([],[["atv",/^[\S\s]+/]]),["uq.val"]);k(u({keywords:F,hashComments:!0,cStyleComments:!0,types:K}),["c","cc","cpp","cxx","cyc","m"]);k(u({keywords:"null,true,false"}),["json"]);k(u({keywords:H,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:K}),["cs"]);k(u({keywords:G,cStyleComments:!0}),["java"]);k(u({keywords:v,hashComments:!0,multiLineStrings:!0}),["bsh","csh","sh"]);k(u({keywords:I,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),
["cv","py"]);k(u({keywords:"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["perl","pl","pm"]);k(u({keywords:J,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb"]);k(u({keywords:w,cStyleComments:!0,regexLiterals:!0}),["js"]);k(u({keywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,true,try,unless,until,when,while,yes",
hashComments:3,cStyleComments:!0,multilineStrings:!0,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]);k(x([],[["str",/^[\S\s]+/]]),["regex"]);window.prettyPrintOne=function(a,m,e){var h=document.createElement("PRE");h.innerHTML=a;e&&D(h,e);E({g:m,i:e,h:h});return h.innerHTML};window.prettyPrint=function(a){function m(){for(var e=window.PR_SHOULD_USE_CONTINUATION?l.now()+250:Infinity;p<h.length&&l.now()<e;p++){var n=h[p],k=n.className;if(k.indexOf("prettyprint")>=0){var k=k.match(g),f,b;if(b=
!k){b=n;for(var o=void 0,c=b.firstChild;c;c=c.nextSibling)var i=c.nodeType,o=i===1?o?b:c:i===3?N.test(c.nodeValue)?b:o:o;b=(f=o===b?void 0:o)&&"CODE"===f.tagName}b&&(k=f.className.match(g));k&&(k=k[1]);b=!1;for(o=n.parentNode;o;o=o.parentNode)if((o.tagName==="pre"||o.tagName==="code"||o.tagName==="xmp")&&o.className&&o.className.indexOf("prettyprint")>=0){b=!0;break}b||((b=(b=n.className.match(/\blinenums\b(?::(\d+))?/))?b[1]&&b[1].length?+b[1]:!0:!1)&&D(n,b),d={g:k,h:n,i:b},E(d))}}p<h.length?setTimeout(m,
250):a&&a()}for(var e=[document.getElementsByTagName("pre"),document.getElementsByTagName("code"),document.getElementsByTagName("xmp")],h=[],k=0;k<e.length;++k)for(var t=0,s=e[k].length;t<s;++t)h.push(e[k][t]);var e=q,l=Date;l.now||(l={now:function(){return+new Date}});var p=0,d,g=/\blang(?:uage)?-([\w.]+)(?!\S)/;m()};window.PR={createSimpleLexer:x,registerLangHandler:k,sourceDecorator:u,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VALUE:"atv",PR_COMMENT:"com",PR_DECLARATION:"dec",PR_KEYWORD:"kwd",PR_LITERAL:"lit",
PR_NOCODE:"nocode",PR_PLAIN:"pln",PR_PUNCTUATION:"pun",PR_SOURCE:"src",PR_STRING:"str",PR_TAG:"tag",PR_TYPE:"typ"}})();

// twitter-bootstrap file upload (http://jasny.github.com/bootstrap/javascript.html#fileupload)
!function(e){"use strict";var t=function(t,n){this.$element=e(t);this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file");this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name;this.$hidden=this.$element.find(':hidden[name="'+this.name+'"]');if(this.$hidden.length===0){this.$hidden=e('<input type="hidden" />');this.$element.prepend(this.$hidden)}this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");if(this.$preview.css("display")!="inline"&&r!="0px"&&r!="none")this.$preview.css("line-height",r);this.$remove=this.$element.find('[data-dismiss="fileupload"]');this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this));this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this));if(this.$remove)this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(t==="clear")return;if(!n){this.clear();return}this.$hidden.val("");this.$hidden.attr("name","");this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!=="undefined"?n.type.match("image.*"):n.name.match("\\.(gif|png|jpe?g)$"))&&typeof FileReader!=="undefined"){var r=new FileReader;var i=this.$preview;var s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />");s.addClass("fileupload-exists").removeClass("fileupload-new")};r.readAsDataURL(n)}else{this.$preview.text(n.name);this.$element.addClass("fileupload-exists").removeClass("fileupload-new")}},clear:function(e){this.$hidden.val("");this.$hidden.attr("name",this.name);this.$input.attr("name","");this.$input.val("");this.$preview.html("");this.$element.addClass("fileupload-new").removeClass("fileupload-exists");if(e){this.$input.trigger("change",["clear"]);e.preventDefault()}},trigger:function(e){this.$input.trigger("click");e.preventDefault()}};e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");if(!i)r.data("fileupload",i=new t(this,n))})};e.fn.fileupload.Constructor=t;e(function(){e("body").on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).parents("[data-dismiss=fileupload],[data-trigger=fileupload]").first();if(r.length>0){r.trigger("click.fileupload");t.preventDefault()}})})}(window.jQuery)

// bsmSelect for better looking mulit-selects (https://github.com/vicb/bsmSelect)
!function(e){function t(t,n){this.$original=e(t);this.buildingSelect=false;this.ieClick=false;this.ignoreOriginalChangeEvent=false;this.options=n;this.buildDom()}t.prototype={generateUid:function(e){return this.uid=this.options.containerClass+e},buildDom:function(){var t=this,n=this.options;if(n.addItemTarget==="original"){e("option",this.$original).each(function(t,n){if(e(n).data("bsm-order")===null){e(n).data("bsm-order",t)}})}for(var r=0;e("#"+this.generateUid(r)).size();r++){}this.$select=e("<select>",{"class":n.selectClass,name:n.selectClass+this.uid,id:n.selectClass+this.uid,change:e.proxy(this.selectChangeEvent,this),click:e.proxy(this.selectClickEvent,this)});this.$list=e.isFunction(n.listType)?n.listType(this.$original):e("<"+n.listType+">",{id:n.listClass+this.uid});this.$list.addClass(n.listClass);this.$container=e("<div>",{"class":n.containerClass,id:this.uid});this.buildSelect();this.$original.change(e.proxy(this.originalChangeEvent,this)).wrap(this.$container).before(this.$select);if(!this.$list.parent().length){this.$original.before(this.$list)}if(this.$original.attr("id")){e("label[for="+this.$original.attr("id")+"]").attr("for",this.$select.attr("id"))}this.$list.delegate("."+n.removeClass,"click",function(){t.dropListItem(e(this).closest("li"));return false});e.each(n.plugins,function(){this.init(t)})},selectChangeEvent:function(){if(e.browser&&e.browser.msie&&e.browser.version<7&&!this.ieClick){return}var t=e("option:selected:eq(0)",this.$select);if(t.data("orig-option")){this.addListItem(t);this.triggerOriginalChange(t.data("orig-option"),"add")}this.ieClick=false},selectClickEvent:function(){this.ieClick=true},originalChangeEvent:function(){if(this.ignoreOriginalChangeEvent){this.ignoreOriginalChangeEvent=false}else{this.buildSelect();if(e.browser&&e.browser.opera){this.$list.hide().show()}}},buildSelect:function(){var t=this;this.buildingSelect=true;this.$select.empty().prepend(e('<option value=""></option>').text(this.$original.attr("title")||this.options.title));this.$list.empty();this.$original.children().each(function(){if(e(this).is("option")){t.addSelectOption(t.$select,e(this))}else if(e(this).is("optgroup")){t.addSelectOptionGroup(t.$select,e(this))}});if(!this.options.debugMode){this.$original.hide()}this.selectFirstItem();this.buildingSelect=false},addSelectOption:function(t,n){var r=e("<option>",{text:n.text(),val:n.val()}).appendTo(t).data("orig-option",n),i=n.is(":selected"),s=n.is(":disabled");n.data("bsm-option",r);if(i&&!s){this.addListItem(r);this.disableSelectOption(r)}else if(!i&&s){this.disableSelectOption(r)}},addSelectOptionGroup:function(t,n){var r=this,i=e("<optgroup>",{label:n.attr("label")}).appendTo(t);if(n.is(":disabled")){i.attr("disabled","disabled")}e("option",n).each(function(){r.addSelectOption(i,e(this))})},selectFirstItem:function(){e("option:eq(0)",this.$select).attr("selected","selected")},disableSelectOption:function(t){t.addClass(this.options.optionDisabledClass).removeAttr("selected").attr("disabled","disabled").toggle(!this.options.hideWhenAdded);if(e.browser&&e.browser.msie&&e.browser.version<8){this.$select.hide().show()}},enableSelectOption:function(t){t.removeClass(this.options.optionDisabledClass).removeAttr("disabled").toggle(!this.options.hideWhenAdded);if(e.browser&&e.browser.msie&&e.browser.version<8){this.$select.hide().show()}},addListItem:function(t){var n,r=t.data("orig-option"),i=this.options;if(!r){return}if(!this.buildingSelect){if(r.is(":selected")){return}r.attr("selected","selected")}n=e("<li>",{"class":i.listItemClass}).append(e("<span>",{"class":i.listItemLabelClass,html:i.extractLabel(t,i)})).append(e("<a>",{href:"#","class":i.removeClass,html:i.removeLabel})).data("bsm-option",t);this.disableSelectOption(t.data("item",n));switch(i.addItemTarget){case"bottom":this.$list.append(n.hide());break;case"original":var s=r.data("bsm-order"),o=false;e("."+i.listItemClass,this.$list).each(function(){if(s<e(this).data("bsm-option").data("orig-option").data("bsm-order")){n.hide().insertBefore(this);o=true;return false}});if(!o){this.$list.append(n.hide())}break;default:this.$list.prepend(n.hide())}if(this.buildingSelect){e.bsmSelect.effects.show(n)}else{i.showEffect(n);i.highlightEffect(this.$select,n,i.highlightAddedLabel,this.options);this.selectFirstItem()}},dropListItem:function(t){var n=t.data("bsm-option"),r=this.options;n.removeData("item").data("orig-option").removeAttr("selected");(this.buildingSelect?e.bsmSelect.effects.remove:r.hideEffect)(t);this.enableSelectOption(n);r.highlightEffect(this.$select,t,r.highlightRemovedLabel,r);this.triggerOriginalChange(n.data("orig-option"),"drop")},triggerOriginalChange:function(e,t){this.ignoreOriginalChangeEvent=true;this.$original.trigger("change",[{option:e,value:e.val(),item:e.data("bsm-option").data("item"),type:t}])}};e.fn.bsmSelect=function(n){var r=e.extend({},e.bsmSelect.conf,n);return this.each(function(){var n=e(this).data("bsmSelect");if(!n){n=new t(e(this),r);e(this).data("bsmSelect",n)}})};e.bsmSelect={};e.extend(e.bsmSelect,{effects:{show:function(e){e.show()},remove:function(e){e.remove()},highlight:function(t,n,r,i){var s,o=t.attr("id")+i.highlightClass;e("#"+o).remove();s=e("<span>",{"class":i.highlightClass,id:o,html:r+n.children("."+i.listItemLabelClass).first().text()}).hide();t.after(s.fadeIn("fast").delay(50).fadeOut("slow",function(){e(this).remove()}))},verticalListAdd:function(t){t.animate({opacity:"show",height:"show"},100,function(){e(this).animate({height:"+=2px"},100,function(){e(this).animate({height:"-=2px"},100)})})},verticalListRemove:function(t){t.animate({opacity:"hide",height:"hide"},100,function(){e(this).prev("li").animate({height:"-=2px"},100,function(){e(this).animate({height:"+=2px"},100)});e(this).remove()})}},plugins:{}});e.bsmSelect.conf={listType:"ol",showEffect:e.bsmSelect.effects.show,hideEffect:e.bsmSelect.effects.remove,highlightEffect:e.noop,addItemTarget:"bottom",hideWhenAdded:false,debugMode:false,title:"Select...",removeLabel:"remove",highlightAddedLabel:"Added: ",highlightRemovedLabel:"Removed: ",extractLabel:function(e){return e.html()},plugins:[],containerClass:"bsmContainer",selectClass:"bsmSelect",optionDisabledClass:"bsmOptionDisabled",listClass:"bsmList",listItemClass:"bsmListItem",listItemLabelClass:"bsmListItemLabel",removeClass:"bsmListItemRemove",highlightClass:"bsmHighlight"}}(jQuery)


$(function() {
	$('.truncate').each(function(index) {
		var length = $(this).attr('data-truncate') !== undefined ? $(this).attr('data-truncate') : 100;
        var end = $(this).attr('data-truncate-end') !== undefined ? $(this).attr('data-truncate-end') : '&hellip; Read More';
		if ($(this).text().length > length) {
			$(this).after('<div class="truncated" style="display: none;">' + $(this).html() + ' <a class="truncate-less">&hellip; Less</a></div>');
			$(this).html($.trim($(this).text()).substring(0, length).split(" ").slice(0, -1).join(" ") + '  <a class="truncate-more">' + end + '</a>');
		}
	});
	$('.truncate-more').click(function(){
		$(this).parent().hide();
		$(this).parent().next().show('slow');
	});
	$('.truncate-less').click(function(){
		$(this).parent().hide();
		$(this).parent().prev().show();
	});
	
	
	// default super-select class
    $(".super-select").bsmSelect({
        removeLabel: ' x',
        containerClass: 'row super-select', // Class for container that wraps this widget
        listClass: '',               // Class for the list ($ol)
        listItemClass: 'label label-info pull-left',             // Class for the <li> list items
        listItemLabelClass: '',       // Class for the label text that appears in list items
        removeClass: 'close'         // Class given to the "remove" link
    }).parent().parent().children('label').append('<small> (<a href="#" class="super-select-all">select all</a>) </small>');
    $(document).on('click', '.super-select-all', function() {
        $('.super-select', $(this).parent().parent().parent()).children().attr('selected', 'selected').end().change();
        $(this).parent().replaceWith('<small> (<a href="#" class="super-remove-all">remove all</a>) </small>');
        return false;
    });
    $(document).on('click', '.super-remove-all', function() {
        $('.super-select', $(this).parent().parent().parent()).children().removeAttr('selected').end().change();
        $(this).parent().replaceWith('<small> (<a href="#" class="super-select-all">select all</a>) </small>');
        return false;
    }); 

});

// Avoid `console` errors in browsers that lack a console.
if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
            console[methods[length]] = noop;
        }
    }());
}
// make code pretty
window.prettyPrint && prettyPrint();

// replace tag snippet
(function($){
  $.fn.replaceTagName = function(a){
    var t = [];
    for(var i = this.length - 1; 0 <= i ; i--) {
      var n = document.createElement(a);
      n.innerHTML = this[i].innerHTML;
      $.each(this[i].attributes, function(j, v) {
        $(n).attr(v.name, v.value);
      });
      $(this[i]).after(n).remove();
      t[i] = n;
    }
    return $(t);
  };
})(jQuery);


$(function() {
	
    // Default tooltip selector 
    $("a[rel=tooltip]").tooltip();
    
    // tables
	$('.container table:not(#webpage_content table)').addClass('table');
	
    //handle money inputs (which are denoted by two decimal places)
    $('input[step="0.01"]').width(function() {
        //$(this).width($(this).width() - 28);
        $(this).wrap('<div class="input-group"></div>');
        $(this).before('<span class="input-group-addon">$</span>');
        //$(this).parent().addClass('input-prepend');
    });
	
	// pagination 
	$(".paging span:first-child").addClass("previous");
	$(".paging span:last-child").addClass("next");
	$(".paging span").wrapAll("<ul />");
	$(".paging ul span").wrap("<li />");
	$(".paging").addClass("panel panel-default").wrapInner('<div class="panel-body"></div>');
	$(".paging ul").addClass("pagination");
	
	// messages
	$("#flashMessage, #authMessage").addClass("alert alert-info").prepend("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>");
    
    $("*[data-toggle=collapse]").css('cursor', 'pointer');
    
    /* forms */
    $('input[type=submit]').addClass('btn btn-primary');
    $('.required').attr('required', true);
    $('label').addClass('control-label');
    $('input:not([type=submit], [type=checkbox], [type=radio]), select, textarea').addClass('form-control').parent().addClass('form-group');
	
/**
 * Hides form elements that come after a legend with the class toggleClick
 * <legend class="toggleClick">Legend Text</legend>
 */
  	$('legend.toggleClick').siblings().hide();
	$('legend.toggleClick').addClass("toggle");
	
  	$('body').on("click", "legend.toggleClick", function(){
    	$(this).siblings().slideToggle("toggle");
		if ($(this).is(".toggle")) {
			$(this).removeClass("toggle");
			$(this).addClass("toggled");
		} else {
			$(this).removeClass("toggled");
			$(this).addClass("toggle");
		}
    });
	
/**
 * Site wide toggle, set the click elements class to toggleClick, 
 * and the data-target attribute to the selector of the element you want to toggle. 
 * example:  <div class="toggleClick" data-target="#someId + .someClass">click to toggle</div>
 */
	$(".toggleClick, .toggleHover, .showClick").css('cursor', 'pointer');
	$(".toggleClick[data-target], .toggleHover[data-target], .showClick[data-target]").each( function(index) {
		var currentName = $(this).attr("data-target");
		$(currentName).hide();
        $(this).removeClass('toggled');
        $(this).addClass('toggle');
	});
	
	$(".toggleClick[data-target]").click(function (e) {
		var link = $(this);
		var currentName = $(this).attr('data-target');
		$(currentName).toggle('easing', function() {
			if ($(link).hasClass('toggle')) {
        		$(link).removeClass('toggle');
        		$(link).addClass('toggled');
			} else {
        		$(link).removeClass('toggled');
        		$(link).addClass('toggle');
			}
		});
		return false;
	});
	
	$(".toggleHover[data-target]").hover(function () {
		var currentName = $(this).attr('data-target');
		$(currentName).toggle();
		return false;
	});
	
	$(".showClick[data-target]").click(function () {
		var currentName = $(this).attr('data-target');
		$(currentName).show('slow');
		return false;
	});	
});

// hmm.. only place I see this used is on the privileges page

function applyCheckboxToggles () {
    $('.checkboxToggleDiv').each(function () {
        var c = $(this).children('input[type=checkbox]').first();
        c.wrap('<label class="toggle well header-toggle" style="width:70px;" />');
        c.after('<p><span class="btn-inverse disabled active">no</span><span class="btn-success disabled active">yes</span></p><a class="btn btn-mini slide-button"></a>');
        c.change(function(e){
        	toggleMode($(e.target));
        });
    	
    	toggleMode(c);
    	
    });
    
    $('.checkboxToggle').each(function () {
		var yes = ( $(this).data('yes') === undefined ) ? 'yes' : $(this).data('yes');
		var no = ( $(this).data('no') === undefined ) ? 'no' : $(this).data('no');
		var width = ( $(this).data('width') === undefined ) ? '70' : $(this).data('width');
        $(this).wrap('<label class="toggle well header-toggle" style="width:'+width+'px;" />');
        $(this).after('<p><span>'+no+'</span><span>'+yes+'</span></p><a class="btn btn-mini slide-button"></a>');
    });
}
applyCheckboxToggles();