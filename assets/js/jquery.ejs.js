(function ($) {
    var cache = {};
    var settings = {
        evaluate: /<%([\s\S]+?)%>/g,
        interpolate: /<%=([\s\S]+?)%>/g,
        escape: /<%-([\s\S]+?)%>/g
    };
    var noMatch = /(.)^/;
    var escapes = {
        "'": "'",
        '\\': '\\',
        '\r': 'r',
        '\n': 'n',
        '\t': 't',
        '\u2028': 'u2028',
        '\u2029': 'u2029'
    };
    var escaper = /\\|'|\r|\n|\t|\u2028|\u2029/g;
    var htmlEntities = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#x27;'
    };
    var entityRe = new RegExp('[&<>"\']', 'g');
    var escapeExpr = function (string) {
        if (string == null) return '';
        return ('' + string).replace(entityRe, function (match) {
            return htmlEntities[match];
        });
    };

    var template = function ( text , name ) {
        var render;
        var matcher = new RegExp([
                (settings.escape || noMatch).source,
                (settings.interpolate || noMatch).source,
                (settings.evaluate || noMatch).source
            ].join('|') + '|$', 'g');
        var index = 0;
        var source = "__p+='";
        text.replace(matcher, function (match, escape, interpolate, evaluate, offset) {
            source += text.slice(index, offset)
                .replace(escaper, function (match) {
                    return '\\' + escapes[match];
                });

            if (escape) {
                source += "'+\n((__t=(" + escape + "))==null?'':escapeExpr(__t))+\n'";
            }
            if (interpolate) {
                source += "'+\n((__t=(" + interpolate + "))==null?'':__t)+\n'";
            }
            if (evaluate) {
                source += "';\n" + evaluate + "\n__p+='";
            }
            index = offset + match.length;
            return match;
        });
        source += "';\n";
        if (!settings.variable) source = 'with(obj||{}){\n' + source + '}\n';
        source = "var __t,__p='',__j=Array.prototype.join," +
            "print=function(){__p+=__j.call(arguments,'');};\n" +
            source + "return __p;\n//# sourceURL=" + name || '' ;
        try {
            render = new Function(settings.variable || 'obj', 'escapeExpr', source);
        } catch (e) {
            e.source = source;
            throw e;
        }
        var template = function (data) {
            return render.call(this, data, escapeExpr);
        };
        template.source = 'function(' + (settings.variable || 'obj') + '){\n' + source + '}';
        return template;
    };

    var output = function(){

    };

    output.prototype = {
        extend: function (data) {
            return $.extend(false, {}, this, data || {}, output.helpers );
        },
        include: function (url, data) {
            return $.ejs(url).render(this.extend(data));
        },
        attr:function(name,value){
            var i = 0,
                data = this,
                name = (name || '').split('.'),
                prop = name.pop(),
                len = arguments.length;
            for (; i < name.length; i++) {
                if (data && data.hasOwnProperty(name[i])) {
                    data = data[name[i]];
                }
                else {
                    if (len == 2) {
                        data = (data[name[i]] = {});
                    }
                    else {
                        break;
                    }
                }
            }
            if (len == 1) {
                return data ? data[prop] : null;
            }
            if (len == 2) {
                data[prop] = value;
            }
            return this;
        }
    };

    output.helpers = {
        or: function (bool, success, failure) {
            return bool ? success : failure;
        },
        alt: function (bool, result) {
            return bool ? result : '';
        },
        def: function (value, defaults) {
            return value || defaults;
        },
        eachContext:function(prop){
            prop.attr = this.attr;
            return prop;
        },
        each: function (object, callback) {
            var prop,object = typeof(object)=='string' ? (this.attr(object) || object) : object;
            for(prop in object) {
                if(object.hasOwnProperty(prop)){
                   callback(object[prop],prop);
                }
            }
        }
    };
    var ejs = function(url){
        this.config.url      = url;
        this.template = new output();
        if(url) return this.request();
    };
    ejs.prototype = {
        config: {
            ext: '.ejs'
        },
        url: function () {
            var url = this.config.url;
            url = url + ( url.indexOf(this.config.ext) != -1 ? '' : this.config.ext );
            return url.concat('?').concat(new Date().getTime());
        },
        request: function () {
            var response = $.ajax({type: 'get', url: this.url(), async: false });
            this.template.source = response.status==200 ? (response.responseText || '') : '';
            this.output();
        },
        output: function () {
            this.template.output = template(this.template.source);
        },
        render: function (data) {
            data = this.template.extend(data);
            return this.template.output.call(data, data);
        }
    };
    $.ejs = function(template){
        template = $.ejs.basePath.concat(template);
        if (cache[template]) return cache[template];
        cache[template] = new ejs(template);
        return cache[template];
    };
    $.ejs.basePath  = '';
    $.ejs.addHelper = function(name,callback){
        output.helpers[name] = callback;
    };
})(jQuery);