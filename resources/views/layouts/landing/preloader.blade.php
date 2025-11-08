<div class="preload preload-container">
    <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
        <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
        <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
        <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
        <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
    </svg>
</div>

<style>
/* Preloader Styles - Fixed Positioning */
.preload {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.95);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.preload-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

/* SVG Animation Styles */
.pl__ring {
    animation: bounce 1.6s ease-in-out infinite, pulse 2s ease-in-out infinite;
}

.pl__ring--a {
    stroke: #667eea;
    animation-delay: 0s, 0s;
}

.pl__ring--b {
    stroke: #764ba2;
    animation-delay: 0.2s, 0.2s;
}

.pl__ring--c {
    stroke: #f093fb;
    animation-delay: 0.4s, 0.4s;
}

.pl__ring--d {
    stroke: #f5576c;
    animation-delay: 0.6s, 0.6s;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-18px);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Hide preloader when page is loaded */
.preload.hide {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}
</style>

<script>
// Hide preloader when page is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Simulate loading time
    setTimeout(function() {
        const preloader = document.querySelector('.preload');
        if (preloader) {
            preloader.classList.add('hide');
            // Remove from DOM after transition
            setTimeout(function() {
                preloader.remove();
            }, 500);
        }
    }, 1000); // Adjust time as needed
});
</script>