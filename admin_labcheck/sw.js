self.addEventListener("install", evt => self.skipWaiting());  // (A) INSTANT WORKER ACTIVATION
self.addEventListener("activate", evt => self.clients.claim()); // (B) CLAIM CONTROL INSTANTLY

if (self.location.href.includes('admin_labcheck')) {
  let isAdminSession = false;

  self.addEventListener("push", evt => {
    const data = evt.data.json();
    static_data = evt.data.json();

    fetch('session_check.php')
    .then(response => response.json())
    .then(session => {
      if (session.isAdmin) {
        isAdminSession = true;
          
          self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            image: data.image,
            badge: data.badge
          });
  
      } else {
        console.log('No active admin session');
      }    
    }).catch(error => console.error('Error checking session:', error));
  })

        self.addEventListener('notificationclick', function (event) {
          if (isAdminSession) {
            console.log('On notification click: ', event);
            event.notification.close();

            event.waitUntil(clients.matchAll({
              type: "window"
            }).then(function (clientList) {

              for (var i = 0; i < clientList.length; i++) {
                var client = clientList[i];
                if (client.url == static_data.onclic_url && 'focus' in client)
                  return client.focus();
              }
              if (clients.openWindow) return clients.openWindow(static_data.onclic_url);
            }));
          } else {
            console.log('No active admin session for notification click');
          }
        });
}
