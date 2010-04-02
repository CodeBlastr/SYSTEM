/*
        DatePicker v4.5 by frequency-decoder.com

        Released under a creative commons Attribution-ShareAlike 2.5 license (http://creativecommons.org/licenses/by-sa/2.5/)

        Please credit frequency-decoder in any derivative work - thanks.
        
        You are free:

        * to copy, distribute, display, and perform the work
        * to make derivative works
        * to make commercial use of the work

        Under the following conditions:

                by Attribution.
                --------------
                You must attribute the work in the manner specified by the author or licensor.

                sa
                --
                Share Alike. If you alter, transform, or build upon this work, you may distribute the resulting work only under a license identical to this one.

        * For any reuse or distribution, you must make clear to others the license terms of this work.
        * Any of these conditions can be waived if you get permission from the copyright holder.
*/

var datePickerController = (function datePickerController() {
        var languageInfo        = parseNavigatorLanguage(),
            datePickers         = {},
            uniqueId            = 0,
            weeksInYearCache    = {},
            localeImport        = false,
            nbsp                = String.fromCharCode(160),
            nodrag              = false,            
            buttonTabIndex      = true,
            returnLocaleDate    = false,  
            splitAppend         = ["-dd","-mm"],
            cellFormat          = "d-sp-F-sp-Y",
            titleFormat         = "F-sp-d-cc-sp-Y",
            formatParts         = ["placeholder", "sp-F-sp-Y"],
            formatMasks         = ["Y-sl-m-sl-d","m-sl-d-sl-Y","d-sl-m-sl-Y","Y-ds-m-ds-d","m-ds-d-ds-Y","d-ds-m-ds-Y","d-ds-m-ds-y","d-sl-m-sl-y"],                
            localeDefaults      = {
                fullMonths:["January","February","March","April","May","June","July","August","September","October","November","December"],
                monthAbbrs:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                fullDays:  ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                dayAbbrs:  ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
                titles:    ["Previous month","Next month","Previous year","Next year", "Today", "Show Calendar", "wk", "Week [[%0%]] of [[%1%]]", "Week", "Select a date", "Click \u0026 Drag to move", "Display \u201C[[%0%]]\u201D first", "Go to Today\u2019s date", "Disabled date"],
                firstDayOfWeek:0,
                imported:  false
            }; 
               
        void function() {
                var scriptFiles = document.getElementsByTagName('head')[0].getElementsByTagName('script'),                    
                    scriptInner = scriptFiles[scriptFiles.length - 1].innerHTML.replace(/[\n\r\s\t]+/g, " ").replace(/^\s+/, "").replace(/\s+$/, ""),                    
                    json        = parseJSON(scriptInner);                
               
                if(typeof json === "object" && !("err" in json)) {                          
                        affectJSON(json);
                };
       
                if(typeof(fdLocale) != "object") {
                        var loc    = scriptFiles[scriptFiles.length - 1].src.substr(0, scriptFiles[scriptFiles.length - 1].src.lastIndexOf("/")) + "/lang/",
                            script;
                        
                        for(var i = 0; i < languageInfo.length; i++) {                                 
                                script = document.createElement('script');                                               
                                script.type = "text/javascript";                         
                                script.src  = loc + languageInfo[i] + ".js";                                                                 
                                script.setAttribute("charset", "utf-8");
                                /*@cc_on
                                /*@if(@_win32)
                                var bases = document.getElementsByTagName('base');
                                if (bases.length && bases[0].childNodes.length) {
                                        bases[0].appendChild(script);
                                } else {
                                        document.getElementsByTagName('head')[0].appendChild(script);
                                };
                                bases = null;
                                @else @*/
                                document.getElementsByTagName('head')[0].appendChild(script);
                                /*@end
                                @*/    
                        };
                        script = null;                      
                } else {
                        returnLocaleDate = true;
                };   
                                      
        }();
        
        function parseNavigatorLanguage() {
                var languageTag = navigator.language ? navigator.language.toLowerCase() : navigator.userLanguage ? navigator.userLanguage.toLowerCase() : "en";                     
                
                if(languageTag.search(/^([a-z]{2})-([a-z]{2})$/) != -1) {                        
                        return  [languageTag.match(/^([a-z]{2})-([a-z]{2})$/)[1], languageTag];                         
                } else {
                        return [languageTag.substr(0,2)];
                };         
        };
        
        function affectJSON(json) {
                if(typeof json !== "object") { return; };
                for(key in json) {
                        value = json[key];                                                                
                        switch(key.toLowerCase()) { 
                                case "lang":
                                        if(value.search(/^[a-z]{2}(-([a-z]{2}))?$/i) != -1) {                                                
                                                languageInfo = [value.toLowerCase()];                                                   
                                                returnLocaleDate = true;
                                        };
                                        break;
                                case "split":                                                 
                                        if(typeof value === 'object') {
                                                if(value.length && value.length == 2) {                                                        
                                                        splitAppend = value;                                                        
                                                };
                                        };
                                        break; 
                                case "formats":                                                 
                                        if(typeof value === 'object') {
                                                if(value.length) {
                                                        var tmpMasks = [];
                                                        for(var m = 0, msk; msk = value[m]; m++) {
                                                                if(msk.match(/((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p]))(-((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p])))+/)) {
                                                                        tmpMasks.push(msk);
                                                                };
                                                        };
                                                        if(tmpMasks.length) { formatMasks = tmpMasks; };
                                                };
                                        };
                                        break;
                                case "nodrag":
                                        nodrag = !!value;
                                        break;                                
                                case "buttontabindex":
                                        buttonTabIndex = !!value;
                                        break;  
                                case "cellformat":
                                        if(typeof value == "string" && value.match(/^((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p]))(-((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p])))+$/)) {
                                                parseCellFormat(value);
                                        };
                                        break;
                                case "titleformat":
                                        if(value.match(/((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p]))(-((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p])))+/)) {
                                                titleFormat = value;
                                        };                                                                                                                                                
                        };          
                };        
        };                  
        
        function parseCellFormat(value) {                  
                // I'm sure this could be done with a regExp and a split in one line... seriously...
                var parts       = value.split("-"),
                    fullParts   = [],
                    tmpParts    = [],
                    part;                              
                
                for(var pt = 0; pt < parts.length; pt++) {
                        part = parts[pt];                         
                        if(part == "j" || part == "d") { 
                                if(tmpParts.length) {
                                        fullParts.push(tmpParts.join("-")); 
                                        tmpParts = [];
                                };
                                fullParts.push("placeholder");   
                        } else { 
                                tmpParts.push(part);
                        };                                             
                };                  
                
                if(tmpParts.length) {
                        fullParts.push(tmpParts.join("-"));                                         
                };
                
                if(!fullParts.length || fullParts.length > 3) {
                        formatParts = window.opera ? ["placeholder"] : ["placeholder", "sp-F-sp-Y"];
                        cellFormat = "j-sp-F-sp-Y"; 
                        return;
                };
                
                // Don't use hidden text for opera due to focus outline problems
                formatParts = window.opera ? ["placeholder"] : fullParts;
                cellFormat  = window.opera ? "j-sp-F-sp-Y" : value;               
        };
         
        function pad(value, length) { 
                length = length || 2; 
                return "0000".substr(0,length - Math.min(String(value).length, length)) + value; 
        };
        
        function addEvent(obj, type, fn) { 
                try {                 
                if( obj.attachEvent ) {
                        obj["e"+type+fn] = fn;
                        obj[type+fn] = function(){obj["e"+type+fn]( window.event );};
                        obj.attachEvent( "on"+type, obj[type+fn] );
                } else {
                        obj.addEventListener( type, fn, true );
                };
                } catch(err) {
                        alert(obj + " " + type + " " + fn)
                }
        };
        
        function removeEvent(obj, type, fn) {
                try {
                        if( obj.detachEvent ) {
                                obj.detachEvent( "on"+type, obj[type+fn] );
                                obj[type+fn] = null;
                        } else {
                                obj.removeEventListener( type, fn, true );
                        };
                } catch(err) {};
        };   

        function stopEvent(e) {
                e = e || document.parentWindow.event;
                if(e.stopPropagation) {
                        e.stopPropagation();
                        e.preventDefault();
                };
                /*@cc_on
                @if(@_win32)
                e.cancelBubble = true;
                e.returnValue = false;
                @end
                @*/
                return false;
        };
        
        function parseJSON(str) {
                // Check we have a String
                if(typeof str !== 'string' || str == "") { return {}; };                 
                try {
                        // Does a JSON (native or not) Object exist                              
                        if(typeof JSON === "object" && JSON.parse) {                                              
                                return window.JSON.parse(str);  
                        // Genious code taken from: http://kentbrewster.com/badges/                                                      
                        } else if(/lang|split|formats|nodrag/.test(str.toLowerCase())) {                                               
                                var f = Function(['var document,top,self,window,parent,Number,Date,Object,Function,',
                                        'Array,String,Math,RegExp,Image,ActiveXObject;',
                                        'return (' , str.replace(/<\!--.+-->/gim,'').replace(/\bfunction\b/g,'function?') , ');'].join(''));
                                return f();                          
                        };
                } catch (e) { };
                return {"err":"Trouble parsing JSON object"};                                            
        };        

        function setARIARole(element, role) {
                if(element && element.tagName) {
                        element.setAttribute("role", role);
                };
        };
        
        function setARIAProperty(element, property, value) {
		if(element && element.tagName) {
                        element.setAttribute("aria-" + property, value);
                };	
	};

        // The datePicker object itself 
        function datePicker(options) {                                      
                this.dateSet             = null;                 
                this.timerSet            = false;
                this.visible             = false;
                this.fadeTimer           = null;
                this.timer               = null;
                this.yearInc             = 0;
                this.monthInc            = 0;
                this.dayInc              = 0;
                this.mx                  = 0;
                this.my                  = 0;
                this.x                   = 0;
                this.y                   = 0; 
                this.cursorDate          = options.cursorDate ? options.cursorDate : "",       
                this.date                = "cursorDate" in options && options.cursorDate ? new Date(+options.cursorDate.substr(0,4), +options.cursorDate.substr(4,2) - 1, +options.cursorDate.substr(6,2)) : new Date();
                this.defaults            = {};
                this.created             = false;
                this.disabled            = false;
                this.id                  = options.id;
                this.opacity             = 0;          
                this.firstDayOfWeek      = localeImport.firstDayOfWeek; 
                this.buttonWrapper       = "buttonWrapper" in options ? options.buttonWrapper : false;                
                this.staticPos           = "staticPos" in options ? !!options.staticPos : false;
                this.disabledDays        = "disabledDays" in options && options.disabledDays.length ? options.disabledDays : [0,0,0,0,0,0,0];
                this.disabledDates       = "disabledDates" in options ? options.disabledDates : {};
                this.enabledDates        = "enabledDates" in options ? options.enabledDates : {};
                this.showWeeks           = "showWeeks" in options ? !!options.showWeeks : false;
                this.low                 = options.low || "";
                this.high                = options.high || "";
                this.dragDisabled        = nodrag ? true : ("dragDisabled" in options ? !!options.dragDisabled : false);
                this.positioned          = "positioned" in options ? options.positioned : false;
                this.hideInput           = this.staticPos ? false : "hideInput" in options ? !!options.hideInput : false;
                this.splitDate           = "splitDate" in options ? !!options.splitDate : false;
                this.format              = options.format || "d-sl-m-sl-Y";
                this.statusFormat        = options.statusFormat || "";                                
                this.highlightDays       = options.highlightDays && options.highlightDays.length ? options.highlightDays : [0,0,0,0,0,1,1];
                this.noFadeEffect        = "noFadeEffect" in options ? !!options.noFadeEffect : false;
                this.opacityTo           = this.noFadeEffect || this.staticPos ? 99 : 90;
                this.callbacks           = {};
                this.fillGrid            = !!options.fillGrid;
                this.noToday             = !!options.noToday;
                this.labelledBy          = findLabelForElement(document.getElementById(options.id));
                this.constrainSelection  = this.fillGrid && !!options.constrainSelection;
                this.finalOpacity        = !this.staticPos && "finalOpacity" in options ? +options.finalOpacity : 90;                
                this.dynDisabledDates    = {};
                this.inUpdate            = false;                
                this.noFocus             = true;
                this.kbEventsAdded       = false;
                this.fullCreate          = false;
                this.selectedTD          = null;
                this.cursorTD            = null;
                this.addSpans            = this.staticPos;
                this.spansAdded          = false;
                
                /*@cc_on
                @if(@_win32)
                this.interval            = new Date();
                this.iePopUp             = null;
                this.isIE7               = false;                 
                @end
                @*/
                
                /*@cc_on
                @if(@_jscript_version <= 5.7)
                this.isIE7               = document.documentElement && typeof document.documentElement.style.maxHeight != "undefined";
                @end
                @*/
                
                for(var thing in options.callbacks) {
                        this.callbacks[thing] = options.callbacks[thing];                 
                };
                
                // Adjust time to stop daylight savings madness on windows
                this.date.setHours(12);              
                
                this.changeHandler = function() {                        
                        o.setDateFromInput();                        
                        if(o.created) { o.updateTable(); };
                };
                this.getScrollOffsets = function() {                         
                        if(typeof(window.pageYOffset) == 'number') {
                                //Netscape compliant
                                return [window.pageXOffset, window.pageYOffset];                                
                        } else if(document.body && (document.body.scrollLeft || document.body.scrollTop)) {
                                //DOM compliant
                                return [document.body.scrollLeft, document.body.scrollTop];                                
                        } else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
                                //IE6 standards compliant mode
                                return [document.documentElement.scrollLeft, document.documentElement.scrollTop];
                        };
                        return [0,0];
                };
                this.reposition = function() {
                        if(!o.created || !o.getElem() || o.staticPos) { return; };

                        o.div.style.visibility = "hidden";
                        o.div.style.left = o.div.style.top = "0px";                           
                        o.div.style.display = "block";

                        var osh         = o.div.offsetHeight,
                            osw         = o.div.offsetWidth,
                            elem        = document.getElementById('fd-but-' + o.id),
                            pos         = o.truePosition(elem),
                            trueBody    = (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body,
                            sOffsets    = o.getScrollOffsets(),
                            scrollTop   = sOffsets[1], 
                            scrollLeft  = sOffsets[0]; 

                        o.div.style.visibility = "visible";

                        o.div.style.left  = Number(parseInt(trueBody.clientWidth+scrollLeft) < parseInt(osw+pos[0]) ? Math.abs(parseInt((trueBody.clientWidth+scrollLeft) - osw)) : pos[0]) + "px";
                        o.div.style.top   = Number(parseInt(trueBody.clientHeight+scrollTop) < parseInt(osh+pos[1]+elem.offsetHeight+2) ? Math.abs(parseInt(pos[1] - (osh + 2))) : Math.abs(parseInt(pos[1] + elem.offsetHeight + 2))) + "px";

                        /*@cc_on
                        @if(@_jscript_version <= 5.7)
                        if(o.isIE7) return;
                        o.iePopUp.style.top    = o.div.style.top;
                        o.iePopUp.style.left   = o.div.style.left;
                        o.iePopUp.style.width  = osw + "px";
                        o.iePopUp.style.height = (osh - 2) + "px";
                        @end
                        @*/
                };
                this.removeOldFocus = function() {
                        var td = document.getElementById(o.id + "-date-picker-hover");
                        if(td) {                                        
                                try { 
                                        td.setAttribute(!/*@cc_on!@*/false ? "tabIndex" : "tabindex", "-1");
                                        td.tabIndex = -1;                                          
                                        td.className = td.className.replace(/date-picker-hover/, "");                                         
                                        td.id = "";                                                                               
                                } catch(err) {};
                        };
                }; 
                this.setNewFocus = function() {                                                                      
                        var td = document.getElementById(o.id + "-date-picker-hover");
                        if(td) {
                                try {                                          
                                        td.setAttribute(!/*@cc_on!@*/false ? "tabIndex" : "tabindex", "0"); 
                                        td.tabIndex = 0;                                                                             
                                        td.className = td.className.replace(/date-picker-hover/, "") + " date-picker-hover";                                                                                                                                                              
                                        if(!this.noFocus) {                                                                                                   
                                                setTimeout(function() { try { td.focus(); } catch(err) {}; }, 0);
                                        };                                         
                                } catch(err) {};
                        };
                };
                this.updateTable = function(noCallback) {  
                        if(o.inUpdate) return;
                        
                        o.inUpdate = true;                        
                        o.removeOldFocus();
                                                               
                        if(o.timerSet) {
                                o.date.setDate(Math.min(o.date.getDate()+o.dayInc, daysInMonth(o.date.getMonth()+o.monthInc,o.date.getFullYear()+o.yearInc)) );
                                o.date.setMonth(o.date.getMonth() + o.monthInc);
                                o.date.setFullYear(o.date.getFullYear() + o.yearInc);
                        }; 
        
                        o.outOfRange();
                        if(!o.noToday) { o.disableTodayButton(); };
                        o.showHideButtons(o.date);
                
                        var cd = o.date.getDate(),
                            cm = o.date.getMonth(),
                            cy = o.date.getFullYear(),
                            cursorDate = (String(cy) + pad(cm+1) + pad(cd)),
                            tmpDate    = new Date(cy, cm, 1);                      
                
                        tmpDate.setHours(5);
                        
                        var dt, cName, td, i, currentDate, cellAdded, col, currentStub, abbr, bespokeRenderClass, spnC,
                        weekDayC            = ( tmpDate.getDay() + 6 ) % 7,                
                        firstColIndex       = (((weekDayC - o.firstDayOfWeek) + 7 ) % 7) - 1,
                        dpm                 = daysInMonth(cm, cy),
                        today               = new Date(),
                        dateSetD            = (o.dateSet != null) ? o.dateSet.getFullYear() + pad(o.dateSet.getMonth()+1) + pad(o.dateSet.getDate()) : false,
                        stub                = String(tmpDate.getFullYear()) + pad(tmpDate.getMonth()+1),
                        cellAdded           = [4,4,4,4,4,4],                                                                   
                        lm                  = new Date(cy, cm-1, 1),
                        nm                  = new Date(cy, cm+1, 1),                          
                        daySub              = daysInMonth(lm.getMonth(), lm.getFullYear()),                
                        stubN               = String(nm.getFullYear()) + pad(nm.getMonth()+1),
                        stubP               = String(lm.getFullYear()) + pad(lm.getMonth()+1),                
                        weekDayN            = (nm.getDay() + 6) % 7,
                        weekDayP            = (lm.getDay() + 6) % 7,                                       
                        today               = today.getFullYear() + pad(today.getMonth()+1) + pad(today.getDate()),
                        spn                 = document.createElement('span'),
                        enabledDates        = o.getEnabledDates(cy, cm + 1); 
                        
                        o.firstDateShown    = !o.constrainSelection && o.fillGrid && (0 - firstColIndex < 1) ? String(stubP) + (daySub + (0 - firstColIndex)) : stub + "01";            
                        o.lastDateShown     = !o.constrainSelection && o.fillGrid ? stubN + pad(41 - firstColIndex - dpm) : stub + String(dpm);
                        o.currentYYYYMM     = stub;                    
                
                        bespokeRenderClass  = o.callback("redraw", {id:o.id, dd:pad(cd), mm:pad(cm+1), yyyy:cy, firstDateDisplayed:o.firstDateShown, lastDateDisplayed:o.lastDateShown}) || {};                    
                        o.dynDisabledDates  = o.getDisabledDates(cy, cm + 1);                          
                        
                        spn.className       = "fd-screen-reader";
                        
                        if(this.selectedTD != null) {
                                setARIAProperty(this.selectedTD, "selected", false);
                                this.selectedTD = null;
                        };
                        
                        for(var curr = 0; curr < 42; curr++) {
                                row  = Math.floor(curr / 7);                         
                                td   = o.tds[curr];
                                spnC = spn.cloneNode(false); 
                                
                                while(td.firstChild) td.removeChild(td.firstChild);
                                
                                if((curr > firstColIndex && curr <= (firstColIndex + dpm)) || o.fillGrid) {
                                        currentStub     = stub;
                                        weekDay         = weekDayC;                                
                                        dt              = curr - firstColIndex;
                                        cName           = [];                                         
                                        selectable      = true;                                     
                                        
                                        if(dt < 1) {
                                                dt              = daySub + dt;
                                                currentStub     = stubP;
                                                weekDay         = weekDayP;                                        
                                                selectable      = !o.constrainSelection;
                                                cName.push("month-out");                                                  
                                        } else if(dt > dpm) {
                                                dt -= dpm;
                                                currentStub     = stubN;
                                                weekDay         = weekDayN;                                        
                                                selectable      = !o.constrainSelection; 
                                                cName.push("month-out");                                                                                           
                                        }; 
                                        
                                        weekDay = ( weekDay + dt + 6 ) % 7;
                                        cName.push("day-" + localeDefaults.dayAbbrs[weekDay].toLowerCase());
                                        
                                        currentDate = currentStub + String(dt < 10 ? "0" : "") + dt;                            
                                        
                                        if(o.low && +currentDate < +o.low || o.high && +currentDate > +o.high) {                                          
                                                td.className = "out-of-range";  
                                                td.title = ""; 
                                                td.appendChild(document.createTextNode(dt));                                             
                                                if(o.showWeeks) { cellAdded[row] = Math.min(cellAdded[row], 2); };                                                                                                                                               
                                        } else {                               
                                                if(selectable) {                                                                                                        
                                                        td.title = titleFormat ? printFormattedDate(new Date(+String(currentStub).substr(0,4), +String(currentStub).substr(4, 2) - 1, +dt), titleFormat, true) : "";                                                                                                      
                                                        cName.push("cd-" + currentDate + " yyyymm-" + currentStub + " mmdd-" + currentStub.substr(4,2) + pad(dt));
                                                } else {  
                                                        td.title = titleFormat ? getTitleTranslation(13) + " " + printFormattedDate(new Date(+String(currentStub).substr(0,4), +String(currentStub).substr(4, 2) - 1, +dt), titleFormat, true) : "";                                                                       
                                                        cName.push("yyyymm-" + currentStub + " mmdd-" + currentStub.substr(4,2) + pad(dt) + " not-selectable");
                                                };                                                                                                                                             
                                                
                                                if(currentDate == today) { cName.push("date-picker-today"); };

                                                if(dateSetD == currentDate) { 
                                                        cName.push("date-picker-selected-date"); 
                                                        setARIAProperty(td, "selected", "true");
                                                        this.selectedTD = td;
                                                };

                                                if((o.disabledDays[weekDay] && !(currentDate in enabledDates)) || currentDate in o.dynDisabledDates) { cName.push("day-disabled"); if(titleFormat && selectable) { td.title = getTitleTranslation(13) + " " + td.title; }; }
                                        
                                                if(currentDate in bespokeRenderClass) { cName.push(bespokeRenderClass[currentDate]); }
                                        
                                                if(o.highlightDays[weekDay]) { cName.push("date-picker-highlight"); };

                                                if(cursorDate == currentDate) { 
                                                        td.id = o.id + "-date-picker-hover";                                                         
                                                };                                         
                                                
                                                td.className = cName.join(" ");
                                                
                                                if(o.kbEventsAdded || o.addSpans) {
                                                        for(var pt = 0, part; part = formatParts[pt]; pt++) {
                                                                if(part == "placeholder") {
                                                                        td.appendChild(document.createTextNode(dt));
                                                                } else {
                                                                        spnC = spn.cloneNode(spn);
                                                                        spnC.appendChild(document.createTextNode(printFormattedDate(new Date(+String(currentStub).substr(0,4), +String(currentStub).substr(4, 2) - 1, +dt), part, true)));
                                                                        td.appendChild(spnC);
                                                                };                                                
                                                        };
                                                        
                                                } else {
                                                        td.appendChild(document.createTextNode(dt));
                                                };
                                                
                                                if(o.showWeeks) {                                                         
                                                        cellAdded[row] = Math.min(cName[0] == "month-out" ? 3 : 1, cellAdded[row]);                                                          
                                                }; 
                                        };                       
                                } else {
                                        td.className = "date-picker-unused";                                                                                                                    
                                        td.appendChild(document.createTextNode(nbsp));
                                        td.title = "";                                                                              
                                };                                                  
                                
                                if(o.showWeeks && curr - (row * 7) == 6) { 
                                        while(o.wkThs[row].firstChild) o.wkThs[row].removeChild(o.wkThs[row].firstChild);                                         
                                        o.wkThs[row].appendChild(document.createTextNode(cellAdded[row] == 4 && !o.fillGrid ? nbsp : getWeekNumber(cy, cm, curr - firstColIndex - 6)));
                                        o.wkThs[row].className = "date-picker-week-header" + (["",""," out-of-range"," month-out",""][cellAdded[row]]);                                          
                                };                                
                        };            
                
                        o.spansAdded = o.kbEventsAdded || o.addSpans;
                        var span = o.titleBar.getElementsByTagName("span");
                        while(span[0].firstChild) span[0].removeChild(span[0].firstChild);
                        while(span[1].firstChild) span[1].removeChild(span[1].firstChild);
                        span[0].appendChild(document.createTextNode(getMonthTranslation(cm, false) + nbsp));
                        span[1].appendChild(document.createTextNode(cy));
                        
                        if(o.timerSet) {
                                o.timerInc = 50 + Math.round(((o.timerInc - 50) / 1.8));
                                o.timer = window.setTimeout(o.updateTable, o.timerInc);
                        };
                        
                        o.inUpdate = false; 
                        o.setNewFocus();                         
                };
                
                this.show = function(autoFocus) {                         
                        if(this.staticPos) { return; };
                        
                        var elem = this.getElem();
                        if(!elem || (elem && elem.disabled)) { return; };   
                        
                        this.noFocus = true;   
                        if(!document.getElementById('fd-' + this.id)) {
                                this.created    = false;
                                this.fullCreate = false;                                                                                             
                                this.create();                                 
                                this.fullCreate = true;                                                            
                        } else {                                                        
                                this.setDateFromInput();                                                               
                                this.reposition();                                 
                        };                      
                        
                        this.noFocus = !!!autoFocus;                          
                        
                        if(this.noFocus) { 
                                addEvent(document, "mousedown", this.onmousedown); 
                        };                          
                        
                        this.updateTable();
                         
                        this.opacityTo = this.finalOpacity;
                        this.div.style.display = "block";                        
                                                        
                        /*@cc_on
                        @if(@_jscript_version <= 5.7)
                        
                        if(!o.isIE7) {
                                this.iePopUp.style.width = this.div.offsetWidth + "px";
                                this.iePopUp.style.height = this.div.offsetHeight + "px";
                                this.iePopUp.style.display = "block";
                        };
                        
                        @end
                        @*/                               
                        
                        this.setNewFocus(); 
                        this.fade();
                        var butt = document.getElementById('fd-but-' + this.id);
                        if(butt) { butt.className = butt.className.replace("dp-button-active", "") + " dp-button-active"; };                                                
                };
                this.hide = function() {                        
                        if(!this.visible || !this.created || !document.getElementById('fd-' + this.id)) return;
                        
                        this.stopTimer();
                        this.removeFocusEvents();
                        
                        if(this.staticPos) { return; };

                        var butt = document.getElementById('fd-but-' + this.id);
                        if(butt) butt.className = butt.className.replace("dp-button-active", "");
                
                        removeEvent(document, "mousedown", this.onmousedown);
                        
                        /*@cc_on
                        @if(@_jscript_version <= 5.7)
                        if(!this.isIE7) { this.iePopUp.style.display = "none"; };
                        @end
                        @*/

                        this.opacityTo = 0;
                        this.fade();                          
                        
                        // Programmatically remove the focus style on the calendar         
                        this.div.className = this.div.className.replace("datepicker-focus", "");                      
                                                                
                        // Update status bar                                
                        if(this.statusBar) { this.updateStatus(getTitleTranslation(9)); };                                            
                };
                this.destroy = function() {
                        
                        if(document.getElementById("fd-but-" + this.id)) {
                                document.getElementById("fd-but-" + this.id).parentNode.removeChild(document.getElementById("fd-but-" + this.id));        
                        };
                        
                        if(!this.created) { return; };
                        
                        // Cleanup for Internet Explorer
                        removeEvent(this.table, "mousedown", o.onmousedown);  
                        removeEvent(this.table, "mouseover", o.onmouseover);
                        removeEvent(this.table, "mouseout", o.onmouseout);
                        removeEvent(document, "mousedown", o.onmousedown);
                        removeEvent(document, "mouseup",   o.clearTimer);
                        o.removeFocusEvents();
                        clearTimeout(o.fadeTimer);
                        clearTimeout(o.timer);

                        /*@cc_on
                        @if(@_jscript_version <= 5.7)                         
                        if(!o.staticPos && !o.isIE7) {
                                try {
                                        o.iePopUp.parentNode.removeChild(o.iePopUp);
                                        o.iePopUp = null;
                                } catch(err) {};
                        };
                        @end
                        @*/                         

                        if(this.div && this.div.parentNode) {
                                this.div.parentNode.removeChild(this.div);
                        };
                                                 
                        o = null;
                };
                this.resizeInlineDiv = function()  {                        
                        o.div.style.width = o.table.offsetWidth + "px";
                        o.div.style.height = o.table.offsetHeight + "px";
                };
                this.create = function() {
                        if(this.created) { return; };

                        this.noFocus = true; 
                        
                        function createTH(details) {
                                var th = document.createElement('th');
                                if(details.thClassName) th.className = details.thClassName;
                                if(details.colspan) {
                                        /*@cc_on
                                        /*@if (@_win32)
                                        th.setAttribute('colSpan',details.colspan);
                                        @else @*/
                                        th.setAttribute('colspan',details.colspan);
                                        /*@end
                                        @*/
                                };
                                /*@cc_on
                                /*@if (@_win32)
                                th.unselectable = "on";
                                /*@end@*/
                                return th;
                        };
                        function createThAndButton(tr, obj) {
                                for(var i = 0, details; details = obj[i]; i++) {
                                        var th = createTH(details);
                                        tr.appendChild(th);
                                        var but = document.createElement('span');
                                        but.className = details.className;
                                        but.id = o.id + details.id;
                                        but.appendChild(document.createTextNode(details.text || o.nbsp));
                                        but.title = details.title || "";                                          
                                        /*@cc_on
                                        /*@if(@_win32)
                                        th.unselectable = but.unselectable = "on";
                                        /*@end@*/
                                        th.appendChild(but);
                                };
                        };  
                        
                        this.div                     = document.createElement('div');
                        this.div.id                  = "fd-" + this.id;
                        this.div.className           = "datePicker";  
                        
                        // Attempt to hide the div from screen readers during content creation
                        this.div.style.visibility = "hidden";
                        this.div.style.display = "none";
                                                
                        // Set the ARIA describedby property if the required block available
                        if(document.getElementById("fd-datepicker-aria-describedby")) {
                                setARIAProperty(this.div, "describedby", "fd-datepicker-aria-describedby");
                        };
                        
                        // Set the ARIA labelled property if the required label available
                        if(this.labelledBy) {
                                setARIAProperty(this.div, "labelledby", this.labelledBy.id);
                        };
                              
                        var tr, row, col, tableHead, tableBody, tableFoot;

                        this.table             = document.createElement('table');
                        this.table.className   = "datePickerTable";                         
                        this.table.onmouseover = this.onmouseover;
                        this.table.onmouseout  = this.onmouseout;
                        this.table.onclick     = this.onclick;
                        
                        if(this.staticPos) {
                                this.table.onmousedown  = this.onmousedown;
                        };

                        this.div.appendChild(this.table);   
                        
                        var dragEnabledCN = !this.dragDisabled ? " drag-enabled" : "";
                                
                        if(!this.staticPos) {
                                this.div.style.visibility = "hidden";
                                this.div.className += dragEnabledCN;
                                document.getElementsByTagName('body')[0].appendChild(this.div);
                                                              
                                /*@cc_on
                                @if(@_jscript_version <= 5.7) 
                                
                                if(!this.isIE7) {                                         
                                        this.iePopUp = document.createElement('iframe');
                                        this.iePopUp.src = "javascript:'<html></html>';";
                                        this.iePopUp.setAttribute('className','iehack');
                                        // Remove iFrame from tabIndex                                        
			                this.iePopUp.setAttribute("tabIndex", -1);  			                
                                        // Hide it from ARIA aware technologies
			                setARIARole(this.iePopUp, "presentation");
                                        setARIAProperty(this.iePopUp, "hidden", "true"); 			                
                                        this.iePopUp.scrolling = "no";
                                        this.iePopUp.frameBorder = "0";
                                        this.iePopUp.name = this.iePopUp.id = this.id + "-iePopUpHack";
                                        document.body.appendChild(this.iePopUp);                                        
                                };
                                
                                @end
                                @*/
                                
                                // Aria "hidden" property for non active popup datepickers
                                setARIAProperty(this.div, "hidden", "true");
                        } else {
                                elem = this.positioned ? document.getElementById(this.positioned) : this.getElem();
                                if(!elem) {
                                        this.div = null;
                                        throw this.positioned ? "Could not locate a datePickers associated parent element with an id:" + this.positioned : "Could not locate a datePickers associated input with an id:" + this.id;
                                };

                                this.div.className += " static-datepicker";                          

                                if(this.positioned) {
                                        elem.appendChild(this.div);
                                } else {
                                        elem.parentNode.insertBefore(this.div, elem.nextSibling);
                                };
                                
                                if(this.hideInput) {
                                        var elemList = [elem];                                        
                                        if(this.splitDate) {
                                                elemList[elemList.length] = document.getElementById(this.id + splitAppend[1]);
                                                elemList[elemList.length] = document.getElementById(this.id + splitAppend[0]);                                         
                                        };
                                        for(var i = 0; i < elemList.length; i++) {
                                                if(elemList[i].tagName) elemList[i].className += " fd-hidden-input";        
                                        };
                                };                                                                  
                                                                          
                                setTimeout(this.resizeInlineDiv, 300);                               
                        };                          
                                
                        // ARIA Grid role
                        setARIARole(this.div, "grid");
                       
                        if(this.statusFormat) {
                                tableFoot = document.createElement('tfoot');
                                this.table.appendChild(tableFoot);
                                tr = document.createElement('tr');
                                tr.className = "date-picker-tfoot";
                                tableFoot.appendChild(tr);                                
                                this.statusBar = createTH({thClassName:"date-picker-statusbar" + dragEnabledCN, colspan:this.showWeeks ? 8 : 7});
                                tr.appendChild(this.statusBar); 
                                this.updateStatus(); 
                        };

                        tableHead = document.createElement('thead');
                        this.table.appendChild(tableHead);

                        tr  = document.createElement('tr');
                        setARIARole(tr, "presentation");
                        
                        tableHead.appendChild(tr);

                        // Title Bar
                        this.titleBar = createTH({thClassName:"date-picker-title" + dragEnabledCN, colspan:this.showWeeks ? 8 : 7});
                        
                        tr.appendChild(this.titleBar);
                        tr = null;

                        var span = document.createElement('span');
                        span.appendChild(document.createTextNode(nbsp));
                        span.className = "month-display" + dragEnabledCN; 
                        this.titleBar.appendChild(span);

                        span = document.createElement('span');
                        span.appendChild(document.createTextNode(nbsp));
                        span.className = "year-display" + dragEnabledCN; 
                        this.titleBar.appendChild(span);

                        span = null;

                        tr  = document.createElement('tr');
                        setARIARole(tr, "presentation");
                        tableHead.appendChild(tr);

                        createThAndButton(tr, [
                        {className:"prev-but prev-year",  id:"-prev-year-but", text:"\u00AB", title:getTitleTranslation(2) },
                        {className:"prev-but prev-month", id:"-prev-month-but", text:"\u2039", title:getTitleTranslation(0) },
                        {colspan:this.showWeeks ? 4 : 3, className:"today-but", id:"-today-but", text:getTitleTranslation(4)},
                        {className:"next-but next-month", id:"-next-month-but", text:"\u203A", title:getTitleTranslation(1)},
                        {className:"next-but next-year",  id:"-next-year-but", text:"\u00BB", title:getTitleTranslation(3) }
                        ]);

                        tableBody = document.createElement('tbody');
                        this.table.appendChild(tableBody);

                        var colspanTotal = this.showWeeks ? 8 : 7,
                            colOffset    = this.showWeeks ? 0 : -1,
                            but, abbr;   
                
                        for(var rows = 0; rows < 7; rows++) {
                                row = document.createElement('tr');

                                if(rows != 0) {
                                        // ARIA Grid role
                                        setARIARole(row, "row");
                                        tableBody.appendChild(row);   
                                } else {
                                        tableHead.appendChild(row);
                                };

                                for(var cols = 0; cols < colspanTotal; cols++) {                                                                                
                                        if(rows === 0 || (this.showWeeks && cols === 0)) {
                                                col = document.createElement('th');                                                                                              
                                        } else {
                                                col = document.createElement('td'); 
                                                 
                                                col.onblur  = this.onblur;
                                                col.onfocus = this.onfocus;                                                 
                                                setARIAProperty(col, "describedby", this.id + "-col-" + cols + (this.showWeeks ? " " + this.id + "-row-" + rows : ""));
                                                setARIAProperty(col, "selected", "false");                                                 
                                        };
                                        
                                        /*@cc_on@*/
                                        /*@if(@_win32)
                                        col.unselectable = "on";
                                        /*@end@*/  
                                        
                                        row.appendChild(col);
                                        if((this.showWeeks && cols > 0 && rows > 0) || (!this.showWeeks && rows > 0)) {                                                
                                                setARIARole(col, "gridcell"); 
                                        } else {
                                                if(rows === 0 && cols > colOffset) {
                                                        col.className = "date-picker-day-header";
                                                        col.scope = "col";
                                                        setARIARole(col, "columnheader"); 
                                                        col.id = this.id + "-col-" + cols;                                          
                                                } else {
                                                        col.className = "date-picker-week-header";
                                                        col.scope = "row";
                                                        setARIARole(col, "rowheader");
                                                        col.id = this.id + "-row-" + rows;
                                                };
                                        };
                                };
                        };

                        col = row = null; 
                
                        this.ths = this.table.getElementsByTagName('thead')[0].getElementsByTagName('tr')[2].getElementsByTagName('th');
                        for (var y = 0; y < colspanTotal; y++) {
                                if(y == 0 && this.showWeeks) {
                                        this.ths[y].appendChild(document.createTextNode(getTitleTranslation(6)));
                                        this.ths[y].title = getTitleTranslation(8);
                                        continue;
                                };

                                if(y > (this.showWeeks ? 0 : -1)) {
                                        but = document.createElement("span");
                                        but.className = "fd-day-header";                                        
                                        /*@cc_on@*/
                                        /*@if(@_win32)
                                        but.unselectable = "on";
                                        /*@end@*/
                                        this.ths[y].appendChild(but);
                                };
                        };
                
                        but = null; 
                                        
                        this.trs             = this.table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                        this.tds             = this.table.getElementsByTagName('tbody')[0].getElementsByTagName('td');
                        this.butPrevYear     = document.getElementById(this.id + "-prev-year-but");
                        this.butPrevMonth    = document.getElementById(this.id + "-prev-month-but");
                        this.butToday        = document.getElementById(this.id + "-today-but");
                        this.butNextYear     = document.getElementById(this.id + "-next-year-but"); 
                        this.butNextMonth    = document.getElementById(this.id + "-next-month-but");
        
                        if(this.noToday) {
                                this.butToday.style.display = "none";        
                        };
                        
                        if(this.showWeeks) {
                                this.wkThs = this.table.getElementsByTagName('tbody')[0].getElementsByTagName('th');
                                this.div.className += " weeks-displayed";
                        };

                        tableBody = tableHead = tr = createThAndButton = createTH = null;

                        if(this.low && this.high && (this.high - this.low < 7)) { this.equaliseDates(); }; 
                        
                        this.setDateFromInput();                                       
                        this.updateTableHeaders();
                        this.created = true;                         
                        this.callback("create", {id:this.id});                        
                        this.updateTable();                         
                        
                        if(this.staticPos) {                                 
                                this.visible = true;
                                this.opacity = this.opacityTo;                                                              
                                this.div.style.visibility = "visible";                       
                                this.div.style.display = "block";
                                this.noFocus = true;                                                          
                                this.fade();
                        } else {                                     
                                this.reposition();
                                this.div.style.visibility = "visible";
                                this.fade();
                                this.noFocus = true;   
                        };   
                        
                        this.addSpans = false;                                                     
                };                 
                this.fade = function() {
                        window.clearTimeout(o.fadeTimer);
                        o.fadeTimer = null;   
                        var diff = Math.round(o.opacity + ((o.opacityTo - o.opacity) / 4)); 
                        o.setOpacity(diff);  
                        if(Math.abs(o.opacityTo - diff) > 3 && !o.noFadeEffect) {                                 
                                o.fadeTimer = window.setTimeout(o.fade, 50);
                        } else {
                                o.setOpacity(o.opacityTo);
                                if(o.opacityTo == 0) {
                                        o.div.style.display    = "none";
                                        o.div.style.visibility = "hidden";
                                        setARIAProperty(o.div, "hidden", "true");
                                        o.visible = false;
                                } else {
                                        setARIAProperty(o.div, "hidden", "false");
                                        o.visible = true;                                        
                                };
                        };
                };                  
                this.trackDrag = function(e) {
                        e = e || window.event;
                        var diffx = (e.pageX?e.pageX:e.clientX?e.clientX:e.x) - o.mx;
                        var diffy = (e.pageY?e.pageY:e.clientY?e.clientY:e.Y) - o.my;
                        o.div.style.left = Math.round(o.x + diffx) > 0 ? Math.round(o.x + diffx) + 'px' : "0px";
                        o.div.style.top  = Math.round(o.y + diffy) > 0 ? Math.round(o.y + diffy) + 'px' : "0px";
                        /*@cc_on
                        @if(@_jscript_version <= 5.7)                         
                        if(o.staticPos || o.isIE7) return;
                        o.iePopUp.style.top    = o.div.style.top;
                        o.iePopUp.style.left   = o.div.style.left;
                        @end
                        @*/
                };
                this.stopDrag = function(e) {
                        removeEvent(document,'mousemove',o.trackDrag, false);
                        removeEvent(document,'mouseup',o.stopDrag, false);
                        o.div.style.zIndex = 9999;
                }; 
                this.onmousedown = function(e) {
                        e = e || document.parentWindow.event;
                        var el     = e.target != null ? e.target : e.srcElement,
                            origEl = el,
                            hideDP = true,
                            reg    = new RegExp("^fd-(but-)?" + o.id + "$");
                        
                        o.mouseDownElem = null;
                       
                        // Are we within the wrapper div or the button    
                        while(el) {
                                if(el.id && el.id.length && el.id.search(reg) != -1) { 
                                        hideDP = false;
                                        break;
                                };
                                try { el = el.parentNode; } catch(err) { break; };
                        };
                        
                        // If not, then ...     
                        if(hideDP) {                                                        
                                hideAll();                                                            
                                return true;                                                                  
                        };
                        
                        if((o.div.className + origEl.className).search('fd-disabled') != -1) { return true; };                                                                                                            
                        
                        // We check the mousedown events on the buttons
                        if(origEl.id.search(new RegExp("^" + o.id + "(-prev-year-but|-prev-month-but|-next-month-but|-next-year-but)$")) != -1) {
                                o.mouseDownElem = origEl;
                                
                                addEvent(document, "mouseup", o.clearTimer);
                                addEvent(origEl, "mouseout",  o.clearTimer); 
                                                                 
                                var incs = {
                                        "-prev-year-but":[0,-1,0],
                                        "-prev-month-but":[0,0,-1],
                                        "-next-year-but":[0,1,0],
                                        "-next-month-but":[0,0,1]
                                    },
                                    check = origEl.id.replace(o.id, ""),
                                    dateYYYYMM = Number(o.date.getFullYear() + pad(o.date.getMonth()+1));
                                
                                o.timerInc      = (o.currentYYYYMM > dateYYYYMM || o.currentYYYYMM < dateYYYYMM) ? 1600 : 800;
                                o.timerSet      = true;
                                o.dayInc        = incs[check][0];
                                o.yearInc       = incs[check][1];
                                o.monthInc      = incs[check][2]; 
                                
                                o.addSpans      = false;
                                 
                                o.updateTable();    
                                                            
                        } else if(el.className.search("drag-enabled") != -1) {                                  
                                o.mx = e.pageX ? e.pageX : e.clientX ? e.clientX : e.x;
                                o.my = e.pageY ? e.pageY : e.clientY ? e.clientY : e.Y;
                                o.x  = parseInt(o.div.style.left);
                                o.y  = parseInt(o.div.style.top);
                                addEvent(document,'mousemove',o.trackDrag, false);
                                addEvent(document,'mouseup',o.stopDrag, false);
                                o.div.style.zIndex = 10000;
                        };
                        return true;                                                                      
                }; 
                this.onclick = function(e) {
                        if(o.opacity != o.opacityTo || o.disabled) return stopEvent(e);
                        
                        e = e || document.parentWindow.event;
                        var el = e.target != null ? e.target : e.srcElement;                         
                          
                        while(el.parentNode) {
                                // Are we within a valid TD node  
                                if(el.tagName && el.tagName.toLowerCase() == "td") {
                                        if(el.className.search(/cd-([0-9]{8})/) == -1 || el.className.search(/date-picker-unused|out-of-range|day-disabled|no-selection|not-selectable/) != -1) return stopEvent(e);
                                        var cellDate = el.className.match(/cd-([0-9]{8})/)[1];                                                                                                                                                                           
                                        o.date          = new Date(cellDate.substr(0,4),cellDate.substr(4,2)-1,cellDate.substr(6,2));
                                        o.dateSet       = new Date(o.date); 
                                        o.noFocus       = true;                                
                                        o.returnFormattedDate();                                        
                                        o.hide();                            
                                        o.stopTimer();
                                        break;                
                                } else if(el.id && el.id == o.id + "-today-but") {                                 
                                        o.date = new Date(); 
                                        o.updateTable();
                                        o.stopTimer();
                                        break;       
                                } else if(el.className.search(/date-picker-day-header/) != -1) {
                                        var cnt = o.showWeeks ? -1 : 0,
                                        elem = el;
                                        
                                        while(elem.previousSibling) {
                                                elem = elem.previousSibling;
                                                if(elem.tagName.toLowerCase() == "th") cnt++;
                                        };
                                        
                                        o.firstDayOfWeek = (o.firstDayOfWeek + cnt) % 7;
                                        o.updateTableHeaders();
                                        break;     
                                };
                                try { el = el.parentNode; } catch(err) { break; };
                        };
                        
                        return stopEvent(e);                                                
                };
                this.onblur = function(e) {                                 
                        e = e || document.parentWindow.event;
                        var el = e.target != null ? e.target : e.srcElement;                                 
                                
                        while(el.parentNode) {
                                if(el.id && el.id == "fd-" + o.id) {
                                        return true;
                                };
                                try { el = el.parentNode; } catch(err) { break; };
                        };
                                
                        // Remove the keyboard events from the document    
                        if(o.kbEventsAdded) o.removeFocusEvents();        
                                
                        // Programmatically remove the focus style on the calendar         
                        o.div.className = o.div.className.replace("datepicker-focus", "");                                                      
                        o.noFocus  = true;
                        o.addSpans = false;                                                                                                      
                        o.hide();
                           
                        // Update status bar                                
                        if(o.statusBar) { o.updateStatus(getTitleTranslation(9)); };                
                };
                this.onfocus = function(e) {                                                                                                                            
                        if(o.staticPos) {
                                o.noFocus = false;
                                if(!o.spansAdded) {
                                        o.addSpans = true;
                                        o.updateTable();
                                };
                        };                                                                                                       
                        o.addFocusEvents();                                                  
                        //o.noFocus = false;
                };                         
                this.onkeydown = function (e) {
                        o.stopTimer();
                        if(!o.visible) return false;
                                
                        if(e == null) e = document.parentWindow.event;
                        var kc = e.keyCode ? e.keyCode : e.charCode;
                                
                        if( kc == 13 ) {
                                // RETURN/ENTER: close & select the date
                                var td = document.getElementById(o.id + "-date-picker-hover");                                         
                                if(!td || td.className.search(/cd-([0-9]{8})/) == -1 || td.className.search(/no-selection|out-of-range|day-disabled/) != -1) {
                                        return stopEvent(e);
                                };
                                o.dateSet = new Date(o.date);
                                o.returnFormattedDate();                                        
                                o.hide();
                                return stopEvent(e);
                        } else if(kc == 27) {
                                // ESC: close, no date selection 
                                o.hide();
                                return stopEvent(e);
                        } else if(kc == 32 || kc == 0) {
                                // SPACE: goto today's date 
                                o.date = new Date();
                                o.updateTable();
                                return stopEvent(e);
                        };    
                                 
                        // Internet Explorer fires the keydown event faster than the JavaScript engine can
                        // update the interface. The following attempts to fix this.
                                
                        /*@cc_on
                        @if(@_win32)                                 
                        if(new Date().getTime() - o.interval.getTime() < 50) { return stopEvent(e); }; 
                        o.interval = new Date();                                 
                        @end
                        @*/
                        
                        if ((kc > 49 && kc < 56) || (kc > 97 && kc < 104)) {
                                if(kc > 96) kc -= (96-48);
                                kc -= 49;
                                o.firstDayOfWeek = (o.firstDayOfWeek + kc) % 7;
                                o.updateTableHeaders();
                                return stopEvent(e);
                        };

                        if ( kc < 33 || kc > 40 ) return true;

                        var d = new Date(o.date), tmp, cursorYYYYMM = o.date.getFullYear() + pad(o.date.getMonth()+1); 

                        // HOME: Set date to first day of current month
                        if(kc == 36) {
                                d.setDate(1); 
                        // END: Set date to last day of current month                                 
                        } else if(kc == 35) {
                                d.setDate(daysInMonth(d.getMonth(),d.getFullYear())); 
                        // PAGE UP & DOWN                                   
                        } else if ( kc == 33 || kc == 34) {
                                var add = (kc == 34) ? 1 : -1; 
                                
                                // CTRL + PAGE UP/DOWN: Moves to the same date in the previous/next year
                                if(e.ctrlKey) {                                                                                                               
                                        d.setFullYear(d.getFullYear() + add);
                                // PAGE UP/DOWN: Moves to the same date in the previous/next month                                            
                                } else {                                                     
                                        if(!((kc == 33 && o.currentYYYYMM > cursorYYYYMM) || (kc == 34 && o.currentYYYYMM < cursorYYYYMM))) {                                                    
                                                tmp = new Date(d);
                                                tmp.setDate(2);
                                                tmp.setMonth(d.getMonth() + add);                                         
                                                d.setDate(Math.min(d.getDate(), daysInMonth(tmp.getMonth(),tmp.getFullYear())));                                        
                                                d.setMonth(d.getMonth() + add);
                                        };      
                                };                                                                    
                        // LEFT ARROW                                    
                        } else if ( kc == 37 ) {                                         
                                d = new Date(o.date.getFullYear(), o.date.getMonth(), o.date.getDate() - 1);                                       
                        // RIGHT ARROW
                        } else if ( kc == 39 || kc == 34) {                                         
                                d = new Date(o.date.getFullYear(), o.date.getMonth(), o.date.getDate() + 1 ); 
                        // UP ARROW                                        
                        } else if ( kc == 38 ) {                                          
                                d = new Date(o.date.getFullYear(), o.date.getMonth(), o.date.getDate() - 7);  
                        // DOWN ARROW                                        
                        } else if ( kc == 40 ) {                                          
                                d = new Date(o.date.getFullYear(), o.date.getMonth(), o.date.getDate() + 7);                                         
                        };

                        if(o.outOfRange(d)) { return stopEvent(e); };
                        o.date = d;
                        
                        if(o.statusBar) { o.updateStatus(printFormattedDate(o.date, o.statusFormat, true)); };
                        var t = String(o.date.getFullYear()) + pad(o.date.getMonth()+1) + pad(o.date.getDate());

                        if(e.ctrlKey || (kc == 33 || kc == 34) || t < o.firstDateShown || t > o.lastDateShown) {                                                                       
                                o.updateTable(); 
                                /*@cc_on
                                @if(@_win32)
                                o.interval = new Date();                        
                                @end
                                @*/                                       
                        } else {                                    
                                if(!o.noToday) { o.disableTodayButton(); };                                        
                                o.removeOldFocus();
                                var dt = "cd-" + o.date.getFullYear() + pad(o.date.getMonth()+1) + pad(o.date.getDate());
                                            
                                for(var i = 0, td; td = o.tds[i]; i++) {                                                                                             
                                        if(td.className.search(dt) == -1) {                                                          
                                                continue;
                                        };                                                 
                                        o.showHideButtons(o.date);
                                        td.id = o.id + "-date-picker-hover";                                                
                                        o.setNewFocus();
                                        break;
                                };
                        };

                        return stopEvent(e);
                }; 
                this.onmouseout = function(e) {
                        e = e || document.parentWindow.event;
                        var p = e.toElement || e.relatedTarget;
                        while (p && p != this) try { p = p.parentNode } catch(e) { p = this; };
                        if (p == this) return false;
                        if(o.currentTR) {
                                o.currentTR.className = ""; 
                                o.currentTR = null;
                        };
                        if(o.statusBar) { o.updateStatus(printFormattedDate(o.date, o.statusFormat, true)); };
                };
                this.onmouseover = function(e) {
                        e = e || document.parentWindow.event;
                        var el = e.target != null ? e.target : e.srcElement;
                        while(el.nodeType != 1) { el = el.parentNode; }; 
                                
                        if(!el || ! el.tagName) { return; };                              
                                
                        var statusText = getTitleTranslation(9);
                        switch (el.tagName.toLowerCase()) {
                                case "td":                                            
                                        if(el.className.search(/date-picker-unused|out-of-range/) != -1) {
                                                statusText = getTitleTranslation(9);
                                        } if(el.className.search(/cd-([0-9]{8})/) != -1) {                                                                                               
                                                o.stopTimer();
                                                var cellDate = el.className.match(/cd-([0-9]{8})/)[1];                                                                                                                          
                                                
                                                o.removeOldFocus();
                                                el.id = o.id+"-date-picker-hover";
                                                o.setNewFocus();
                                                                                       
                                                o.date = new Date(+cellDate.substr(0,4),+cellDate.substr(4,2)-1,+cellDate.substr(6,2));                                                
                                                if(!o.noToday) { o.disableTodayButton(); };
                                                statusText = printFormattedDate(o.date, o.statusFormat, true);                                                
                                        };
                                        break;
                                case "th":
                                        if(!o.statusBar) { break; };
                                        if(el.className.search(/drag-enabled/) != -1) {
                                                statusText = getTitleTranslation(10);
                                        } else if(el.className.search(/date-picker-week-header/) != -1) {
                                                var txt = el.firstChild ? el.firstChild.nodeValue : "";
                                                statusText = txt.search(/^(\d+)$/) != -1 ? getTitleTranslation(7, [txt, txt < 3 && o.date.getMonth() == 11 ? getWeeksInYear(o.date.getFullYear()) + 1 : getWeeksInYear(o.date.getFullYear())]) : getTitleTranslation(9);
                                        };
                                        break;
                                case "span":
                                        if(!o.statusBar) { break; };
                                        if(el.className.search(/drag-enabled/) != -1) {
                                                statusText = getTitleTranslation(10);
                                        } else if(el.className.search(/day-([0-6])/) != -1) {
                                                var day = el.className.match(/day-([0-6])/)[1];
                                                statusText = getTitleTranslation(11, [getDayTranslation(day, false)]);
                                        } else if(el.className.search(/prev-year/) != -1) {
                                                statusText = getTitleTranslation(2);
                                        } else if(el.className.search(/prev-month/) != -1) {
                                                statusText = getTitleTranslation(0);
                                        } else if(el.className.search(/next-year/) != -1) {
                                                statusText = getTitleTranslation(3);
                                        } else if(el.className.search(/next-month/) != -1) {
                                                statusText = getTitleTranslation(1);
                                        } else if(el.className.search(/today-but/) != -1 && el.className.search(/disabled/) == -1) {
                                                statusText = getTitleTranslation(12);
                                        };
                                        break;
                                default:
                                        statusText = "";
                        };
                        while(el.parentNode) {
                                el = el.parentNode;
                                if(el.nodeType == 1 && el.tagName.toLowerCase() == "tr") {                                                  
                                        if(o.currentTR) {
                                                if(el == o.currentTR) break;
                                                o.currentTR.className = ""; 
                                        };                                                 
                                        el.className = "dp-row-highlight";
                                        o.currentTR = el;
                                        break;
                                };
                        };                                                          
                        if(o.statusBar && statusText) { o.updateStatus(statusText); };                                 
                }; 
                this.clearTimer = function() {
                        o.stopTimer();
                        o.timerInc      = 800;
                        o.yearInc       = 0;
                        o.monthInc      = 0;
                        o.dayInc        = 0;
                        
                        removeEvent(document, "mouseup", o.clearTimer);
                        if(o.mouseDownElem != null) {
                                removeEvent(o.mouseDownElem, "mouseout",  o.clearTimer);
                        };
                        o.mouseDownElem = null;
                };    
                
                var o = this;
                
                
                if(this.staticPos) { 
                        this.create();                        
                } else { 
                        this.createButton();                                               
                };
                
                this.setDateFromInput();  
                
                (function() {
                        var elem = o.getElem();
                        if(elem && elem.tagName && elem.tagName.search(/select|input/i) != -1) {                                         
                                addEvent(elem, "change", o.changeHandler);
                                if(this.splitDate) {                                                                         
                                        addEvent(document.getElementById(o.id + splitAppend[1]), "change", o.changeHandler);
                                        addEvent(document.getElementById(o.id + splitAppend[0]), "change", o.changeHandler);
                                };
                        };
                        
                        if(!elem || elem.disabled == true) {
                               o.disableDatePicker();
                        }; 
                })();   
                
                // We have fully created the datepicker...
                this.fullCreate = true;
        };
        datePicker.prototype.addButtonEvents = function(but) {
                but.onkeydown = but.onclick = function(e) {
                        e = e || window.event;                      
                
                        var inpId     = this.id.replace('fd-but-',''),
                            dpVisible = isVisible(inpId),
                            autoFocus = false;                
                        
                        if(e.type == "keydown") {
                                var kc = e.keyCode != null ? e.keyCode : e.charCode;
                                if(kc != 13) return true; 
                                if(dpVisible) {
                                        this.className = this.className.replace("dp-button-active", "");                                          
                                        hideAll();
                                        return false;
                                };                                   
                                autoFocus = true;
                        };

                        this.className = this.className.replace("dp-button-active", "");
                        
                        if(!dpVisible) {                                 
                                this.className += " dp-button-active";
                                hideAll(inpId);
                                showDatePicker(inpId, autoFocus);
                        } else {
                                hideAll();
                        };
                
                        return false;
                };
                
                if(!buttonTabIndex) {
                        but.setAttribute(!/*@cc_on!@*/false ? "tabIndex" : "tabindex", "-1");
                        but.tabIndex = -1; 
                        but.onkeydown = null; 
                } else {
                        but.setAttribute(!/*@cc_on!@*/false ? "tabIndex" : "tabindex", "0");
                        but.tabIndex = 0;
                };                              
        };
        
        datePicker.prototype.createButton = function() {
                
                if(this.staticPos || document.getElementById("fd-but-" + this.id)) { return; };

                var inp         = this.getElem(),
                    span        = document.createElement('span'),
                    but         = document.createElement('a');

                but.href        = "#" + this.id;
                but.className   = "date-picker-control";
                but.title       = getTitleTranslation(5);
                but.id          = "fd-but-" + this.id;
                                
                span.appendChild(document.createTextNode(nbsp));
                but.appendChild(span);

                span = document.createElement('span');
                span.className = "fd-screen-reader";
                span.appendChild(document.createTextNode(but.title));
                but.appendChild(span);
                
                // Set the ARIA role to be "button"
                setARIARole(but, "button");                 
                
                // Set a "haspopup" ARIA property - should this not be a list if ID's????
                setARIAProperty(but, "haspopup", true);
                                             			                	
                if(this.buttonWrapper && document.getElementById(this.buttonWrapper)) {
                        document.getElementById(this.buttonWrapper).appendChild(but);
                } else if(inp.nextSibling) {
                        inp.parentNode.insertBefore(but, inp.nextSibling);
                } else {
                        inp.parentNode.appendChild(but);
                };                   
                
                this.addButtonEvents(but);

                but = null;
        };  
        datePicker.prototype.setRangeLow = function(range) {
                this.low = (String(range).search(/^(\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/) == -1) ? false : range;                
                this.checkSelectedDate();
                if(this.created) { this.updateTable(); };
        };
        datePicker.prototype.setRangeHigh = function(range) {
                this.high = (String(range).search(/^(\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/) == -1) ? false : range;                
                this.checkSelectedDate();
                if(this.created) { this.updateTable(); };
        };
        datePicker.prototype.setDisabledDays = function(dayArray) {
                this.disabledDays = dayArray;
                this.checkSelectedDate();
                if(this.created) { this.updateTable(); };
        };
        datePicker.prototype.setDisabledDates = function(dateArray) {                
                this.disabledDates = {};
                this.addDisabledDates(dateArray);                
        }; 
        datePicker.prototype.addDisabledDates = function(dateArray) {
                var disabledDateObj = {};
                if(typeof dateArray !== "object") dateArray = [dateArray];                
                for(var i = dateArray.length; i-- ;) {
                        if(dateArray[i].match(/^(\d\d\d\d|\*\*\*\*)(0[1-9]|1[012]|\*\*)(0[1-9]|[12][0-9]|3[01])$/) != -1) {
                                this.disabledDates[dateArray[i]] = 1;
                        };
                }; 
                this.checkSelectedDate();                   
                if(this.created) { this.updateTable(); };                                  
        };
        datePicker.prototype.checkSelectedDate = function() {
                if(!this.dateSet) return;
                if(!this.canDateBeSelected(this.dateSet)) {
                        this.dateSet = null;
                };
        };
        datePicker.prototype.addFocusEvents = function() {                              
                if(this.kbEventsAdded || this.noFocus) {                         
                        return;
                };
                
                this.div.className = this.div.className.replace(/datepicker-focus/, "") + " datepicker-focus";
                addEvent(document, "keypress", this.onkeydown);
                addEvent(document, "mousedown", this.onmousedown);
                
                /*@cc_on
                @if(@_win32)
                removeEvent(document, "keypress", this.onkeydown);
                addEvent(document, "keydown", this.onkeydown);                 
                @end
                @*/
                if(window.devicePixelRatio) {
                        removeEvent(document, "keypress", this.onkeydown);
                        addEvent(document, "keydown", this.onkeydown);
                };             
                this.noFocus = false;   
                this.kbEventsAdded = true;                
        };         
        datePicker.prototype.removeFocusEvents = function() {
                if(!this.kbEventsAdded) { return; };
                this.div.className = this.div.className.replace(/datepicker-focus/, "");
                removeEvent(document, "keypress",  this.onkeydown);
                removeEvent(document, "keydown",   this.onkeydown);
                removeEvent(document, "mousedown", this.onmousedown);                 
                this.noFocus       = true;
                this.kbEventsAdded = false;                 
        };         
        datePicker.prototype.stopTimer = function() {
                this.timerSet = false;
                window.clearTimeout(this.timer);
        };
        datePicker.prototype.setOpacity = function(op) {
                this.div.style.opacity = op/100;
                this.div.style.filter = 'alpha(opacity=' + op + ')';
                this.opacity = op;
        };         
        datePicker.prototype.getElem = function() {
                return document.getElementById(this.id.replace(/^fd-/, '')) || false;
        };
        datePicker.prototype.getEnabledDates = function(y, m) {
                m = pad(m);                 
                
                var obj = {},            
                    lower  = this.firstDateShown,
                    upper  = this.lastDateShown,             
                    dt1, dt2, rngLower, rngUpper;  
                
                if(!upper || !lower) {
                        lower = this.firstDateShown = y + pad(m) + "01";
                        upper = this.lastDateShown  = y + pad(m) + pad(daysInMonth(m, y));                        
                };                 
                
                for(dt in this.enabledDates) {                         
                        dt1 = dt.replace(/^(\*\*\*\*)/, y).replace(/^(\d\d\d\d)(\*\*)/, "$1"+m);
                        dt2 = this.enabledDates[dt];

                        if(dt2 == 1) {
                                obj[dt1] = 1;
                                continue;
                        };
                        
                        // Range
                        //if(Number(dt1.substr(0,6)) == +String(this.firstDateShown).substr(0,6) && Number(dt2.substr(0,6)) == +String(this.lastDateShown).substr(0,6)) {
                                // Same month
                                if(Number(dt1.substr(0,6)) == Number(dt2.substr(0,6))) {
                                        for(var i = dt1; i <= dt2; i++) {
                                                obj[i] = 1;
                                        };
                                        continue;
                                };

                                // Different months but we only want this month
                                rngLower = Number(dt1.substr(0,6)) == +String(this.firstDateShown).substr(0,6) ? dt1 : lower;
                                rngUpper = Number(dt2.substr(0,6)) == +String(this.lastDateShown).substr(0,6) ? dt2 : upper;
                                for(var i = +rngLower; i <= +rngUpper; i++) {
                                        obj[i] = 1;
                                };
                        //};
                };
                return obj;
        };
        
        datePicker.prototype.getDisabledDates = function(y, m) {
                m = pad(m);                 
                
                var obj = {},            
                    lower  = this.firstDateShown,
                    upper  = this.lastDateShown,             
                    dt1, dt2, rngLower, rngUpper;  
                
                if(!upper || !lower) {
                        lower = this.firstDateShown = y + pad(m) + "01";
                        upper = this.lastDateShown  = y + pad(m) + pad(daysInMonth(m, y));                        
                };
                
                for(var dt in this.disabledDates) {                            
                        dt1 = dt.replace(/^(\*\*\*\*)/, y).replace(/^(\d\d\d\d)(\*\*)/, "$1"+m);
                        dt2 = this.disabledDates[dt];

                        if(dt2 == 1) {                                 
                                if(+lower <= +dt1 && +upper >= +dt1) {
                                        obj[dt1] = 1;                                         
                                };
                                continue;
                        };

                        // Range of disabled dates                        
                        if(Number(dt1.substr(0,6)) <= +String(this.firstDateShown).substr(0,6) && Number(dt2.substr(0,6)) >= +String(this.lastDateShown).substr(0,6)) {
                                // Same month
                                if(Number(dt1.substr(0,6)) == Number(dt2.substr(0,6))) {
                                        for(var i = dt1; i <= dt2; i++) {
                                                obj[i] = 1;
                                        };
                                        continue;
                                };

                                // Different months but we only want this month
                                rngLower = Number(dt1.substr(0,6)) == +String(this.firstDateShown).substr(0,6) ? dt1 : lower;
                                rngUpper = Number(dt2.substr(0,6)) == +String(this.lastDateShown).substr(0,6) ? dt2 : upper;
                                for(var i = +rngLower; i <= +rngUpper; i++) {
                                        obj[i] = 1;                                        
                                };
                        };
                };
                
                for(dt in this.enabledDates) {
                        dt1 = dt.replace(/^(\*\*\*\*)/, y).replace(/^(\d\d\d\d)(\*\*)/, "$1"+m);
                        dt2 = this.enabledDates[dt];

                        if(dt2 == 1) {
                                if(dt1 in obj) {                                          
                                        obj[dt1] = null;
                                        delete obj[dt1];
                                };
                                continue;
                        };

                        // Range
                        if(Number(dt1.substr(0,6)) <= +String(this.firstDateShown).substr(0,6) && Number(dt2.substr(0,6)) >= +String(this.lastDateShown).substr(0,6)) {
                                // Same month
                                if(Number(dt1.substr(0,6)) == Number(dt2.substr(0,6))) {
                                        for(var i = dt1; i <= dt2; i++) {
                                                if(i in obj) {
                                                        obj[i] = null;
                                                        delete obj[i];
                                                };
                                        };
                                        continue;
                                };

                                // Different months but we only want this month
                                rngLower = Number(dt1.substr(0,6)) == +String(this.firstDateShown).substr(0,6) ? dt1 : lower;
                                rngUpper = Number(dt2.substr(0,6)) == +String(this.lastDateShown).substr(0,6) ? dt2 : upper;
                                for(var i = +rngLower; i <= +rngUpper; i++) {
                                        if(i in obj) {
                                                obj[i] = null;
                                                delete obj[i];
                                        };
                                };
                        };
                };
                return obj;
        };
        datePicker.prototype.truePosition = function(element) {
                var pos = this.cumulativeOffset(element);
                if(window.opera) { return pos; };
                var iebody      = (document.compatMode && document.compatMode != "BackCompat")? document.documentElement : document.body,
                    dsocleft    = document.all ? iebody.scrollLeft : window.pageXOffset,
                    dsoctop     = document.all ? iebody.scrollTop  : window.pageYOffset,
                    posReal     = this.realOffset(element);
                return [pos[0] - posReal[0] + dsocleft, pos[1] - posReal[1] + dsoctop];
        };
        datePicker.prototype.realOffset = function(element) {
                var t = 0, l = 0;
                do {
                        t += element.scrollTop  || 0;
                        l += element.scrollLeft || 0;
                        element = element.parentNode;
                } while(element);
                return [l, t];
        };
        datePicker.prototype.cumulativeOffset = function(element) {
                var t = 0, l = 0;
                do {
                        t += element.offsetTop  || 0;
                        l += element.offsetLeft || 0;
                        element = element.offsetParent;
                } while(element);
                return [l, t];
        };
        datePicker.prototype.equaliseDates = function() {
                var clearDayFound = false, tmpDate;
                for(var i = this.low; i <= this.high; i++) {
                        tmpDate = String(i);
                        if(!this.disabledDays[new Date(tmpDate.substr(0,4), tmpDate.substr(6,2), tmpDate.substr(4,2)).getDay() - 1]) {
                                clearDayFound = true;
                                break;
                        };
                };
                if(!clearDayFound) { this.disabledDays = [0,0,0,0,0,0,0] };
        };
        datePicker.prototype.outOfRange = function(tmpDate) {
                if(!this.low && !this.high) { return false; };

                var level = false;
                if(!tmpDate) {
                        level   = true;
                        tmpDate = this.date;
                };

                var d  = pad(tmpDate.getDate()),
                    m  = pad(tmpDate.getMonth() + 1),
                    y  = tmpDate.getFullYear(),
                    dt = String(y)+String(m)+String(d);

                if(this.low && +dt < +this.low) {
                        if(!level) { return true; };
                        this.date = new Date(this.low.substr(0,4), this.low.substr(4,2)-1, this.low.substr(6,2), 5, 0, 0);
                        return false;
                };
                if(this.high && +dt > +this.high) {
                        if(!level) { return true; };
                        this.date = new Date(this.high.substr(0,4), this.high.substr(4,2)-1, this.high.substr(6,2), 5, 0, 0);
                };
                return false;
        };  
        datePicker.prototype.canDateBeSelected = function(tmpDate) {
                if(!tmpDate) return false;
                                                               
                var d  = pad(tmpDate.getDate()),
                    m  = pad(tmpDate.getMonth() + 1),
                    y  = tmpDate.getFullYear(),
                    dt = String(y)+String(m)+String(d),
                    dd = this.getDisabledDates(+y, +m),
                    de = this.getEnabledDates(+y, +m),
                    wd = printFormattedDate(tmpDate, "N");              
                
                if((this.low && +dt < +this.low) || (this.high && +dt > +this.high) || (dt in dd) || (this.disabledDays[wd-1] && !(dt in de))) {
                        return false;
                };
                
                return true;
        };        
        datePicker.prototype.updateStatus = function(msg) {                                
                while(this.statusBar.firstChild) { this.statusBar.removeChild(this.statusBar.firstChild); };
                
                if(msg && this.statusFormat.search(/-S|S-/) != -1 && msg.search(/([0-9]{1,2})(st|nd|rd|th)/) != -1) {                
                        msg = msg.replace(/([0-9]{1,2})(st|nd|rd|th)/, "$1<sup>$2</sup>").split(/<sup>|<\/sup>/);                                                 
                        var dc = document.createDocumentFragment();
                        for(var i = 0, nd; nd = msg[i]; i++) {
                                if(/^(st|nd|rd|th)$/.test(nd)) {
                                        var sup = document.createElement("sup");
                                        sup.appendChild(document.createTextNode(nd));
                                        dc.appendChild(sup);
                                } else {
                                        dc.appendChild(document.createTextNode(nd));
                                };
                        };
                        this.statusBar.appendChild(dc);                        
                } else {                        
                        this.statusBar.appendChild(document.createTextNode(msg ? msg : getTitleTranslation(9)));                                                 
                };                                    
        };
        datePicker.prototype.setDateFromInput = function() {
                this.dateSet = null;

                var elem = this.getElem(), 
                    upd  = false, 
                    dt;
                    
                if(!elem || elem.tagName.search(/select|input/i) == -1) return; 

                if(!this.splitDate && elem.value.replace(/\s/g, "") !== "") {
                        var dynFormatMasks = formatMasks.concat([this.format]).reverse();                                                
                        for(var i = 0, fmt; fmt = dynFormatMasks[i]; i++) {
                                dt = parseDateString(elem.value, fmt);                                                              
                                if(dt) {                                    
                                        upd = true;                                       
                                        break;
                                };
                        };                                                                        
                } else if(this.splitDate) {
                        var mmN  = document.getElementById(this.id + splitAppend[1]),
                            ddN  = document.getElementById(this.id + splitAppend[0]),
                            tm   = parseInt(mmN.tagName.toLowerCase() == "input"  ? mmN.value  : mmN.options[mmN.selectedIndex || 0].value, 10),
                            td   = parseInt(ddN.tagName.toLowerCase() == "input"  ? ddN.value  : ddN.options[ddN.selectedIndex || 0].value, 10),
                            ty   = parseInt(elem.tagName.toLowerCase() == "input" ? elem.value : elem.options[elem.selectedIndex || 0].value, 10);
                                             
                        if(!(/\d\d\d\d/.test(ty)) || !(/^(0?[1-9]|1[012])$/.test(tm)) || !(/^(0?[1-9]|[12][0-9]|3[01])$/.test(td))) {
                                dt = false;
                        } else {
                                if(+td > daysInMonth(+tm - 1, +ty)) {                                         
                                        upd = true;
                                        td  = daysInMonth(+tm - 1, +ty); 
                                        dt  = new Date(ty,tm-1,td);
                                } else {
                                        dt = new Date(ty,tm-1,td);
                                };
                        };                        
                };

                if(!dt || isNaN(dt)) {                                                              
                        this.date = this.cursorDate ? new Date(+this.cursorDate.substr(0,4), +this.cursorDate.substr(4,2) - 1, +this.cursorDate.substr(6,2)) : new Date();
                        this.date.setHours(5);
                        this.outOfRange();
                        return;
                };

                dt.setHours(5);
                this.date = new Date(dt);                            
                this.outOfRange();                 
                
                if(dt.getTime() == this.date.getTime() && this.canDateBeSelected(this.date)) {                        
                        this.dateSet = new Date(this.date);
                };
                
                if(upd) { this.returnFormattedDate(true); };
        };
        datePicker.prototype.setSelectIndex = function(elem, indx) {
                for(var opt = elem.options.length-1; opt >= 0; opt--) {
                        if(elem.options[opt].value == +indx) {
                                elem.selectedIndex = opt;
                                return;
                        };
                };
        };
        datePicker.prototype.returnFormattedDate = function(noFocus) {                         
                var elem = this.getElem();
                if(!elem || this.dateSet == null) return;

                noFocus = !!noFocus;
                
                var d                   = pad(this.date.getDate()),
                    m                   = pad(this.date.getMonth() + 1),
                    yyyy                = this.date.getFullYear(),
                    disabledDates       = this.getDisabledDates(+yyyy, +m),
                    enabledDates        = this.getEnabledDates(+yyyy, +m),
                    weekDay             = (this.date.getDay() + 6) % 7,
                    dt                  = String(yyyy) + String(m) + String(d);
                
                if(!(this.disabledDays[weekDay] && !(dt in enabledDates)) || !(String(yyyy)+m+d in this.disabledDates)) {
                        if(this.splitDate) {                                  
                                var ddE = document.getElementById(this.id+splitAppend[0]),
                                    mmE = document.getElementById(this.id+splitAppend[1]),
                                    tY = elem.value, tM = mmE.value, tD = ddE.value;                                  
                                
                                if(+tY == +yyyy && +tM == +m && +tD == +d) { return; };                                
                                 
                                if(ddE.tagName.toLowerCase() == "input") { ddE.value = d; }
                                else { this.setSelectIndex(ddE, d); };
                                if(mmE.tagName.toLowerCase() == "input") { mmE.value = m; }
                                else { this.setSelectIndex(mmE, m); };
                                if(elem.tagName.toLowerCase() == "input") elem.value = yyyy;
                                else { this.setSelectIndex(elem, yyyy); };
                        } else if(elem.tagName.toLowerCase() == "input") {   
                                var oldVal = elem.value,
                                    newVal = printFormattedDate(this.date, this.format, returnLocaleDate);
                                                                                                                          
                                if(oldVal == newVal) { return; };                                 
                                elem.value = newVal;                             
                        };
                        
                        if(this.staticPos) { 
                                this.noFocus = true;
                                this.updateTable(); 
                                this.noFocus = false;
                        };                         
                        
                        if(this.fullCreate) {
                                if(elem.type && elem.type != "hidden" && !noFocus) { elem.focus(); };                                                                                          
                                this.callback("dateselect", { "id":this.id, "date":this.dateSet, "dd":d, "mm":m, "yyyy":yyyy });                        
                        };                                                          
                };                        
        };
        datePicker.prototype.disableDatePicker = function() {
                if(this.disabled) return;
                
                if(this.staticPos) {
                        this.removeFocusEvents();
                        this.noFocus = true;
                        this.div.className = this.div.className.replace(/dp-disabled/, "") + " dp-disabled";  
                        this.table.onmouseover = this.table.onclick = this.table.onmouseout = this.table.onmousedown = null;                                      
                        removeEvent(document, "mousedown", this.onmousedown);                         
                        removeEvent(document, "mouseup",   this.clearTimer);                       
                } else {  
                        if(this.visible) this.hide();                        
                        var but = document.getElementById("fd-but-" + this.id);
                        if(but) {
                                but.className = but.className.replace(/dp-disabled/, "") + " dp-disabled";
                                // Set a "disabled" ARIA state
                                setARIAProperty(but, "disabled", true);                               
                                but.onkeydown = but.onclick = function() { return false; }; 
                                but.setAttribute(!/*@cc_on!@*/false ? "tabIndex" : "tabindex", "-1");
                                but.tabIndex = -1;                
                        };                         
                };               
                                
                clearTimeout(this.timer);                
                this.disabled = true;  
        }; 
        datePicker.prototype.enableDatePicker = function() {
                if(!this.disabled) return;
                
                if(this.staticPos) {
                        this.removeOldFocus();
                        this.noFocus = true;
                        this.addSpans = true;
                        this.updateTable();
                        this.div.className = this.div.className.replace(/dp-disabled/, "");
                        this.disabled = false;                         
                        this.table.onmouseover = this.onmouseover;
                        this.table.onmouseout  = this.onmouseout;
                        this.table.onclick     = this.onclick;                         
                        this.table.onmousedown = this.onmousedown;                                                                    
                } else {                         
                        var but = document.getElementById("fd-but-" + this.id);
                        if(but) {
                                but.className = but.className.replace(/dp-disabled/, "");
                                // Reset the "disabled" ARIA state
                                setARIAProperty(but, "disabled", false);
                                this.addButtonEvents(but);                                                
                        };                         
                };
                
                this.disabled = false;                
        };
        datePicker.prototype.disableTodayButton = function() {
                var today = new Date();                     
                this.butToday.className = this.butToday.className.replace("fd-disabled", "");
                if(this.outOfRange(today) || (this.date.getDate() == today.getDate() && this.date.getMonth() == today.getMonth() && this.date.getFullYear() == today.getFullYear())) {
                        this.butToday.className += " fd-disabled";                          
                };
        };
        datePicker.prototype.updateTableHeaders = function() {
                var colspanTotal = this.showWeeks ? 8 : 7,
                    colOffset    = this.showWeeks ? 1 : 0,
                    d, but;

                for(var col = colOffset; col < colspanTotal; col++ ) {
                        d = (this.firstDayOfWeek + (col - colOffset)) % 7;
                        this.ths[col].title = getDayTranslation(d, false);

                        if(col > colOffset) {
                                but = this.ths[col].getElementsByTagName("span")[0];
                                while(but.firstChild) { but.removeChild(but.firstChild); };
                                but.appendChild(document.createTextNode(getDayTranslation(d, true)));
                                but.title = this.ths[col].title;
                                but.className = but.className.replace(/day-([0-6])/, "") + " day-" + d;
                                but = null;
                        } else {
                                while(this.ths[col].firstChild) { this.ths[col].removeChild(this.ths[col].firstChild); };
                                this.ths[col].appendChild(document.createTextNode(getDayTranslation(d, true)));
                        };

                        this.ths[col].className = this.ths[col].className.replace(/date-picker-highlight/g, "");
                        if(this.highlightDays[d]) {
                                this.ths[col].className += " date-picker-highlight";
                        };
                };
                
                if(this.created) { this.updateTable(); }
        }; 
        datePicker.prototype.callback = function(type, args) {                                                     
                if(!type || !(type in this.callbacks)) return false;
                
                var ret = false;                   
                for(var func = 0; func < this.callbacks[type].length; func++) {                         
                        ret = this.callbacks[type][func](args || this.id);
                        if(!ret) return false;
                };                      
                return ret;
        };        
        datePicker.prototype.showHideButtons = function(tmpDate) {
                var tdm = tmpDate.getMonth(),
                    tdy = tmpDate.getFullYear();

                this.butPrevYear.className = this.butPrevYear.className.replace("fd-disabled", "");
                if(this.outOfRange(new Date((tdy - 1), tdm, daysInMonth(+tdm, tdy-1)))) {
                        this.butPrevYear.className += " fd-disabled";
                        if(this.yearInc == -1) this.stopTimer();
                };    
                
                this.butPrevMonth.className = this.butPrevMonth.className.replace("fd-disabled", "");
                if(this.outOfRange(new Date(tdy, (+tdm - 1), daysInMonth(+tdm-1, tdy)))) {
                        this.butPrevMonth.className += " fd-disabled";
                        if(this.monthInc == -1) this.stopTimer();
                };
         
                this.butNextYear.className = this.butNextYear.className.replace("fd-disabled", "");
                if(this.outOfRange(new Date((tdy + 1), +tdm, 1))) {
                        this.butNextYear.className += " fd-disabled";
                        if(this.yearInc == 1) this.stopTimer();
                };
                
                this.butNextMonth.className = this.butNextMonth.className.replace("fd-disabled", "");
                if(this.outOfRange(new Date(tdy, +tdm + 1, 1))) {
                        this.butNextMonth.className += " fd-disabled";
                        if(this.monthInc == 1) this.stopTimer();
                };
        };        
            
        var grepRangeLimits = function(sel) {
                var range = [];
                for(var i = 0; i < sel.options.length; i++) {
                        if(sel.options[i].value.search(/^\d\d\d\d$/) == -1) { continue; };
                        if(!range[0] || Number(sel.options[i].value) < range[0]) { range[0] = Number(sel.options[i].value); };
                        if(!range[1] || Number(sel.options[i].value) > range[1]) { range[1] = Number(sel.options[i].value); };
                };
                return range;
        };
        var joinNodeLists = function() {
                if(!arguments.length) { return []; }
                var nodeList = [];
                for (var i = 0; i < arguments.length; i++) {
                        for (var j = 0, item; item = arguments[i][j]; j++) {
                                nodeList[nodeList.length] = item;
                        };
                };
                return nodeList;
        };
        var cleanUp = function() {
                var dp;
                for(dp in datePickers) {
                        if(!document.getElementById(datePickers[dp].id)) {
                                datePickers[dp].destroy();
                                datePickers[dp] = null;
                                delete datePickers[dp];
                        };
                };
        };         
        var hideAll = function(exception) {
                var dp;
                for(dp in datePickers) {
                        if(!datePickers[dp].created || (exception && exception == datePickers[dp].id)) continue;
                        datePickers[dp].hide();
                };
        };
        var hideDatePicker = function(inpID) {                
                if(inpID in datePickers) {
                        if(!datePickers[inpID].created || datePickers[inpID].staticPos) return;
                        datePickers[inpID].hide();
                };
        };
        var showDatePicker = function(inpID, autoFocus) {                
                if(!(inpID in datePickers)) return false;                 
                datePickers[inpID].show(autoFocus);
                return true;        
        };
        var destroy = function() {
                for(dp in datePickers) {
                        datePickers[dp].destroy();
                        datePickers[dp] = null;
                        delete datePickers[dp];
                };
                datePickers = null;
                removeEvent(window, 'load',   datePickerController.create);
                removeEvent(window, 'unload', datePickerController.destroy);
        }; 
        var destroySingleDatePicker = function(id) {
                if(id && (id in datePickers)) {
                        datePickers[id].destroy();
                        datePickers[id] = null;
                        delete datePickers[id];        
                };
        };
        var getTitleTranslation = function(num, replacements) {
                replacements = replacements || [];
                if(localeImport.titles.length > num) {
                         var txt = localeImport.titles[num];
                         if(replacements && replacements.length) {
                                for(var i = 0; i < replacements.length; i++) {
                                        txt = txt.replace("[[%" + i + "%]]", replacements[i]);
                                };
                         };
                         return txt.replace(/[[%(\d)%]]/g,"");
                };
                return "";
        };
        var getDayTranslation = function(day, abbreviation) {
                var titles = localeImport[abbreviation ? "dayAbbrs" : "fullDays"];
                return titles.length && titles.length > day ? titles[day] : "";
        };
        var getMonthTranslation = function(month, abbreviation) {
                var titles = localeImport[abbreviation ? "monthAbbrs" : "fullMonths"];
                return titles.length && titles.length > month ? titles[month] : "";
        };
        var daysInMonth = function(nMonth, nYear) {
                nMonth = (nMonth + 12) % 12;
                return (((0 == (nYear%4)) && ((0 != (nYear%100)) || (0 == (nYear%400)))) && nMonth == 1) ? 29: [31,28,31,30,31,30,31,31,30,31,30,31][nMonth];
        };
        var getWeeksInYear = function(Y) {
                if(Y in weeksInYearCache) {
                        return weeksInYearCache[Y];
                };
                var X1, X2, NW;
                with (X1 = new Date(Y, 0, 4)) {
                        setDate(getDate() - (6 + getDay()) % 7);
                };
                with (X2 = new Date(Y, 11, 28)) {
                        setDate(getDate() + (7 - getDay()) % 7);
                };
                weeksInYearCache[Y] = Math.round((X2 - X1) / 604800000);
                return weeksInYearCache[Y];
        };
        var parseRangeFromString = function(str) {
                if(!str) return "";
                
                var low = str.search(/^range-low-/) != -1;
                str = str.replace(/range-(low|high)-/, "");

                if(str.search(/^(\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/) != -1) { return str; };

                var tmpDate = new Date();
                
                if(str.search(/^today$/) != -1) { return tmpDate.getFullYear() + pad(tmpDate.getMonth() + 1) + pad(tmpDate.getDate()); };
                
                var regExp = /^(\d)-(day|week|month|year)$/;
                
                if(str.search(regExp) != -1) {
                        var parts       = str.match(regExp),
                            acc         = { day:0,week:0,month:0,year:0 };
                            
                        acc[parts[2]]   = low ? -(+parts[1]) : +parts[1];
                        tmpDate.setFullYear(tmpDate.getFullYear() + +acc.year);
                        tmpDate.setMonth(tmpDate.getMonth() + +acc.month);
                        tmpDate.setDate(tmpDate.getDate() + +acc.day + (7 * +acc.week));
                        return !tmpDate || isNaN(tmpDate) ? "" : tmpDate.getFullYear() + pad(tmpDate.getMonth() + 1) + pad(tmpDate.getDate());
                };
                
                return "";
        };
        var getWeekNumber = function(y,m,d) {
                var d = new Date(y, m, d, 0, 0, 0);
                var DoW = d.getDay();
                d.setDate(d.getDate() - (DoW + 6) % 7 + 3); // Nearest Thu
                var ms = d.valueOf(); // GMT
                d.setMonth(0);
                d.setDate(4); // Thu in Week 1
                return Math.round((ms - d.valueOf()) / (7 * 864e5)) + 1;
        };
        var printFormattedDate = function(date, fmt, useImportedLocale) {
                if(!date || isNaN(date)) { return ""; };
                
                var parts = fmt.split("-"),
                      str = [],
                        d = date.getDate(),
                        D = date.getDay(),
                        m = date.getMonth(),
                        y = date.getFullYear(),
                    flags = {
                                "sp":" ",
                                "dt":".",
                                "sl":"/",
                                "ds":"-",
                                "cc":",",
                                "d":pad(d),
                                "D":useImportedLocale ? localeImport.dayAbbrs[D == 0 ? 6 : D - 1] : localeDefaults.dayAbbrs[D == 0 ? 6 : D - 1],
                                "l":useImportedLocale ? localeImport.fullDays[D == 0 ? 6 : D - 1] : localeDefaults.fullDays[D == 0 ? 6 : D - 1],
                                "j":d,
                                "N":D == 0 ? 7 : D,
                                "w":D,                                
                                "W":getWeekNumber(date),
                                "M":useImportedLocale ? localeImport.monthAbbrs[m] : localeDefaults.monthAbbrs[m],
                                "F":useImportedLocale ? localeImport.fullMonths[m] : localeDefaults.fullMonths[m],
                                "m":pad(m + 1),
                                "n":m + 1,
                                "t":daysInMonth(m + 1, y),
                                "Y":y,
                                "o":y,
                                "y":String(y).substr(2,2),
                                "S":["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                            };  
                
                for(var pt = 0, part; part = parts[pt]; pt++) {                        
                        str.push(!(part in flags) ? "" : flags[part]);
                };
                
                return str.join("");
        };
        var parseDateString = function(str, fmt) {
                var d     = false,
                    m     = false,
                    y     = false,
                    now   = new Date(),
                    parts = fmt.replace(/-sp(-sp)+/g, "-sp").split("-"),
                    divds = { "dt":".","sl":"/","ds":"-","cc":"," };                    

                loopLabel:
                for(var pt = 0, part; part = parts[pt]; pt++) {                        
                        if(str.length == 0) { return false; };
                                
                        switch(part) {
                                // Dividers
                                case "sp": // Space " "
                                                if(str.charAt(0).search(/\s/) != -1) {
                                                        // Be easy on multiple spaces...
                                                        while(str.charAt(0).search(/\s/) != -1) { str = str.substr(1); };
                                                        break;
                                                } else return "";
                                case "dt":
                                case "sl":
                                case "ds":
                                case "cc":
                                                if(str.charAt(0) == divds[part]) {
                                                        str = str.substr(1);
                                                        break;
                                                } else return "";
                                // DAY
                                case "d": // Day of the month, 2 digits with leading zeros (01 - 31)
                                case "j": // Day of the month without leading zeros (1 - 31)  
                                          // Accept both when parsing                                                          
                                                if(str.search(/^(3[01]|[12][0-9]|0?[1-9])/) != -1) {
                                                        d = +str.match(/^(3[01]|[12][0-9]|0?[1-9])/)[0];
                                                        str = str.substr(str.match(/^(3[01]|[12][0-9]|0?[1-9])/)[0].length);                                                        
                                                        break;
                                                } else return "";
                                                
                                case "D": // A textual representation of a day, three letters (Mon - Sun)
                                case "l": // A full textual representation of the day of the week (Monday - Sunday)
                                                l = part == "D" ? localeDefaults.dayAbbrs : localeDefaults.fullDays;
                                                for(var i = 0; i < 7; i++) {
                                                        if(new RegExp("^" + l[i], "i").test(str)) {
                                                                str = str.substr(l[i].length);
                                                                continue loopLabel;
                                                        };
                                                };
                                                return "";                                  
                                case "N": // ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0) 1 (for Monday) through 7 (for Sunday)
                                case "w": // Numeric representation of the day of the week 0 (for Sunday) through 6 (for Saturday)
                                                if(str.search(part == "N" ? /^([1-7])/ : /^([0-6])/) != -1) {
                                                        str = str.substr(1);
                                                        break;
                                                } else return "";
                                case "S": // English ordinal suffix for the day of the month, 2 characters: st, nd, rd or th
                                                if(str.search(/^(st|nd|rd|th)/i) != -1) {
                                                        str = str.substr(2);
                                                        break;
                                                } else return "";
                                case "z": // The day of the year (starting from 0): 0 - 365
                                                if(str.search(/^([0-9]|[1-9][0-9]|[12][0-9]{2}|3[0-5][0-9]|36[0-5])/) != -1) {
                                                        str = str.substr(str.match(/^([0-9]|[1-9][0-9]|[12][0-9]{2}|3[0-5][0-9]|36[0-5])/)[0].length);
                                                        break;
                                                } else return "";
                                // WEEK
                                case "W": // ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0): 1 - 53
                                                if(str.search(/^([1-9]|[1234[0-9]|5[0-3])/) != -1) {
                                                        str = str.substr(str.match(/^([1-9]|[1234[0-9]|5[0-3])/)[0].length);
                                                        break;
                                                } else return "";
                                // MONTH
                                case "M": // A short textual representation of a month, three letters
                                case "F": // A full textual representation of a month, such as January or March
                                                l = localeDefaults.fullMonths.concat(localeDefaults.monthAbbrs); // : localeDefaults.fullMonths;
                                                for(var i = 0; i < 24; i++) {
                                                        if(str.search(new RegExp("^" + l[i],"i")) != -1) {
                                                                str = str.substr(l[i].length);
                                                                m = ((i + 12) % 12);                                                                 
                                                                continue loopLabel;
                                                        };
                                                };
                                                return "";
                                case "m": // Numeric representation of a month, with leading zeros
                                case "n": // Numeric representation of a month, without leading zeros
                                                //l = part == "m" ? /^(0[1-9]|1[012])/ : /^([1-9]|1[012])/;
                                                // Accept either when parsing
                                                l = /^(1[012]|0?[1-9])/;
                                                if(str.search(l) != -1) {
                                                        m = +str.match(l)[0] - 1;
                                                        str = str.substr(str.match(l)[0].length);
                                                        break;
                                                } else return "";
                                case "t": // Number of days in the given month: 28 through 31
                                                if(str.search(/2[89]|3[01]/) != -1) {
                                                        str = str.substr(2);
                                                        break;
                                                } else return "";
                                // YEAR
                                case "Y": // A full numeric representation of a year, 4 digits
                                case "o": // ISO-8601 year number. This has the same value as Y
                                                if(str.search(/^(\d{4})/) != -1) {
                                                        y = str.substr(0,4);
                                                        str = str.substr(4);
                                                        break;
                                                } else return "";
                                case "y": // A two digit representation of a year - be easy on four figure dates though
                                                if(str.search(/^(\d{4})/) != -1) {
                                                        y = str.substr(0,4);
                                                        str = str.substr(4);
                                                        break;
                                                } else if(str.search(/^(0[0-9]|[1-9][0-9])/) != -1) {
                                                        y = str.substr(0,2);
                                                        y = +y < 50 ? '20' + String(y) : '19' + String(y);
                                                        str = str.substr(2);
                                                        break;
                                                } else return "";
                                default:
                                                return "";
                        };
                };   
                
                d = d === false ? now.getDate() : d;
                m = m === false ? now.getMonth() - 1 : m;
                y = y === false ? now.getFullYear() : y;
                   
                var tmpDate = new Date(y,m,d);
                return isNaN(tmpDate) ? "" : tmpDate;
        };
        var repositionDatePickers = function(e) {
                for(dp in datePickers) {
                        if(!datePickers[dp].created || datePickers[dp].staticPos || (!datePickers[dp].staticPos && !datePickers[dp].dragDisabled)) continue;
                        datePickers[dp].reposition();
                };
        };
        var findLabelForElement = function(element) {
                var label;
                if(element.parentNode && element.parentNode.tagName.toLowerCase() == "label") lebel = element.parentNode;
                else {
                        var labelList = document.getElementsByTagName('label');
                        // loop through label array attempting to match each 'for' attribute to the id of the current element
                        for(var lbl = 0; lbl < labelList.length; lbl++) {
                                // Internet Explorer requires the htmlFor test
                                if((labelList[lbl]['htmlFor'] && labelList[lbl]['htmlFor'] == element.id) || (labelList[lbl].getAttribute('for') == element.id)) {
                                        label = labelList[lbl];
                                        break;
                                };
                        };
                };
                
                if(label && !label.id) { label.id = element.id + "_label"; };
               
                return label;         
        };        
        var addDatePicker = function(options) {
                // Has the locale file loaded?
                if(typeof(fdLocale) == "object" && !localeImport) {                        
                        localeImport = {
                                titles          : fdLocale.titles,
                                fullMonths      : fdLocale.fullMonths,
                                monthAbbrs      : fdLocale.monthAbbrs,
                                fullDays        : fdLocale.fullDays,
                                dayAbbrs        : fdLocale.dayAbbrs,
                                firstDayOfWeek  : ("firstDayOfWeek" in fdLocale && String(fdLocale.firstDayOfWeek).search(/^([0-6]{1})$/) != -1) ? fdLocale.firstDayOfWeek : 0,
                                imported        : true
                        };                                               
                } else if(!localeImport) {                        
                        localeImport = localeDefaults;
                };  
        
                if(!options.id || (options.id in datePickers)) { return; };
                
                var elem = document.getElementById(options.id);
                if(!elem || !elem.tagName || String(elem.tagName).search(/^(input|select)$/i) == -1) { return; };
                
                if(!options.staticPos) {
                        options.hideInput       = false;                                                 
                } else {
                        options.noFadeEffect    = true;
                        options.dragDisabled    = true;
                };

                datePickers[options.id] = new datePicker(options);
        };
        var parseCallbacks = function(cbs) {
                if(cbs == null) { return {}; };
                var func,
                    type,
                    cbObj = {},
                    parts,
                    obj;
                for(var i = 0, fn; fn = cbs[i]; i++) {
                        type = fn.match(/(cb_(dateselect|redraw|create)_)([^\s|$]+)/i)[1].replace(/^cb_/i, "").replace(/_$/, "");
                        fn   = fn.replace(/cb_(dateselect|redraw|create)_/i, "").replace(/-/g, ".");
                        
                        try {
                                if(fn.indexOf(".") != -1) {
                                        parts = fn.split('.');
                                        obj   = window;
                                        for (var x = 0, part; part = obj[parts[x]]; x++) {
                                                if(part instanceof Function) {
                                                        (function() {
                                                                var method = part;
                                                                func = function (data) { method.apply(obj, [data]) };
                                                        })();
                                                } else {
                                                obj = part;
                                                };
                                        };
                                } else {
                                        func = window[fn];
                                };

                                if(!(func instanceof Function)) continue;
                                if(!(type in cbObj)) { cbObj[type] = []; };
                                cbObj[type][cbObj[type].length] = func;
                        } catch (err) {};
                };
                return cbObj;
        };
        // Used by the button to dictate whether to open or close the datePicker
        var isVisible = function(id) {
                return (!id || !(id in datePickers)) ? false : datePickers[id].visible;
        };                
        var create = function(inp) {
                if(!(typeof document.createElement != "undefined" && typeof document.documentElement != "undefined" && typeof document.documentElement.offsetWidth == "number")) { return; };             
                
                var formElements = (inp && inp.tagName) ? [inp] : joinNodeLists(document.getElementsByTagName('input'), document.getElementsByTagName('select')),
                    disableDays  = /disable-days-([1-7]){1,6}/g,
                    highlight    = /highlight-days-([1-7]{1,7})/,
                    rangeLow     = /range-low-(((\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01]))|((\d)-(day|week|month|year))|(today))/,
                    rangeHigh    = /range-high-(((\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01]))|((\d)-(day|week|month|year))|(today))/,
                    cursorDate   = /cursor-((\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01]))/,
                    dateFormat   = /dateformat(-((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p])))+/,
                    statusFormat = /statusformat(-((sp|dt|sl|ds|cc)|([d|D|l|j|N|w|S|W|M|F|m|n|t|Y|o|y|O|p])))+/,                                          
                    disableDates = /disable((-(\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])){2}|(-((\d\d\d\d)|(xxxx))((0[1-9]|1[012])|(xx))(0[1-9]|[12][0-9]|3[01])))/g,
                    enableDates  = /enable((-(\d\d\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])){2}|(-((\d\d\d\d)|(xxxx))((0[1-9]|1[012])|(xx))(0[1-9]|[12][0-9]|3[01])))/g,
                    callbacks    = /((cb_(dateselect|redraw|create)_)([^\s|$]+))/ig,
                    positioned   = /display-inline-([^\s|$]+)/i,
                    bPositioned  = /button-([^\s|$]+)/i,
                    range,tmp,j,t,options,dts,parts;                  
                    
                for(var i = 0, elem; elem = formElements[i]; i++) {  
                        if(elem.className && (elem.className.search(dateFormat) != -1 || elem.className.search(/split-date/) != -1) && ((elem.tagName.toLowerCase() == "input" && (elem.type == "text" || elem.type == "hidden")) || elem.tagName.toLowerCase() == "select")) {
                                
                                if(elem.id && elem.id in datePickers) {                                                                                                                        
                                        if(!datePickers[elem.id].staticPos) { datePickers[elem.id].createButton(); }
                                        else { 
                                                if(!document.getElementById("fd-" + elem.id)) {
                                                        datePickers[elem.id].created = false;                                                         
                                                        datePickers[elem.id].create();                                                     
                                                } else if(inp) {    
                                                        // Only do this if called from an ajax update etc                                                    
                                                        datePickers[elem.id].setDateFromInput();  
                                                        datePickers[elem.id].updateTable();      
                                                };                                        
                                        };                                          
                                        continue;
                                };
                                
                                if(!elem.id) { elem.id = "fdDatePickerInput-" + uniqueId++; };
                                
                                options = {
                                        id:elem.id,
                                        low:"",
                                        high:"",
                                        format:"d-sl-m-sl-Y",
                                        statusFormat:"",                                                                                 
                                        highlightDays:[0,0,0,0,0,1,1],
                                        disabledDays:[0,0,0,0,0,0,0],
                                        disabledDates:{},
                                        enabledDates:{},
                                        noFadeEffect:elem.className.search(/no-animation/i) != -1,
                                        staticPos:elem.className.search(/display-inline/i) != -1,
                                        hideInput:elem.className.search(/hide-input/i) != -1,
                                        noToday:elem.className.search(/no-today-button/i) != -1,
                                        showWeeks:elem.className.search(/show-week/i) != -1,
                                        dragDisabled:nodrag ? true : elem.className.search(/disable-drag/i) != -1,
                                        positioned:false,                                        
                                        fillGrid:elem.className.search(/fill-grid/i) != -1,
                                        constrainSelection:elem.className.search(/fill-grid-no-select/i) != -1,
                                        callbacks:parseCallbacks(elem.className.match(callbacks)),
                                        buttonWrapper:"",                                        
                                        cursorDate:""
                                };                            
                                
                                // The cursor start date
                                if(elem.className.search(cursorDate) != -1) {
                                        options.cursorDate = elem.className.match(cursorDate)[1];                                                                               
                                };
                                
                                // Positioning of static dp's
                                if(options.staticPos && elem.className.search(positioned) != -1) {
                                        options.positioned = elem.className.match(positioned)[1];                                        
                                };
                                
                                // Positioning of non-static dp's button
                                if(!options.staticPos && elem.className.search(bPositioned) != -1) {
                                        options.buttonWrapper = elem.className.match(bPositioned)[1];                                        
                                };
                                
                                // Opacity of non-static datePickers
                                if(!options.staticPos) {
                                        options.finalOpacity = elem.className.search(/opacity-([1-9]{1}[0-9]{1})/i) != -1 ? elem.className.match(/opacity-([1-9]{1}[0-9]{1})/i)[1] : 90                              
                                };
                                
                                // Dates to disable
                                dts = elem.className.match(disableDates);
                                if(dts) {
                                        for(t = 0; t < dts.length; t++) {
                                                parts = dts[t].replace(/xxxx/, "****").replace(/xx/, "**").replace("disable-", "").split("-");
                                                options.disabledDates[parts[0]] = (parts.length && parts.length == 2) ? parts[1] : 1;                                                
                                        };
                                };

                                // Dates to enable
                                dts = elem.className.match(enableDates);
                                if(dts) {
                                        for(t = 0; t < dts.length; t++) {
                                                parts = dts[t].replace(/xxxx/, "****").replace(/xx/, "**").replace("enable-", "").split("-");
                                                options.enabledDates[parts[0]] = (parts.length && parts.length == 2) ? parts[1] : 1;                                                
                                        };
                                };
                                             
                                // Split the date into three parts ?                                
                                options.splitDate = (elem.className.search(/split-date/) != -1 && document.getElementById(elem.id+splitAppend[0]) && document.getElementById(elem.id+splitAppend[1]) && document.getElementById(elem.id+splitAppend[0]).tagName.search(/input|select/i) != -1 && document.getElementById(elem.id+splitAppend[1]).tagName.search(/input|select/i) != -1);                              
                                
                                // Date format
                                if(!options.splitDate && elem.className.search(dateFormat) != -1) {
                                        options.format = elem.className.match(dateFormat)[0].replace('dateformat-','');
                                };

                                // Status bar date format
                                if(elem.className.search(statusFormat) != -1) {
                                        options.statusFormat = elem.className.match(statusFormat)[0].replace('statusformat-','');
                                };                                 
                                
                                // The days of the week to highlight
                                if(elem.className.search(highlight) != -1) {
                                        tmp = elem.className.match(highlight)[0].replace(/highlight-days-/, '');
                                        options.highlightDays = [0,0,0,0,0,0,0];
                                        for(j = 0; j < tmp.length; j++) {
                                                options.highlightDays[tmp.charAt(j) - 1] = 1;
                                        };
                                };
                                
                                // The days of the week to disable
                                if(elem.className.search(disableDays) != -1) {
                                        tmp = elem.className.match(disableDays)[0].replace(/disable-days-/, '');
                                        options.disabledDays = [0,0,0,0,0,0,0];                                         
                                        for(j = 0; j < tmp.length; j++) {
                                                options.disabledDays[tmp.charAt(j) - 1] = 1;
                                        };
                                };

                                // The lower limit
                                if(elem.className.search(rangeLow) != -1) {
                                        options.low = parseRangeFromString(elem.className.match(rangeLow)[0]);
                                };

                                // The higher limit
                                if(elem.className.search(rangeHigh) != -1) {
                                        options.high = parseRangeFromString(elem.className.match(rangeHigh)[0]);
                                };

                                // Always round lower & higher limits if a selectList involved
                                if(elem.tagName.search(/select/i) != -1) {
                                        range        = grepRangeLimits(elem);
                                        options.low  = options.low  ? range[0] + String(options.low).substr(4,4)  : range[0] + "0101";
                                        options.high = options.high ? range[1] + String(options.high).substr(4,4) : range[1] + "1231";
                                };

                                addDatePicker(options);
                        };
                };
        };

        addEvent(window, 'load',   create);
        addEvent(window, 'unload', destroy);
        addEvent(window, 'resize', repositionDatePickers);

        return {
                addEvent:               function(obj, type, fn) { return addEvent(obj, type, fn); },
                removeEvent:            function(obj, type, fn) { return removeEvent(obj, type, fn); },
                stopEvent:              function(e) { return stopEvent(e); },
                show:                   function(inpID) { return showDatePicker(inpID, false); },
                hide:                   function(inpID) { return hideDatePicker(inpID); },
                create:                 function(inp) { create(inp); },
                createDatePicker:       function(options) { addDatePicker(options); },
                removeOnloadEvent:      function() { removeEvent(window, 'load',   create); },
                destroyDatePicker:      function(inpID) { destroySingleDatePicker(inpID); },
                cleanUp:                function() { cleanUp(); },                                 
                repositionDatePickers:  function() { repositionDatePickers(); },                
                printFormattedDate:     function(dt, fmt, useImportedLocale) { return printFormattedDate(dt, fmt, useImportedLocale); },
                setDateFromInput:       function(inpID) { if(!inpID || !(inpID in datePickers) || !datePickers[inpID].created) return false; datePickers[inpID].setDateFromInput(); },
                setRangeLow:            function(inpID, yyyymmdd) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].setRangeLow(yyyymmdd); },
                setRangeHigh:           function(inpID, yyyymmdd) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].setRangeHigh(yyyymmdd); },
                parseDateString:        function(str, format) { return parseDateString(str, format); },
                setGlobalVars:          function(json) { affectJSON(json); },
                dateValidForSelection:  function(inpID, dt) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].canDateBeSelected(dt); },
                addDisabledDates:       function(inpID, dts) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].addDisabledDates(dts); },
                setDisabledDates:       function(inpID, dts) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].setDisabledDates(dts); },
                disable:                function(inpID) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].disableDatePicker();},
                enable:                 function(inpID) { if(!inpID || !(inpID in datePickers)) return false; datePickers[inpID].enableDatePicker();}                                                              
        }; 
})();