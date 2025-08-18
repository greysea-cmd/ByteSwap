function checkNotifications() {
    fetch('/admin/api/check-notifications.php')
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge(data.length);
            if (data.length > 0) {
                playNotificationSound();
            }
        });
}

// Poll every 30 seconds
setInterval(checkNotifications, 30000);

// Update UI
function updateNotificationBadge(count) {
    const badge = document.getElementById('notification-badge');
    badge.textContent = count;
    badge.style.display = count > 0 ? 'block' : 'none';
}

// Play sound
function playNotificationSound() {
    new Audio('/assets/sounds/notification.mp3').play();
}