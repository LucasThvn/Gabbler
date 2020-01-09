const songs = ['if_i_go.mp3',
                'little_lion_man.mp3',
                'jaguar.mp3',
];



let audio = new Audio();


let currentSong = 1;


let seekBar = document.querySelector('.seek-bar');
let playButton = document.querySelector('button.play');
let fillBar = seekBar.querySelector('.fill');
let durationSong = document.querySelector('.duration');
let currentTimeSong = document.querySelector('.current_time');
let currentPlaySong = document.getElementById(currentSong.toString());
let mouseDown = false;

audio.src = "../build/audio/" + songs[currentSong - 1];


window.changeCurrentSong =  function changeCurrentSong (number) {
    if (audio.paused && number !== currentSong) {
        currentPlaySong = document.getElementById(currentSong.toString());
        currentPlaySong.className = "play_song";
        currentSong = number;
        audio.src = "../build/audio/" + songs[currentSong - 1];
        audio.play();
    } else if (audio.played && number !== currentSong){
        currentPlaySong = document.getElementById(currentSong.toString());
        currentPlaySong.className = "play_song";
        currentSong = number;
        audio.src = "../build/audio/" + songs[currentSong - 1];
        audio.play();
    }else if (audio.paused && number === currentSong){
        audio.play();
    } else {
        currentPlaySong = document.getElementById(currentSong.toString());
        currentPlaySong.className = "pause_song";
        audio.pause();
    }

    currentPlaySong = document.getElementById(currentSong.toString());
    audio.addEventListener('play', function () {
        currentPlaySong.className = 'song pause_song'

    });

    audio.addEventListener('pause', function () {
        currentPlaySong.className = 'song play_song'
    });
};


playButton.addEventListener('click', function () {
    if (audio.paused) {
        if (currentSong == 1) {
            currentPlaySong.className = 'song pause_song';
        }
        audio.play();
    } else {
        if (currentSong == 1) {
            currentPlaySong.className = 'song play_song'
        }
        audio.pause();
    }
});

audio.addEventListener('play', function () {
    playButton.className = 'pause';
});

audio.addEventListener('pause', function () {
    playButton.className = 'play';
});


function convertToTime (timeSong) {
    let current = function(num, size) { return ('000' + num).slice(size * -1); },
        time = parseFloat(timeSong).toFixed(3),
        minutes = Math.floor(time / 60) % 60,
        seconds = Math.floor(time - minutes * 60);
    return current(minutes, 1) + ':' + current(seconds, 2);
}

audio.addEventListener('timeupdate', function () {
    if (mouseDown) return;

    let p = audio.currentTime / audio.duration;

    fillBar.style.width = p * 100 + '%';

    let c = Math.round(audio.currentTime);

    let d = Math.round(audio.duration);

    currentTimeSong.textContent = convertToTime(c);

    durationSong.textContent = convertToTime(d);
});

function clamp (min, val, max) {
    return Math.min(Math.max(min, val), max);
}

function getP (e) {
    let p = (e.clientX - seekBar.offsetLeft) / seekBar.clientWidth;
    p = clamp(0, p, 1);

    return p;
}

seekBar.addEventListener('mousedown', function (e) {
    mouseDown = true;

    let p = getP(e);

    fillBar.style.width = p * 100 + '%';
});

window.addEventListener('mousemove', function (e) {
    if (!mouseDown) return;

    let p = getP(e);

    fillBar.style.width = p * 100 + '%';
});

window.addEventListener('mouseup', function (e) {
    if (!mouseDown) return;

    mouseDown = false;

    let p = getP(e);

    fillBar.style.width = p * 100 + '%';

    audio.currentTime = p * audio.duration;
});



