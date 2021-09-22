import React, { useState, useEffect } from 'react';
import './styles.scss';

const TextInput = ({
    status = 1,
    button = false,
    from,
    setMessages,
    messages,
    test
}) => {

    const eventHandler =  (e) => {
        let content = document.querySelector('.custom-input').value;
        
        if ((e.keyCode === 13 && !e.shiftKey) || e.type == "click") {

            if (content === ''){
                return ;
            }

            e.stopPropagation();
            e.preventDefault();
            
            let message = {
                num_media: 0,
                body: content,
                to: from,
                from: 13024824478,
                api_version: '2010-04-01',
                num_segments: 1,
                created_at: new Date()
            };
            
            if (!test) {
                status = -1;
                axios.post('/api/v1/webhook/post', message).then((data)=>{
                    if (data.status === 200) {
                        status = 1;
                        let temp = [...messages];
                        temp.push(message);
                        setMessages(temp);
                        temp = [];
                    }
                }).catch((error) => {
                    console.error(error);
                });

            } else {
                let temp = [...messages];
                temp.push(message);
                setMessages(temp);
                temp = [];
            }
            document.querySelector('.custom-input').value = '';
        }
    }
    return (
        <div className="input-wrapper">
            <textarea
                className="custom-input"
                placeholder="Escribe un mensaje"
                maxLength="250"
                onKeyDown={eventHandler.bind()}
                disabled={status < 1}></textarea>
            {
                button &&
                <button className="button-send" onClick={eventHandler}/>
            }
        </div>
    );
};

export default TextInput;