import "./bootstrap";
import.meta.glob(["../images/**"]);
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';


window.Echo.channel('notifications')
    .listen('NewNotification', (e) => {
        let badge = document.querySelector(`.nav-link[href="${window.notificationRoute}"] span.badge`);
        if (badge) {
            badge.textContent = parseInt(badge.textContent) + 1;
        } else {
            let span = document.createElement('span');
            span.className = 'badge badge-danger';
            span.textContent = '1';
            document.querySelector(`.nav-link[href="${window.notificationRoute}"]`).appendChild(span);
        }
    });
