import React, { Component } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom';
import Message from './Message/Message';
import MessageInput from './MessageInput/MessageInput'
import BookingStatusMessage from './BookingStatusMessage/BookingStatusMessage';
import ProcesStatus from './../ProcesStatus/ProcesStatus'
import Modal from 'react-bootstrap/Modal';
import DenyModal from '../DenyModal/DenyModal';
import { NotificationConsumer } from '../Communication/NotificationContext';
import Media from 'react-bootstrap/Media';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Button from 'react-bootstrap/Button';
import Dropdown from 'react-bootstrap/Dropdown';
import DropdownButton from 'react-bootstrap/DropdownButton';
import DropdownItem from 'react-bootstrap/DropdownItem';
import  Userpicture from './../UserPicture/UserPicture';

import './Chat.scss';


import Axios from 'axios';

class Chat extends Component {

    constructor(props) {
        super(props);
        let user_id = this.props.user_id,
            role_id = this.props.role_id,
            notifications = this.props.notifications,
            myDestination = (role_id == 3) ? 1 : 0;
        this.state = {
            message: '',
            user: {
                user_id: user_id,
                role_id: role_id,
                my_destination: myDestination,
                user_image: '',
                user_name: '',
                country_icon: ''
            },
            userChat: {},
            booking:{
                id: null,
                status: 1,
                mode: null
            },
            'history': [],
            messages: [],
            booking_status_messages:[
                'Habitacion Disponible',
                'Solicitud Confirmada',
                'Solicitud Confirmada',
                'Espera de pago',
                'Reserva exitosa'
            ],
            avabilityModalShow: true,
            typing: false,
            channel: '',
            echoChannel: '',
            notifications,
            selectedNotification: Object,
            open: false,
            cancelBookingModalShow: false,
            changeRoomModal: false,
            managerRooms: false,
            managerVicos: false,
            vicoTitle: 'Mis VICO',
            roomTitle: '',
            roomId: ''
        };
        this.denyModal = React.createRef();
        this.roomDropdown = React.createRef();
        this.houseDropdown = React.createRef();
    }

    chargeNotification(notifications) { 
        let notification = this.processNotification(notifications, this.state.booking.id);
        this.setState({
            selectedNotification: notification,
            notifications
        });
    }

    openDenyModal() {
        this.setState({
            avabilityModalShow: false,
        }, () => {
            this.child.handleShow();
        });
    }


    handleOpenAvabilityModal(){
        this.setState({
            avabilityModalShow: true
        })
    }

    handleavabilityModalHide() {
        this.setState({
            avabilityModalShow: false
        });
        Axios.post('api/booking/available',{
            id:this.state.booking.id,
        }).then((data)=>{
            console.log(data);
        });
    }

    componentDidMount(){
        this.getMessages(this.state.booking.id);
        this.props.onRef(this);
        if(this.state.booking.status == 1){
            this.handleOpenAvabilityModal();
        }
    }

    componentWillUnmount() {
        this.props.onRef(undefined);
    }

    handleDenyModalClose(completedCorrectly){
        if(!completedCorrectly){
            this.handleOpenAvabilityModal();
        }
    }

    change(bookingData) {
        let data = [],
            id = bookingData.booking_id,
            channel = `BookingMessageChannel.${id}`,
            notification = this.processNotification(this.state.notifications, id);
        
        if(id != this.state.booking.id){
            axios.get(`/api/message/${id}`).then((response) => {
                data = response.data;
                if (channel != this.state.channel && bookingData.status >= 1) {
                    this.suscribeChannel('private', channel, 'MessageWasReceived');
                }
                this.setState({
                    userChat:{
                        id: notification.data.user_id,
                        image: bookingData.user_image,
                        name: bookingData.user_name,
                        country_icon: bookingData.country_icon,
                        lastname: notification.data.user_lastname,
                        genere: notification.data.user_genere,
                        nationallity: notification.data.nationallity,
                        age: notification.data.user_age
                    },
                    history: data,
                    booking:{
                        id: id,
                        status: bookingData.status,
                        mode: bookingData.mode
                    },
                    channel: channel,
                    selectedNotification: notification,
                    avabilityModalShow: true,

                });
            }).catch((error) => {
                console.log(error);
            });
        }
    }

