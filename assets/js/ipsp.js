(function($){
    $.PortalApi = function(){
        this.init();
    };
    $.PortalApi.prototype = {
        gateway:'https://mpapi.dev.fondy.eu/mportal/#/connector/52',
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
        init:function(){
            this.wrapper = $(this);
            this.frame(this.gateway).then($.proxy(this,'load'));
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
    $.ejs.basePath = '/assets/ejs';
})(jQuery);

(function($){
    var api = new $.PortalApi();
    api.scope(function(){
        this.session().done(function(){
            this.request('api.merchant','list',{}).done(function(data){
                console.log('success',data);
            });
            this.request('api.merchant','payments',{}).done(function(data){

            });
        }).fail(function(){

        });
    });
})(jQuery);


(function($){




})(jQuery);