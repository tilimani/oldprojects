import React, { Component } from 'react';
import Chat from './../Chat/Chat';
import Notification from './../Notification/Notification';
import Profile from '../Profile/Profile';
import ReactDOM from 'react-dom';

import {NotificationConsumer, NotificationProvider} from './NotificationContext'

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import SuccessSmile from '../images/SuccessSmile.svg';
import Accepted from '../images/accepted.png';
import './Communication.scss';
import Axios from 'axios';

import Localization from '../../Localization/Localization';

class Communication extends Component {
    constructor(props) {
        super(props);
        let connection = this.props.connection.split(','),
            user_id = connection[0],
            role_id = connection[1],
            pending = connection[2],
            unread = connection[3],
            accepted = connection[4],
            denied = connection[5],
            userName = connection[6],
            payment = connection[7],
            language = connection[8]
        this.state= {
            user_id,
            role_id,
            pending,
            unread,
            accepted,
            denied,
            userName,
            payment,
            language,
            channel: '',
            notifications: [],
            allNotifications: [],
            manager: '',
            user: '',
            load: false,
            acceptedBookings: [],
            paymentNotifications: [],
            showAcceptedModal: false,
            showUserPayedModal: false,
            showManagerPayedModal: false,
            currentPaymentNotification: 0,
            currentAcceptedBooking: 0,
            showDropdown: false,
            currentSelectedBooking: null,
            currentUserQualification: 0,
            currentUserVerifications: null,
            isShowingProfile: false,
            Localization: '',
            userProfile: false,
            showRoomChangeModal: false,
            changedVico: '',
            changedRoom: '',
            changedRoomId: '',
            changedRoomBookingId: ''
        }
        this.chatContainer = React.createRef();
        this.notificationsContainer = React.createRef();
    }

    setPaymentNotifications(notifications){
        let payload = {
            roomIds: []
        }
        let newPaymentNotifications = [];
        let newAcceptedNotifications = [];
        notifications.map((notification)=>{
            if(notification.data.status == 2){
                if(this.state.role_id == 3){
                    this.setState({
                        changedVico: notification.data.house_name,
                        changedRoom: notification.data.room_number,
                        changedRoomId: notification.data.room_id,
                        changedRoomBookingId: notification.data.booking_id
                    })
                    this.openChangeRoomModal();
                }
            }
            if(notification.read_at == null){
                if(notification.data.status == 5){
                    payload.roomIds.push(notification.data.room_id);
                    let info = {
                        user_name: notification.data.user_name,
                        room_number: notification.data.room_number,
                        house_name: notification.data.house_name,
                        date_from: notification.data.date_from,
                        room_price: notification.data.depositPrice
                    }
                    newPaymentNotifications.push(info)
                }
                if(notification.data.status == 4){                    
                    if(this.state.role_id == 3){
                        let booking = {};
                        let date = this.formatDate(notification.data.updated_at.date);
                        booking = {
                            id: notification.data.booking_id,
                            date: date[0],
                            hour: date[1],
                        }
                        newAcceptedNotifications.push(booking);
                    }
                }
            }
        })
        this.setState({
            acceptedBookings: newAcceptedNotifications
        },()=>{
            if(newAcceptedNotifications.length > 0 && this.state.role_id == 3){
                this.openAcceptModal();
            }
        });
        // if(payload.roomIds.length > 0){
            Axios.post('/api/rooms',payload).then((rooms)=>{
                newPaymentNotifications.map(function(value,i){
                    newPaymentNotifications[i] = {...newPaymentNotifications[i],room_price: rooms.data[i].price}
                })
                this.setState({
                    paymentNotifications: newPaymentNotifications
                },()=>{
                    if(newPaymentNotifications.length > 0){
                        if(this.state.role_id == 3){
                            this.openUserPayedModal();
                        }else{
                            this.openManagerPayedModal();
                        }
                    }
                })
            })
        // }
    }    

