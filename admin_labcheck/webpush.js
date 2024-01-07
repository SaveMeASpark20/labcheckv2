if (Notification.permission === 'default') {
    Notification.requestPermission().then(perm => {
        if (Notification.permission === 'granted') {
            
        regWorker().catch(err => console.error(err));
        } else {
        alert("There's an error occured");
        }
    });
} 
else if (Notification.permission === 'granted') {
    regWorker().catch(err => console.error(err));
}

else { 
    alert("Notification Denied");
}
async function regWorker () {

    const publicKey = 'BBt4aeJUh0cO3PoGP_T8BKsM8QtggF4zYmWDNvSOtHqwa91VO8sQVqovNBXs-U7DxjczjMw4jeeFOX1pNGktc2c';

    navigator.serviceWorker.register('sw.js');

    navigator.serviceWorker.ready
    .then(reg => {
        console.log('subscribe to notification server');
    reg.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: publicKey
    }).then(sub => {
        console.log(sub);
        var data = new FormData();
        data.append('sub', JSON.stringify(sub));
        
        console.log('FormData entries:');
                for (const entry of data.entries()) {
                    console.log(entry[0]);
                    console.log(entry[1]);
                }
        fetch('../web_notif_server.php', { method: 'POST', body : data })
        .then(res => res.json())
        .then(txt => console.log(txt))
        .catch(err => console.error(err));
        },

        err => console.error(err)
    );
    });

}