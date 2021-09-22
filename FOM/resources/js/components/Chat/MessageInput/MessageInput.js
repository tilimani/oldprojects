import React, {Component} from 'react';
import SendMessage from "./../SendMessage/SendMessage";
import './MessageInput.scss';

class MessageInput extends Component {
    constructor(props) {
        super(props);
        // this.state = {
        //     isSending: false,
        // }
        // let messageInput = document.querySelector('.custom-input');
        // messageInput.addEventListener('keydown', (e) => {
        //     console.log(messageInput.value);
        // });
    }

    componentDidMount(){
        this.props.onRef(this);
    }

    componentWillUnmount(){
        this.props.onRef(this);
    }

    sendMessageHandler(e,customMessage = ''){
        if ((e.keyCode === 13 && !e.shiftKey) || e.type == "click") {
            e.preventDefault();
            let isSending = false;
            let inputText = this.refs.message.value;
            if(customMessage != ''){
                inputText = customMessage;
            }
            if (inputText == "") {
                return;
            }

            let destination = (parseInt(this.props.role) == 3) ? 0 : 1;
            let message = {
                bookings_id: this.props.booking.id,
                message: inputText,
                destination: destination,
                status: this.props.booking.status,
                read: 0,
                created_at: new Date()
            };


            isSending = true;
            this.props.addMessageLocally(message, isSending);
            axios.post('/message/post', message).then((data)=>{
                if (data.status === 200) {
                    isSending = false;
                    this.props.addMessageLocally(message,isSending)
                }
            }).catch((error) => {
                let message = {
                    message: 'No se pudo enviar el mensaje.' + error,
                };
                console.error(message.message);
            });
            this.refs.message.value = "";
        } else {
            // this.props.isTyping();
        }
    }
    focusHandler(e) {
        this.props.readMessages();
    }

    render() {
        let Localization = this.props.Localization;
        return (
            <footer className="input-footer" key={this.props.$keys}>
                <div className="input-container">
                    <div className="input-holder">
                        <div className="input-wrapper">
                            {/* <div
                                onKeyDown={this.sendMessageHandler.bind(this)} 
                                onFocus={this.focusHandler.bind(this)}
                                className="custom-input"
                                contentEditable={true}>Escribe tu mensaje aquí.</div> */}
                            <textarea  
                                className="custom-input add-opacity-short" 
                                placeholder={Localization.trans('write')} 
                                maxLength="250" 
                                ref="message"
                                onKeyDown={this.sendMessageHandler.bind(this)} 
                                onFocus={this.focusHandler.bind(this)}
                                disabled={this.props.booking.status < 1}></textarea>
                            {/* <div className="button_container">
                                <div className="button_holder">
                                    <span>
                                    </span>
                                </div>
                            </div> */}
                            <SendMessage clickHandler={this.sendMessageHandler.bind(this)}></SendMessage>
                        </div>
                    </div>
                </div>
            </footer>
            // <div className="message-input">
            //     <textarea ref="message" className="add-opacity-short" placeholder="Escribe tu respuesta..." maxLength="250" onKeyDown={this.sendMessageHandler.bind(this)} onFocus={this.focusHandler.bind(this)}></textarea>
            //     <SendMessage clickHandler={this.sendMessageHandler.bind(this)} />
            // </div>
        );
    }
}
export default MessageInput;
