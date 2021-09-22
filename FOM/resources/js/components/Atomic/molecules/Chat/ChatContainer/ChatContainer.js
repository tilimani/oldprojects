import React, { useState, useEffect } from 'react';
import TextInput from '../../../atoms/TextInput/TextInput';
import MessageBubble, {TextContainer, TimeContainer} from '../../../atoms/MessageBubble/MessageBubble';
import './styles.scss'

const ChatContainer = ({children, messages}) => {

    return (
        <div className="chat-app">
            <div className="chat-container">
                <div className="copyable-area">
                    <div className="messages-container">
                        <div className="messages-area">
                            {
                                messages.map((message, index) => {
                                    let type = '';
                                    if (message.to =='13024824478') {
                                        type = 'in';
                                    } else {
                                        type = 'out';
                                    }
                                    return (
                                        <MessageBubble type = {type} key={`messagebubble-${index}`}>
                                            <TextContainer message={message.body}/>
                                            <TimeContainer time={message.created_at}/>
                                        </MessageBubble>
                                    );
                                })
                            }
                        </div>
                    </div>
                </div>
            </div>
            {children}
        </div>
    );
};
export const ChatInput = ({setMessages, messages, from, test = false}) => {
    
    return (
        <>
            <footer className="chat-footer">
                <div className="input-container">
                    <div className="input-holder">
                        <TextInput
                            setMessages={setMessages}
                            button={true}
                            from={from}
                            test={test}
                            messages={messages}
                        />
                    </div>
                </div>
            </footer>
        </>
    )
};
export default ChatContainer;