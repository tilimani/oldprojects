import React, { Component } from 'react'
import './ProcesStatus.scss';
import {NotificationConsumer, NotificationProvider} from './../Communication/NotificationContext';
import Cointainer from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Media from 'react-bootstrap/Media'
import Button from 'react-bootstrap/Button';
import ButtonToolbar from 'react-bootstrap/ButtonToolbar';
import Modal from 'react-bootstrap/Modal';
import Axios from 'axios';
import DenyModal from '../DenyModal/DenyModal';
import SuccessSmile from '../images/SuccessSmile.svg';


class ProcesStatus extends Component {
    constructor(props){
        super(props);
        let role_id = this.props.role_id,
            booking = this.props.booking,
            notification = this.props.notification;

        this.state={
            role_id,
            booking,
            notification,
            showConfirmationModal: false
        }
    }

    processClassName(status, bmode){
        let mode = (bmode == 1) ? 'online': 'offline',
            res = '';
        if (mode == 'online') {
            res += 'online ';
        } else {
            res += 'offline ';
        }
        switch(status){
            case 1: 
                res += 'waiting ';            
            break;
            case 3:
                res += 'available ';
            break ;
            case 4:
                res += 'confirmed ';
            break;
            case 5:
                res += 'payment ';            
            break;
            case 50:
                res += 'payment-check ';
            break;
            case -4:
                res += 'payment-cancelled ';
            break;   
            case -21:
                res += 'block';
            break;
            case -22:
                res += 'deny';
            break;
            case -1:
                res += 'deny';
            break;
            case 100:
                res += 'deny';
            break;
        }
        return res;
    }

    handleShowConfirmationModal(){
        this.setState({
            showConfirmationModal: true
        })
    }

