<?php
use App\Events\MessageWasReceived;
use App\Message;

/**
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 **/

// Route::get( //Ruta para acceder al homemate
//     '/home',
//     'HomeController@index'
// )->name('home');

// Route::group(
//     [
//         'middleware' => [
//             'web'
//         ]
//     ], function() {
//         Route::get('home', 'HomeController@index')->name('home');
//     }
// );
// Route::get('/home', 'HomeController@index')->name('home'); //Ruta para acceder al homemate
/**
 * Landing page
 */
Route::get('', 'HomeController@index')->name('home');
Route::get('/bogota/alojamiento-habitaciones-estudiantes', 'HomeController@bogota')->name('landingpage.bogota');

// Rutas para sitemaps for SEO
Route::get('/sitemapindex.xml', 'SitemapController@index');
Route::get('/sitemap.xml', 'SitemapController@index');
Route::get('/sitemap/information.xml', 'SitemapController@information');
Route::get('/sitemap/houses.xml', 'SitemapController@houses');

/**
 * Rutas para la autenticación
 **/
Auth::routes();

/**
 * Ruta index
 */
//Route::get('/houses', 'HouseController@index')->name('index'); //Ruta principal de la aplicación

/**
 * Rutas para los usuarios, costumers y homemates
 */
Route::get('/users', 'UserController@index')->middleware('role');
Route::get('/users/{user}', 'UserController@show');
Route::get('/users/{user}/active', 'UserController@showActive')->middleware('auth'); //Show active users for discounts
Route::get('/user/create/{flag}', 'UserController@create');
Route::get('/user/managerRegister/{id}', 'UserController@managerRegister');
Route::get('/users/search/{request}', 'UserController@searchUsers')->middleware('role');
Route::get('/users/edit/{id}', 'UserController@adminEditUser')->name('admin_user_edit')->middleware('role');
Route::get('/lazyUsers', 'UserController@getLazyUsers')->name('lazy_users')->middleware('role');
Route::get('/lazyManagers', 'UserController@getLazyManagers')->name('lazy_managers')->middleware('role');

Route::post('/users/update', 'UserController@update');
Route::post('/users/newUser', 'Controller@newUser');

Route::post('/users/updateRole/{user}','UserController@resetPassword')->name('reset.user.password');#->middleware('role');

Route::post('/manager/notify/photoshoot', 'Controller@notifyPhotoshootToManager')->name('notify.photoshoot');
Route::post('/manager/notify/whatsapp/photoshoot', 'Controller@notifyPhotoshootToManagerWhatsapp')->name('notify.photoshoot.whatsapp');
Route::post('/manager/notify/postedphotos', 'Controller@notifyPostedPhotosToManager')->name('notify.postedfotos');



/**
 * Rutas para los vicoReferrals
 */
Route::post('/usesreferrals/update','VicoReferralController@usesUpdate')->name('referrals.update');
Route::get('/usesreferrals','VicoReferralController@usesIndex')->name('referrals.uses');
Route::resource('vicoreferrals', 'VicoReferralController');
Route::post('/vicoreferral/check', 'VicoReferralController@validateVicoCode')->name('referrals.check');

/**
 * Rutas para los descuentos con MIEO
 */
Route::get('/discounts/mieo', 'DiscountController@discountCodeMieo');
Route::get('/mails/welcome', 'NewsletterController@sendWelcomeMail');
Route::get('/mails/sorry', 'NewsletterController@sendSorryMail');

Route::post('/addCity', 'Controller@addCity');
Route::post('/addNeighborhood', 'Controller@addNeighborhood');
Route::post('/users/completeRegisterManager', 'UserController@completeRegisterManager');
Route::get('/roomDatesBooking/{room_id}', 'Controller@roomDatesBooking');
Route::get('/myhouses', 'Controller@myVicos')->name('my_houses');
Route::post('/setPreferences','Controller@setUserPreferences')->name('set_preferences');

/**
 * Customer's application route resource
 */
Route::get('/customers', 'CustomerController@index');
Route::get('/customers/{customer}', 'CustomerController@show');
Route::post('/customers/{customer}', 'CustomerController@create');
Route::put('/customers/{customer}', 'CustomerController@edit');

/**
 * Homemate's applciation routes
 */
Route::get('/homemate/create/{flag}', 'HomemateController@create');
Route::post('/homemate/store', 'HomemateController@store');

