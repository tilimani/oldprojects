import React from 'react';
import './BookingStatusMessage.scss';

const BookingStatusMessage = (props) => {
    return (                            
        <hr key={props.$key} className="hr-text add-opacity" data-content={props.text}></hr>          
    );
};

export default BookingStatusMessage;