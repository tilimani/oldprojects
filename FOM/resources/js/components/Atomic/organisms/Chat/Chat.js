import React, { useState, useEffect } from 'react';
import ChatContainer, {ChatInput} from '../../molecules/Chat/ChatContainer/ChatContainer';
import Axios from 'axios';

const Chat = ({
    from,
    test = false,
    messagesChat
}) => {

    const [messages, setMessages] = useState([]);

    const fetchMessages = (from) => {

        let messages = [];
        messages = [
            {
                from: 573194924382,
                to: 13024824478,
                body: `hello 1 ${from}`,
                created_at: new Date()
            },
            {
                from: 573194924383,
                to: 13024824478,
                body: `hello 1 ${from}`,
                created_at: new Date()
            },
            {
                from: 573194924384,
                to: 13024824478,
                body: `hello 1 ${from}`,
                created_at: new Date()
            },
        ];
        return messages;
    };

    useEffect( () => {
        if (test) {
            setMessages(fetchMessages(from));
        } else {
            setMessages(messagesChat);
        }
    }, [from, messagesChat]);

    return (
        <>
            <ChatContainer messages={messages} key={`chat-${from}`}>
                <ChatInput
                    setMessages={setMessages.bind()}
                    messages={messages}
                    from={from}
                    test={test}
                />
            </ChatContainer>
        </>
    );
};

export default Chat;