/**
 * Translation route
 */
Route::post('/translate','TranslateController@translateText')->name('translate');

/**
 * Rutas para las casas
 */
Route::get('/vicos/unal','PartnersLandingpagesController@landingUnal')->name('landing.unal');
Route::get('/vicos/{city}','HouseController@indexNew')->name('houses.index')/*->name('houses.index')*/;
Route::get('/houses/introduction/{flag}', 'HouseController@init')->name('introduction');
Route::get('/houses/{house}', 'HouseController@show')->name('show_house');
Route::get('/houses/map/{house_id}', 'HouseController@createNew')->name('create_house');
Route::get('/houses/createNew/{flag}', 'HouseController@create');
Route::get('/houses/edit/{house}', 'HouseController@edit');
Route::post('/houses/edit/post', 'HouseController@editMailRequest');
Route::get('/houses/searchAll/{string}', 'HouseController@searchAll');
Route::get('/addvico', 'HouseController@initPreCreate')->name('publish_intro');
Route::get('/houses/housedata/{house}/{id}', 'HouseController@housedata');
Route::get('/houses/finalization/{house}', 'HouseController@finish')->name('house.finish');
Route::get('/houses/create/{flag}', 'HouseController@getMapStep')->name('create'); /*Create */
Route::get('/houses/verifyHouse/{name}/{address}', 'HouseController@verifyHouse');
Route::get('/vicos/{city}/search', 'HouseController@searchNew')->name('search');
Route::post('/houses/store', 'HouseController@storeNew');
Route::post('/houses/storeNew', 'HouseController@store');
Route::post('/houses/delete/{id}', 'HouseController@destroy');
Route::post('/houses/update', 'HouseController@update');
Route::post('/houses/postMap', 'HouseController@postMapStep')->name('post_map'); //Create map
Route::get('/houses/favorites/{user}', 'FavoriteController@getFavoritesUser')->name('favorites');
Route::post('/houses/favorites/post', 'FavoriteController@store');
Route::delete('/houses/favorites/delete', 'FavoriteController@deleteFavorite');
Route::post('/houses/updateStatusHouse', 'HouseController@updateStatusHouse');

/**
 * Rutas para las habitaciones
 */
Route::get('/rooms/create/{id}', 'RoomController@create');
Route::get('/rooms/createNew/{id}', 'RoomController@createNew')->name('rooms.create');
Route::get('/rooms/editNew/{id}', 'RoomController@editNew');
Route::get('/rooms/reservation/{room}', 'RoomController@reservation');
Route::get('/rooms/edit/{id}', 'RoomController@edit');
Route::get('/reserve/success/{id}', 'RoomController@reserveSuccess')->name('booking.success');
Route::post('/rooms/store', 'RoomController@store');
Route::post('/rooms/storeNew', 'RoomController@storeNew');
Route::post('/rooms/updateNew', 'RoomController@updateNew');
Route::post('/rooms/reserve', 'RoomController@reserve');
Route::post('/rooms/update', 'RoomController@update');
Route::post('/rooms/delete/{id}', 'RoomController@destroy');
Route::post('/rooms/updatePriceRoom', 'RoomController@updatePriceRoom');
Route::get('/rooms/roomdata/{room}', 'RoomController@roomdata');
Route::get('/rooms/roomBookingData/{room}', 'RoomController@roomDataBooking');


/**
 * Rutas para los bookings
 */
Route::get('/booking', 'BookingController@index');
Route::get('/booking/search/{request}', 'BookingController@searchBooking')->middleware('role');
Route::get('/booking/confirmed', 'BookingController@indexConfirmedBookings')->middleware('role')->name('bookings.confirmed.index');

