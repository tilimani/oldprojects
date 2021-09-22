import React, { Component } from 'react';
import ReactDOM from "react-dom";
import '../../pages/WebhookWhatsapp/styles.scss';

import ChatAccess from '../../organisms/ChatAccess/ChatAccess';
import Chat from '../../organisms/Chat/Chat';

class WebhookWhatsapp extends Component {
    constructor(props) {
        super(props);
        this.state = {
            chats: [            
            {
                from: 573194924382,
                to: 13024824478,
                body: "hello 1",
                created_at: new Date()
            },
            {
                from: 573194924383,
                to: 13024824478,
                body: "hello 2",
                created_at: new Date()
            },
            {
                from: 573194924384,
                to: 13024824478,
                body: "hello 3",
                created_at: new Date()
            },
        ],
            from: null,
        };
    }

    componentWillMount() {

    }

    componentDidMount() {

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
        this.setState({from})
    }

    render() {
        let chats = this.state.chats;
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
                                    test={true}
                                />
                            }
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}


const rootElement = document.getElementById("react-webhookwhatsapp-test");
if (rootElement) {
    const connection = rootElement.dataset.info;
    ReactDOM.render(<WebhookWhatsapp connection={connection}/>, rootElement);
}

export default WebhookWhatsapp;


