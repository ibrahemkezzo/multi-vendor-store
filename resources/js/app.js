import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
var channel = Echo.private(`App.Aodel.User.${userID}`);
channel.notification(function(data) {
  alert(data.body);
});
