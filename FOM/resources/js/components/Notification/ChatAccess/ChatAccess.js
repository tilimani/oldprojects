import React from 'react';
import Countdown from 'react-countdown-now';
import Userpicture from '../../UserPicture/UserPicture';
import './ChatAccess.scss';
import Col from 'react-bootstrap/Col';

const ChatAccess = (props) => {

    let clickHandler = (e) => {
        props.openChat(props.notification.data);
        // SEGMENT TRACKING INFO
        openChat(
            props.notification.data.booking_id, 
            props.notification.data.status,
            props.notification.data.user_nationallity.name,
            props.notification.data.house_id
        );
    }

    let getNotificationClass = (notification, flag) => {
        let className = "";
        
        if (flag) {
            className += " ";
            className += getNotificationStatus(notification.data.status);
        } else {
            if (notification.data.ismessage == true) {
                className += " message";
            } else {
                className += " ";
                className += getNotificationStatus(notification.data.status);
            }
        }
        return className;

    }

    let getNotificationStatus = (status) => {
        if(status<0){
            return 'canceled';
        }
        switch (status) {            
            case 1:
                return 'now';                
            case 2:
                return '2';
            case 3:
                return '3';
            case 4:
                return 'payment';
            case 5:
                return 'accepted'
            default:
                return status;
        }
    }

    let formatDate = (date) => {        
        let formattedDate = new Date(date);
        let now = new Date();
        let offset = now.getTimezoneOffset();
        let offsetHours = (offset - (offset%60))/60;
        let offsetMinutes = offset%60;
        formattedDate.setHours(formattedDate.getHours() - offsetHours);
        formattedDate.setMinutes(formattedDate.getMinutes() - offsetMinutes);     
        if(now.getMonth() > formattedDate.getMonth() || now.getDate()>formattedDate.getDate()){
            return ('0' + formattedDate.getDate()).slice(-2) + "/"+ ('0' + formattedDate.getMonth()).slice(-2) + "/" + formattedDate.getFullYear().toString().slice(-2);            
        }
        return ('0' + formattedDate.getHours()).slice(-2) + ":" + ('0' + formattedDate.getMinutes()).slice(-2);
    }

    let readedNotification = (readAt) =>{
        if (
            props.user.role_id == 3 && props.notification.data.sender == 'user'
        ) {
            return 'read';
        } else {
            return readAt == null ? 'unread' : 'read';
        }
        // return readAt == null ? 'unread' : 'read';
    }

    let isOnlineBooking = (mode) => {
        return mode == 0 ? 'online' : '';
    }

    let addDays = (date, days) => {
        var res = new Date(date);
        res.setDate(res.getDate() + days);
        return res;
    }

    let processMessage = (message, status) => {
        if (status == 5) {
            return message;
        } else {
            if (message.length > 15) {
                return new String(message).substring(0, 15).concat('...');
            } else {
                return new String(message).substring(0, 15);
            }
        }
    }

    let processVicoName = (vicoName, roomNumber, count) => {
        if (props.user.role_id == 3) {
            return new String(`${vicoName} - Hab#${roomNumber}`);
        } else {
            if (count > 0) {
                return new String(`${vicoName} - Hab#${roomNumber}`);
            } else {
                return new String(`Hab #${roomNumber}`);
            }
        }
    }

    return (
        
        ((props.notification.data.status > 0 && props.notification.data.status < 100) && props.user.role_id < 3 || props.user.role_id==3) &&
            <div className={`_item  ${readedNotification(props.notification.read_at)}`}  onClick={clickHandler}>
                <div className="_content">
                    <div className="_image_container">
                        <Userpicture size='sm' user_gender={props.notification.data.user_genere} user_image={props.notification.data.user_image} country_icon={props.notification.data.country_icon}/>
                    </div>
                    <div className="_text_container">
                        <div className="_main_tittle">
                            <div className="_main_content">
                                <span className="text-capitalize">
                                    {props.notification.data.user_name} {props.notification.data.user_lastname != null ? props.notification.data.user_lastname[0] : ''}
                                </span>
                            </div>
                            <div className="_secondary_content">
                                <span>{formatDate(props.notification.created_at)}</span>
                            </div>
                        </div>
                        <div className="_main_content">
                            <div className="_content">
                                <div className="_text_1">
                                    <span>
                                        <span className={(props.notification.data.status == 5 && props.notification.data.ismessage) ? "icon " + getNotificationClass(props.notification, true): ''}></span>
                                        {processVicoName(props.notification.data.house_name, props.notification.data.room_number, props.notification.data.vico_count)}
                                    </span>
                                </div>
                            </div>
                            <div className="_second_content">
                                
                            </div>
                        </div>
                        <div className="_main_content">
                            <div className="_content user_name">
                                <div className="_text_1">
                                <span className={"icon " + getNotificationClass(props.notification, false)}></span>
                                <span className={(props.notification.data.status == 4) ? 'vico-name':''}>{props.processMessage(props.notification.data.message)}</span>
                                </div>
                            </div>
                            <div className="_second_content">
                                {props.timer}
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    
        // <Col xs={12} sm={12} md={12} lg={12}>
        //     <div key={props.notification.id} className={"Chat-access " + getNotificationClass(props.notification) + " add-opacity " + readedNotification(props.notification.read_at)} onClick={clickHandler}>
        //         <div className="user-image-opacity">
        //             <img className="user-image" src={`https://fom.imgix.net/${props.notification.data.user_image}?w=500&h=500&fit=crop`}/>
        //         </div>
        //         <div className="flag-image-opacity">
        //             <img className="user-flag" src={`../../images/flags/${props.notification.data.country_icon}`}/>
        //         </div>
        //         <span className={"message-hour " + readedNotification(props.notification.read_at)}>{formatDate(props.notification.created_at)}</span>
        //         <div className={"visit-type " + isOnlineBooking(props.notification.data.booking_mode)}></div>
        //         <div className="user-info">
        //             <span className={"username " + readedNotification(props.notification.read_at)}>{props.notification.data.user_name}</span>
        //             <span className={"vico-name "  + readedNotification(props.notification.read_at)}>{processVicoName(props.notification.data.house_name, props.notification.data.room_number, props.notification.data.vico_count)}</span>
        //             <span className={"icon " + getNotificationClass(props.notification)}></span>
        //             <span className={"message "  + readedNotification(props.notification.read_at)}>
        //                 {processMessage(props.notification.data.message, props.notification.data.status)}
        //             </span>
        //             <span className="float-right timer">{props.timer}</span>
        //         </div>
        //     </div>
        // </Col>
    );
};

export default ChatAccess;
