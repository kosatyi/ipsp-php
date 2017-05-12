var fs = require('fs');
var exec = require('child_process').exec;


function execCommand(command,callback){
    exec(command,function (error, stdout, stderr){
        if(error) console.error(stderr);
        else {
            callback(stdout)
        }
    });
}


function moveDir(oldPath, newPath, callback) {
    fs.rename(oldPath, newPath, function (err) {
        if (err) {
            if (err.code === 'EXDEV') {
                copy();
            } else {
                callback(err);
            }
            return;
        }
        callback();
    });
    function copy() {
        var readStream = fs.createReadStream(oldPath);
        var writeStream = fs.createWriteStream(newPath);
        readStream.on('error',callback);
        writeStream.on('error',callback);
        readStream.on('close',function(){
            fs.unlink(oldPath, callback);
        });
        readStream.pipe(writeStream);
    }
}

execCommand('git submodule update --recursive --force --remote',function(message){
    console.log(message);
    moveDir('_jekyll/_data','_data',function(){});
    moveDir('_jekyll/_plugins','_plugins',function(){});
    moveDir('_jekyll/_layouts','_layouts',function(){});
    moveDir('_jekyll/_includes','_includes',function(){});
    moveDir('_jekyll/assets','assets',function(){});
})


