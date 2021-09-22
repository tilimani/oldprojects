import React, { Component } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom';
import ChatAccess from "./ChatAccess/ChatAccess";
import './Notification.scss'; 
import Dropdown from 'react-bootstrap/Dropdown';
import Container from 'react-bootstrap/Container';
import Col from 'react-bootstrap/Col';
import Row from 'react-bootstrap/Row';
import Media from 'react-bootstrap/Media';
import Badge from 'react-bootstrap/Badge'
import Toggle from './Toggle/Toggle';
import Menu from './Menu/Menu';
import Countdown from 'react-countdown-now';
import {NotificationConsumer, NotificationProvider} from './../Communication/NotificationContext';
import { error } from 'util';

import 'md5';
  
class Notification extends Component {
    constructor(props) {
        super(props);

        let user_id = this.props.user_id,
            role_id = this.props.role_id,
            pending = this.props.pending,
            unread = this.props.unread,
            accepted = this.props.accepted,
            denied = this.props.denied,
            payment = this.props.payment,
            manager = this.props.manager,
            channel = this.props.channel,
            notifications = this.props.notifications,
            allNotifications = this.props.allNotifications;

        this.state = {
            user_id,
            role_id,
            pending,
            unread,
            accepted,
            denied,
            payment,
            allNotifications,
            notifications,
            manager,
            channel,
            timer: new Date().getTime(),
            showDropdown: false,
        }
        this.searchInput = React.createRef();
    }

    componentDidMount() {
        
    }

    componentDidUpdate () {
        
    }
    
    openChat(bookingData){
        this.props.readNotification(bookingData.booking_id, this.state.user_id);
        this.props.selectChat(bookingData);        
    }

    addDays(date, days) {
        let formattedDate = new Date(date),
            now = new Date(),
            offset = now.getTimezoneOffset(),
            offsetHours = (offset - (offset % 60))/60,
            offsetMinutes = offset % 60;
        formattedDate.setHours(formattedDate.getHours() - offsetHours);
        formattedDate.setMinutes(formattedDate.getMinutes() - offsetMinutes);
        var res = new Date(formattedDate);
        res.setDate(res.getDate() + days);
        return res;
    }
    
    openProfile (user_id){
        window.open(`/useredit/${user_id}`, '_blank');

        return 1;
    }
    
    renderer({days, hours, minutes, seconds}, completed){
        if (completed) {
            return 'Plazo de pago vencido';
        } else {
            let newHours = hours += 24*days;
            return new String(`${('0' + hours).slice(-2)}:${('0' + minutes).slice(-2)}:${('0' + seconds).slice(-2)}`);
        }
    }

    search(){
        this.props.searchHandler(this.searchInput.current);
    }

    filter(key){
        this.props.filterStatus(key,this.searchInput.current);
    }

    unreadNotifications(){
        let unreadedNotifications = 0;
        this.state.allNotifications.forEach(element => {
            if(element.data.status > 0 && element.read_at == null){
                unreadedNotifications++;
            }
        });
        return unreadedNotifications;
    }

    openDropdown (e) {
        // e.preventDefault();
        let open = this.props.showDropdown;
        let dropdownContent = document.querySelector('.dropdown-content');
        if (open) {
            dropdownContent.classList.add('closed');
            dropdownContent.classList.remove('open');
            this.setState({
                showDropdown: false
            });
        } else {
            dropdownContent.classList.add('open');
            dropdownContent.classList.remove('closed');
            this.setState({
                showDropdown: true
            });
        }
    }

