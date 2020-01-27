window.fileUpload = function fileUpload() {
    let file = document.getElementById('track_audioFile_file');
    file.click();
};


let file = document.getElementById('track_audioFile_file');
let cacheMisere = document.getElementById('cache_text');
let cacheButton = document.getElementById('cache_button')


file.onchange = function () {
    if (file.value !== '') {
        let songName = file.value.split('\\');
        cacheMisere.textContent = songName.pop();
        cacheMisere.className = "cache_text active_file";
        cacheButton.className = "cache_button active_file_button";
    }
};
