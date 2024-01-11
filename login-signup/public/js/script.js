function hideAlerts() {
    setTimeout(function () {
        document.getElementById('error').style.display = 'none';
    }, 3500);
    setTimeout(function () {
        document.getElementById('session-error').style.display = 'none';
    }, 3500);
    setTimeout(function () {
        document.getElementById('session-success').style.display = 'none';
    }, 3500);
}

window.onload = function () {
    hideAlerts();
};