    showNextPaymentNotification(){
        let newPaymentNotifications = [];
        // if(this.state.paymentNotifications.length > 0){
        // }
        if(this.state.paymentNotifications.length >= 0) {
            if(this.state.role_id == 3){
                this.setState({
                    showUserPayedModal: false
                })
            }else{
                this.setState({
                    showManagerPayedModal: false
                })
            }
            newPaymentNotifications = this.state.paymentNotifications;
            newPaymentNotifications.shift();
        }
        this.setState({
            paymentNotifications: newPaymentNotifications,
            currentPaymentNotification: this.state.currentPaymentNotification++
        });
    }

    openAcceptModal(){
        this.setState({
            showAcceptedModal: true
        });
    }
    closeAcceptModal(){
        let newAcceptedBookings = [];
        newAcceptedBookings = this.state.acceptedBookings;
        newAcceptedBookings.shift();
        if(this.state.acceptedBookings.length > 0){
            if(this.state.role_id == 3){
                
                this.setState({
                    acceptedBookings: newAcceptedBookings
                })
            }
        }else{
            this.setState({
                showAcceptedModal:false
            })
        }
    }

    openUserPayedModal(){
        this.setState({
            showUserPayedModal: true,
        });
    }

    openManagerPayedModal(){
        this.setState({
            showManagerPayedModal: true
        });
    }

    handleCloseUserPayedModal(){
        this.setState({
            showUserPayedModal: false
        });
    }

    handleCloseManagerPayedModal(){
        this.setState({
            showManagerPayedModal:false
        });
    }

    redirectPayment(booking){
        window.open(`/payments/deposit/${booking.id}`, '_blank');
    }

    loadComponentData(user_id) {
        let echoChannel = window.Echo.private(`App.User.${user_id}`)
            .notification((notification) => {
                if (notification.type == 'App\\Notifications\\BookingNotification'){
                    this.updateNotifications(notification);
                    if(notification.status == 4){
                        if(!notification.ismessage){  
                            let booking = {};                          
                            let date = this.formatDate(notification.updated_at.date);
                            booking = {
                                id: notification.booking_id,
                                date: date[0],
                                hour: date[1]
                            };
                            this.setState({
                                acceptedBookings: [...this.state.acceptedBookings,booking]
                            });
                            if(this.state.role_id == 3){
                                this.openAcceptModal();
                            }
                        }
                    }
                    if(notification.status == 2){
                        if(this.state.role_id == 3){
                            this.setState({
                                changedVico: notification.house_name,
                                changedRoom: notification.room_number,
                                changedRoomId: notification.room_id,
                                changedRoomBookingId: notification.booking_id
                            })
                            this.openChangeRoomModal();
                        }
                    }
                    if(notification.status == 5){
                        if(!notification.ismessage){
                            let info = {};                            
                            info = {
                                user_name: notification.user_name,
                                room_number: notification.room_number,
                                house_name: notification.house_name,
                                date_from: notification.date_from,
                                room_price: notification.depositPrice,
                            }
                            this.setState({
                                paymentNotifications: [...this.state.paymentNotifications,info],
                            },()=>{
                                if(this.state.role_id == 3){
                                    this.openUserPayedModal();
                                } else {
                                    this.openManagerPayedModal();
                                }
                            });
                        }
                    }
                }
            });
        axios.get(`/api/notification/${user_id}`)
            .then((response) => {
                this.setPaymentNotifications(response.data);                
                this.setState({
                    'notifications' : response.data,
                    'allNotifications':response.data
                });
                axios.get(`/api/user/${user_id}`)
                    .then((response1) =>{
                        this.setState({
                            manager: response1.data,
                            channel: echoChannel,
                            load: true,
                        });
                    }).catch((error) => {
                        console.error("Error getting user " + error);
                });
            }).catch((error) => {
                console.error("Error getting notifications " + error);
        });
    }    

    componentWillMount(){
        let localization = new Localization;
        localization.initialize('process',this.state.language);
        this.setState({
            Localization: localization,
            load: false
        })
    }

    componentDidMount(){
        this.loadComponentData(this.state.user_id);
    }

