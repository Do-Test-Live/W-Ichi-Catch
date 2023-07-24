// Function to detect if the user is browsing from a desktop device
function isDesktop() {
    const userAgent = navigator.userAgent;
    return !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent));
}

// Function to show an alert for desktop users
function showAlertForDesktop() {
    alert('Sorry, this website is not accessible from desktop devices. Please visit from a mobile device.');
    window.location.replace("https://www.google.com/");
}

// Check if the user is browsing from a desktop device and show the alert
if (isDesktop()) {
    showAlertForDesktop();
}
