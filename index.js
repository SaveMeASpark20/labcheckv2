if(document.querySelector('.notification')){
    var notifications = document.querySelector('.notification');

    notifications.addEventListener('animationend', function(event) {
        if (event.animationName === 'fadeOut') {
            // Remove the notification element from the DOM
            notifications.remove();
        }
    });
}