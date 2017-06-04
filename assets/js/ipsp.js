(function ($) {
    $.fn.serializeObject = function () {
        var result = {};
        var extend = function (i, element) {
            var node = result[element.name];
            if ('undefined' !== typeof node && node !== null) {
                if ($.isArray(node)) {
                    node.push(element.value);
                } else {
                    result[element.name] = [node, element.value];
                }
            } else {
                result[element.name] = element.value;
            }
        };
        $.each(this.serializeArray(), extend);
        return result;
    };
})(jQuery);

(function ($) {
    /**
     *
     * @constructor
     */
    $.PortalApi = function () {

    };
    $.PortalApi.prototype = {
        origin: 'https://portal.fondy.eu',
        endpoint: {
            portal: '/mportal',
            gateway: '/mportal/#/connector/52',
            google: '/api/account/registration/google/',
            facebook: '/api/account/registration/facebook/',
            linkedin: '/api/account/registration/linkedin/'
        },
        created: false,
        loaded: false,
        /**
         *
         * @param url
         * @returns {*}
         */
        frame: function (url) {
            var defer = this.defer();
            $('<iframe>').hide().attr('src', url).appendTo('body').on('load',function(){
                defer.resolve(this);
            }).on('error', function () {
                defer.reject(this);
            });
            return defer;
        },
        /**
         *
         * @param type
         * @param url
         * @returns {string}
         */
        url: function (type, url) {
            return this.origin.concat(this.endpoint[type] || '/').concat(url || '');
        },
        /**
         *
         */
        init: function () {
            if( this.created == false ) {
                this.created = true;
                this.wrapper = $(this);
                this.frame(this.url('gateway')).then($.proxy(this,'load'));
            }
            return this;
        },
        /**
         *
         * @param frame
         */
        load: function (frame) {
            this.connector = new $.Connector(frame.contentWindow);
            this.connector.action('load', $.proxy(this, 'ready'));
        },
        /**
         *
         * @param ev
         * @param data
         */
        ready: function (ev, data) {
            this.loaded = true;
            this.wrapper.trigger('portal.api').off('portal.api');
        },
        /**
         *
         * @param callback
         * @returns {*}
         */
        scope: function (callback) {
            if (this.init().loaded) return callback.call(this);
            else this.wrapper.on('portal.api', $.proxy(callback, this));
        },
        /**
         *
         * @returns {$.Deferred}
         */
        defer: function () {
            return $.Deferred();
        },
        /**
         *
         * @param model
         * @param method
         * @param params
         * @returns {defer}
         */
        request: function (model, method, params) {
            var defer = this.defer();
            var data = {};
            data.uid = this.connector.getUID();
            data.action = model;
            data.method = method;
            data.params = params || {};
            this.connector.send('request', data);
            this.connector.action(data.uid, $.proxy(function (ev, response) {
                defer[response.error ? 'rejectWith' : 'resolveWith'](this, [response]);
            }, this));
            return defer;
        },
        /**
         *
         * @returns {defer}
         */
        session: function () {
            return this.request('api.account', 'check');
        }
    };
})(jQuery);

(function ($) {
    $.ejs.basePath = '/assets/html';
})(jQuery);

(function ($) {
    var list = {};
    var toArray = function (obj) {
        return Array.prototype.slice.call(obj);
    };
    $.addControl = function (name, callback) {
        list[name] = callback;
    };
    $.bindControl = function (selector, name) {
        toArray(document.querySelectorAll(selector)).forEach(function (el, control) {
            control = el.hasAttribute('control') ? el.getAttribute('control').split(',') : [];
            if (control.indexOf(name) < 0) control.push(name);
            el.setAttribute('control', control.join(','));
        });
    };
    $.initControls = function () {
        toArray(document.querySelectorAll('[control]')).forEach(function (el, control, item) {
            item = $(el);
            control = el.getAttribute('control').split(',');
            control.forEach(function (name) {
                if (list.hasOwnProperty(name))
                    list[name](item);
            });
            el.removeAttribute('control');
        });
    };
})(jQuery);

(function ($) {
    $.api = new $.PortalApi();
    $.ejs.addHelper('api', $.api);
})(jQuery);

(function ($) {
    /**
     *
     * @param form
     * @returns {*}
     */
    $.PortalApi.prototype.account = function (form) {
        var method = form.password ? 'login' : 'registration';
        return this.request('api.account', method, form);
    };

    $.addControl('signup', function (element) {

        var render = function (template, data) {
            element.find('.panel').html($.ejs(template).render(data));
        };

        var success = function () {
            $.when(
                this.request('api.account.milestone', 'get', {})
            ).done(function (milestone) {
                render('/account', {
                    milestone: milestone
                });
            });
        };

        var submit = function (ev, form) {
            ev.preventDefault();
            form = $(this).serializeObject();
            $.api.account(form).fail(function (data) {
                render('/signup', {
                    login: true,
                    form: form,
                    error: data.error
                });
            }).done(function (data) {
                if (data.two_factor) {
                    render('/signup', {
                        login: true,
                        two_factor: true,
                        form: form
                    });
                } else {
                    success.call(this, data);
                }
            });
        };
        var toggle = function(){
            element.find('.panel').toggleClass('show').hasClass('show') &&
            $.api.scope(function () {
                this.session().fail(function () {
                    render('/signup', {login: false});
                }).done(success);
            });
        };
        $(document).on('click',function(ev){
            if(!element.has(ev.target).get(0)){
                element.find('.panel').removeClass('show');
            }
        });
        element.on('submit', 'form', submit);
        element.on('click', '.button.user', toggle);
    });

})(jQuery);


(function ($) {
    $.initControls();
})(jQuery);


(function ($) {


})(jQuery);