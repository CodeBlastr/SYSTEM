/**
 * Copyright (c) 2009-2010, Skype Technologies S.A. All rights reserved.
 * Originally partly based on YUI library (http://developer.yahoo.com/yui/),
 * also some techniques from jQuery library (http://www.jquery.com/).
 * Version: 2.0
 */

/**
 * The SKYPE object is the single global object used by Skype Common Library.
 * It contains utility functions for strings, arrays, cookies, preferences, and
 * logging. SKYPE.util, SKYPE.user are namespaces created automatically for
 * and used by the library.
 * @module skype
 * @title  SKYPE Global
 */
if (typeof SKYPE == "undefined")
{
	/**
	 * The SKYPE global namespace object
	 * @class SKYPE
	 * @static
	 */
	var SKYPE = {};
}

/**
 * Returns the namespace specified and creates it if it doesn't exist
 * <pre>
 * SKYPE.namespace("property.package");
 * SKYPE.namespace("SKYPE.property.package");
 * </pre>
 * Either of the above would create SKYPE.property, then
 * SKYPE.property.package
 *
 * Be careful when naming packages. Reserved words may work in some browsers
 * and not others. For instance, the following will fail in Safari:
 * <pre>
 * SKYPE.namespace("really.long.nested.namespace");
 * </pre>
 * This fails because "long" is a future reserved word in ECMAScript
 *
 * @method namespace
 * @static
 * @param  {String*} arguments 1-n namespaces to create 
 * @return {Object}  A reference to the last namespace object created
 */
SKYPE.namespace = function()
{
	var a=arguments, o=null, i, j, d;
	for (i=0; i<a.length; ++i)
	{
		d=a[i].split(".");
		o=SKYPE;
		// SKYPE is implied, so it is ignored if it is included
		for (j=(d[0] == "SKYPE") ? 1 : 0; j<d.length; ++j)
		{
			o[d[j]]=o[d[j]] || {};
			o=o[d[j]];
		}
	}
	return o;
};

/**
 * Uses console.log to output a log message, if the console object is available.
 *
 * @method log
 * @static
 * @param  {String}  msg  The message to log.
 * @param  {String}  cat  The log category for the message.  Default
 *						categories are "info", "warn", "error", time".
 *						Custom categories can be used as well. (opt)
 * @param  {String}  src  The source of the the message (opt)
 * @return {Boolean}	  True if the log operation was successful.
 */
SKYPE.__log_enabled = null;
SKYPE.log = function(msg, cat, src)
{
	if (SKYPE.__log_enabled === null)
	{
		SKYPE.__log_enabled = (
			location.host.indexOf(".test") > -1
			|| document.cookie.indexOf("debug") > -1
			|| location.search.indexOf("debug") > -1
		);
		
		if (!SKYPE.__log_enabled) return;
		
		SKYPE.__log_type = null;
		if (typeof YAHOO != "undefined" && YAHOO.widget && YAHOO.widget.Logger && YAHOO.widget.Logger.log)
			SKYPE.__log_type = "yui";
		else if (SKYPE.util.Browser.isGecko && typeof console != "undefined" && typeof console.log != "undefined")
			SKYPE.__log_type = "firebug";
		else if (SKYPE.util.Browser.isSafari && typeof window.console != "undefined" && typeof window.console.log != "undefined")
			SKYPE.__log_type = "webkit";
		else if (SKYPE.util.Browser.isOpera && typeof opera == "object" && typeof opera.postError != "undefined")
			SKYPE.__log_type = "opera";
		else if (typeof console != "undefined" && (typeof console.log == "function" || typeof console.log == "object"))
			SKYPE.__log_type = "native";
	}
	if (!SKYPE.__log_enabled) return;
	
	switch (SKYPE.__log_type)
	{
		// YUI logger
		case "yui":
			return YAHOO.widget.Logger.log(msg, cat, src);
			break;
		
		// Firefox Firebug
		case "firebug":
			if (cat && (typeof console[cat] != "undefined"))
				console[cat](msg);
			else
				console.log((cat ? "["+cat.toUpperCase()+"] " : "") + msg);
			break;
			
		// Safari/WebKit JS console
		case "webkit":
			window.console.log((cat ? "["+cat.toUpperCase()+"] " : "") + msg);
			break;
		
		// Opera error console
		case "opera":
			opera.postError((cat ? "["+cat.toUpperCase()+"] " : "") + msg);
			break;

		case "native":
			console.log((cat ? "["+cat.toUpperCase()+"] " : "") + msg);
	}
};

