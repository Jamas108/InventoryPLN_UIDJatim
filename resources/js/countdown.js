document.addEventListener('DOMContentLoaded', function() {
    function getRemainingTime(startDate, returnDate) {
        const now = new Date();
        const end = new Date(returnDate);
        const start = new Date(startDate);
        let timeDiff = end - now;
        if (now > end) return "Expired";
        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
        timeDiff -= days * (1000 * 60 * 60 * 24);
        const hours = Math.floor(timeDiff / (1000 * 60 * 60));
        timeDiff -= hours * (1000 * 60 * 60);
        const minutes = Math.floor(timeDiff / (1000 * 60));
        timeDiff -= minutes * (1000 * 60);

        return `${days}d ${hours}h ${minutes}m`;
    }

    function updateCountdown() {
        document.querySelectorAll('[data-countdown]').forEach(function(element) {
            const startDate = element.getAttribute('data-start-date');
            const returnDate = element.getAttribute('data-return-date');
            const remainingTime = getRemainingTime(startDate, returnDate);

            if (new Date() > new Date(returnDate)) {
                element.innerHTML = `<span class="h1 badge bg-danger custom-badge">Expired</span>`;
            } else {
                element.innerHTML = `<span class="badge bg-warning custom-badge">${remainingTime}</span>`;
            }
        });
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
