var fs = require('fs');

function move(oldPath, newPath, callback) {
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
        readStream.on('error', callback);
        writeStream.on('error', callback);
        readStream.on('close', function () {
            fs.unlink(oldPath, callback);
        });
        readStream.pipe(writeStream);
    }
}

//git submodule update --recursive --force --remote

move('_jekyll/_data','_data',function(){});
move('_jekyll/_plugins','_plugins',function(){});
move('_jekyll/_layouts','_layouts',function(){});
move('_jekyll/_includes','_includes',function(){});
move('_jekyll/assets','assets',function(){});