    getMessages(id){        
        let channel = `BookingMessageChannel.${id}`;
        if (id){
            axios.get(`/api/message/${id}`)
                .then((response) => {
                    this.setState({ 'history' : response.data});
                    if (channel != this.state.channel) {
                        this.suscribeChannel('private', channel, 'MessageWasReceived');
                    }
                }).catch((error) => {
                    // console.error("Error getting History " + error);
            });
        }
    }

    suscribeChannel(type, channel, event){
        let echoChannel = '';
        if (type === 'private') {
            echoChannel = window.Echo.private(`${channel}`)
            .listen(`${event}`, e => {
                if(this.state.user.my_destination == e.message.destination){
                    this.setState({
                        messages: [...this.state.messages, e.message],
                    });
                }
            })
            .listenForWhisper('typing', (e) => {
                let _this = this;
                _this.setState({
                    typing: true
                });
            })
            .listenForWhisper('read', (e) => {
                this.setState((state) => {
                    let history = state.history.map((message) => {
                        if (message.destination != this.state.user.my_destination) {
                            message.read = 2;
                        }
                    });
                    return history;
                });
                this.setState((state) => {
                    let messages = state.messages.map((message, i) => {
                        if (message.destination != this.state.user.my_destination) {
                            message.read = 2;
                        }
                    });
                    return messages;
                });
            });
            this.setState({
                channel: channel,
                echoChannel: echoChannel
            });
        } else {

        }
    }

    isTyping() {
        let channel = this.state.echoChannel,
            user = this.state.user,
            booking = this.state.user;
        channel.whisper('typing',{
            user: user,
            booking: booking
        });
    }

