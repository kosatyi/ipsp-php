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

move('_jekyll/_data','_data',function(){});
move('_jekyll/_plugins','_plugins',function(){});
move('_jekyll/_layouts','_layouts',function(){});
move('_jekyll/_includes','_includes',function(){});
move('_jekyll/_assets','_assets',function(){});
move('_jekyll/_saas','_saas',function(){});
