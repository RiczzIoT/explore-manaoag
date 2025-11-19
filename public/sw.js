
self.addEventListener('push', function(event) {
    const data = event.data.json();
    const title = data.title || 'Explore Manaoag';
    const options = {
        body: data.body,
        icon: data.icon || './images/manaoag-seal.png',
        badge: './images/manaoag-seal.png'
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});