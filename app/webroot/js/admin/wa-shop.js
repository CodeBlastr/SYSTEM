/*global SKYPE, pageTracker, s_gi, sc_custom_local, s, s_account, gotErrorPage, shopProductName, shopCategoryName, hex_sha1*/
/*jslint bitwise: true, browser: true, eqeqeq: true, immed: true, newcap: true, nomen: true, onevar: true, plusplus: true, white: true, widget: true, undef: true, indent: 2*/

/* Init SKYPE.wanalytics namespace */
if (typeof SKYPE.wanalytics === "undefined" || !SKYPE.account) {
  SKYPE.namespace("wanalytics");
}

SKYPE.wanalytics.Shop = (function () {

  var W = SKYPE.wanalytics.Core,
      TID = "",

  readCookie = function (name) {
    var nameEQ  = name + "=",
    ca          = document.cookie.split(';'),
    i, c;
    
    for (i = 0; i < ca.length; i = i + 1) {
      c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1, c.length);
      }
      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length, c.length);
      }
    }
    return null;
  },

  /* Should be an trackEvent, instead */
  hashedTID = function ()
  {
    var tmstamp = (new Date()).getTime().toString(),
        vid = readCookie("s_vi");
        
    return ((typeof hex_sha1 !== "undefined") ? hex_sha1(tmstamp + vid) : "");
  };
  
  return {
    
    reportAction: function (action, detail)
    {
      return W.trackAction(action, function () {
        s.linkTrackVars   = "prop17"; 
        s.linkTrackEvents = "None"; 
        s.prop17          = detail;
      });
    },

    reportBuyLnk: function ()
    {
      return W.trackAction("buy", function () {
        s.linkTrackVars   = "events,products,transactionID"; 
        s.linkTrackEvents = "event18";
        s.events          = "event18";
        s.products        = shopCategoryName + ";" + shopProductName;
        s.transactionID   = TID;
      });
    },
    
    getTID: function ()
    {
      return TID;
    },

    /* Page Report */               
    report: function ()
    {
        if ((typeof gotErrorPage !== "undefined") && (gotErrorPage !== ""))
        {
          W.trackErrorPageSC("shop.hw", W.getPageName(location.pathname), gotErrorPage);
        }
        else 
        {         
          W.trackPageSC("shop.hw", W.getPageName(location.pathname), 
                        W.getCategory(location.pathname), function () {

            /* if product page, make a productView */
            if ((typeof shopProductName !== "undefined") && (shopProductName !== "") &&
              (typeof shopCategoryName !== "undefined") && (shopCategoryName !== ""))
            {
              s.events = "prodView";
              s.products = shopCategoryName + ";" + shopProductName;

              /* Creates a new TID */
              TID = hashedTID();
            }       
          });
        }
      }
  };
}());

SKYPE.wanalytics.Shop.report();