/**
 * Registers a module with the SKYPE object
 * @method register
 * @static
 * @param {String}   name	the name of the module (event, slider, etc)
 * @param {Function} mainClass a reference to class in the module.  This
 *							 class will be tagged with the version info
 *							 so that it will be possible to identify the
 *							 version that is in use when multiple versions
 *							 have loaded
 * @param {Object}   data	  metadata object for the module.  Currently it
 *							 is expected to contain a "version" property
 *							 and a "build" property at minimum.
 */
SKYPE.register = function(name, mainClass, data) {
	var mods = SKYPE.env.modules;
	if (!mods[name]) {
		mods[name] = { versions:[], builds:[] };
	}
	var m=mods[name],v=data.version,b=data.build,ls=SKYPE.env.listeners;
	m.name = name;
	m.version = v;
	m.build = b;
	m.versions.push(v);
	m.builds.push(b);
	m.mainClass = mainClass;
	// fire the module load listeners
	for (var i=0;i<ls.length;i=i+1) {
		ls[i](m);
	}

	// label the main class
	if (mainClass) {
		mainClass.VERSION = v;
		mainClass.BUILD = b;
	} else {
		SKYPE.log("mainClass is undefined for module " + name, "warn");
	}
};


/**
 * SKYPE.env is used to keep track of what is known about the YUI library and
 * the browsing environment
 * @class SKYPE.env
 * @static
 */
SKYPE.env = SKYPE.env || {

	/**
	 * Keeps the version info for all modules that have reported themselves
	 * @property modules
	 * @type Object[]
	 */
	modules: [],
	
	/**
	 * List of functions that should be executed every time a module
	 * reports itself.
	 * @property listeners
	 * @type Function[]
	 */
	listeners: []
};

/**
 * Returns the version data for the specified module:
 *	  <dl>
 *	  <dt>name:</dt>	  <dd>The name of the module</dd>
 *	  <dt>version:</dt>   <dd>The version in use</dd>
 *	  <dt>build:</dt>	 <dd>The build number in use</dd>
 *	  <dt>versions:</dt>  <dd>All versions that were registered</dd>
 *	  <dt>builds:</dt>	<dd>All builds that were registered.</dd>
 *	  <dt>mainClass:</dt> <dd>An object that was was stamped with the
 *				 current version and build. If 
 *				 mainClass.VERSION != version or mainClass.BUILD != build,
 *				 multiple versions of pieces of the library have been
 *				 loaded, potentially causing issues.</dd>
 *	   </dl>
 *
 * @method getVersion
 * @static
 * @param {String}  name the name of the module (event, slider, etc)
 * @return {Object} The version info
 */
SKYPE.env.getVersion = function(name) {
	return SKYPE.env.modules[name] || null;
};

SKYPE.namespace("util", "user");

SKYPE.util.Browser = function()
{
	// Partly from ExtJS lib
	var ua = navigator.userAgent.toLowerCase();
	var isStrict = document.compatMode == "CSS1Compat";
	var isOpera = ua.indexOf("opera") > -1;
	var isSafari = /webkit|khtml/.test(ua);
	var isIE = ua.indexOf("msie") > -1;
	var isIE7 = ua.indexOf("msie 7") > -1;
	var isGecko = !isSafari && ua.indexOf("gecko") > -1;
	var isBorderBox = isIE && !isStrict;
	var isWindows = (ua.indexOf("windows") != -1 || ua.indexOf("win32") != -1);
	var isMac = (ua.indexOf("macintosh") != -1 || ua.indexOf("mac os x") != -1);
	var isLinux = /x11|linux|freebsd|netbsd/.test(ua);
	var isHtmlVideo = function (){
		var detect = document.createElement('video') || false;
		var htmlVideo = detect && (typeof detect.canPlayType !== "undefined");
		return (htmlVideo == true);
	}();
	var isHtmlVideoMp4 = function(){
		var detect = document.createElement('video') || false;
		if (isIE) {
			return false;
		}
		var htmlVideoMp4 = detect.canPlayType("video/mp4") === "maybe" || detect.canPlayType("video/mp4") === "probably";
		return (htmlVideoMp4 == true);
	}();
	
	return {
		isStrict: isStrict
		,isOpera: isOpera
		,isSafari: isSafari
		,isIE: isIE
		,isIE7: isIE7
		,isGecko: isGecko
		,isBorderBox: isBorderBox
		,isWindows: isWindows
		,isMac: isMac
		,isLinux: isLinux
		,isHtmlVideo: isHtmlVideo
		,isHtmlVideoMp4: isHtmlVideoMp4
	};
}();