    formatDate(date) {        
        let formattedDate = new Date(date);
        let now = new Date();
        let offset = now.getTimezoneOffset();
        let offsetHours = (offset - (offset%60))/60;
        let offsetMinutes = offset%60;
        formattedDate.setHours(formattedDate.getHours() - offsetHours);
        formattedDate.setMinutes(formattedDate.getMinutes() - offsetMinutes);
        formattedDate.setDate(formattedDate.getDate() + 2);
        let month = formattedDate.getMonth() + 1;
        return [formattedDate.getDate()+'.'+month+'.'+formattedDate.getFullYear(),('0' + formattedDate.getHours()).slice(-2) + ":" + ('0' + formattedDate.getMinutes()).slice(-2)];
    }

    updateNotifications(response) {
        let now = new Date();
        now.setHours(now.getHours() + (now.getTimezoneOffset()/60));
        let data = response,
            newNotifications = [],
            notifications = this.state.notifications,
            newNotification = {
                id: '',
                data: data,
                created_at: now,
                read_at: null
            };
        newNotifications.push(newNotification);
        notifications.map((notification, i) => {
            if (notification.data.booking_id != data.booking_id) {
                newNotifications.push(notification);
            } else {
                newNotification.id = notification.id;
            }
        });

        this.setState({
            notifications: newNotifications,
            allNotifications: newNotifications
        });
        this.child.chargeNotification(newNotifications);

    }

    componentDidUpdate() {
        // console.log(this.state.notifications);
    }

    readNotification (booking_id, user_id) {
        user_id = parseInt(user_id);
        let data = {
            booking_id,
            user_id
        };
        if(this.state.role_id != 1) {
            axios.post(`/api/user/notification/read`, data)
            .then((response) => {
                // console.log(response);
                this.setState({
                    notifications: response.data,
                    allNotifications: response.data
                });
            });
        }
    }

    selectChat(bookingData){        
        this.child.change(bookingData);
        this.setState({currentSelectedBooking:bookingData});
        this.getUserRating(bookingData.user_id);
        this.getUserVerifications(bookingData.user_id);
        // this.getUserProfile(bookingData.user_id);
        this.showChat(true);
    }

    showChat(isShowing){
        let notificationContainer = document.querySelector('.notification_app');
        let chatContainer = document.querySelector('.chat_app');
        if(isShowing){
            chatContainer.classList.add('active');            
            // chatContainer.classList.add('add-expandWidth');
            chatContainer.classList.remove('inactive');
            // chatContainer.classList.remove('add-shrinkWidth');
            notificationContainer.classList.add('inactive');
            // notificationContainer.classList.add('add-shrinkWidth')
            notificationContainer.classList.remove('active');
            // notificationContainer.classList.remove('add-expandWidth');
        }else{
            chatContainer.classList.add('inactive');
            // chatContainer.classList.add('add-shrinkWidth');
            chatContainer.classList.remove('active');
            // chatContainer.classList.remove('add-expandWidth');
            notificationContainer.classList.add('active');
            // notificationContainer.classList.add('add-expandWidth');
            notificationContainer.classList.remove('inactive');
            // notificationContainer.classList.remove('add-shrinkWidth');
        }

    }

    showProfileInfo(){
        let notificationContainer = document.querySelector('.notification_app');
        let chatContainer = document.querySelector('.chat_app');
        let profileContainer = document.querySelector('.profile_app');
        if(!this.state.isShowingProfile){
            profileContainer.classList.add('active');
            profileContainer.classList.add('add-expandWidth');
            profileContainer.classList.remove('inactive');
            profileContainer.classList.remove('add-shrinkWidth');
            chatContainer.classList.add('inactive');
            chatContainer.classList.add('add-shrinkWidth');
            chatContainer.classList.remove('active');
            chatContainer.classList.remove('add-expandWidth');
            notificationContainer.classList.add('inactive');
            notificationContainer.classList.add('add-shrinkWidth')
            notificationContainer.classList.remove('active');
            notificationContainer.classList.remove('add-expandWidth');
            this.setState({
                isShowingProfile:true
            })
        }else{
            profileContainer.classList.add('inactive');
            profileContainer.classList.add('add-shrinkWidth');
            profileContainer.classList.remove('active');
            profileContainer.classList.remove('add-expandWidth');
            chatContainer.classList.add('active');
            chatContainer.classList.add('add-expandWidth');
            chatContainer.classList.remove('inactive');
            chatContainer.classList.remove('add-shrinkWidth');
            notificationContainer.classList.add('inactive');
            notificationContainer.classList.add('add-shrinkWidth')
            notificationContainer.classList.remove('active');
            notificationContainer.classList.remove('add-expandWidth');
            this.setState({
                isShowingProfile:false
            })
        }
        
    }

