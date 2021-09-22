import React, {useState, useEffect} from 'react';
import './styles.scss';

import SingleChatAccess from '../../molecules/SingleChatAccess/SingleChatAccess';

const ChatAccess = ({
    chats,
    openChat
}) => {

    return (
        <div className="chataccess-app">
            <div className="chataccess-container">
                <div className="chataccess-holder">
                    <div className="scroll-area">
                        {
                            chats.map((chat, index) => {
                                return (
                                    chat.to == '13024824478' &&
                                    <SingleChatAccess chat={chat}
                                        openChat={openChat}
                                        $key={`singlechataccess-${index}`}
                                        key={`singlechataccess-${index}`}
                                    />
                                );
                            })
                        }
                    </div>
                </div>
            </div>
        </div> 
    );
};

export default ChatAccess;