SKYPE.util.Createnodes = function() {
	if (navigator.userAgent.toLowerCase().match("msie")) {
		var n = ("abbr article aside audio canvas details figcaption figure footer header hgroup mark meter nav output progress section summary time video").split(" ");
		for (var i in n) { document.createElement(n[i]);}
	}
}();


/**
 * Utility method for extending an object with another object.
 *
 * Mostly from jQuery lib
 *
 * @method extend
 * @static
 * @param {Object}   Target object to extend
 * @param {Object*}  1..n number of objects to merge to the first one
 * @return {Object}  Returns the extended object, that was supplied as first parameter
 */
SKYPE.util.extend = function() {
	var _isArray = function( obj ) {
		return toString.call(obj) === "[object Array]";
	},
	_isPlainObject = function( o ) {
		var hasOwnProperty = Object.prototype.hasOwnProperty;

		// Must be an Object.
		// Because of IE, we also have to check the presence of the constructor property.
		// Make sure that DOM nodes and window objects don't pass through, as well
		if ( !obj || toString.call(obj) !== "[object Object]" || obj.nodeType || obj.setInterval ) {
			return false;
		}
	
		// Not own constructor property must be Object
		if ( obj.constructor
			&& !hasOwnProperty.call(obj, "constructor")
			&& !hasOwnProperty.call(obj.constructor.prototype, "isPrototypeOf") ) {
			return false;
		}
	
		// Own properties are enumerated firstly, so to speed up,
		// if last one is own, then all properties are own.

		var key;
		for ( key in obj ) {}
	
		return key === undefined || hasOwnProperty.call( obj, key );
	},
	_extend = function() {
		// copy reference to target object
		var target = arguments[0] || {}, i = 1, length = arguments.length, deep = false, options, name, src, copy;

		// Handle a deep copy situation
		if ( typeof target === "boolean" ) {
			deep = target;
			target = arguments[1] || {};
			// skip the boolean and the target
			i = 2;
		}

		// Handle case when target is a string or something (possible in deep copy)
		if ( typeof target !== "object" && typeof target !== "function" ) {
			target = {};
		}

		// nothing to extend if 1 argument
		if ( length === i ) {
			return;
		}

		for ( ; i < length; i++ ) {
			// Only deal with non-null/undefined values
			if ( (options = arguments[ i ]) != null ) {
				// Extend the base object
				for ( name in options ) {
					src = target[ name ];
					copy = options[ name ];

					// Prevent never-ending loop
					if ( target === copy ) {
						continue;
					}

					// Recurse if we're merging object literal values or arrays
					if ( deep && copy && ( _isPlainObject(copy) || _isArray(copy) ) ) {
						var clone = src && ( _isPlainObject(src) || _isArray(src) ) ? src
							: _isArray(copy) ? [] : {};

						// Never move original objects, clone them
						target[ name ] = _extend( deep, clone, copy );

					// Don't bring in undefined values
					} else if ( copy !== undefined ) {
						target[ name ] = copy;
					}
				}
			}
		}

		// Return the modified object
		return target;
	};

	return _extend;
}();


/**
 * Boot loader utility
 *
 * Gives SKYPE core utility to load additional javascript as modules.
 *
 * @class   Loader
 * @author  Martin Kapp <martin.kapp@skype.net>
 * @version 1.0
 * @site	http://www.skype.com/
 */