Route::get('/booking/user', 'BookingController@userIndex')->name('bookings_user'); //show users bookings
Route::get('/booking/confirmed/user', 'BookingController@userIndexMyStays')->name('bookings.confirmed.user'); //show users bookings
Route::get('/booking/admin/user/{id}', 'BookingController@adminBookingsPerUser')->name('bookings.per.user');
Route::get('/booking/admin/{id}', 'BookingController@adminIndex')->name('bookings_admin'); //index with admin's bookings
Route::get('/booking/create', 'BookingController@create');
Route::get('/booking/delete/{id}', 'BookingController@destroy');
Route::get('/booking/show/{booking}', 'BookingController@show')->name('bookings.manager.show');
Route::get('/booking/user/{booking}', 'BookingController@userView')->name('bookings.user.show');
Route::get('/booking/print/{id}', 'BookingController@printConfirmation')->name('print.confirmation.user');
Route::get('/booking/manager/print/{id}', 'BookingController@printConfirmationManager')->name('print.confirmation.manager');
Route::get('/booking/screenshot/{id}', 'BookingController@screenshot'); /*->middleware('role')*/
Route::post('/booking/screenshot/process', 'BookingController@screenProcess'); /*->middleware('role')*/ //process booking's screenshot
Route::post('/booking/screenshot/load', 'BookingController@screenLoad'); //load a screenshot
Route::post('/booking/store', 'BookingController@store'); // create a booking
Route::post('/booking/update', 'BookingController@update'); // update a booking
Route::post('/booking/acepted', 'BookingController@accepted'); // when admin accepted a student
Route::post('/booking/reserved', 'BookingController@reserved'); //when student get time to pay by admin
Route::post('/booking/denied', 'BookingController@denied'); //when admin dennied a student
Route::post('/booking/time', 'BookingController@timeRequest'); //when student request time to pay
Route::post('/booking/cancel', 'BookingController@cancel'); // when student cancel a booking
Route::post('/booking/cancelrequest/user', 'BookingController@cancelRequest')->name('cancel.request.user'); // when student cancel a booking already payed
Route::post('/booking/cancelrequest/manager', 'BookingController@cancelRequest')->name('cancel.request.manager'); // when manager cancel a booking already payed
Route::get('/booking/cancelrequest/user/{booking}', 'BookingController@cancelRequestUser')->name('booking.cancel.request.user'); // when manager cancel a booking already payed
Route::get('/booking/cancelrequest/manager/{booking}', 'BookingController@cancelRequestManager')->name('booking.cancel.request.manager'); // when manager cancel a booking already payed
Route::post('/booking/cancelNotify/user', 'BookingController@cancelNotify')->name('cancel.notify.user');
Route::post('/booking/cancelNotify/manager', 'BookingController@cancelNotify')->name('cancel.notify.manager');
Route::post('/booking/updateDateTo', 'BookingController@updateDateTo'); // when student cancel a booking
Route::post('/booking/refresh_messages', 'BookingController@refreshMessages');
Route::post('/booking/showPhoneNumber', 'BookingController@showPhoneNumber');
Route::get('/booking/confirmed/export/all', 'BookingController@confirmedBookingsCsv')->name('bookings.confirmed.export.csv');
/**
 * Rutas de notificaciones
 */
Route::get('/notifications', 'MessagesController@getNotifications');
Route::post('/notifications/update', 'MessagesController@updateNotification');
Route::get('/notification', 'NotificationController@UserBookingNotifications')->middleware('web')->name('vico.process');
Route::get('/bookings/manager_notifications/{booking}','NotificationController@managerBookingsNotifications')->middleware('role')->name('vico.manager.process');
Route::get('/bookings/student_notifications/{booking}','NotificationController@studentBookingsNotifications')->middleware('role')->name('vico.student.process');
/**
 * Rutas para el chat
 */
Route::post('/message/post', 'MessagesController@store');
Route::post('/message/update', 'MessagesController@update');


/**
 * Rutas para administrador
 */

// Route::group(['middleware' => 'role'], function() {
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/jeffboard', 'Controller@jeffboard');
    Route::post('/admin/update', 'AdminController@destroy');
    Route::get('/dashboard', 'AdminController@dashboardForAdmin')->name('dashboardForAdmin');
    // });
    route::get('/admin/whatsapp','AdminController@whatsappBoard')->name('dashboard.whatsapp');

/**
 * Rutas get de la review
 */
Route::get('/redirect/{id}/role/{role}', 'BookingController@redirectReview')->name('redirect_review');
Route::get('/booking/{id}/review', 'BookingController@getReview')->name('get_user_review');
Route::get('/booking/{id}/review/manager', 'BookingController@getReviewManager')->name('get_manager_review');


/**
 * Rutas post para la review
 */
Route::post('/booking/review/{booking}', 'BookingController@postReview')->name('post_user_review');
Route::post('/booking/review/manager/{booking}', 'BookingController@postReviewManager')->name('post_manager_review');

/**
 * Rutas get para los comentarios
 */
