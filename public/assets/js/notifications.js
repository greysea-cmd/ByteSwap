// WebSocket connection for real-time alerts
const notificationSocket = new WebSocket(`wss://${window.location.host}/admin/ws-notifications`);

notificationSocket.onmessage = (event) => {
    const notification = JSON.parse(event.data);
    
    // Show desktop notification
    if (Notification.permission === 'granted') {
        new Notification('ByteSwap Alert', {
            body: notification.message,
            icon: '/assets/images/logo-icon.png'
        });
    }
    
    // Play sound
    new Audio('/assets/sounds/alert.mp3').play();
    
    // Update badge count
    const badge = document.querySelector('.notification-badge');
    badge.textContent = parseInt(badge.textContent || 0) + 1;
};