SKYPE.env.Loader = (function() {

	// Internal list
	var _required = {},
		modules = {},
		readyCalled = false,
		modulesLoaded = false;

	var _prefix = '/';
	if ( typeof SKYPE != 'undefined' && SKYPE.settings && SKYPE.settings.assetsPath ) {
		_prefix = SKYPE.settings.assetsPath + (SKYPE.settings.assetsPath.substr(-1) == '/' ? '' : '/');
	}


	// Load all the SCRIPTS
	var _loadDependencyTree = function( list ) {
		if ( typeof list == 'undefined' ) {
			list = _required;
		}

		var ready = [];

		for ( var i in list ) {
			if ( typeof list[i].loaded == 'undefined' ) {
				
				if (typeof list[i].loadcheck != 'undefined') {
					if (list[i].loadcheck) {
						ready.push(i);
						continue;
					}
				}

				if ( typeof list[i].requires == 'undefined' ) {
					ready.push(i);

				} else if ( typeof list[i].requires == 'object' ) {

					var modReady = true;

					for ( var j in list[i].requires ) {
						var mod = list[j];

						if ( typeof mod.loaded == 'undefined' || !mod.loaded ) {
							modReady = false;
							if (typeof mod.loadcheck != 'undefined') {
								if (mod.loadcheck) {
									modReady = true;
								}
							}
						}
					}
					if ( modReady ) {
						ready.push(i);
					}
				}
			}
		}

		if ( ready.length ) {
			SKYPE.log( 'Ready to load ' + ready.toString(), 'info' );

			for ( var i = 0, len = ready.length; i < len; i++ ) {
				list[ ready[i] ].loaded = false;
				if (typeof list[ready[i]].loadcheck != 'undefined') {
					if (list[ready[i]].loadcheck) {
						list[ready[i]].loaded = true;
						SKYPE.log('Mod already loaded ' + ready[i], 'info');
						continue;
					}
				}
				(function() {
					var inc = ready[i];
					_insertScript( _prefix + '' + list[ inc ].src, 'utf-8', function() {
						SKYPE.log( 'Done loading ' + inc, 'info' );

						list[inc].loaded = true;

						// If init parameters are supplied and module is registered, call init
						if ( list[inc].init ) {
							if ( null !== ( mod = SKYPE.env.getVersion(inc) )) {
								if ( mod.mainClass && mod.mainClass.init && typeof mod.mainClass.init == 'function' ) {
									SKYPE.log( 'Calling init on ' + inc, 'info' );
									mod.mainClass.init( list[inc].init );
								}
							}
						}

						_loadDependencyTree();
					});
				})();
			}
		}

	},

	// Inserts new SCRIPT tag to the HTML then cleans it up afterwards
	_insertScript = function( url, scriptCharset, callback ) {
		var head = document.getElementsByTagName("head")[0] || document.documentElement;
		var script = document.createElement("script");
		script.src = url;
		if ( scriptCharset ) {
			script.charset = scriptCharset;
		}

		// Handle Script loading
		var done = false;

		// Attach handlers for all browsers
		script.onload = script.onreadystatechange = function() {
			if ( !done && (!this.readyState ||
					this.readyState === "loaded" || this.readyState === "complete") ) {
				done = true;

				// Handle memory leak in IE
				script.onload = script.onreadystatechange = null;
				if ( head && script.parentNode ) {
					head.removeChild( script );
				}

				if ( typeof callback == 'function' ) {
					callback();
				}
			}
		};

		// Use insertBefore instead of appendChild  to circumvent an IE6 bug.
		// This arises when a base node is used (#2709 and #4378).
		head.insertBefore( script, head.firstChild );

		// We handle everything using the script element injection
		return undefined;
	};

	/**
	 * Load module info
	 */
	_insertScript( _prefix + 'i/js/skype-common-modules.js?' + (new Date()).getTime(), 'utf-8', function() {
		SKYPE.log( 'Core modules loaded', 'info' );

		var loadCommon = function( name, opts ) {
			if ( opts && typeof opts.condition != 'undefined' && opts.condition == false ) {
				SKYPE.log('Pass mod ' + name + ' – no condition', 'info');
				if ( typeof opts.skiprequired == 'undefined' ) {
					opts.skiprequired = [];
				}
				return false;
			}


			_required[name] = SKYPE.util.extend( modules[name], opts );

			opts = _required[name];

			// Load module dependencies
			if ( opts && opts.requires ) {
				for ( var i in opts.requires) {
					var added = loadCommon( i, opts.requires[i] );
					if ( !added ) {
						delete opts.requires[i];
					}
				}
			}

			return true;
		};

		for ( var i in _required ) {
			loadCommon( i, _required[i] );
		}

		modulesLoaded = true;

		if ( readyCalled ) {
			_loadDependencyTree();
		}
	});

	// Expose Loader methods
	return {
		// Add available module info
		addModules: function( coreModules ) {
			modules = SKYPE.util.extend( {}, modules, coreModules );
		},

		// Function to add required modules
		require: function( module, opts, initParams ) {

			if (typeof opts != 'object') {
				opts = null;
			}

			// Check if condition is supplied and is valid
			if ( opts && typeof opts.condition != 'undefined' ) {
				if ( !opts.condition ) {
					return false;
				}
			}

			if ( !modulesLoaded ) {
				if ( typeof opts == 'object' ) {

					if ( _required[module] ) {
						_required[module] = SKYPE.util.extend( _required[module], opts );
					} else {
						_required[module] = opts;
					}

				} else {
					_required[module] = {};
				}
			} else {
				// Add module to the required list
				if ( module in modules ) {
					_required[module] = modules[module];

					if ( opts ) {
						_required[module] = SKYPE.util.extend( _required[module], opts );
					}

					opts = _required[module];

				} else if ( opts && opts.src ) {

					if ( _required[module] ) {
						_required[module] = SKYPE.util.extend( _required[module], opts );
					} else {
						_required[module] = opts;
					}

				}
			}

			// Check if init needs to be called when done
			if ( typeof initParams != 'undefined' ) {
				if ( typeof _required[ module ].init == 'undefined' ) {
					_required[ module ].init = [];
				}

				_required[ module ].init.push( initParams );
			}

			// Load module dependencies
			if ( opts && opts.requires ) {
				for ( var i in opts.requires) {
					var added = this.require( i, opts.requires[i] );
					if ( !added ) {
						delete opts.requires[i];
					}
				}
			}

			return true;
		},

		// Function that loads required javascripts
		ready: function() {
			SKYPE.register("loader", SKYPE.env.Loader, {version: "1.0.2", build: "3"});

			readyCalled = true;

			if ( modulesLoaded ) {
				_loadDependencyTree();
			}
		},

		load: function( script, charset, callback ) {
			_insertScript( script, charset, callback );
		}
	};

})();

