import React from 'react';
import './SendMessage.scss';

const MessageInput = (props) => {

    return (                     
        <button className="send-button" onClick={props.clickHandler}></button>        
    );
};
export default MessageInput;
