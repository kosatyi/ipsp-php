const fs = require('fs-extra')
const exec = require('child_process').exec;

function execCommand(command,callback){
    exec(command,function (error, stdout, stderr){
        if(error) console.error(stderr);
        else {
            callback(stdout)
        }
    });
}


function moveDir(oldPath, newPath, callback) {
    console.log(fs);
    fs.copy(oldPath,newPath,callback);
}

function logArgs(){
    console.log(arguments);
};

execCommand('git submodule update --recursive --force --remote',function(message){
    console.log(message);
    moveDir('_jekyll/_data','_data',logArgs);
    moveDir('_jekyll/_plugins','_plugins',logArgs);
    moveDir('_jekyll/_layouts','_layouts',logArgs);
    moveDir('_jekyll/_includes','_includes',logArgs);
    moveDir('_jekyll/assets','assets',logArgs);
})