    handleConfirmationClose(){
        this.setState({
            showConfirmationModal: false
        })
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

    acceptBooking(booking){
        let booking_id = booking.id;
        console.log(booking_id);
        Axios.post('/api/booking/accept', {
                id: booking_id
            }).then((response) => {
                console.log(response);
            this.setState({
                showConfirmationModal:false
            })
        });
    }
    redirectPayment(booking){
        window.open(`/payments/deposit/${booking.id}`, '_blank');
    }
    redirectHouse(house_id){
        window.open(`/houses/${house_id}`, '_blank');
    }

    render() {
        let _this = this,
            i = 0,
            role_id = this.state.role_id,
            booking = this.state.booking,
            notification = _this.state.notification,
            status = notification.data.status,
            mode = notification.data.booking_mode,
            paymentHour = this.addDays(notification.data.updated_at.date, 1),
            Localization = this.props.Localization,
            vicos = this.props.vicos,
            rooms = this.props.rooms;
        //role_id == 3
        if (role_id == 3) {
            //mode == 1
            if (mode == 1) { // online
                switch (status) {
                case -1: return(<>
                        <header className="chatHeader sticky-0">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status danger">
                                        <i className="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span>{Localization.trans('cancelled_request')}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('cancelled_byuser')}
                                    </span>
                                </div>
                            </div>
                        </header> 
                    </>)
                case 1:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number}</strong>
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                            
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        {/* <span className="fs-em-9">{`${notification.data.user_name}`} {Localization.trans('personal_visit')} <i className="fas fa-arrow-right vico-color float-right"></i></span> */}
                                        <span className="fs-em-9">{Localization.trans('visit_time')} <i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header> 
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>     
                        </>
                    );
                break;
                case 2:
                    return (<>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9"></span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>cambio a la {Localization.trans('room')} {notification.data.room_number} - {notification.data.house_name} deseas aceptarlo?</strong>.
                                    </span>
                                    <Button variant="primary" onClick={this.props.openChangeRoomModal}>Ver cambio</Button>
                                </div>
                            </div>
                        </header>
                    </>);
                break;
                case 3:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number}</strong>
                                    </span>                                    
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                        
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                    <small className="text-muted">{Localization.trans('room_available')}.</small>
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>      
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                   
                        </>
                    );
                break;
                case 4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"></small></span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {notification.data.user_name} {Localization.trans('invited')}  
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader sticky-0">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{`Tienes hasta mañana a las  ` + paymentHour.getHours()}:{paymentHour.getMinutes()}:{paymentHour.getSeconds() + ` para realizar el pago`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <div className="_content">
                                        <div className="_item">
                                            <Button variant="primary" onClick={this.redirectPayment.bind(this, booking)} className="">
                                                {Localization.trans('pay')}
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectPayment.bind(this, booking)} className="">
                                            {Localization.trans('pay')}
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>      
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                   
                        </>
                    );
                break;
                case 5:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('reserve_paid')} - <small className="text-muted">{Localization.trans('deposit_pay')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                    </span>
                                </div> */}
                            </div>
                        </header>     
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                 
                        </>
                    );
                break;
                case 50:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Pagos en revisión</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        Esperando confirmación de pago
                                    </span>
                                </div>
                            </div>
                        </header>         
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>              
                        </>
                    );
                break;
                case -4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status danger">
                                        <i className="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('payment_expired')}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('waiting_for')} {notification.data.user_name} {Localization.trans('restart_payment')}
                                    </span>
                                </div>
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                    
                        </>
                    );
                break;
                case 100:
                    return(
                        <>                
                        </>
                    );
                break;
                default:
                    return null;
            }
            } else {
                switch (status) {
                    case -1: return(<>
                        <header className="chatHeader sticky-0">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status danger">
                                        <i className="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span>{Localization.trans('payment_expired')}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('reserve_cancelled')}
                                    </span>
                                </div>
                            </div>
                        </header> 
                    </>)
                    case 1:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status uncheck">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status uncheck">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{`${notification.data.user_name}`} {Localization.trans('personal_visit')} <i className="fas fa-arrow-right vico-color float-right"></i></span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                        </span>
                                    </div> */}
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status uncheck">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{Localization.trans('48_hours')}</span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                        </span>
                                    </div> */}
                                </div>
                            </header>    
                            </>
                        );
                    break;
                    case 3:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status process">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"></small></span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status uncheck">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{Localization.trans('48_hours')}</span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                        </span>
                                    </div> */}
                                </div>
                            </header> 
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                                <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                            
                            </>
                        );
                    break;
                    case 60:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>
                                            Visita: Mar., 09 mayo 10:00 am
                                        </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Visita confirmada / Realizada
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status process">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"></small></span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            {notification.data.user_name} {Localization.trans('invited')}  
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status uncheck">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>
                                                {Localization.trans('48_hours')}
                                            </span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            
                                        </span>
                                    </div> */}
                                </div>
                            </header>    
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                                <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                            
                            </>
                        );
                    break;
                    case 4:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>
                                            Visita: Mar., 09 mayo 10:00 am
                                        </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Visita confirmada / Realizada
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"></small></span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            {notification.data.user_name} {Localization.trans('invited')}  
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader sticky-0">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status process">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>
                                            {`Tienes hasta mañana a las  ` + paymentHour.getHours()}:{paymentHour.getMinutes()}:{paymentHour.getSeconds() + ` para realizar el pago`}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <div className="_content">
                                            <div className="_item">
                                                <Button variant="primary" onClick={this.redirectPayment.bind(this, booking)} className="">
                                                    {Localization.trans('pay')}
                                                </Button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/* <div className="button_container">
                                    <div className="_content">
                                        <div className="_item">
                                            <Button variant="primary" onClick={this.redirectPayment.bind(this, booking)} className="">
                                                {Localization.trans('pay')}
                                            </Button>
                                        </div>
                                    </div>
                                </div> */}
                            </header>     
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                           
                            </>
                        );
                    break;
                    case 5:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>
                                            Visita: Mar., 09 mayo 10:00 am
                                        </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Visita confirmada / Realizada
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            
                                        </span>
                                    </div> */}
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{Localization.trans('reserve_paid')} - <small className="text-muted">{Localization.trans('deposit_pay')}</small></span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                        </span>
                                    </div> */}
                                </div>
                            </header>       
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                         
                            </>
                        );
                    break;
                    case 50:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>
                                            Visita: Mar., 09 mayo 10:00 am
                                        </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Visita confirmada / Realizada
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            
                                        </span>
                                    </div> */}
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status process">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>Pagos en revisión</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Esperando confirmación de pago
                                        </span>
                                    </div>
                                </div>
                            </header>    
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                             
                            </>
                        );
                    break;
                    case -4:
                        return(
                            <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{notification.data.house_name}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>
                                            Visita: Mar., 09 mayo 10:00 am
                                        </span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            Visita confirmada / Realizada
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status check">
                                            <i className="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                        <span>{`${notification.data.date_from} - ${notification.data.date_to}`}<small className="text-muted"> - {Localization.trans('room_available')}</small></span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            
                                        </span>
                                    </div> */}
                                </div>
                            </header>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status danger">
                                            <i className="fas fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span>{Localization.trans('payment_expired')}</span>
                                        </div>
                                    </div>
                                    <div className="_content_secondary">
                                        <span>
                                            {Localization.trans('waiting_for')} {notification.data.user_name} {Localization.trans('restart_payment')}
                                        </span>
                                    </div>
                                </div>
                            </header>    
                            <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                             
                            </>
                        );
                    break;
                    case 100:
                        return(
                            <>                
                            </>
                        );
                    break;
                    default:
                        return null;
                }
            } 
        } else { //admin or manager
            //mode == 1
            if (mode == 1) { // online
                switch (status) {
                case -22: return(<>
                    <header className="chatHeader sticky-0">
                        <div className="button_image">
                            <div className="_content_status">
                                <div className="_image_status danger">
                                    <i className="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <div className="button_text">
                            <div className="_content_main">
                                <div className="_text">
                                    <span>{Localization.trans('cancelled_request')}</span>
                                </div>
                            </div>
                            <div className="_content_secondary">
                                <span>
                                    {Localization.trans('reserve_cancelled')}
                                </span>
                            </div>
                        </div>
                    </header> 
                </>)
                case 1:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                         <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                             
                        </>
                    );
                break;
                case 2:
                    return (<>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Esperando respuesta de Usuario</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>Para el cambio a la {Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                    </span>
                                </div>
                            </div>
                        </header>
                    </>);
                break;
                case 3:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                         <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                             
                        </>
                    );
                break;
                case 4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} </strong>
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{`${notification.data.user_name} tiene exclusividad para realizar su pago de reserva hasta mañana a las ` + paymentHour.getHours()}:{paymentHour.getMinutes()}</span>
                                    </div>
                                </div>
                                 <div className="_content_secondary">
                                    <span>
                                      {Localization.trans('48_hours')}
                                    </span>
                                </div>
                            </div>
                        </header> 
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                               
                        </>
                    );
                break;
                case 5:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('reserve_paid')} - <small className="text-muted">{Localization.trans('deposit_pay')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                    </span>
                                </div> */}
                            </div>
                        </header>  
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                              
                        </>
                    );
                break;
                case 23:
                    return (
                        <>
                            <header className="chatHeader">
                                <div className="button_image">
                                    <div className="_content_status">
                                        <div className="_image_status danger">
                                            <i className="fas fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <div className="button_text">
                                    <div className="_content_main">
                                        <div className="_text">
                                            <span className="fs-em-9">Usuario Rechazó cambio de habitacion</span>
                                        </div>
                                    </div>
                                    {/* <div className="_content_secondary">
                                        <span>
                                            <strong>Para el cambio a la {Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                        </span>
                                    </div> */}
                                </div>
                            </header>
                            <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                         <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        </>
                    );
                break;
                case 50:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Pagos en revisión</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        Esperando confirmación de pago
                                    </span>
                                </div>
                            </div>
                        </header>  
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                               
                        </>
                    );
                break;
                case -4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status danger">
                                        <i className="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('payment_expired')}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('want_restart_payment')}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('cancel')} Localization={Localization}/>
                                    </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)} className="check">
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                              
                        </>
                    );
                break;
                case 100:
                    return(
                        <>                
                        </>
                    );
                break;
                default:
                    return null;
                }
            } else {
                switch (status) {
                case -22: return(<>
                    <header className="chatHeader sticky-0">
                        <div className="button_image">
                            <div className="_content_status">
                                <div className="_image_status danger">
                                    <i className="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <div className="button_text">
                            <div className="_content_main">
                                <div className="_text">
                                    <span>{Localization.trans('cancelled_request')}</span>
                                </div>
                            </div>
                            <div className="_content_secondary">
                                <span>
                                    {Localization.trans('cancelled_request')}
                                </span>
                            </div>
                        </div>
                    </header> 
                </>)
                case 1:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                         <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>
                        </>
                        // <>
                        // <header className="chatHeader">
                        //     <div className="button_image">
                        //         <div className="_content_status">
                        //             <div className="_image_status uncheck">
                        //                 <i className="fas fa-check"></i>
                        //             </div>
                        //         </div>
                        //     </div>
                        //     <div className="button_text">
                        //         <div className="_content_main">
                        //             <div className="_text">
                        //                 <span className="fs-em-9">{notification.data.house_name}</span>
                        //             </div>
                        //         </div>
                        //         <div className="_content_secondary">
                        //             <span>
                        //                 <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>
                        //             </span>
                        //         </div>
                        //     </div>
                        //     {/* <div className="button_container">
                        //         <div className="_content">
                        //             <div className="_item">
                        //                 <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                        //                     Ver
                        //                 </Button>
                        //             </div>
                        //         </div>
                        //     </div> */}
                        // </header>
                        // <header className="chatHeader">
                        //     <div className="button_image">
                        //         <div className="_content_status">
                        //             <div className="_image_status uncheck">
                        //                 <i className="fas fa-check"></i>
                        //             </div>
                        //         </div>
                        //     </div>
                        //     <div className="button_text">
                        //         <div className="_content_main">
                        //             <div className="_text">
                        //                 <span className="fs-em-9">{Localization.trans('visit_time')} <i className="fas fa-arrow-right vico-color float-right"></i></span>
                        //             </div>
                        //         </div>
                        //         {/* <div className="_content_secondary">
                        //             <span>
                        //                 <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                        //             </span>
                        //         </div> */}
                        //     </div>
                        // </header>
                        // <header className="sticky-0 chatHeader">
                        //     <div className="button_image">
                        //         <div className="_content_status">
                        //             <div className="_image_status uncheck">
                        //                 <i className="fas fa-check"></i>
                        //             </div>
                        //         </div>
                        //     </div>
                        //     <div className="button_text">
                        //         <div className="_content_main">
                        //             <div className="_text">
                        //                 <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                        //                 <>
                        //                 {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                        //                  <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                        //                     {Localization.trans('accept')}
                        //                 </Button> */}
                        //                 </>
                        //             </div>
                        //         </div>
                        //         <div className="_content_secondary">
                        //             <span>
                        //                 {`${notification.data.date_from} - ${notification.data.date_to}`}
                        //             </span>
                        //         </div>
                        //     </div>
                        //     <div className="button_container">
                        //         <div className="_content">
                        //             <div className="_item">
                        //                 <Button variant="primary" onClick={this.acceptBooking.bind(this, booking)} disabled>
                        //                     {Localization.trans('cancel')}                                        </Button>
                        //             </div>
                        //             <div className="_item">
                        //                 <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)} disabled>
                        //                     {Localization.trans('accept')}
                        //                 </Button>
                        //             </div>
                        //         </div>
                        //     </div>
                        // </header>
                        // <header className="chatHeader">
                        //     <div className="button_image">
                        //         <div className="_content_status">
                        //             <div className="_image_status uncheck">
                        //                 <i className="fas fa-check"></i>
                        //             </div>
                        //         </div>
                        //     </div>
                        //     <div className="button_text">
                        //         <div className="_content_main">
                        //             <div className="_text">
                        //                 <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                        //             </div>
                        //         </div>
                        //         {/* <div className="_content_secondary">
                        //             <span>
                        //                 <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                        //             </span>
                        //         </div> */}
                        //     </div>
                        // </header>                      
                        // <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        //     <Modal.Header closeButton ></Modal.Header>
                        //     <Modal.Body className="text-center">
                        //         <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                        //         <h2 className="text-success mt-3"></h2>
                        //         <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                        //     <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        //     </Modal.Body>
                        //         <Modal.Footer>
                        //             <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                        //                 {Localization.trans('accept')}
                        //             </Button>
                        //         </Modal.Footer>
                        //     </Modal>          
                        // </>
                    );
                break;
                case 3:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}.
                                    </span>                                    
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('visit_time')} <i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                         <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)} >
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>    
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                            <Modal.Header closeButton ></Modal.Header>
                            <Modal.Body className="text-center">
                                <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                                <h2 className="text-success mt-3"></h2>
                                <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                            </Modal.Body>
                                <Modal.Footer>
                                    <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                        {Localization.trans('accept')}
                                    </Button>
                                </Modal.Footer>
                            </Modal>                            
                        </>
                    );
                break;
                case 60:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Visita: Mar., 09 mayo 10:00 a.m<i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('house_user')} {notification.data.user_name}?</span>
                                        <>
                                        {/* <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization} />
                                        <Button variant="primary ml-5" onClick={this.acceptBooking.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button> */}
                                        </>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {`${notification.data.date_from} - ${notification.data.date_to}`}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('deny')} vicos={vicos} rooms={rooms} Localization={Localization}/>
                                     </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}>
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status uncheck">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('48_hours')}</span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header> 
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                     
                        </>
                    );
                break;
                case 4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Visita: Mar., 09 mayo 10:00 a.m<i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{`${notification.data.user_name} Tiene hasta mañana a las  ` + paymentHour.getHours()}:{paymentHour.getMinutes()}:{paymentHour.getSeconds() + ` para realizar su pago`}</span>
                                    </div>
                                </div>
                                    <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('48_hours')}  
                                    </span>
                                </div>
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                   
                        </>
                    );
                break;
                case 5:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Visita: Mar., 09 mayo 10:00 a.m<i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('reserve_paid')} - <small className="text-muted">{Localization.trans('deposit_pay')}</small></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                    </span>
                                </div> */}
                            </div>
                        </header>   
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                   
                        </>
                    );
                break;
                case 50:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Visita: Mar., 09 mayo 10:00 a.m<i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status process">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Pagos en revisión</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        Esperando confirmación de pago
                                    </span>
                                </div>
                            </div>
                        </header>    
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>                   
                        </>
                    );
                break;
                case -4:
                    return(
                        <>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{notification.data.house_name}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong>{Localization.trans('room_available')}
                                    </span>
                                </div>
                            </div>
                            {/* <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.redirectHouse.bind(this, notification.data.house_id)} className="">
                                            Ver
                                        </Button>
                                    </div>
                                </div>
                            </div> */}
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">Visita: Mar., 09 mayo 10:00 a.m<i className="fas fa-arrow-right vico-color float-right"></i></span>
                                    </div>
                                </div>
                                {/* <div className="_content_secondary">
                                    <span>
                                        <strong>{Localization.trans('room')} {notification.data.room_number} - </strong><small>{Localization.trans('room_available')}</small>
                                    </span>
                                </div> */}
                            </div>
                        </header>
                        <header className="chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status check">
                                        <i className="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                    <span className="fs-em-9">{`${notification.data.date_from} - ${notification.data.date_to}`}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                                
                                    </span>
                                </div>
                            </div>
                        </header>
                        <header className="sticky-0 chatHeader">
                            <div className="button_image">
                                <div className="_content_status">
                                    <div className="_image_status danger">
                                        <i className="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="button_text">
                                <div className="_content_main">
                                    <div className="_text">
                                        <span className="fs-em-9">{Localization.trans('payment_expired')}</span>
                                    </div>
                                </div>
                                <div className="_content_secondary">
                                    <span>
                                        {Localization.trans('want_restart_payment')}
                                    </span>
                                </div>
                            </div>
                            <div className="button_container">
                                <div className="_content">
                                    <div className="_item">
                                        <DenyModal notification={notification} text={Localization.trans('cancel')} Localization={Localization}/>
                                    </div>
                                    <div className="_item">
                                        <Button variant="primary" onClick={this.handleShowConfirmationModal.bind(this, booking)}  >
                                            {Localization.trans('accept')}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <Modal centered size="sm" dialogClassName="confirmation-modal" show={this.state.showConfirmationModal} onHide={this.handleConfirmationClose.bind(this)}>
                        <Modal.Header closeButton ></Modal.Header>
                        <Modal.Body className="text-center">
                            <img className="mb-2" src={SuccessSmile} height={100} width={100}/>
                            <h2 className="text-success mt-3"></h2>
                            <p className="text-muted mt-5">{Localization.trans('let')} {notification.data.user_name} {Localization.trans('experience')}</p>
                            <p className="text-muted mt-2"><b>{Localization.trans('new')}</b></p>
                        </Modal.Body>
                            <Modal.Footer>
                                <Button className="border-radius mx-auto px-4" variant="success" onClick={this.acceptBooking.bind(this,booking)}>
                                    {Localization.trans('accept')}
                                </Button>
                            </Modal.Footer>
                        </Modal>
                        </>
                    );
                break;
                case 100:
                    return(
                        <>                
                        </>
                    );
                break;
                default:
                    return null;
                }
            }
        }
    }
}

export default ProcesStatus;