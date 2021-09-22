import React, { Component } from 'react';
import ReactDOM from "react-dom";
import '../../pages/WebhookWhatsapp/styles.scss';

import ChatAccess from '../../organisms/ChatAccess/ChatAccess';
import Chat from '../../organisms/Chat/Chat';
import Axios from 'axios';

class WebhookWhatsapp extends Component {
    constructor(props) {
        super(props);
        this.state = {
            chats: [],
            from: null,
            messages: []
        };
    }

    componentWillMount() {

    }

    componentDidMount() {
        Axios.get('/api/v1/webhook/index').then((response) => {
            if(response.status === 200) {
                this.setState({chats: response.data});

            }
        });
        let echoChannel = window.Echo.private(`ApiMessagesChannel.13024824478`)
            .listen('ApiMessageReceived', (event) => {

                let newChat = event.apiMessage;

                if (newChat.from === this.state.from || newChat.to === this.state.from) {
                    let messages = [... this.state.messages];
                    messages.push(newChat);
                    this.setState({messages: messages});

                }

                let chats = this.processChats(newChat, [...this.state.chats]);
                if (newChat.from == '13024824478') {
                    let tempTo = newChat.to;
                    newChat.from = tempTo;
                    newChat.to = '13024824478';
                }

                chats.push(newChat);

                this.setState({chats: chats});
                
            });

        this.setState({echoChannel});
    }

    processChats(newChat, chats) {
        return [...chats].filter((chat) => chat.from != newChat.from && chat.from != newChat.to);
    }

    componentWillReceiveProps(nextProps) {

    }

    componentWillUpdate(nextProps, nextState) {

    }

    componentDidUpdate(prevProps, prevState) {

    }

    componentWillUnmount() {

    }

    openChat(from) {
        this.setState({from});
        Axios.get(`/api/v1/webhook/get/${from}`).then((response) => {
            if(response.status === 200) {
                this.setState({messages: response.data});
                
            }
        });
    }
    
    reverseArray(array = []) {
        return [... array].reverse();
    }

    render() {
        let chats = this.reverseArray(this.state.chats);
        let messagesChat = this.state.messages;
        let from = this.state.from;
        return (
            <div className="app">
                <div className="main">
                    <div className="app-wrapper">
                        <div className="main-wrapper">
                            <ChatAccess 
                                chats={chats}
                                openChat={this.openChat.bind(this)}/>
                            {
                                from && 
                                <Chat from={this.state.from}
                                    test={false}
                                    messagesChat={messagesChat}
                                />
                            }
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}


const rootElement = document.getElementById("react-webhookwhatsapp");
if (rootElement) {
    const connection = rootElement.dataset.info;
    ReactDOM.render(<WebhookWhatsapp connection={connection}/>, rootElement);
}

export default WebhookWhatsapp;


