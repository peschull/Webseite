document.addEventListener('DOMContentLoaded', function() {
    initializePodcastPlayers();
});

function initializePodcastPlayers() {
    const players = document.querySelectorAll('.mini-podcast-player');
    
    players.forEach(player => {
        const audio = player.querySelector('audio');
        const playButton = player.querySelector('.play-button');
        const playIcon = player.querySelector('.play-icon');
        const pauseIcon = player.querySelector('.pause-icon');
        const progressBar = player.querySelector('.progress-current');
        const progressSlider = player.querySelector('.progress-slider');
        const currentTime = player.querySelector('.current-time');
        const durationTime = player.querySelector('.duration-time');
        
        // Audio Event Listener
        audio.addEventListener('loadedmetadata', () => {
            progressSlider.max = audio.duration;
            durationTime.textContent = formatTime(audio.duration);
        });
        
        audio.addEventListener('timeupdate', () => {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = `${progress}%`;
            progressSlider.value = audio.currentTime;
            currentTime.textContent = formatTime(audio.currentTime);
        });
        
        audio.addEventListener('ended', () => {
            playIcon.style.display = 'block';
            pauseIcon.style.display = 'none';
            progressBar.style.width = '0%';
            progressSlider.value = 0;
            currentTime.textContent = '00:00';
        });
        
        // Play/Pause Button
        playButton.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playIcon.style.display = 'none';
                pauseIcon.style.display = 'block';
            } else {
                audio.pause();
                playIcon.style.display = 'block';
                pauseIcon.style.display = 'none';
            }
        });
        
        // Progress Control
        progressSlider.addEventListener('input', (e) => {
            const time = e.target.value;
            audio.currentTime = time;
            progressBar.style.width = `${(time / audio.duration) * 100}%`;
            currentTime.textContent = formatTime(time);
        });
    });
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
}
