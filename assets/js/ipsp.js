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
            var frame = $('<iframe>').hide().attr('src', url).appendTo('body');
            this.connector = new $.Connector(frame.get(0).contentWindow);
            this.connector.action('load', $.proxy(this, 'ready'));
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
            if (this.created == false) {
                this.created = true;
                this.wrapper = $(this);
                this.frame(this.url('gateway')).then($.proxy(this, 'load'));
            }
            return this;
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

    $.ejs.addHelper('_', function (value) {
        return value;
    });

    $.ejs.addHelper('has', function (prop, value) {
        return this.def(this.attr(prop), '').indexOf(this.attr(value)) != -1;
    });

    $.ejs.addHelper('concat', function () {
        var args = Array.prototype.slice.call(arguments);
        args = args.map(function (name) {
            return this.attr(name);
        }.bind(this)).filter(function (item) {
            return item;
        });
        return args.length ? args.join('.') : '';
    });
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
            el.setAttribute('control-init', 'true');
            el.removeAttribute('control');
        });
    };
})(jQuery);

(function ($) {
    $.api = new $.PortalApi();
    $.ejs.addHelper('api', $.api);
})(jQuery);

(function ($) {

    $.PortalApi.prototype.account = function (form) {
        var method = form.password ? 'login' : 'registration';
        return this.request('api.account', method, form);
    };


    $.addControl('select.value', function (element) {
        element.val(element.attr('value'));
    });

    $.addControl('facebook.login', function (element) {
        location.replace($.api.url('facebook'));
    });

    $.addControl('social.login', function (element) {

        var width = 1100;
        var height = 690;
        var format = "scrollbars=0,resizable=0,menubar=0,toolbar=0,status=0,left={0},top={1},width={2},height={3}";
        var config = parse(format, (screen.width / 2) - (width / 2), (screen.height / 2) - (height / 2), width, height);
        var idle = null;
        var popup = null;
        var type = element.data('type');
        var url = $.api.url(type);

        function parse(string) {
            var args = Array.prototype.slice.call(arguments, 1);
            return string.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] != "undefined" ? args[number] : match
            });
        };

        function open(url) {
            popup = window.open(url, '', config);
            popup.focus();
            idle = setInterval(poll, 1000);
        };

        function poll() {
            if (popup.closed == true) {
                clearInterval(idle);
                complete();
            }
        };

        function complete() {
            $.api.scope(function(){
                this.request('api.account', 'check_auth', {}).done(function (response) {
                    if ('registration' in response) {
                        if (response.registration) {
                            location.assign('/activation/merchant.html');
                        } else {
                            location.assign('https://portal.fondy.eu/mportal/');
                        }
                    }
                });
            });
        };
        $.api.scope(function(){
            element.on('click', function (ev) {
                ev.preventDefault();
                $.trackEvent('social', 'auth', element.data('type'));
                open(url);
            });
        });
    });

    $.addControl('merchant', function (element) {
        var render = function (template, data) {
            element.html($.ejs(template).render(data));
            $.initControls();
        };
        var params = function () {
            return element.find('form').serializeObject();
        };
        var success = function (params) {
            $.api.request('api.merchant', 'country', params).done(function (merchant) {
                if (merchant.id) {
                    location.assign('/activation/settings.html');
                } else {
                    render('/merchant', {
                        merchant: merchant,
                        params: params
                    });
                }
            });
        };
        element.on('change', 'select', function () {
            success(params());
        });
        element.on('submit', function (ev) {
            ev.preventDefault();
            var form = params();
            form.jurtype = form.type;
            success(form);
        });
        $(window).on('api.authorize', function () {
            success(params());
        });
        $(window).on('api.logout', function () {
            render('/blank');
        });
        $.api.scope(function () {
            this.session().fail(function () {
                $(window).trigger('api.login');
            }).done(function () {
                success(params());
            });
        });
    });


    $.addControl('signup', function (element) {
        var loaded = false;
        var render = function (template, data) {
            element.find('.content').html($.ejs(template).render(data));
            $.initControls();
        };
        var complete = function () {
            loaded = true;
        };
        var success = function () {
            $.trackEvent('signup', 'show', 'account modal');
            $.when(
                this.request('api.account.milestone', 'get', {})
            ).done(function (milestone) {
                render('/account', {
                    milestone: milestone
                });
                $(window).trigger('api.authorize');
            });
        };
        var submit = function (ev, form) {
            ev.preventDefault();
            form = $(this).serializeObject();
            $.api.account(form).fail(function (data) {
                $.trackEvent('signup', 'error', data.error);
                render('/signup', {
                    login: true,
                    form: form,
                    error: data.error
                });
            }).done(function (data) {
                if (data.two_factor) {
                    $.trackEvent('signup', 'show', 'two factor dialog');
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
        var toggle = function () {
            var state = element.find('.panel').toggleClass('show').hasClass('show');
            $.trackEvent('signup', 'click', 'user button');
            console.log(state);
            if (state) {
                $.api.scope(function () {
                    this.session().fail(function () {
                        $.trackEvent('signup', 'show', 'signup modal');
                        render('/signup', {login: false});
                    }).done(success).always(complete);
                });
            }
        };
        var logout = function () {
            $.api.request('api.account', 'logout', {}).done(function (data) {
                $.trackEvent('signup', 'click', 'logout button');
                render('/signup', {login: false});
                $(window).trigger('api.logout');
            });
        };
        var recovery = function (ev) {
            ev.preventDefault();
            $.trackEvent('recovery', 'show', 'modal');
            $.api.request('api.account', 'forgot_password', element.find('form').serializeObject()).done(function (data) {
                $.trackEvent('recovery', 'message', 'Check your e-mail.');
                render('/signup', {login: true, error: 'Check your e-mail.'});
            }).fail(function (data) {
                $.trackEvent('recovery', 'error', data.error);
                render('/signup', {login: true, error: data.error});
            });
        };
        $(window).on('api.login', function () {
            toggle();
        });
        element.on('submit', 'form', submit);
        element.on('click', '.close', toggle);
        element.on('click', '.button.user', toggle);
        element.on('click', '.btn.recovery', recovery);
        element.on('click', '.btn.logout', logout);
    });

    $.addControl('signup.form', function (element) {
        var template = function (data) {
            return $.ejs('/email').render(data)
        };
        var error = function (data) {
            element.find('.form').addClass('hide');
            element.find('.message').removeClass('hide').html(data.error);
            $.trackEvent('registration', 'error', location.href);
        };
        var success = function () {
            element.find('.form').addClass('hide');
            element.find('.message').removeClass('hide');
            $(window).trigger('api.login');
            $.trackEvent('registration', 'success', location.href);
        };
        var submit = function (ev, params) {
            ev.preventDefault();
            params = element.find('.form').serializeObject();
            $.api.scope(function () {
                this.account(params).done(function () {
                    this.request('api.account', 'feedback', {
                        contacts: params.email,
                        message: template(params)
                    }).done(success).fail(error);
                }).fail(error);
            });
        };
        element.on('submit', 'form', submit);
    });
})(jQuery);

(function ($) {
    $('.page-content').append($.ejs('/user').render({}));
})(jQuery);

(function ($) {
    $.trackEvent = function (category, action, label, fieldObject) {
        if (typeof(window['ga']) !== 'function') return;
        ga('send', 'event', category, action, label, fieldObject || {});
    };
})(jQuery);

(function ($) {
    $.initControls();
})(jQuery);


(function ($) {
    return;
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'https://api.ipsp-php.com/checkout',
        data: {
            amount: '200',
            currency: 'EUR',
            order_desc: ' '
        }
    }).then(function (data) {
        console.log(data);
    });
})(jQuery);
