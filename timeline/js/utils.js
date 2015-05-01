﻿
// debug

// http://paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function () {
    log.history = log.history || [];   // store logs to an array for reference
    log.history.push(arguments);
    if (this.console) {
        console.log(Array.prototype.slice.call(arguments));
    }
};

// end debug

// string

String.format = function () {
    var s = arguments[0];
    for (var i = 0; i < arguments.length - 1; i++) {
        var reg = new RegExp("\\{" + i + "\\}", "gm");
        s = s.replace(reg, arguments[i + 1]);
    }

    return s;
};

String.prototype.startsWith = function (str) { return this.indexOf(str) == 0; };
String.prototype.trim = function () { return this.replace(/^\s\s*/, '').replace(/\s\s*$/, ''); };
String.prototype.ltrim = function () { return this.replace(/^\s+/, ''); };
String.prototype.rtrim = function () { return this.replace(/\s+$/, ''); };
String.prototype.fulltrim = function () { return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g, '').replace(/\s+/g, ' '); };
String.prototype.toFileName = function () { return this.replace(/[^a-z0-9]/gi, '_').toLowerCase(); };

function ellipsis(text, chars) {
    if (text.length <= chars) return text;
    var trimmedText = text.substr(0, chars);
    trimmedText = trimmedText.substr(0, Math.min(trimmedText.length, trimmedText.lastIndexOf(" ")));
    return trimmedText + "&hellip;";
}

function numericalInput (event) {
    // Allow: backspace, delete, tab and escape
    if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
        // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) ||
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        // let it happen, don't do anything
        return true;
    } else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
}

// end string

// math

function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
    return result;
}

function normalise(num, min, max) {
    return (num - min) / (max - min);
}

function fitRect(width1, height1, width2, height2) {
    var ratio1 = height1 / width1;
    var ratio2 = height2 / width2;

    var width, height, scale;

    if (ratio1 < ratio2) {
        scale = width2 / width1;
        width = width1 * scale;
        height = height1 * scale;
    }
    if (ratio2 < ratio1) {
        scale = height2 / height1;
        width = width1 * scale;
        height = height1 * scale;
    }

    return { width: Math.floor(width), height: Math.floor(height) };
}

// end math

// array

if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj, start) {
        for (var i = (start || 0), j = this.length; i < j; i++) {
            if (this[i] === obj) {
                return i;
            }
        }
        return -1;
    };
}

// end array

// date

function getTimeStamp() {
    return new Date().getTime();
}

// end date

// querystring

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

// end querystring

// uri

function getUrlParts(url) {
    var a = document.createElement('a');
    a.href = url;

    return {
        href: a.href,
        host: a.host,
        hostname: a.hostname,
        port: a.port,
        pathname: a.pathname,
        protocol: a.protocol,
        hash: a.hash,
        search: a.search
    };
}

function convertToRelativeUrl(url) {
    var parts = getUrlParts(url);
    var relUri = parts.pathname + parts.search;

    if (!relUri.startsWith("/")) {
        relUri = "/" + relUri;
    }

    return relUri;
}

// end uri

// objects

if (typeof Object.create !== 'function') {
    Object.create = function(o) {
        var F = function() {
        };
        F.prototype = o;
        return new F();
    };
}

Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

// end objects

// events

function debounce(fn, debounceDuration) {
    // summary:
    //      Returns a debounced function that will make sure the given 
    //      function is not triggered too much.
    // fn: Function
    //      Function to debounce.
    // debounceDuration: Number
    //      OPTIONAL. The amount of time in milliseconds for which we 
    //      will debounce the function. (defaults to 100ms)

    debounceDuration = debounceDuration || 100;

    return function () {
        if (!fn.debouncing) {
            var args = Array.prototype.slice.apply(arguments);
            fn.lastReturnVal = fn.apply(window, args);
            fn.debouncing = true;
        }
        clearTimeout(fn.debounceTimeout);
        fn.debounceTimeout = setTimeout(function () {
            fn.debouncing = false;
        }, debounceDuration);

        return fn.lastReturnVal;
    };
};

// end events

// dom

function getMaxZIndex(){
    return Math.max.apply(null,$.map($('body > *'), function(e,n){
        if($(e).css('position')=='absolute')
            return parseInt($(e).css('z-index'))||1 ;
        })
    );
}

// end dom