    searchHandler(searchInput){        
        if(searchInput.value != ""){
            this.setState({
                notifications: this.state.notifications.filter((notification)=>{   
                    let house_name = (notification.data.house_name != null) ? notification.data.house_name.toLowerCase(): '';
                    let user_name = (notification.data.user_name != null) ? notification.data.user_name.toLowerCase(): '';                         
                    return this.compareNotifications(
                        searchInput,
                        house_name,
                        user_name,
                        notification.data.room_number,
                        notification.data.status,
                        notification.data.booking_id,
                        notification.read_at
                    );
                })
            },()=>{
                // console.log(this.state.notifications)
            })            
        } else {
            this.setState({
                notifications:this.state.allNotifications
            },()=>{
                // console.log(this.state.notifications)
            })
        }
        
    }

    filterStatus(key, searchInput) {
        this.setState({
            notifications: this.state.allNotifications
            } ,() => {
            if ( !key ){
                key = '';
            }
                let event = new Event('onChange');
                searchInput.value = '';
                searchInput.value=key;
                searchInput.dispatchEvent(event);
                this.searchHandler(searchInput);
        });
        this.setState({
            showDropdown:false
        })        
        
        return true;
    }

    compareNotifications(
        searchInput,
        vicoName,
        userName,
        roomNumber, 
        booking_status = false,
        booking_id = false,
        read = false
    ){
        if (vicoName.includes(searchInput.value.toLowerCase(),0)) {
            return true;
        }
        if(userName.includes(searchInput.value.toLowerCase(),0)){
            return true;
        }
        if(roomNumber.toString().includes(searchInput.value.toLowerCase(),0)){
            return true;
        }
        if (booking_status && this.procesStatus(booking_status).toString().includes(searchInput.value.toLowerCase())) {
            return true;
        }
        if (booking_id && booking_id.toString().includes(searchInput.value.toLowerCase(), 0)) {
            return true;
        }
        return false;
    }

    procesStatus(status, read) {
        if (!status) {
            console.error('status not defined: ' + status);
            return -1;
        }
        let res = 0;
        if (status < 0) {
            res += 'denied';
        } else  {
            switch (parseInt(status)) {
                case 1:
                    res += ' pending';
                break;
                case 2:
                    res += '';
                break;
                case 3:
                    res += ' reserve';
                break;
                case 4:
                    res += ' payment';
                break;
                case 5:
                    res += ' accepted';
                break;
            }
        }
        if (!read) {
            res += ' unread';
        }
        return res;
    }

    openDropdown(){
        let show = this.state.showDropdown;

        if (show) {
            this.setState({
                showDropdown: false
            });
        } else {
            this.setState({
                showDropdown: true
            });
        }
    }

    processMessage (message) {
        if(message != null){
            message = message.replace(/([1-9]+[\- ]?[1-9]+[\- ]?[1-9]+[\- ]?[1-9])/g, '*****');
    
            return message;
        }
    }

    getUserRating(user_id){
        axios.get('/api/v1/user/qualification/'+user_id).then((response)=>{
            let currentUserQualification = response.data;
            axios.get(`/api/user/${user_id}`).then((response) => {
                let userProfile = response.data;
                this.setState({
                    userProfile,
                    currentUserQualification
                });
            });        
        })
    }

    getUserVerifications(user_id){
        axios.get('/api/v1/verification/'+user_id).then((response)=>{
            let verifications = {
                document: response.data.document_verified,
                phone: response.data.phone_verified,                
                email: response.data.email_verified
            }            
            this.setState({
                currentUserVerifications: verifications
            });
        })
    }    
    getUserProfile(user_id){
        axios.get(`api/user/${user_id}`).then((response) => {
            let userProfile = response.user;
            this.setState({
                userProfile
            });
        });
    }

