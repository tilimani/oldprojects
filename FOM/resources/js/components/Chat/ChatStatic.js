import React, { Component } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom';
import Message from './Message/Message';
import MessageInput from './MessageInput/MessageInput'
import BookingStatusMessage from './BookingStatusMessage/BookingStatusMessage';
import './Chat.scss';

class ChatStatic extends Component {
    constructor(props) {
        super(props);
        let connection = this.props.connection.split(','),
            user_id = connection[0],
            role_id = parseInt(connection[1], 10),
            booking_id = parseInt(connection[2]),
            booking_status = parseInt(connection[3]),
            myDestination = (role_id == 3) ? 1 : 0;

        this.state = {
            connection: connection,
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
                id: booking_id,
                status: booking_status,
            },
            'history': [],
            messages: [],
            booking_status_messages:[
                'Habitacion Disponible',
                'Solicitud Confirmada',
                'Estado 3',
                'Estado 4',
                'Estado 5'
            ],
            typing: false,
            channel: '',
            echoChannel: ''
        }
    }


    componentDidMount(){
        // console.log(this.state.user);
        this.getMessages(this.state.booking.id);
    }

    componentWillUnmount() {
    }

    change(bookingData) {
        let data = [],
            id = bookingData.booking_id,
            channel = `BookingMessageChannel.${id}`

        axios.get(`/api/message/${id}`).then((response) => {
            data = response.data;
            console.log(channel, this.state.channel);
            if (channel != this.state.channel) {
                this.suscribeChannel('private', channel, 'MessageWasReceived');
            }
            this.setState({
                userChat:{
                    user_image: bookingData.user_image,
                    user_name: bookingData.user_name,
                    country_icon: bookingData.country_icon,
                },
                history: data,
                booking:{
                    id: id,
                    status: bookingData.booking_status,
                },
                channel: channel,
            });
        }).catch((error) => {
            console.log(error);
        });
        
        // this.getMessages(bookingData.booking_id);
    }

    getMessages(id){
        let channel = `BookingMessageChannel.${id}`;
        axios.get(`/api/message/${id}`)
            .then((response) => {
                this.setState({ 'history' : response.data});
                if (channel != this.state.channel) {
                    this.suscribeChannel('private', channel, 'MessageWasReceived');
                }
            }).catch((error) => {
            console.error("Error getting History " + error);
        });
    }

    suscribeChannel(type, channel, event){
        let echoChannel = '';
        if (type === 'private') {
            echoChannel = window.Echo.private(`${channel}`)
            // .here((users) =>{
            //     console.dir(users);
            //     console.log('Aquí en la sala.');
            // })
            // .joining((users) =>{
            //     console.dir(users);
            //     console.log('Está ingresando a la sala.');
            // })
            // .leaving((users) =>{
            //     console.dir(users);
            //     console.log('Se fue de la sala.');
            // })
            .listen(`${event}`, e => {
                // console.log(this.state.user.my_destination + ' ' + e.message.destination)
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
                // console.log(_this.state.typing + ', está escribiendo');
                // console.dir(e);

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
            // this.setState((state) => {
            //     let history = state.history.map((message) => {
            //         if (message.destination == this.state.user.my_destination) {
            //             message.read = 2;
            //         }
            //     });
            //     // state.history.push(history);
            //     return history;
            // });
            // this.setState((state) => {
            //     let messages = state.messages.map((message, i) => {
            //         if (message.destination == this.state.user.my_destination) {
            //             message.read = 2;
            //         }
            //     });
            //     // state.messages.push(messages);
            //     return messages;
            // });
            channel.whisper('read', {
                read: true
            });
        });
    }

    
    componentDidUpdate(){   
        try {
            this.refs.messages.scrollTop = this.refs.messages.scrollHeight;
        } catch(ex) {
            console.error(ex);
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

    render() {
        let history = this.state.history,
            booking_status_messages = this.state.booking_status_messages,
            user = this.state.userChat,
            booking = this.state.booking,
            userRole = this.state.user.role_id,
            messages = this.state.messages,
            statusIndex = 0,
            side = 'left-side';
        if (this.state.booking.id != null) {
            try {
                return  (   
                    <div className="Chat">
                        <div className="messages-area" ref="messages">
                            {
                                history.map((message,i)=>{
                                    if (userRole == 3) {
                                        side = message.destination == 0 ? 'right-aligned' : 'left-aligned';
                                    } else if (userRole <= 2) {
                                        side = message.destination == 1 ? 'right-aligned' : 'left-aligned';
                                    }
                                    if (statusIndex != message.status) {
                                        statusIndex = message.status;
                                        return <div key={`message-history-container${i}`}>
                                            <BookingStatusMessage text={booking_status_messages[statusIndex - 1]}/>
                                            <Message message={message} show={true} side={side} key={`message${i}`} type={'message'} />
                                        </div>
                                    } else {
                                        return <div key={`message-history-container${i}`}>
                                            <Message message={message} show={true} side={side} key={`message${i}`} type={'message'} />
                                        </div>
                                    }
                                })
                            }
                            {
                                messages.map((message,i)=>{
                                    if (userRole == 3) {
                                        side = message.destination == 0 ? 'right-aligned' : 'left-aligned';
                                    } else if (userRole <= 2) {
                                        side = message.destination == 1 ? 'right-aligned' : 'left-aligned';
                                    }
                                    if (statusIndex != message.status) {
                                        statusIndex = message.status;
                                        return <div key={`message-container-${i}`}>
                                            <BookingStatusMessage text={booking_status_messages[statusIndex - 1]}/>
                                            <Message message={message} show={true} side={side} key={`message-content-${i}`} type={'message'} />
                                        </div>
                                    } else {
                                        return <div key={`message-container-${i}`}>
                                            <Message message={message} show={true} side={side} key={`message-content-${i}`} type={'message'} />
                                        </div>
                                    }
                                    // <Message message={message} show={true} side={side} key={i} type={'message'} />;
                                })
                            }
                        </div>
                        <MessageInput ref="message" 
                            key={`chat-${this.state.booking.id}`}
                            user={user} 
                            role={this.state.user.role_id} 
                            booking={booking} 
                            addMessageLocally={this.addMessageLocally.bind(this)} 
                            isTyping={this.isTyping.bind(this)} 
                            readMessages={this.readMessages.bind(this)}/>
                    </div>
                );
            } catch(ex){
                return ex;
            }
        }
        return null;
    }
}

if(document.getElementById('react-chat-static')){
    let chatDiv = document.getElementById('react-chat-static');
    let connection = chatDiv.dataset.connection;
    ReactDOM.render( <ChatStatic connection={connection}/>, document.getElementById('react-chat-static'));
}

