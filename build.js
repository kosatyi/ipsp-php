var fs = require('fs-extra')
var exec = require('child_process').exec;

function execCommand(command,callback){
    exec(command,function (error, stdout, stderr){
        if(error) {
            console.error(stderr);
        }
        else {
            callback(stdout)
        }
    });
}

function logArgs(){
    console.log(arguments);
};

execCommand('git submodule update --recursive --force --remote',function(message){
    console.log(message);
    fs.copy('_jekyll/_data','_data',logArgs);
    fs.copy('_jekyll/_plugins','_plugins',logArgs);
    fs.copy('_jekyll/_layouts','_layouts',logArgs);
    fs.copy('_jekyll/_includes','_includes',logArgs);
    fs.copy('_jekyll/assets','assets',logArgs);
})