Route::get('/booking/{id}/review/manager_comment', 'BookingController@getReviewManagerComment')->name('get_manager_comment'); //user
Route::get('/booking/{id}/review/fom_comment', 'BookingController@getReviewFomComment')->name('get_fom_comment_user'); //user
Route::get('/booking/{id}/review/manager/private_comment/{manager_id}', 'BookingController@getManagerReviewPrivateComment')->name('get_private_comment'); // manager
Route::get('/booking/{id}/review/manager/fom_comment/{manager_id}', 'BookingController@getManagerReviewFomComment')->name('get_fom_comment'); //manager


/**
 * Rutas post para los comentarios
 */
Route::post('/booking/review/manager_comment/{booking}', 'BookingController@postReviewManagerComment')->name('post_manager_comment');
Route::post('/booking/review/fom_comment/{booking}', 'BookingController@postReviewFomComment')->name('post_fom_comment_user');
Route::post('/booking/review/manager/private_comment/{booking}', 'BookingController@postManagerReviewPrivateComment')->name('post_private_comment');
Route::post('/booking/review/manager/fom_comment/{booking}', 'BookingController@postManagerReviewFomComment')->name('post_fom_comment');

/**
 * Review Admin
 */
Route::get('/review/admin/all', 'BookingController@getAdminReviews')->name('admin_reviews');
Route::get('/review/admin/{id}', 'BookingController@adminIndex')->name('admin_reviews'); //index with admin's booking
Route::get('/review/user', 'BookingController@userIndexReviews')->name('user_reviews');



/**
 * Users Routes
 */
Route::get('/useredit/{id}', 'UserController@showEdituser')->name('profile');
Route::get('/review/general/{id}', 'ReviewController@showReview');
Route::get('/review/fom/{id}', 'ReviewController@showFomComment');
Route::get('/user/verification', 'UserController@userVerification')->name('my_verifications');
Route::get('/review/general/{id}', 'ReviewController@showReview');
Route::get('/review/fom/{id}', 'ReviewController@showFomComment');
Route::get('/profile/{id}', 'UserController@showProfile');
Route::post('/userUpdate/personalData', 'UserController@UpdatePersonalData');
Route::post('/userUpdate/password', 'UserController@UpdatePassword');
Route::post('/userUpdate/delete', 'UserController@destroy');
Route::post('/userUpdate/role', 'UserController@updateMyRole')->name('user.update.role');
Route::post('/userUpdate/profileImage', 'UserController@UpdateProfileImage');
Route::post('/userUpdate/description', 'UserController@UpdateDescription');
Route::post('/userUpdate/channel', 'UserController@ChangeChannel');
Route::get('/user/referrals','UserController@userReferral')->name('my_referrals');
Route::post('/user/changePayment', 'UserController@changePaymentMethod');

/**
 * Rutas de funciones generales
 */

/**
 * Rutas de funciones legales como el contrato y los terminos y condiciones 
 */
//Crear una nueva versión
Route::get('/termsandconditions/create', 'TermsAndConditionsController@createNewVersion')->name('termsandconditions.createnewversion'); 
//Store new version 
Route::post('/termsandconditions/storenewversion', 'TermsAndConditionsController@storeNewVersion')->name('termsandconditions.storenewversion'); 
//show the last version of the TyC
Route::get('/termsandconditions/version/{id}', 'TermsAndConditionsController@showLastVersion')->name('termsandconditions.showlastversion');
 //ask if user has accepted the TyCs
Route::get('/termsandconditions/update', 'TermsAndConditionsController@updateTermsAndConditionsUser');
//When user confirms save his response
Route::post('/termsandconditions/store', 'TermsAndConditionsController@store'); 
//Create automatically the contract
Route::get('termsandconditions/contract/download/{id}', 'TermsAndConditionsController@downloadContractPDF')->name('download.contract.pdf'); 

// Questions Controller to show FAQs
Route::get('/questions/user', 'QuestionController@showUserFAQ')->name('questions.user');
Route::get('/questions/host', 'QuestionController@showHostFAQ')->name('questions.host');


Route::get('/schools/json', 'SchoolController@indexjson');
Route::post('/multilanguage/change', 'Controller@multilanguageUpdate');
Route::get('/countries.json', 'Controller@countriesJson');
Route::get('/test', 'TestController@index');
Route::get('/test/getCoordinates/{id}', 'TestController@getCoordinatesHouse');
Route::get('/test/updateNeigborhoods/{house_id}/{neighborhood}/{city}/{country}', 'TestController@updateNeigborhoods');
Route::get('/test/2', 'TestController@index_test');
Route::post('/test/store', 'TestController@store');
Route::get('lang/{lang}', 'LanguageController@change')->middleware('web')->name('change_lang');