    openChangeRoomModal(){
        this.setState({
            showRoomChangeModal: true
        })
    }

    acceptRoomChange(){
        let payload = {
            booking_id: this.state.changedRoomBookingId,
            room_id: this.state.changedRoomId,
        };
        Axios.post('/api/v1/changeHouse',payload).then(()=>{
            this.setState({
                showRoomChangeModal: false
            })
        });
    }

    denyRoomChange(){
        let payload = {
            booking_id: this.state.changedRoomBookingId,
            room_id: this.state.changedRoomId,
        };
        console.log(payload);
        Axios.post('/api/v1/denyroomchange',payload).then(()=>{
            this.setState({
                showRoomChangeModal: false
            })
        });
    }

    closeRoomChangeModal(){
        this.setState({
            showRoomChangeModal: false
        })
    }

    render() {
        let load = this.state.load;
        let paymentNotification = this.state.paymentNotifications[this.state.currentPaymentNotification];
        let acceptedNotification = this.state.acceptedBookings[this.state.currentAcceptedBooking];
        let currentBooking = this.state.currentSelectedBooking;
        let Localization = this.state.Localization;
        if (load) {
            return (
                <div className="app_vico">
                    <div className="_process">
                        <div className="app_wrapper_web">
                            <div className="app_process">
                            <NotificationProvider value={this.state.notifications}>
                                    <Notification
                                        ref={this.notificationsContainer}
                                        searchHandler={this.searchHandler.bind(this)}
                                        filterStatus={this.filterStatus.bind(this)}
                                        showDropdown={this.state.showDropdown}
                                        openDropdown={this.openDropdown.bind(this)}
                                        $key={`notification-${this.state.notifications.length}`}
                                        // key={`notification-${this.state.notifications.length}`}
                                        user_id={this.state.user_id}
                                        role_id={this.state.role_id}
                                        pending={this.state.pending}
                                        unread={this.state.unread}
                                        accepted={this.state.accepted}
                                        denied={this.state.denied}
                                        payment={this.state.payment}
                                        notifications={this.state.notifications}
                                        allNotifications={this.state.allNotifications}
                                        channel={this.state.channel}
                                        selectChat={this.selectChat.bind(this)}
                                        manager={this.state.manager}
                                        readNotification={this.readNotification.bind(this)}
                                        processMessage = {this.processMessage.bind(this)}
                                        Localization={Localization}
                                        />
                            </NotificationProvider>
                                <Chat
                                    ref={this.chatContainer} className="d-none d-md-block add-opacity"
                                    onRef={ref => (this.child = ref)}
                                    onBackArrow={this.showChat.bind(this, false)}
                                    notifications={this.state.allNotifications}
                                    user_id={this.state.user_id}
                                    role_id={this.state.role_id}
                                    processMessage = {this.processMessage.bind(this)}
                                    readNotification={this.readNotification.bind(this)}
                                    showProfileInfo={this.showProfileInfo.bind(this)}
                                    Localization={Localization}
                                    changeRoomModal={this.openChangeRoomModal.bind(this)}
                                    />
                                {currentBooking !== null && this.state.userProfile &&
                                <Profile booking={currentBooking} 
                                    qualification={this.state.currentUserQualification}
                                    verifications={this.state.currentUserVerifications}
                                    onBackArrow={this.showProfileInfo.bind(this)}
                                    Localization={Localization}
                                    user={this.state.userProfile}
                                    />
                                }
                            </div> 
                        </div>
                    </div>
                    <Modal centered size="sm" dialogClassName="payed-modal" show={this.state.showUserPayedModal} onHide={this.handleCloseUserPayedModal.bind(this)}>
                        <Modal.Body className="text-center">
                            <img className="mt-3 mb-2" src={Accepted} height={100} width={100}/>
                            <h2 className="text-success mt-4">{Localization.trans('successful_reservation')}</h2>
                            {this.state.paymentNotifications.length > 0 && <p className="text-muted mt-3">
                                {Localization.trans('congratulations')} {this.state.userName} {Localization.trans('successful_payment')}
                                ({Localization.trans('monthly_rent')} ${paymentNotification.room_price}){Localization.trans('all_ready')}
                                {Localization.trans('connect')}{paymentNotification.user_name} {Localization.trans('organize')}
                                {Localization.trans('contact')}
                            </p>}
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.showNextPaymentNotification.bind(this)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                    </Modal>
                    <Modal centered size="sm" dialogClassName="payed-modal" show={this.state.showManagerPayedModal} onHide={this.handleCloseManagerPayedModal.bind(this)}>
                        <Modal.Body className="text-center">
                            <img className="mt-3 mb-2" src={Accepted} height={100} width={100}/>
                            <h2 className="text-success mt-4">{Localization.trans('reserve')}</h2>
                                {this.state.paymentNotifications.length > 0 && <p className="text-muted mt-3">{Localization.trans('congratulations')} {paymentNotification.user_name} {Localization.trans('room_payment')} #{paymentNotification.room_number + ' '}
                                 {Localization.trans('in')}{paymentNotification.house_name} (${paymentNotification.room_price}). {Localization.trans('contact_manager')} {paymentNotification.user_name + ' '}
                                {Localization.trans('organize')} {Localization.trans('the_day')} {paymentNotification.date_from}</p>}
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.showNextPaymentNotification.bind(this)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                    </Modal>
                    <Modal centered size="sm" dialogClassName="accepted-modal" show={this.state.showAcceptedModal} onHide={this.closeAcceptModal.bind(this)}>
                        <Modal.Header closeButton></Modal.Header>
                        <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3">{Localization.trans('super')}</h2>
                                {this.state.acceptedBookings.length > 0 && <p className="text-muted mt-5">
                                    {Localization.trans('deposit_payment')} {acceptedNotification.date} {Localization.trans('at')} {acceptedNotification.hour} {Localization.trans('to_pay')}
                                </p>
                                }

                        </Modal.Body>
                        <Modal.Footer>
                            {this.state.acceptedBookings.length > 0 && <Button className="border-radius mx-auto px-4" variant="success" onClick={this.redirectPayment.bind(this,acceptedNotification)}>
                                {Localization.trans('proceed_pay')}
                                </Button>
                            }

                            <a className="text-primary" onClick={this.closeAcceptModal.bind(this)}>{Localization.trans('later')}</a>
                        </Modal.Footer>
                    </Modal>
                    <Modal centered size="lg" dialogClassName="accepted-modal" show={this.state.showRoomChangeModal} onHide={this.closeRoomChangeModal.bind(this)}>
                        <Modal.Header closeButton></Modal.Header>
                        <Modal.Body className="text-center">
                            <h2>Para tu solicitud #{this.state.changedRoomBookingId} se quiere cambiar a la Habitacion #{this.state.changedRoom} de la {this.state.changedVico}</h2>
                            <h3>¿Deseas aceptar el cambio?</h3>
                            <img className="room-image" src={'https://fom.imgix.net/room_'+this.state.changedRoomId+'.jpeg?w=450&h=300&fit=crop'} />
                            <div className="d-flex justify-content-around">
                                <Button onClick={this.acceptRoomChange.bind(this)}>Aceptar cambio</Button>
                                <Button variant="secondary" onClick={this.denyRoomChange.bind(this)}>Rechazar cambio</Button>
                            </div>
                        </Modal.Body>
                    </Modal>

                </div>
            );
        } else {
            return (
                <Container>
                    <Row>
                        <Col ref="notificationContainer" xs={12} sm={12} md={4} lg={4} className="d-md-block">
                        {
                            Localization.trans('loading_data') != null &&
                            Localization.trans('loading_data')
                        }
                        </Col>
                        <Col ref="chatContainer" md={8} lg={8} className="d-none d-md-block add-opacity">
                            {
                                Localization.trans('loading_data') != null &&
                                Localization.trans('loading_data')
                            }
                        </Col>
                    </Row>
                </Container>
            );
        }
    }
}
if (document.getElementById('react-communication')) {
    let communicationDiv = document.getElementById('react-communication');
    let connection = communicationDiv.dataset.connection;
    ReactDOM.render(<Communication connection={connection} />, document.getElementById('react-communication'));
}
// export default Communication;