/* Settings */

/* @legal: Cookie handling code from the book "JavaScript: The Definitive Guide" by David Flanagan published by O'Reilly. ISBN: 0-596-00048-0 */
SKYPE.util.Cookie = function(document, name, hours, path, domain, secure, fieldsep, valuesep)
{
	this.document = document;
	this.name = name;
	if (hours) {
		this.expiration = new Date((new Date()).getTime() + hours*3600000);
	} else {
		this.expiration = null;
	}
	this.path = path ? path : null;
	this.domain = domain ? domain : null;
	this.secure = secure ? true : false;
	this.fieldsep = fieldsep ? fieldsep : ':';
	this.valuesep = valuesep ? valuesep : '&';
	this.isSimpleValue = false;
	// Actual cookie data is held in this one
	this.data = {};
};
SKYPE.util.Cookie.prototype = {
	/**
	 * Saves values set in cookie.
	 */
	store: function (doSort) {
		var cookieval = "";
		var cookie = "";
		var keys = [];
		if (typeof this.data == "object")
		{
			for(var prop in this.data)
			{
				keys.push(prop);
			}
			if (doSort)
				keys.sort();
			for (var i=0; i < keys.length; i++)
			{
				if (cookieval != "") cookieval += this.fieldsep;
				cookieval += keys[i] + this.valuesep + escape(this.data[keys[i]]);
			}
		}
		else
		{
			cookieval = escape(this.data.toString());
		}
		cookie = this.name + '=' + cookieval;
		if (this.expiration)
			cookie += '; expires=' + this.expiration.toGMTString();
		if (this.path) cookie += '; path=' + this.path;
		if (this.domain) cookie += '; domain=' + this.domain;
		if (this.secure) cookie += '; secure';
		this.document.cookie = cookie;
	},
	
	/**
	 * Loads values from cookie
	 */
	load: function()
	{
		if (this.isSimpleValue && typeof this.data != "string")
			this.data = this.data.toString();
		var allcookies = this.document.cookie;
		if (allcookies == "") return false;
		var start = allcookies.indexOf(this.name + '=');
		if (start == -1) return false;
		start += this.name.length + 1;
		var end = allcookies.indexOf(';', start);
		if (end == -1) end = allcookies.length;
		var cookieval = allcookies.substring(start, end);
		if (!this.isSimpleValue)
		{
			var a = cookieval.split(this.fieldsep);
			for (var i=0; i < a.length; i++)
				a[i] = a[i].split(this.valuesep);
			for (var i = 0; i < a.length; i++)
				this.data[a[i][0]] = unescape(a[i][1]);
		} else {
			this.data = cookieval;
		}
		return true;
	},
	
	/**
	 * Removes cookie if it was set.
	 */
	remove: function()
	{
		var cookie = this.name + '=';
		if (this.path) cookie += '; path=' + this.path;
		if (this.domain) cookie += '; domain=' + this.domain;
		cookie += '; expires=Fri, 02-Jan-1970 00:00:00 GMT';
		this.document.cookie = cookie;
	}
};