/**
 * Rutas para el nuevo edit
 */
Route::get('/houses/editnew/{house}', 'EditNewController@show')->name('edit_show');
Route::get('/houses/editnew/change/{house}', 'EditNewController@change');
Route::get('/houses/editnew/images/{house}', 'EditNewController@images');
Route::get('/houses/editnew/manager/{house}/{user}', 'EditNewController@manager');
// Route::get('/houses/editnew/bookings/{booking}', 'EditNewController@bookings');
Route::get('/houses/editnew/vico/{house}', 'EditNewController@vico');
Route::get('/houses/editnew/devices/{house}', 'EditNewController@devices');
Route::get('/houses/editnew/rules/{house}', 'EditNewController@rules');
Route::get('/houses/editnew/change', 'EditNewController@storeChange');
Route::post('/houses/editnew/images', 'EditNewController@storeImages');
Route::post('/houses/editnew/images/delete', 'EditNewController@deleteImages');
Route::post('/houses/editnew/images/store', 'EditNewController@storeImages');
Route::post('/houses/editnew/images/update', 'EditNewController@update');
Route::post('/houses/editnew/manager', 'EditNewController@storeManager');
// Route::put('/houses/editnew/bookings', 'EditNewController@storeBookings');
Route::post('/houses/editnew/vico', 'EditNewController@storeVico')->name('post_house_description');
Route::post('/houses/editnew/devices/store', 'EditNewController@storeDevices')->name('post_house_devices');
Route::post('/houses/editnew/rules/store', 'EditNewController@storeRules')->name('post_house_rules');
Route::post('/houses/editnew/getBookingInfo', 'EditNewController@getInfoBooking');
Route::post('/houses/editnew/makeRoomAvailable', 'EditNewController@makeRoomAvailable')->name('makeRoomAvailable');
Route::get('/houses/editnew/devices/ajax', 'EditNewController@getAjax');
Route::post('/houses/editnew/devices/ajax', 'EditNewController@postajax')->name('post_house_devicesajax');
Route::post('/houses/editnew/newHomemate', 'EditNewController@newHomemate');
Route::post('/houses/editnew/updateHomemate', 'EditNewController@updateHomemate');
Route::post('/houses/editnew/eraseRoomie', 'EditNewController@eraseRoomie');

/**
 * Complain Routes
 */
Route::post('/complainUser/store', 'BookingController@userComplain')->name('save_complain_user');
Route::post('/complainBooking/store', 'BookingController@bookingComplain')->name('save_complain_booking');

/**
 * Notifications routes
 */
Route::get('/notifications', 'NotificationController@index');
Route::get('/notifications/daily', 'NotificationController@getDaily');
Route::get('/notifications/weekly', 'NotificationController@getWeekly');
Route::get('/notifications/monthly', 'NotificationController@getMonthly');

/**
 * Ruta para la suscripcion a emails
 */
Route::get('/emails/unsubscribe/{id}', 'SubscriptionController@emailUnsubscribe');
Route::post('/emails/unsubscribe/store', 'SubscriptionController@emailUnsubscribeStore');

