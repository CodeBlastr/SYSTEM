SKYPE.util.ConditionalContent = function()
{
    var E = YAHOO.util.Event;
    var D = YAHOO.util.Dom;
    
    var alts;
    
    E.onDOMReady(function()
    {
        // Get all alternative content blocks
        alts = D.getElementsByClassName("alternative", "DIV", document.body, function()
        {
            // Hide if it's not default block
            D.setStyle(this, "display", (D.hasClass(this, "cond-default") ? "block" : "none"));
        });
    });
    
    var filters = {
        "30days": function()
        {
            var age = SKYPE.util.ClientDetection.getSkypeUserAge();
            if (age >= 1 && age <= 30)
            {
                return D.getElementsByClassName("cond-30days", "DIV");
            }
            return [];
        }
        ,"existing": function()
        {
            var installed = SKYPE.util.ClientDetection.isInstalled();
            if (installed)
            {
                return D.getElementsByClassName("cond-existing", "DIV");
            }
            return [];
        }
    };
    
    _getFiltered = function()
    {
        var result = [];
        var tmp;
        for (filter in filters)
        {
            tmp = filters[filter]();
            //SKYPE.log("Running conditionals filter "+filter+" found "+tmp.length+" items");
            result = result.concat(tmp);
            if (result.length) break;
        }
        return result;
    };
    
    return {
        run: function()
        {
            SKYPE.util.ConditionalContent.cookify();
            SKYPE.util.ConditionalContent.switchAlternatives();
            SKYPE.util.ConditionalContent.toggleUsername();
//SKYPE.util.ConditionalContent.checkAbandonedDownload();
            //SKYPE.util.ConditionalContent.switchPages();
        }

,checkAbandonedDownload: function()
{
//SKYPE.log("check abandon install")
var installed = SKYPE.util.ClientDetection.isInstalled();
            var abandonInstall = SKYPE.util.ClientDetection.isAbandonedInstall();
var root = this._getRoot();
            
if (!installed && location.pathname == root && abandonInstall)
{
        location.href = root + "completedownload/";
}
}


,_getRoot: function() 
{
    var root = "";
            // Top root / or /intl/xx/ root
            var rootRE = /^(\/|\/intl\/[^\/]+\/)(useskype\/)?$/;
            
            // Check if we are on root page
            var result = location.pathname.match(rootRE);
            if (result)
            {
                root = result[1];
            }
return root;
}

,cookify: function()
{
            var installed = SKYPE.util.ClientDetection.isInstalled();
            var age = SKYPE.util.ClientDetection.getSkypeUserAge();
            
            // Set the profile value in SC cookie
            var modTime = SKYPE.user.Preferences.getTimeModified();
            
            // SKYPE.log("Checking if should cookify user, installed: "+installed+", modtime: "+modTime);

            if (installed)
            {
                var modify = false;
                // 24 hours delay is for new user check
                if (isNaN(modTime) || modTime < (new Date()).getTime() / 1000 - 60*60*24)
                {
                    SKYPE.log("Modification time is more than a day ago, checking profile");
                    if (age > 30)
                    {
                        SKYPE.log("Setting cookie profile to: existing");
                        SKYPE.user.Preferences.setClientProfile("existing");
                    }
                    else
                    {
                        SKYPE.log("Setting cookie profile to: 30days");
                        SKYPE.user.Preferences.setClientProfile("30days");
                    }
                    modify = true;
                }

                // Check wether client version has been updated
                var skypeVer = SKYPE.util.ClientDetection.getPlatformID()+"/"+SKYPE.util.ClientDetection.getVersion()+"/";
                
                // Ignore when source=installer etc is on URL
                if (skypeVer != SKYPE.user.Preferences.getVersion() && location.search.indexOf("source=") == -1) {
                    SKYPE.log("Setting installed version to "+skypeVer);
                    SKYPE.user.Preferences.setVersion(skypeVer);
                    modify = true;
                }

                // Only update cookie if needed
                if (modify) {
                    SKYPE.log("Updating cookie with client profile info");
                    SKYPE.user.Preferences.save();
                }
            }
        }
        
        ,switchPages: function()
        {
            // 
            // if landing on root
            //  - send to useskype if known user
            // 
            // if landing on useskype
            //  - send to completedownload if known download abandoner
            //  - send to newtoskype if seems totally new
            //  - send to welcomeback if returning user age > 30 days
            //  - leave on useskype if known and age < 30 days
            // 

            var installed = SKYPE.util.ClientDetection.isInstalled();
            var age = SKYPE.util.ClientDetection.getSkypeUserAge();
            var root = this._getRoot();
            
            // known user on front page
            if (installed && location.pathname == root)
            {
                // returning user age > 30 days
                if (age > 30)
                {
                    location.href = root+"welcomeback/";
                }
                else
                {
                    location.href = root+"welcomeback/";
                }
            }
            else if (location.pathname == root+"useskype/")
            {
                // seems totally new
                if (!installed)
                {
                    location.href = root+"welcomeback/";
                }
                // returning user age > 30 days
                else if (installed && age > 30)
                {
                    location.href = root+"welcomeback/";
                }
                // known and age < 30 days
                else if (installed && age < 30)
                {
                    SKYPE.log("Leave on existing page");
                }
                // known download abandoner
                // TODO: add completedownload check with other SO data
            }
        }
        
        ,switchAlternatives: function()
        {
            //SKYPE.log("Switching alternative content blocks");
            
            var enableAlts = _getFiltered();
            if (enableAlts.length)
            {
                D.setStyle(enableAlts, "display", "block");
                SKYPE.util.ConditionalContent.hideDefaults();
            }
            else
            {
                SKYPE.util.ConditionalContent.showDefaults();
            }
        }
        ,showDefaults: function()
        {
            D.getElementsByClassName("cond-default", "DIV", document.body, function()
            {
                D.setStyle(this, "display", "block");
            });
        }
        ,hideDefaults: function()
        {
            D.getElementsByClassName("cond-default", "DIV", document.body, function()
            {
                D.setStyle(this, "display", "none");
            });
        }
        
        ,toggleUsername: function()
        {
            if (typeof SKYPE.util.ClientDetection == "undefined"
                || typeof SKYPE.util.ClientDetection.getSessionUsername == "undefined")
            {
                return;
            }
            var username = SKYPE.util.ClientDetection.getSessionUsername();
            
            if (!username.length) return;
            
            if (D.get("loggedin-username")) D.get("loggedin-username").innerHTML = username.replace(/[<>]/, "");
            
            if (D.get("loggedin-welcome")) D.setStyle(D.get("loggedin-welcome"), "display", "inline");
            if (D.get("loggedin-links")) D.setStyle(D.get("loggedin-links"), "display", "inline");
            if (D.get("loggedin-signout")) D.setStyle(D.get("loggedin-signout"), "display", "inline");
            if (D.get("loggedin-signin")) D.setStyle(D.get("loggedin-signin"), "display", "none");
            if (D.get("loggedin-haveskype")) D.setStyle(D.get("loggedin-haveskype"), "display", "none");
            if (D.get("main-menu-account")) D.setStyle(D.get("main-menu-account"), "display", "inline");
        }
    };
}();

if (typeof SKYPE.util.ClientDetection != "undefined")
{
    SKYPE.util.ClientDetection.subscribe(
        SKYPE.util.ConditionalContent.run
        ,{}
        ,false
        ,function() {SKYPE.log('client detection failure'); }
    );
}