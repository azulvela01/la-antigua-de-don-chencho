<div class="alert alert-warning d-flex align-items-center mt-2 p-3 rounded-pill" role="alert" style="font-size: 0.9rem;">
    <svg class="bi flex-shrink-0 me-2" width="18" height="18" role="img" aria-label="Warning:">
        <use xlink:href="#clock-fill"/>
    </svg>
    <div>
        <strong>Demasiados intentos.</strong> Espera <span id="countdown" class="fw-bold">{{ $seconds }}</span> segundos...
    </div>
</div>

<!-- Icono de reloj (Bootstrap 5) -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="clock-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .207.407l2.5 1.5a.5.5 0 1 0 .492-.814L8 7.5V3.5z"/>
    </symbol>
</svg>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdownEl = document.getElementById('countdown');
        if (!countdownEl) return;

        let seconds = parseInt(countdownEl.textContent);
        const startTime = Date.now();

        // Guardar en sessionStorage
        sessionStorage.setItem('throttle_start', startTime);
        sessionStorage.setItem('throttle_duration', seconds);

        const interval = setInterval(() => {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            const remaining = seconds - elapsed;

            if (remaining <= 0) {
                clearInterval(interval);
                sessionStorage.removeItem('throttle_start');
                sessionStorage.removeItem('throttle_duration');
                document.querySelector('form').submit();
            } else {
                countdownEl.textContent = remaining;
            }
        }, 1000);
    });
</script>