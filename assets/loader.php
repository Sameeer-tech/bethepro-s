<style>
/* Loader Styles */
.loading {
    overflow: hidden;
}

.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
}

.loader-overlay.fade-out {
    opacity: 0;
}

.loader-text {
    color: white;
    font-size: 2rem;
    font-weight: bold;
    margin-top: 2rem;
    text-transform: none !important;
    letter-spacing: normal !important;
}

.loader-subtext {
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.5rem;
}

/* Newton's Cradle Animation */
.newtons-cradle {
    --uib-size: 50px;
    --uib-speed: 1.2s;
    --uib-color: #fff;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: var(--uib-size);
    height: var(--uib-size);
}

.newtons-cradle__dot {
    position: relative;
    display: flex;
    align-items: center;
    height: 100%;
    width: 25%;
    transform-origin: center top;
}

.newtons-cradle__dot::after {
    content: '';
    display: block;
    width: 100%;
    height: 25%;
    border-radius: 50%;
    background-color: var(--uib-color);
}

.newtons-cradle__dot:first-child {
    animation: swing var(--uib-speed) linear infinite;
}

.newtons-cradle__dot:last-child {
    animation: swing2 var(--uib-speed) linear infinite;
}

@keyframes swing {
    0% { transform: rotate(0deg); animation-timing-function: ease-out; }
    25% { transform: rotate(70deg); animation-timing-function: ease-in; }
    50% { transform: rotate(0deg); animation-timing-function: linear; }
}

@keyframes swing2 {
    0% { transform: rotate(0deg); animation-timing-function: linear; }
    50% { transform: rotate(0deg); animation-timing-function: ease-out; }
    75% { transform: rotate(-70deg); animation-timing-function: ease-in; }
}
</style>

<!-- Loader Overlay -->
<div class="loader-overlay" id="loader">
    <div class="newtons-cradle">
        <div class="newtons-cradle__dot"></div>
        <div class="newtons-cradle__dot"></div>
        <div class="newtons-cradle__dot"></div>
        <div class="newtons-cradle__dot"></div>
    </div>
    <div class="loader-text">BeThePro's</div>
    <div class="loader-subtext">Preparing your success journey...</div>
</div>

<script>
// Loader functionality
window.addEventListener('load', function() {
    const loader = document.getElementById('loader');
    const body = document.body;
    
    setTimeout(() => {
        loader.classList.add('fade-out');
        body.classList.remove('loading');
        
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }, 2000);
});
</script>
