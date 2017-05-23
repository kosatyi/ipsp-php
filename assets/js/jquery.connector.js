(function($){
    $.Connector = function( target ){
        this.window = $(window);
        this.target = target;
        this.window.on('message',this.proxy('router'));
        this.create();
    };
    $.Connector.prototype = {
        ns:'crossdomain',
        origin:'*',
        uniqueId  : 1 ,
        create:function(){
            this.element = $('<div>');
        },
        getUID:function(){
            return ++this.uniqueId;
        },
        action:function(action,callback){
            this.element.on([this.ns,action].join('.'),callback);
        },
        publish:function(action,data){
            this.element.trigger([this.ns,action].join('.'),[data]);
        },
        proxy:function(name){
            return $.proxy(this,name);
        },
        router:function(ev,response){
            ev = ev.originalEvent;
            try{
                response = JSON.parse(ev.data);
            } catch(e) {

            }
            if(response.action && response.data){
                this.publish(response.action,response.data);
            }
        },
        send:function(action,data){
            this.target.postMessage(JSON.stringify({
                action  : action ,
                data    : data
            }), this.origin );
        }
    };
})(jQuery);