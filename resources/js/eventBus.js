var Emitter = require('tiny-emitter');
window.events = new Emitter();

window.flash = function (message, status = 'success') {
    window.events.emit('flash', { message, status })
}

window.thankyou = function (data) {
    window.events.emit('thankyou', { data })
}