(function(){
    this.toArray = function(value){
        return Array.prototype.slice.call(value);
    };
    this.find = function(selector){
        return toArray(document.querySelectorAll(String(selector)));
    };
})();

(function(){
    var href = location.href;
    find('[href],[data-rel]').filter(function(el,expr){
        expr = el.getAttribute('data-rel');
        return expr ? href.match(expr) : el.href ? href.indexOf(el.href) !== -1 : false;
    }).map(function(el){
        el.classList.add('active');
    });
})();