/**
 * OAuth Routes
 */
Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('oauth_login');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('oauth_callback');
Route::get('/login/{social}', 'Auth\LoginController@socialLogin')->where('social', 'twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'twitter|facebook|linkedin|google|github|bitbucket');
Route::post('/post/message', 'MessagesController@store')->name('post_message');
Route::get('/get/message', 'MessagesController@get');
Route::get('/status/message/{id}', 'MessagesController@updateReadStatus');

/**
 * Ruta para enviar el correo de contacto desde el usuario
 */
Route::post('/post/contact', 'MailController@postContact')->name('contact');

/**
 * Ruta para verificar los datos del usuario
 */
Route::get('/verification/phonecode', 'VerificationsController@SendPhoneVerificationCode');
Route::get('/verification/whatsappcode', 'VerificationsController@SendWhatsappVerificationCode');
Route::get('/verification/email', 'VerificationsController@EmailValidationSend');
// Route::get('/verification/id/{id}','VerificationsController@IdValidation');
Route::get('/verification/id', 'UserController@IdValidation')->middleware('role')->name('verfication.id');
Route::post('/verification/id/process', 'UserController@IdValidationProcces');
/**
 * User vertification Routes
 */
Route::post('/verification/verify-code', 'VerificationsController@VerifyCode');
Route::get('/emails/validate/{encrypted}', 'VerificationsController@EmailValidationStore');
Route::post('/verification/upload-identification', 'VerificationsController@UploadIdentification');
Route::get('/email/sended', 'VerificationsController@index');

/**
 * Rutas para el manejo de las fechas
 */
Route::resource('bookingdate', 'BookingDateController');
Route::get('bookingdate/user/{booking_id}', 'BookingDateController@userEdit')->name('bookingdate.getUser');
Route::get('bookingdate/manager/{booking_id}', 'BookingDateController@managerEdit')->name('bookingdate.getManager');
Route::post('bookingdate/user/{booking_date_id}', 'BookingDateController@updateUser')->name('bookingdate.user');
Route::post('bookingdate/manager/{booking_date_id}', 'BookingDateController@updateManager')->name('bookingdate.manager');


/**
 * Rutas para el sistema de pagos
 */
// Route::get('/payments/{booking}', 'PaymentsController@show');//no existe este metodo
Route::get('/payments/sepa/{booking}', 'PaymentsController@showSepa'); // no existe este metodo
Route::get('/payments/index/{id}', 'PaymentsController@index')->name('get_payment_index'); //no existe este metodo
Route::post('/payments/pay', 'PaymentsController@storeCard'); // no existe el metodo
Route::post('/payments/pay/sepa', 'PaymentsController@storeSepa'); // no existe el metodo
Route::get('/vico/payments/{id}', 'PaymentsController@cardPaymentGet')->name('get_card_payment');  // listo
Route::post('/vico/payments/card', 'PaymentsController@storeCard')->name('post_card_payment'); //no existe el mentodo
Route::get('/payments/user/{id}', 'PaymentsController@getPaymentsUser')->middleware('payments_auth')->name('payments_user');
Route::get('/payments/change/{id}', 'PaymentsController@getChangeMethod')->middleware('payments_auth')->name('payments_change'); // listo
Route::get('/payments/add/{id}', 'PaymentsController@getAddMethod')->middleware('payments_auth')->name('payments_add'); //listo
Route::get('/payments/admin/{id}', 'PaymentsController@getAdminPayments')->middleware('payments_auth')->name('payments_admin'); // listo
Route::get('/payments/notifyPendingPayments/{id}', 'PaymentsController@notifyPendingPayments');  // no tiene vista
Route::get('/payments/confirmation/{payment}', 'PaymentsController@confirmation')->name('payments_confirmation')->middleware('payment_confirmation'); // listo
Route::get('/verifyPassword/{id}', 'PaymentsController@getPasswordView')->name('getPasswordView'); // no tiene datos a eliminar
Route::post('/verifyPassword/{id}', 'PaymentsController@verifyPassword')->name('verifyPassword');
Route::get('/payments/download/{id}', 'PaymentsController@downloadPaymentPDF')->name('download_payment_pdf'); // en desarrollo por santi
Route::post('/payments/verifyPayment','PaymentsController@verifyPaymentForm')->name('verifyPayment');
Route::post('/vico/payments/card', 'PaymentsController@pay')->middleware('store_card')->name('pay_booking');
Route::post('/payments/change','PaymentsController@changePaymentMethod')->name('change_payment_method');
Route::post('/vico/payments/add/card', 'PaymentsController@addPaymentMethod')->middleware('store_card')->name('payments_card_add');
Route::post('/payments/method/delete', 'PaymentsController@deletePaymentMethod')->name('delete_payment_method');
Route::get('/payments/history', 'PaymentsController@getHistory')->name('payments.history')->middleware('web');

/**
 * Pago del depósito
 */
Route::get('/payments/deposit/{id}', 'PaymentsController@getPaymentsUser')->name('payments_deposit')->middleware('booking_payment');
// Route::get('/payments/deposit/{id}', 'PaymentsController@getDeposit')->name('payments_deposit');
Route::post('/payments/deposit', 'PaymentsController@addDepositToBooking')->middleware('store_card')->name('payments_deposit_store');

/**
 * Payments CRUD
 */
Route::resource('/paymentmanual', 'PaymentsManualController')->middleware('role');
Route::post('/paymentmanual/info','PaymentsManualController@getPaymentInfo')->name('paymentmanual.info');
Route::get('/manager/paymentmanual/{id}','PaymentsManualController@getBookingInfo')->name('manager.paymentmanual');
Route::get('/user/paymentmanual/{id}','PaymentsManualController@getBookingInfo')->name('user.paymentmanual');
Route::post('/manager/paymentmanual/store','PaymentsManualController@saveManagerPayment')->name('manager.paymentmanual.store');
Route::post('/user/paymentmanual/store','PaymentsManualController@saveUserPayment')->name('user.paymentmanual.store');

/**
 * Zone CRUD
 */
Route::resource('zone', 'ZoneController')->middleware('role');
Route::get('zone/house/{house}', 'ZoneController@createHouseZone')->middleware('role')->name('zone.house.create');
Route::post('zone/house/{house}', 'ZoneController@storeHouseZone')->middleware('role')->name('zone.house.store');

Route::get('zone/neighborhood/{neighborhood}', 'ZoneController@createNeighborhoodZone')->middleware('role')->name('zone.neighborhood.create');
Route::post('zone/neighborhood/{neighborhood}', 'ZoneController@storeLocationNeighborhood')->middleware('role')->name('zone.location.store');

/**
 * City CRUD
 */
Route::resource('city', 'CityController')->middleware('role');


/**
 * Neighborhood CRUD
 */
Route::resource('neighborhood', 'NeighborhoodController');

/**
 * Gey currency API
 */
Route::get('api/currency', 'PaymentsController@getCurrency')->name('currency.get');

/**
 * Gey currency API
 */
Route::get('api/city', 'CityController@getCity')->name('city.get');
/**
 * University(Schools) CRUD
 */
Route::resource('school', 'SchoolController');
Route::get('school/neighborhood/{school}', 'SchoolController@createNeighborhoodSchool')->name('neighborhood.school.create');
Route::post('school/neighborhood/{school}', 'SchoolController@storeNeighborhoodSchool')->name('neighborhood.school.store');

/**
 * Location CRUD
 */
Route::resource('location', 'LocationController');

/**
 * Interest Point CRUD
 */
Route::resource('genericInterestPoints', 'GenericInterestPointController')->middleware('role');
Route::resource('specificInterestPoints', 'SpecificInterestPointController')->middleware('role');
Route::get('genericInterestPoints/house/{house}', 'GenericInterestPointController@getHouse')->name('genericInterestPoint.house.create');
Route::post('genericInterestPoints/house/{house}', 'GenericInterestPointController@storeHouse')->name('genericInterestPoint.house.store');
Route::get('specificInterestPoints/house/{house}', 'SpecificInterestPointController@getHouse')->name('specificInterestPoint.house.create');
Route::post('specificInterestPoints/house/{house}', 'SpecificInterestPointController@storeHouse')->name('specificInterestPoint.house.store');
Route::get('specificInterestPoints/city/{city}', 'SpecificInterestPointController@getCity')->name('specificInterestPoint.city.create');
Route::post('specificInterestPoints/city/{city}', 'SpecificInterestPointController@storeCity')->name('specificInterestPoint.city.store');

/**
 * About us page
 */
Route::get('/about', 'HomeController@about')->name('home.about');

Route::get('/client', 'ClientController@index')->middleware('auth');


// whebhook twilio
Route::post('/twiliowebhookhandle', 'WebhookController@handleRecivedMessage');
Route::post('/twiliowebhookstatus', 'WebhookController@handleRecivedMessage');




// Route::get('event/message', function(){
//     $message = Message::find(1);
//     event(new MessageWasReceived($message, 1, 1));
// });
/*
 *  Partner Landing Pages
*/

Route::get('invitation/send','InvitationController@create');
Route::get('invitation/{id}','InvitationController@show');
/**
 * Webhook and post whatsapp messages handler
 */
Route::post('api/v1/webhook/twilio', 'ApiMessageController@twiliov1')->name('webhook.receivev1');
Route::post('api/v2/webhook/twilio', 'ApiMessageController@twiliov2')->name('webhook.receivev2');
    
Route::get('api/v1/message/twilio/{flag}', 'ApiMessageController@test')->name('webhook.v1');


Route::get('/webhook/chat', 'ApiMessageController@getPage');

// Leave recommendation popup

Route::post('reviews/submit', 'UserController@userVicoRating');
