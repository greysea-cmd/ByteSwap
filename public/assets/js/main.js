// Real-time price updates (like StockX)
async function fetchMarketPrice(model) {
    const response = await fetch(`/api/prices/${model}`);
    const data = await response.json();
    document.getElementById('market-price').textContent = `$${data.price}`;
}

// Form validation
document.getElementById('listing-form').addEventListener('submit', (e) => {
    const serial = document.getElementById('serial-number').value;
    if (!/^[A-Z0-9]{8,20}$/.test(serial)) {
        e.preventDefault();
        alert('Invalid serial number format!');
    }
});