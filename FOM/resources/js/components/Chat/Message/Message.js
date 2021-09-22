import React from 'react';
import './Message.scss';

const Message = (props) => {
    const componentClasses = [];
    let seenArrow = '';
    if (props.show) {
        componentClasses.push(props.side == 'right-aligned' ? 'out' : 'in');
        seenArrow = props.side != 'right-aligned' ? 'd-none' : '';
    };

    let formatMessageDate = (created_at)=>{
        let date = new Date(created_at),
            options = { month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: 'true',timeZoneName: 'short' };
        // return date.toISOString();

        return date.toLocaleDateString('es-co', options);
    };

    let changeIcon = (status) => {
        let statusNumber = parseInt(status);
        if (props.message)
        switch (statusNumber) {
            case 0:
                return 'sending';
            case 1:
                return 'sended';
            case 2:
                return 'readed';
            default:
                return 'sended'
        }
    }

    return (
        <div className="message-chat" key={props.$key}>
            <div className={`message ${componentClasses.join(' ')} tail`}>
                <div className="text-container ">
                    <div className="coopyable-text">
                        <div className="text-holder">
                            <span className="selectable-text invisible-space">
                                {props.processMessage(props.message.message)}
                                {/* {props.message.message} */}
                            </span>
                        </div>
                    </div>
                </div>
                <div className="time-container">
                    <div className="copyable-text">
                        <div className="time-holder">
                            <span className="selectable-text invisible-space">
                            {formatMessageDate(props.message.created_at)}<span className={changeIcon(props.message.read) + ` ${seenArrow}`}></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
    // <div className={"Message "+ props.side}>
    //     <p className={componentClasses.join(' ')}>{props.message.message}</p>
    //     <span className={"time " + props.side}>{formatMessageDate(props.message.created_at)}</span><span className={changeIcon(props.message.read) + ` ${seenArrow}`}></span>
    // </div>
};

export default Message;
