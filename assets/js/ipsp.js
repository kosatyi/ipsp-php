(function($){
    $.PortalApi = function(){
        this.init();
    };
    $.PortalApi.prototype = {
        //origin:'https://mpapi.dev.fondy.eu',
        origin:'https://portal.fondy.eu',
        endpoint:{
            portal  : '/mportal',
            gateway : '/mportal/#/connector/52',
            google  : '/api/account/registration/google/',
            facebook: '/api/account/registration/facebook/',
            linkedin: '/api/account/registration/linkedin/'
        },
        loaded : false ,
        frame:function(url){
            var defer = this.defer();
            $('<iframe>').hide().attr('src',url).appendTo('body').on('load',function(ev){
                defer.resolve(this);
            }).on('error',function(){
                defer.reject(this);
            });
            return defer;
        },
        url:function(type,url){
            return this.origin.concat(this.endpoint[type]||'/').concat(url||'');
        },
        init:function(){
            this.wrapper = $(this);
            this.frame(this.url('gateway')).then($.proxy(this,'load'));
        },
        load:function(frame){
            this.connector = new $.Connector(frame.contentWindow);
            this.connector.action('load',$.proxy(this,'ready'));
        },
        ready:function(ev,data){
            this.loaded = true;
            this.wrapper.trigger('portal.api').off('portal.api');
        },
        scope:function(callback){
            if( this.loaded ) return callback.call(this);
            else this.wrapper.on('portal.api', $.proxy(callback,this) );
        },
        defer:function(){
            return $.Deferred();
        },
        request:function(model,method,params){
            var defer   = this.defer();
            var data    = {};
            data.uid    = this.connector.getUID();
            data.action = model;
            data.method = method;
            data.params = params || {};
            this.connector.send('request',data);
            this.connector.action(data.uid,$.proxy(function( ev , response ){
                defer[ response.error ? 'rejectWith' : 'resolveWith' ]( this , [ response ] );
            },this));
            return defer;
        },
        session:function(){
            return this.request('api.account','check');
        }
    };
})(jQuery);

(function($){
    $.ejs.basePath = '/assets/html';
})(jQuery);

(function($){
    var list = {};
    var toArray = function(obj){
        return Array.prototype.slice.call(obj);
    };
    $.addControl = function(name,callback){
        list[name] = callback;
    };
    $.bindControl = function(selector,name){
        toArray(document.querySelectorAll(selector)).forEach(function(el,control){
            control = el.hasAttribute('control') ? el.getAttribute('control').split(',') : [];
            if(control.indexOf(name)<0)  control.push(name);
            el.setAttribute('control',control.join(','));
        });
    };
    $.initControls = function(){
        toArray(document.querySelectorAll('[control]')).forEach(function(el,control,item){
            item    = $(el);
            control = el.getAttribute('control').split(',');
            control.forEach(function(name){
                if(list.hasOwnProperty(name))
                    list[name](item);
            });
            el.removeAttribute('control');
        });
    };
})(jQuery);

(function($){
    $.api = new $.PortalApi();
    $.ejs.addHelper('api',$.api);
})(jQuery);

(function($){

    $.PortalApi.prototype.account = function(email,password){
        var method = password ? 'login' : 'registration';
        return this.request('api.account',method,{
            email:email,
            password:password
        });
    };

    $.addControl('signup',function(element){
        var template = $.ejs('/signup');
        var render   = function(data){
            element.html(template.render(data));
        };
        var submit   = function(ev,form){
            ev.preventDefault();
            form = new FormData(this);
            $.api.account(form.get('email'),form.get('password')).fail(function(data){
                render({
                    login: true ,
                    email: form.get('email'),
                    error: data.error
                });
            }).done(function(){
                this.request('api.account.milestone','get',{}).done(function(data){
                    element.html($.ejs('/account').render({
                        milestone:data
                    }));
                });
            });
        };
        element.on('submit','form',submit);
        $.api.scope(function(){
            this.session().fail(function(){
                render({login:false});
            }).done(function(){
                this.request('api.account.milestone','get',{}).done(function(data){
                    element.html($.ejs('/account').render({
                        milestone:data
                    }));
                });
            });
        });
    });

})(jQuery);


(function($){
    $.initControls();
})(jQuery);




(function($){




})(jQuery);