/**
 * Skype Preference Cookie Handling
 */
SKYPE.user.Preferences = function()
{
	var values = {
		'LC':''
		,'CCY':''
		,'CC':''
		,'TZ':''
		,'VER':''
		,'TS':''
		,'TM':''
		,'VAT':''
		,'UCP':''
		,'ENV':''
	};
	
	var domain = null;
	var cookieName = "SC";
	var cookie = null;
	var path = "/";
	var secure = false;
	var expires = null;
	var _parsing = false;
	
	var platformNames = {
		'0':'windows'
		,'1':'pocketpc'
		,'2':'linux'
		,'3':'osx'
	};
	
	return {
		init: function()
		{
			this.setDomain();
			expires = 365;
			this.parseCookie();
		},
		getCookie: function()
		{
			var c = new SKYPE.util.Cookie(document, cookieName, expires, path, domain, secure, ":", "=");
			c.load();
			return c;
		},
		scrubCookieValue: function(value)
		{
			return value.replace(/[\n\r]/g, "").replace(/</g, "&lt;").replace(/>/g, "&gt;");
		},
		setDomain: function(dom)
		{
			if (dom) {
				domain = dom;
			} else if (location && location.hostname) {
				var parts = location.hostname.split(".");
				var i = parts.length;
				if (i >= 2 && isNaN(parseInt(parts[i-1]))) {
					domain = "."+parts[i-2]+"."+parts[i-1];
				}
			}
		},
		parseCookie: function()
		{
			cookie = this.getCookie();
			var knownSetters = {
				'LC': 'setLanguage'
				,'CCY': 'setCurrency'
				,'CC': 'setCountryCode'
				,'TZ': 'setTimezone'
				,'VER': 'setVersion'
				,'TS': 'setTimeStamp'
				,'TM': 'setTimeModified'
				,'VAT': 'setVatEligible'
				,'UCP': 'setClientProfile'
			};
			_parsing = true;
			for (var prop in cookie.data)
			{
				if (prop.search(/[A-Z]+/) != -1)
				{
					if (knownSetters[prop])
						this[knownSetters[prop]](cookie.data[prop]);
					else
						this.setValue(prop, cookie.data[prop]);
				}
			}
			_parsing = false;
			return true;
		},
		
		save: function()
		{
			for (var val in values)
			{
				cookie.data[val] = values[val];
			}
			cookie.store(true);
		},
		
		clear: function()
		{
			cookie.remove();
		},
		
		getValue: function(key, def)
		{
			if (typeof def == "undefined")
				def = "";
			if (values[key] && values[key] != null && values[key].length)
				return values[key];
			return def;
		},
		setValue: function(key, value)
		{
			values[key] = value.toString();
		},
		
		touchCookie: function()
		{
			var now = parseInt(new Date().getTime()/1000);
			if (_parsing)
				return false;
			if (!this.getTimeStamp().length)
				this.setValue("TS", now);
			this.setValue("TM", now);
			return true;
		},
		
		setLanguage: function(value)
		{
			/* TODO: Should do validation here before setting? */
			this.setValue("LC", value.replace(/_/g, "-"));
			this.touchCookie();
			return true;
		},
		getLanguage: function(def)
		{
			return this.getValue("LC", def);
		},
		
		setCurrency: function(value)
		{
			if (/^([A-Z]{3}|[0-9]{3})$/.test(value) == false)
				value = "";
			this.setValue("CCY", value);
			this.touchCookie();
			return true;
		},
		getCurrency: function(def)
		{
			return this.getValue("CCY", def);
		},
		
		setCountryCode: function(value)
		{
			if (/^([A-Z]{2,3}|[0-9]{3})$/.test(value) == false)
				value = "";
			this.setValue("CC", value);
			this.touchCookie();
			return true;
		},
		getCountryCode: function(def)
		{
			return this.getValue("CC", def);
		},
		
		formatDecimal: function(value)
		{
			if (value < 10)
				return "0" + value;
			return value;
		},
		
		setTimezone: function(value)
		{
			if (/^([-+]((0[0-9]|1[0-3]):[0-5][0-9]|14:00)|Z)$/.test(value) == false)
			{
				var matches = value.match(/^([-+]?)([0-9]{1,2})(\.[0-9])?$/);
				if (matches)
				{
					var sign = matches[1] && matches[1].length ? matches[1] : '+';
					var hours = parseInt(matches[2]);
					var minutes = matches[3] && matches[3].length ? parseInt(60 * parseFloat(matches[3])) : 0;
					if (hours > 14) hours = 14;
					if (hours == 14) minutes = 0;
					if (minutes > 59) minutes = 0;
					value = sign+this.formatDecimal(hours)+":"+this.formatDecimal(minutes);
				}
			}
			this.setValue("TZ", value);
			this.touchCookie();
			return true;
		},
		getTimezone: function(def)
		{
			return this.getValue("TZ", def);
		},
		
		setVersion: function(value)
		{
			if (typeof value == "object")
			{
				var defaultValues = {
					'platform':''
					,'platformname':''
					,'version':''
					,'campaign':''
					,'partner':''
					,'partnername':''
				};
				for (var prop in defaultValues)
				{
					if (value[prop] == null)
						value[prop] = defaultValues[prop];
				}
				var splitVer = value.version.split(".");
				
				value = value.platform+"/"+splitVer[0]+"."+splitVer[1]+"."+(value.partner.length ? value.partner : splitVer[2])+"."+splitVer[3]+"/"+value.campaign;
			}
			
			if (/^[0-9]?\/[0-9]{1,2}(\.[0-9]{1,5}){3}\/[0-9]*$/.test(value) == false)
				return false;
			
			this.setValue("VER", value);
			this.touchCookie();
			return true;
		},
		getVersion: function(def)
		{
			return this.getValue("VER", def);
		},
		getParsedVersion: function(def)
		{
			var result = {
				'platform':''
				,'platformname':''
				,'version':''
				,'campaign':''
				,'partner':''
				,'partnername':''
			};
			var ver = this.getVersion(def);
			if (!ver.length)
				return result;
			var splitVer = ver.split("/");
			result.platform = splitVer[0];
			result.version = splitVer[1];
			result.campaign = splitVer[2];
			splitVer = result.version.split(".");
			result.partner = (splitVer.length > 2 && splitVer[2]) ? splitVer[2] : 0;
			return result;
		},
		
		setTimeStamp: function(value)
		{
			this.setValue("TS", value);
			this.touchCookie();
		},
		getTimeStamp: function(def)
		{
			return parseInt(this.getValue("TS", def));
		},
		
		setTimeModified: function(value)
		{
			if (_parsing)
			{
				this.setValue("TM", value);
			}
			this.touchCookie();
		},
		getTimeModified: function(def)
		{
			return parseInt(this.getValue("TM", def));
		},
		
		setClientProfile: function(value)
		{
			this.setValue("UCP", value);
			this.touchCookie();
		},
		getClientProfile: function(def)
		{
			return this.getValue("UCP", def);
		},
		
		setVatEligible: function(value)
		{
			var result = "";
			// If string was passed in, then only accept "true" and "false" as valid
			if (typeof value == "string")
			{
				if (value == "true") result = "true";
				else if (value == "false") result = "false";
				else result = "";
			}
			// Turn booleans into strings
			else if (typeof value == "boolean")
			{
				result = value ? "true" : "false";
			}
			// Accept only numbers 0 and 1, nothing else
			else if (typeof value == "number")
			{
				if (value == 1) result = "true";
				else if (value == 0) result = "false";
				else result = "";
			}
			this.setValue("VAT", result);
			this.touchCookie();
		},
		isVatEligible: function()
		{
			var val = this.getValue("VAT");
			if (val == "true") return true;
			else if (val == "false") return false;
			else return null;
		},
		
		setEnv: function(value)
		{
			value = value.replace(/\//g, "-");
			
			if (!this.getEnv(value))
			{
				var env = this.getValue("ENV");
				env = env.length ? env.split("/") : [];
				env.push(value);
				this.setValue("ENV", env.join("/"));
				this.touchCookie();
			}
		},
		getEnv: function(value)
		{
			value = value.replace(/\//g, "-");
			
			var env = this.getValue("ENV").split("/");
			for (var i = 0; i < env.length; i++)
			{
				if (env[i] === value) return true;
			}
			return false;
		},
		deleteEnv: function(value)
		{
			var env = this.getValue("ENV").split("/");
			for (var i=0; i < env.length; i++)
			{
				if (env[i] === value)
				{
					env.splice(i, 1);
				}
			};
			this.setValue("ENV", env.join("/"));
			this.touchCookie();
		},
		clearEnv: function()
		{
			this.setValue("ENV", "");
			this.touchCookie();
		},
		
		debug: function()
		{
			var result = "";
			for (var key in values)
			{
				result = result + key + " = " + values[key] + "\n";
			}
			return result;
		}
	};
}();
SKYPE.user.Preferences.init();


/**
 * Site tweaks
 *
 * Written as lib independent to reduce overhead of functionality that’s needed on every page
 */
SKYPE.util.SiteTweaks = function() {
	SKYPE.env.listeners.push(function( mod ) {
		if ( mod.name == 'loader' ) {
			// Input tweaks
			// Added a hack so this would work for Web reg too
			var header = document.getElementById('header');
			var inputs = header.getElementsByTagName( 'input' );
			for ( var i = 0, length = inputs.length; i < length; i++ ){
				if ( inputs[i].title && inputs[i].type == 'text' ) {
					inputs[i].onfocus = function () {
						if ( this.value === this.title ) {
							this.value = '';
						}
					};
					inputs[i].onblur = function () {
						if ( this.value === '' || this.value === this.title ) {
							this.value = this.title;
						}
					};

					if ( inputs[i].value === '' || inputs[i].value === inputs[i].title ) {
						inputs[i].value = inputs[i].title;
					}
				}
			}
			
			// Language selector
			var lDropdown = document.getElementById('userLanguage');
			var upForm = document.getElementById('userPreferencesForm');
			var changeUrl = upForm.action.replace(/(%5B|\[)LC(%5D|\])/g, lDropdown.options[lDropdown.selectedIndex].value);
			if (lDropdown && upForm) {
				lDropdown.onchange = function() {
					var ddValue = lDropdown.options[lDropdown.selectedIndex].value;
					
					if (typeof SKYPE.user.Preferences.setLanguage != "undefined") {
						SKYPE.user.Preferences.setLanguage(ddValue);
						SKYPE.user.Preferences.save();
						SKYPE.log("Setting user language to: "+ ddValue, "info");
					}
					
					if(/*!lDropdown.options[lDropdown.selectedIndex].value.match("^(zh-Hans|cs|da|nl|et|fi|ko|no|hu|pt|es|ar)$") && */!window.location.hostname.match('secure|search|share|support|about|jobs')) {
						// split window.location into urlArray - protocol+hostname, intl/XX-XXXXX, rest of the url
						var reg = new RegExp("(^"+window.location.protocol+"//"+window.location.hostname+"/)"+"(intl/[a-zA-Z-]{2,8})?/?(.*)");
						var urlArray = reg.exec(window.location);
						if(typeof urlArray[1] != undefined) {
							var newLocation = urlArray[1]; 
							newLocation +=  'intl/' + ddValue + '/';
							//if(typeof urlArray[3] != undefined) {
							//	newLocation += urlArray[3];
							//}
							changeUrl = newLocation;
						}
					}
					window.location = changeUrl;
				};
				if (typeof SKYPE.user.Preferences.getLanguage() != "undefined" && SKYPE.user.Preferences.getLanguage() == "") {
					SKYPE.user.Preferences.setLanguage(lDropdown.options[lDropdown.selectedIndex].value);
					SKYPE.user.Preferences.save();
					SKYPE.log("Setting user language to: "+ lDropdown.options[lDropdown.selectedIndex].value, "info");
				}
			} else {
				return;
			}
		}
	});
	SKYPE.env.Loader.require('sitetweaks', { 'src': 'i/js/jquery/sitetweaks.js', 'requires': { 'jquery' : true } });
}();

/* Load CSS with javascript help */

SKYPE.loadCss = function (filename) {
	var fileref = document.createElement("link");
	fileref.setAttribute("rel", "stylesheet");
	fileref.setAttribute("type", "text/css");
	fileref.setAttribute("href", filename);
	if (typeof fileref != "undefined") {
		document.getElementsByTagName("head")[0].appendChild(fileref);
	}
};

SKYPE.register("skype", SKYPE, {version: "2.0.1", build: "3"});