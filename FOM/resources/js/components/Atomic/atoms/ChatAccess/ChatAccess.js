import React from 'react';
import './styles.scss';

const ChatAccess = ({children}) => {
    return (
        <div className="chat-access">
            <div className="content">
                {children}
            </div>
        </div>
    );
};

export const TextContainer = ({children}) => {
    return (
        <div className="text-container">
            {children}
        </div>
    );
};

export const MainTittle = ({children}) => {
    return (
        <div className="main-tittle">
            {children}
        </div>
    );
};

export const MainContent = ({children}) => {
    return (
        <div className="main-content">
            {children}
        </div>
    );
};

export const SecondContent = ({children}) => {
    return (
        <div className="secondary-content">
            {children}
        </div>
    );
};

export const Content = ({children}) => {
    return (
        <div className="content">
            {children}
        </div>
    );
};

export const Text = ({text, capitalize}) => {
    return (
        <div className={`text ${capitalize ? 'capitalize': ''}`}>
            {text}
        </div>
    );
}

export default ChatAccess;