    render() {
        let chatNotifications = this.state.notifications;
        const _this = this;
        Localization={Localization}
        let Localization = this.props.Localization;
        return (
            <>
            <div className="notification_app" key={'notification_app'}>
                <div className="_notification_container">
                    <header className="_notification_header dropdown" >
                        <div className="_image_container" onClick={this.openProfile.bind(this, this.state.manager.id)}>
                            <div className="_image_holder">
                                <img
                                    className="_image"
                                    src={`https://fom.imgix.net/${this.state.manager.image}?w=500&h=500&fit=crop`}
                                    alt="User Image"
                                />
                            </div>
                        </div>
                        <div className="_icons_container" onClick={this.props.openDropdown.bind(this)}>
                            <div className={`_icons_holder `}>
                                <span>
                                    <div className="_item">
                                        {Localization.trans('all_bookings')}<i className="fas fa-chevron-down"></i>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div className="_icons_container">
                            <div className="_icons_holder">
                                <span>
                                    <div className="_item">
                                        <span className="notification-bubble float-right">
                                            <span className="badge badge-primary">{(this.state.allNotifications)? this.unreadNotifications():0}</span>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </header>
                    <div className="_notification_search">
                        <div className="_search_holder">
                            <div className="_search_container">
                                <label className="_label_container">
                                    <input className="_input_custom" ref={this.searchInput} placeholder="Buscar..." onChange={this.search.bind(this)}/>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div className="_notification_holder">
                        <div className="_scroll_area" key={this.props.$key}>
                            <NotificationConsumer>
                                {
                                    (notifications) => {
                                        if (notifications.length > 0) {
                                            return (
                                                notifications.map((notification,i)=>{
                                                    var notification = notification;
                                                    if (notification.data.status == 4) {
                                                        return (
                                                            <ChatAccess user={_this.state.manager} 
                                                                notification={notification} 
                                                                openChat={_this.openChat.bind(_this)}
                                                                timer={<Countdown key={`countdown-${i}`} 
                                                                date={_this.addDays(new Date(notification.data.updated_at.date), 2)}
                                                                renderer={_this.renderer.bind(_this)}/>}
                                                                $key={`chat-access${i}`}
                                                                key={`${notification.id}`}
                                                                processMessage = {this.props.processMessage}
                                                                />
                                                        ); 
                                                        
                                                    } else {
                                                        return (
                                                            <ChatAccess user={_this.state.manager} 
                                                                notification={notification} 
                                                                $key={`chat-access${i}`}
                                                                key={`${notification.id}`}
                                                                openChat={_this.openChat.bind(_this)} 
                                                                processMessage = {this.props.processMessage}
                                                                timer=''/>
                                                        );
                                                    }       
                                                })
                                            );
                                        } else {
                                            return null;
                                        }
                                    }
                                }
                            </NotificationConsumer>
                        </div>
                    </div>

                    <div className={`dropdown-content ${(this.props.showDropdown) ? 'open':'closed'}`}>
                        <div key={`pending-${this.state.pending}`} onClick={this.filter.bind(this,'pending')}>
                            <Badge pill variant="danger" className="notification-badge">
                                {this.state.pending}
                            </Badge>
                            <span className="notification-text">{Localization.trans('pending')}</span>
                        </div>
                        <div key={`unread-${this.state.unread}`} onClick={this.filter.bind(this,'unread')}>
                            <Badge pill variant="primary" className="notification-badge unread">
                                {this.state.unread}
                            </Badge>
                            <span className="notification-text denied">{Localization.trans('unread')}</span>
                        </div>
                        <div key={`payment-${this.state.payment}`} onClick={this.filter.bind(this,'payment')}>
                            <Badge pill variant="primary" className="notification-badge">
                                {this.state.payment} 
                            </Badge>
                            <span className="notification-text">{Localization.trans('payment_period')}</span>
                        </div>
                        <div key={`accepted-${this.state.accepted}`} onClick={this.filter.bind(this,'accepted')}>
                            <Badge pill variant="success" className="notification-badge">
                                {this.state.accepted}
                            </Badge>
                            <span className="notification-text">{Localization.trans('accepted')}</span>
                        </div>
                        <div className="text-center" onClick={this.filter.bind(this,'')}>
                            <span className="notification-text denied">{Localization.trans('all_bookings')}</span>
                        </div>
                    </div>
                </div>
            </div>
            </>
        );
    }
}

export default Notification;
