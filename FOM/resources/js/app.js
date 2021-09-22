
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./components/WelcomeToVico/WelcomeToVico');
require('./components/Radio/Radio');
require('react-datepicker/dist/react-datepicker-cssmodules.css');
require('./components/Chat/Chat');
require('./components/Chat/ChatStatic');
require('./components/Notification/Notification');
require('./components/Communication/Communication');
require('./components/DenyModal/DenyModal');
require('./components/Atomic/templates/PaymentHistory/App');
require('./components/Atomic/pages/PaymentHistory/App');
require('./components/TransactionHistory/MonthCarousel');
require('./components/Atomic/organisms/CreatePreLogin/PreCreate');
require('./components/Invitation/Send/Send');
require('./components/Invitation/Accept/Accept');

// Segment tracking code
require('./vanilla/_tracking-actions.js');
require('./components/Atomic/templates/WebhookWhatsapp/WebhookWhatsapp');
require('./components/Atomic/templates/LandingPage/LandingPage');
require('./components/Atomic/pages/WebhookWhatsapp/WebhookWhatsapp');


