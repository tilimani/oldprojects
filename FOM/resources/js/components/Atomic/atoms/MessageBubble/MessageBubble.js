import React, { useState, useEffect } from 'react';
import './styles.scss';

const MessageBubble = ({children, type}) => {
    return (
        <div className="message-chat">
            <div className={`message ${type} tail`}>
                {children}
            </div>
        </div>
    );
};

export const TextContainer = ({message}) => {
    const processMessage = (message) => {
        if(message != null){
            message = message.replace(/\r?\n|\r/g), '';
            message = message.replace(/([1-9]+[\- ]?[1-9]+[\- ]?[1-9]+[\- ]?[1-9])/g, '*****');
    
            return message;
        }
    };
    return (
        <div className="text-container">
            <div className="copyable-text">
                <div className="text-holder">
                    <span className="selectable-text invisble-space">{processMessage(message)}</span>
                </div>
            </div>
        </div>
    );
}

export const TimeContainer = ({time}) => {

    const formatTime = (time) => {
        let date = new Date(time),
            options = { month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: 'true',timeZoneName: 'short' };

        return date.toLocaleDateString('es-co', options);
    }
    return (
        <div className="time-container">
            <div className="copyable-text">
                <div className="time-holder">
                    <span className="selectable-text invisible-space">
                        {
                            formatTime(time)
                        }
                    </span>
                </div>
            </div>
        </div>
    );
}

export default MessageBubble;