    readMessages() {
        let data = {
                id: this.state.booking.id,
                destination: this.state.user.my_destination
            },
            channel = this.state.echoChannel;


        axios.post('/message/update', data).then((data) => {
            channel.whisper('read', {
                read: true
            });
        });
    }

    
    componentDidUpdate(){  
        let messagesContainer = document.querySelector('.messages-container');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    addMessageLocally(message,isSending){
        let lastMessageIndex = this.state.messages.length-1;
        let read = isSending ? 0 : 1;
        message.read = read;
        if (JSON.stringify(this.state.messages[lastMessageIndex]) != JSON.stringify(message)) {
            this.setState(state => {
                let messages = state.messages.push(message);
                return messages;
            })
        } else {
            this.setState(state => {
                let messages = state.messages[lastMessageIndex].read = read;

                return messages;
            })
        }
    }

    sendingEvent(message,isSending){
        let messageIndex = this.state.messages.lastIndexOf(message);
        let read = isSending ? 2 : 0;
        this.setState({
            messages: [...this.state.messages,this.state.messages[messageIndex].read = read]
        })
    }

    processNotification(notifications, booking_id) {
        let resnotification = null;
        notifications.map((notification, index) => {
            notification = notifications[notifications.length - 1 - index];
            if (!notification.data) {
                if (notification.booking_id == booking_id) {
                    resnotification = notification;
                }
            } else {
                if (notification.data.booking_id == booking_id) {
                    resnotification = notification;
                }
            }
        });
        return resnotification;
    }

    processChatClass() {
        let res = '',
            selectedNotification = this.state.selectedNotification;
        
        if (selectedNotification.data.status < 0){
            res += '_variant_1';
        } else if(selectedNotification.data.booking_mode === 1) {
            res += '_variant_3';
        } else {
            res += '_variant_2';
        }
        
        return res;
    }

    openMenu(){
        // alert('hello');
        let open = (this.state.open) ? false:true;
        this.setState({
            open
        });
    }

    loadProfile() {
        this.props.showProfileInfo();
    }
    loadVico() {
        window.open(`/houses/${this.state.selectedNotification.data.house_id}`, '_blank');
    }
    loadDate() {
        if(this.state.selectedNotification.data.role_id == 3){
            window.open(`/bookingdate/user/${this.state.selectedNotification.data.booking_id}`, '_blank');
        }else{
            window.open(`/bookingdate/manager/${this.state.selectedNotification.data.booking_id}`, '_blank');

        }
    }
    downloadContract(){
        window.open(`termsandconditions/contract/download/${this.state.booking.id}`, '_blank')
    }
    loadRoom() {
        window.open(`/houses/${this.state.selectedNotification.data.house_id}`, '_blank');
    }
    loadProblem() {
        window.open(`/`, '_blank');
    }
    loadBooking() {
        let request = {},
            notification = this.state.selectedNotification,
            booking_id = notification.data.booking_id;        
        if (notification.data.status > 4) {
            if (this.state.user.role_id < 3) {
                window.open(`/booking/cancelrequest/manager/${booking_id}`, '_blank');
            } else {
                window.open(`/booking/cancelrequest/user/${booking_id}`, '_blank');
            }
        } else {
            this.setState({
                cancelBookingModalShow: true
            })
        }
        // if (this.state.user.role_id < 3) {
        //     window.open(`/booking/cancelrequest/manager/${booking_id}`, '_blank');
        // } else {
        //     window.open(`/booking/cancelrequest/user/${booking_id}`, '_blank');
        // }
    }

    cancelBooking(){
        let request = {
            id: this.state.selectedNotification.data.booking_id,
            message: 'Cancelado por el ' + this.state.user.role_id == 3 ? 'Usuario' : 'Manager'
        };
        Axios.post('/api/v1/booking/cancel', request);
        this.hideCancelModal();
    }

    hideCancelModal(){
        this.setState({
            cancelBookingModalShow: false
        })
    }

    getHouses(booking_id) {
        return axios.get(`/api/v1/manager/houses/${booking_id}`);
    }

    getHouseRooms(house_id,selected) {
        axios.get(`/api/v1/rooms/house/${house_id}`).then((response) => {
            let rooms = response.data;

            this.setState({
                managerRooms: rooms,
                vicoTitle: selected
            });

        })
    }

    openChangeRoomModal(){
        let managerVicos = this.getHouses(this.state.selectedNotification.data.booking_id);
        managerVicos.then((response) => {
            let managerVicos = response.data;
            this.setState({
                changeRoomModal: true,
                managerVicos
            })
        });
    }

    closeChangeRoomModal(){
        this.setState({
            changeRoomModal: false,
            managerRooms: false,
            managerVicos: false
        })
    }

    sendNewRoomData() {
        let payload = {
            booking_id: this.state.booking.id,
            room_id: this.state.roomId
        };
        axios.post('/api/v1/changeHouse',payload).then(()=>{
            let message = `te cambie a la habitacion #${this.state.roomTitle} de la ${this.state.vicoTitle}`;
            this.messageInput.sendMessageHandler(new Event('click'),message);
            this.setState({
                changeRoomModal: false
            })
        });

    }

    handleRoomChange(room) {
        this.setState({
            roomTitle: room.number,
            roomId: room.id
        });   
    }

    checkRoomAvailable(room){
        let bookingDateFrom = this.state.selectedNotification.data.date_from.split('.');
        let bookingFrom = new Date('20' + bookingDateFrom[2],parseInt(bookingDateFrom[1])-1,bookingDateFrom[0]);
        let roomDate = room.available_from.split('-')
        let roomAvailableFrom = new Date('20' + roomDate[0],parseInt(roomDate[1])-1,roomDate[2]);
        if(bookingFrom >= roomAvailableFrom){
            return false;
        }else {
            return true;
        }
    }

    render() {
        let history = this.state.history,
            booking_status_messages = this.state.booking_status_messages,
            user = this.state.userChat,
            booking = this.state.booking,
            userRole = this.state.user.role_id,
            messages = this.state.messages,
            statusIndex = this.state.booking.status,
            rooms = this.state.managerRooms,
            vicos = this.state.managerVicos,
            side = 'left-side',
            _this = this,
            Localization = this.props.Localization;
        if (this.state.booking.id != null) {
            try {
                return  (
                    <div className="chat_app" 
                        onClick={this.props.readNotification.bind(this, booking.id, this.state.user.user_id)}
                        >
                        
                        <header className="chatHeader">
                            <i className="d-md-none fas fa-arrow-left mr-2" onClick={this.props.onBackArrow}></i>
                            <Userpicture size='sm' user_gender={user.genere} user_image={user.image} country_icon={user.country_icon}/>
                            <div className="button_text" onClick={this.props.showProfileInfo}>
                                <div className="_content_main">
                                    <div className="_text">
                                        <span>{user.name} {user.lastname} <span className="text-muted">{`#${booking.id}`}</span></span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {user.genere} {user.age}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className={`_item ellipsis ${(this.state.open) ? 'open':''}`} onClick={this.openMenu.bind(this)}>
                                        <i className="fas fa-ellipsis-v"></i>
                                        <div className="_menu_holder" key={`process-menu${booking.id}`}>
                                            <div className={`menu ${(this.state.open) ? 'open':'closed'}`}>
                                                <div className="item" onClick={this.loadProfile.bind(this)}>{Localization.trans('view_profile')}</div>
                                                <div className="item" onClick={this.loadVico.bind(this)}>{Localization.trans('view_vico')}</div>
                                                {booking.status > 0 && <>
                                                    <div className="item" onClick={this.loadDate.bind(this,this.state)}>{Localization.trans('change_dates')}</div>
                                                    {(booking.status < 5 && userRole < 3) &&
                                                        <div className="item" onClick={this.openChangeRoomModal.bind(this,booking.id)}>{Localization.trans('change_room')}</div>
                                                    }
                                                    <div className="item" onClick={this.loadBooking.bind(this)}>{Localization.trans('cancel_request')}</div>
                                                    {booking.status >= 5 &&
                                                        <div className="item" onClick={this.downloadContract.bind(this)}>{Localization.trans('download_contract')}</div>
                                                    }
                                                </>
                                                }
                                            </div>
                                        </div>
                                        {/* <Button variant="secondary" className="fas fa-ellipsis-v">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </Button> */}
                                    </div>
                                </div>
                            </div>
                        </header>
                        <Modal centered size="sm" dialogClassName="payed-modal" show={this.state.cancelBookingModalShow} onHide={this.hideCancelModal.bind(this)}>
                            <Modal.Body className="text-center">                                
                                <h2 className="text-muted mt-4 bold">{Localization.trans('reservation_cancelling')}</h2>
                                <p className="text-muted text-center mt-3">                                    
                                        {Localization.trans('cancelling_detail')}
                                </p>
                            </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="light" onClick={this.hideCancelModal.bind(this)}>
                                    No
                                </Button>
                                <Button className="border-radius mx-auto px-4" variant="danger" onClick={this.cancelBooking.bind(this)}>
                                    Si
                                </Button>
                            </Modal.Footer>
                        </Modal>
                        <Modal centered size="sm" dialogClassName="change-room-modal" show={this.state.changeRoomModal} onHide={this.closeChangeRoomModal.bind(this)}>
                            <Modal.Header closeButton></Modal.Header>
                            <Modal.Body>
                            <h2 className="text-muted bold">{Localization.trans('change_room')}</h2>

                                {vicos && 
                                    <DropdownButton title={this.state.vicoTitle} ref={this.roomDropdown}>
                                        {
                                            vicos.map((vico)=>{
                                                return (
                                                    <DropdownItem onClick={this.getHouseRooms.bind(this, vico.id,vico.name)} 
                                                        key={`dropdown-${vico.id }`}>{vico.name}
                                                    </DropdownItem>
                                                );
                                            })
                                        }
                                    </DropdownButton>
                                }
                                {
                                    rooms && 
                                    <DropdownButton title={'Habitación #' + this.state.roomTitle} ref={this.roomDropdown}>
                                        {
                                            rooms.map((room)=>{
                                                return (
                                                    <DropdownItem disabled={this.checkRoomAvailable(room)} key={`dropdown-${room.id }`} onClick={this.handleRoomChange.bind(this,room)}>{Localization.trans('room')} #{room.number}</DropdownItem>
                                                );
                                            })
                                        }
                                    </DropdownButton>
                                }
                                <Button onClick={this.sendNewRoomData.bind(this)}>{Localization.trans('accept')}</Button>
                            </Modal.Body>
                        </Modal>
                        <DenyModal onRef={ref => (this.child = ref)} 
                            onModalClose={this.handleDenyModalClose.bind(this)} 
                            notification={this.state.selectedNotification} 
                            text=""
                            Localization={Localization}
                            />
                        <div className="chat_container" >
                            <div className="copyable-area">
                                <div className={`messages-container ${this.processChatClass()}`}>
                                    <div className="messages-area">
                                    <ProcesStatus 
                                        key={`procesStatus-${this.state.selectedNotification.created_at}`}
                                        notification={this.state.selectedNotification}
                                        role_id={userRole}
                                        booking={this.state.booking}
                                        Localization={Localization}
                                        rooms={rooms}
                                        vicos={vicos}
                                        openChangeRoomModal={this.props.changeRoomModal}
                                        />
                                        {history.map((message,i)=>{
                                            if (userRole == 3) {
                                                side = message.destination == 0 ? 'right-aligned' : 'left-aligned';
                                            } else if (userRole <= 2) {
                                                side = message.destination == 1 ? 'right-aligned' : 'left-aligned';
                                            }
                                            if (statusIndex != message.status && i !=0) {
                                                statusIndex = message.status;
                                                return (
                                                    <>
                                                    <BookingStatusMessage $key={`message-status-container${i}`}  text={booking_status_messages[statusIndex - 1]}/>                                                    
                                                    <Message $key={`message-history-container${i}`} 
                                                        message={message} 
                                                        show={true} 
                                                        side={side} 
                                                        key={`message${i}`} type={'message'} 
                                                        processMessage = {this.props.processMessage}
                                                        />
                                                    </>
                                                );
                                            } else {
                                                return <Message $key={`message-history-container${i}`} 
                                                    message={message} 
                                                    show={true} 
                                                    side={side} 
                                                    key={`message${i}`} type={'message'} 
                                                    processMessage = {this.props.processMessage}
                                                    />
                                            }
                                        })}
                                        {messages.map((message,i)=>{
                                            if(message.bookings_id == this.state.booking.id){
                                                if (userRole == 3) {
                                                    side = message.destination == 0 ? 'right-aligned' : 'left-aligned';
                                                } else if (userRole <= 2) {
                                                    side = message.destination == 1 ? 'right-aligned' : 'left-aligned';
                                                }
                                                if (statusIndex != message.status) {
                                                    statusIndex = message.status;
                                                    return <Message $key={`message-history-container${i}`} 
                                                        message={message} 
                                                        show={true} 
                                                        side={side} 
                                                        key={`message-content-${i}`} type={'message'} 
                                                        processMessage = {this.props.processMessage}
                                                        />
                                                } else {
                                                    return <Message $key={`message-history-container${i}`} 
                                                        message={message} 
                                                        show={true} 
                                                        side={side} 
                                                        key={`message-content-${i}`} type={'message'} 
                                                        processMessage = {this.props.processMessage}
                                                        />
                                                }
                                            }
                                        })}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="messages-area" ref="messages">
                            
                        </div>
                        <MessageInput ref="message" 
                            $key={`chat-${this.state.booking.id}`}
                            user={user} 
                            role={this.state.user.role_id} 
                            booking={this.state.booking} 
                            addMessageLocally={this.addMessageLocally.bind(this)} 
                            isTyping={this.isTyping.bind(this)} 
                            readMessages={this.readMessages.bind(this)}
                            onRef={ref => (this.messageInput = ref)}
                            Localization={Localization}
                            />
                    </div>
                );
            } catch(ex){
                return ex;
            }
        }
        return (
            <div className="chat_app" ></div>
        );
    }
}

// if(document.getElementById('react-chat')){
//     let chatDiv = document.getElementById('react-chat');
//     let connection = chatDiv.dataset.connection;
//     ReactDOM.render( <Chat connection={connection}/>, document.getElementById('react-chat'));
// }
export default Chat;