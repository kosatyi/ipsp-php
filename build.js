var fse = require('fs-extra')
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

execCommand('git submodule update --recursive --force --remote',function( message ){
    console.log(message);
    fse.copy('_jekyll/_layouts','_layouts',logArgs);
    fse.copy('_jekyll/_includes','_includes',logArgs);
    fse.copy('_jekyll/assets','assets',logArgs);
})


