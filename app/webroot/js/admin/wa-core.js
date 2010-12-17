/*global pageTracker, s_gi, sc_custom_local, sc_custom_country,sc_custom_enviroment, s, s_account, language_code*/
/*jslint bitwise: true, browser: true, eqeqeq: true, immed: true, newcap: true, nomen: true, onevar: true, plusplus: true, white: true, widget: true, undef: true, indent: 2, regexp: false*/

var SKYPE = SKYPE || {};
SKYPE.wanalytics = SKYPE.wanalytics || {};

/* Hack for SSI */ 
SKYPE.settings        = SKYPE.settings || {}; 
SKYPE.settings.geoIP  = SKYPE.settings.geoIP || ""; /* will go into row*/
SKYPE.settings.waMode = SKYPE.settings.waMode || "production"; /* live */

SKYPE.wanalytics.Core = (function () {
  
  var page_url = location.href,

  /* remove empty elements from Array */
  removeEmpties = function (arr)
  {
    return SKYPE.wanalytics.Core.myfilter(arr, function (a) { 
      return !(a.match(/^$/));
    });
  },
  
  /* Expects string */
  transformPath = function (path, joinfunc) 
  {
    if (typeof path !== "string") {
      throw new TypeError();
    }
    
    var r_path = removeEmpties(path.split("/")),
    result = "";
    
    /* cleans the: http: & www.skype.com/ */
    if (path.match(/http:/))
    {
      r_path.shift();
      r_path.shift();
    }
    
    /* cleans the intl/en */
    if (path.match(/intl/))
    {
      r_path.shift();
      r_path.shift();
    }
    
    return joinfunc(r_path); 
  },

  isGoogleAnalyticsAvailable = function ()
  {
    return (typeof pageTracker !== "undefined");
  },
  
  isOmnitureAvailable = function ()
  {
    return (typeof s_gi !== "undefined");
  };
  
  return {
    
  /* As we have to support js 1.5, defining my own filter */
    myfilter: function (arr, fun)
    {
      var res = [],
      i = 0,
      val;
      
      if (typeof fun !== "function") {
        throw new TypeError();
      }
      
      for (i = 0; i < arr.length; i = i + 1)
      {
        if (i in arr)  { /* boundary check */
          val = arr[i]; /* in case fun mutates this */
          if (fun(val)) {
            res.push(val);
          }
        }
      }  
      return res;
    },
    
    getPageName: function (path)
    {
      return transformPath(path, function (c_path) {
        var pname = c_path.join("/");
      
        /* if is without html and without php, then add a forward slash */
        if ((pname.indexOf(".html") === -1) && 
            (pname.indexOf(".php")  === -1)) {
          pname += "/";                          
        }      
        return pname;
      });
    },
    
    getCategory: function (path)
    {      
      return transformPath(path, function (c_path) {
        var catg = c_path;
      
        /* filters out the html and php endings*/
        catg = SKYPE.wanalytics.Core.myfilter(c_path, function (a) { 
          return !(a.match(/.html$|.php$/));
        });

        return (catg.join(",").replace(/-/g, ""));
      });            
    },
    
    /* 
       Returns if we are in live or in development      
    */
    getEnviroment: function ()
    {
      /* 1) custom, js var: sc_custom_enviroment */
      if (typeof sc_custom_enviroment !== "undefined" && 
                 sc_custom_enviroment !== "") {
        return sc_custom_enviroment;                              
      }
      
      return SKYPE.settings.waMode;
    },

    /* Returns Users Localization, allows for 2 sources, 
       by order, stops of first matching one:
       1) custom, js var: sc_custom_local
       2) extracts from path, location.pathname, expecting /intl/xx
    */
    getLocalization: function (path)
    {
      /* 1) custom, js var: sc_custom_local */
      if (typeof sc_custom_local !== "undefined" && 
          sc_custom_local !== "") {
        return sc_custom_local;                              
      }

      /* 2) extracts from path, location.pathname, expecting /intl/xx */
      if (typeof path !== "string") {
        throw new TypeError();
      }

      var p_local = "";
      
      /* Figure out the language */
      p_local = path.replace(/^\/intl\/([^\-\/]+)-?([^\/]*)\/.*/, "$1$2");
      
      if (!p_local.length || p_local.search(/[^a-z]/) !== -1) {
        p_local = "enus"; //if there's no intl assumes is US, made for static site.
      } 
     
      return p_local.toLowerCase();
    },
    
    /* Returns Users CountryCode, allows for 3 sources, 
       by order, of last:
       1) SKYPE.settings.geoIP, replacing SSI in static       
       2) custom js var: sc_custom_country
       3) location.search, with ?debug-country=([A-Z]+)
    */
    getCountry: function ()
    {
      var the_cc = SKYPE.settings.geoIP, /* SKYPE.settings.geoIP, replacing SSI in static */
          debug_cc;

      /* 2) custom js var: sc_custom_country */
      if (typeof sc_custom_country !== "undefined" && 
          sc_custom_country !== "") {
        the_cc = sc_custom_country;                              
      }

      /*  3) location.search, with ?debug-country=([A-Z]+) */
      if (location.search) {
        debug_cc = location.search.match(/debug-country=([A-Z]+)/);
        if (debug_cc) {
          the_cc = debug_cc[1];
        }
      }

      return the_cc;
    },
    
    /*******************
      MAIN TRACKING API: 
     ********************/

    /*****************
     * Tracking Pages
     *****************/
    /* optionsfunc is the optional function invoked just before reporting*/
    trackPageOmniture: function (pagename, category, optionsfunc)
    {     
      /* check if omniture tracking is available */
      if (!isOmnitureAvailable()) {
        throw new ReferenceError();
      }
      
      /*REQ1.7. Pass URL without domain as the page name, 
        prefixed by the application and forward slash. */
      /* does not allows empty pagename */
      if (typeof pagename === "string" && pagename !== "") {
        s.pageName = pagename;
      }
      else { /* raises error */
        throw new TypeError();
      }
      s.pageName = s.pageName.replace(/\/\/+/g, "/"); /*Clean out multiple /'s */

      /* REQ1.3. Pass on hierarchy (s.hier1) data with the URL 
         path where directories are separated by commas and the 
         entire string prefixed by the application name and comma. */
      /* allows empty category */
      if (typeof category === "string") {
        s.hier1 = category;
      } 
      else { /* raises error */
        throw new TypeError();

      }
      s.hier1 = s.hier1.replace(/,$/, ""); /* Clean out last ',' */

      /* REQ1.9, language */
      s.eVar5 = s.prop5 = SKYPE.wanalytics.Core.getLocalization(location.pathname);
      
      /* executes the function of the option */
      if (typeof optionsfunc === "function") {
        optionsfunc();
      }

      /* Aborts if it looks wrong, if finds a "native code" */
      if (s.pageName.indexOf("[native code]") !== -1) { 
        return false; 
      }
      
      /**** DO NOT ALTER ANYTHING BELOW THIS LINE ! ****/
      var s_code = s.t();
    
      return true;
    },

    /* page report, allows to specify the pagename and category */
    trackPageSC: function (site, pagename, category, optionsfunc)
    {
      if (typeof site     !== "string" || 
          typeof pagename !== "string" ||
          typeof category !== "string") {
        throw new TypeError();
      }

      /* Obtains them from util methods */
      var scpagename = pagename || SKYPE.wanalytics.Core.getPageName(location.pathname),
          sccategory = category || SKYPE.wanalytics.Core.getCategory(location.pathname);

      s.channel = site;

      return SKYPE.wanalytics.Core
        .trackPageOmniture(site + "/" + scpagename, 
                           site + "," + sccategory,
                           optionsfunc);
    },

    /* page report, the simplest form */
    trackPage: function (site, optionsfunc)
    {
      if (typeof site !== "string") {
        throw new TypeError();
      }

      return SKYPE.wanalytics.Core
        .trackPageSC(site, "", "", optionsfunc);
    },

    /* error page report, in sc format, staying here for legacy compatibility*/
    trackErrorPageSC: function (site, pagename, errorname, optionsfunc) 
    {
      return SKYPE.wanalytics.Core
        .trackErrorPage(site, "", errorname, optionsfunc);
    },

    /* error page report, simplest form */
    trackErrorPage: function (site, errorname, optionsfunc) 
    {
      if (typeof site      !== "string" ||        
          typeof errorname !== "string") {
        throw new TypeError();
      }

      /* gets pageName from utils */
      var scpagename = SKYPE.wanalytics.Core.getPageName(location.pathname);

      /* REQ3.1 - Error Pages */
      /* REQ3.2. Page name may not be passed for 404 errors. */       
      s.pageType = "errorPage";
      s.channel  = site;
      
      return SKYPE.wanalytics.Core
        .trackPageOmniture(errorname + ": " + site + "/" + scpagename, "", optionsfunc);
    },

    /******************
     * Tracking Events
     ******************/
    /* Legacy method, use trackAction instead */
    trackEvent: function (event, category, optionsfunc)
    {
      return SKYPE.wanalytics.Core.trackAction(event, optionsfunc);
    },

    trackAction: function (event, optionsfunc)
    {
      /* check if omniture tracking is available */
      if (!isOmnitureAvailable()) {
        throw new ReferenceError();
      }

      /* check arguments */
      if (typeof event !== "string" || event === "") {
        throw new TypeError();
      }
             
      /* executes the options function */
      if (typeof optionsfunc === "function") {
        optionsfunc();
      }

      /* following vars have to be populated */
      if ((typeof s.linkTrackVars   === "undefined") || s.linkTrackVars   === "" ||
          (typeof s.linkTrackEvents === "undefined") || s.linkTrackEvents === "") {
        return false;
      }

      /* report */
      s.tl(this, 'o', event);

      /* clean up */
      s.linkTrackVars   = "None";
      s.linkTrackEvents = "None"; 
      s.events          = "";
      s.products        = "";

      return true;
    },

    /* Track Action Value, default way to record values */
    trackActionValue: function (site, action, value, optionsfunc)
    {

      /* check arguments */
      if (typeof site   !== "string" || site   === "" || 
          typeof action !== "string" || action === "" ||
          typeof value  !== "string" || value  === "") {
        throw new TypeError();
      }
      
      return SKYPE.wanalytics.Core
        .trackAction(site + "/" + action, function () {
          s.linkTrackVars     = "prop18,eVar19";
          s.linkTrackEvents   = "None"; 
          s.prop18 = s.eVar19 = site + ":" + action + ":" + value;
        });      
    }   
  };
}());
