// SEGMENT TRACKING FUNCTIONS
function faqUser() {
    analytics.track('Enter user FAQ',{
        category: 'User knowlage'
    });
}

function faqManager() {
    analytics.track('Enter manager FAQ',{
        category: 'User knowlage'
    });
}

function aboutVico() {
    analytics.track('Enter About VICO page',{
        category: 'User knowlage'
    });
}

function contactButton(house_id, room_price, room_id, room_city, manager_id) {
    analytics.track('Button contact/reserve',{
        category: 'Main stream',
        houseId: house_id,
        roomId: room_id,
        roomPrice: room_price,
        roomCity: room_city,
        managerId: manager_id
    });
}

function openChat(booking_id, booking_status, user_nationallity, house_id) {
    analytics.track('Enter notification chat',{
        category: 'Chat view',
        houseId: house_id,
        bookingId: booking_id,
        bookingStatus: booking_status
    });
}

function actionContact(problemId) {
    problem_info = document.getElementById(problemId).value;
    analytics.track('Attempted to contact to VICO',{
        problemContent: problem_info
    });
}

function verificateWpp() {
    analytics.track('Verificate whastapp',{
        category: 'Verfications'
    });
}

function verificatePhone() {
    analytics.track('Verificate phone',{
        category: 'Verfications'
    });
}

function verificateEmail() {
    analytics.track('Verificate email',{
        category: 'Verfications'
    });    
}

function searchOnLandingPage() {
    analytics.track('Search on landing page',{
        category: 'Search'
    });
}

function searchOnNavbar() { //WORK
    analytics.track('Search on navbar',{
        category: 'Search'
    });
}

function searchOnIndex() {
    analytics.track('Search on index view',{
        category: 'Search'
    });    
}

function contactButtonAB(house_id, room_price, room_id, room_city, manager_id) {
    analytics.track('Button contact experiment',{
        houseId: house_id,
        roomId: room_id,
        roomPrice: room_price,
        roomCity: room_city,
        managerId: manager_id
    });
}

function clickOnHouse(house_id, house_price) {
    analytics.track('Click on house index',{
        category: 'Main stream',
        label: house_id,
        value: house_price
    });
}