import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import CustomDropdownToggle from "../../Atomic/molecules/CreatePreLogin/CustomDropdownToggle";
import CustomDropdownMenu from "../../Atomic/molecules/CreatePreLogin/CustomDropdownMenu";

import FormBootstrap from 'react-bootstrap/Form';

import InputGroup from 'react-bootstrap/InputGroup';
import Dropdown from 'react-bootstrap/Dropdown';
import Col from 'react-bootstrap/Col';
import { Formik, Field, Form } from 'formik';

import Header from '../../images/invitation_header.jpg';

import './Send.scss';
import axios from 'axios';

export default class SendInvitation extends Component {
    constructor(props){
        super(props);
        this.state={
            vicos:false,
            rooms:false,
            vicoTitle: 'Mis VICO',
            roomTitle: '',
            roomId: '',
            sendViaEmail:false,
            depositPrice:'0',
            link:null
        }
    }

    getHouses(user_id) {
        return axios.get(`/api/v1/user/houses/${user_id}`);
    }

    getHouseRooms(house_id,name) {
        axios.get(`/api/v1/rooms/house/${house_id}`).then((response) => {
            let rooms = response.data;
            this.setState({
                rooms: rooms,
                vicoId:house_id,
                vicoTitle:name
            });
        })
    }

    componentDidMount(){
        let managerVicos = this.getHouses(this.props.userId);
        managerVicos.then((response) => {
            let vicos = response.data;
            this.setState({
                vicos
            })
        });
    }

    checkRoomAvailable(room){
        // let bookingDateFrom = this.state.selectedNotification.data.date_from.split('.');
        // let bookingFrom = new Date('20' + bookingDateFrom[2],parseInt(bookingDateFrom[1])-1,bookingDateFrom[0]);
        // let roomDate = room.available_from.split('-')
        // let roomAvailableFrom = new Date('20' + roomDate[0],parseInt(roomDate[1])-1,roomDate[2]);
        // if(bookingFrom >= roomAvailableFrom){
        //     return false;
        // }else {
        //     return true;
        // }
    }

    handleRoomChange(id,number) {
        let payload = {
            roomIds:[id]
        }
        axios.post('/api/rooms',payload).then((response)=>{
            this.setState({
                roomTitle: 'Habitación #'+ number,
                depositPrice: response.data[0].price,
                roomId: id,
            });
        })
    }
    
    copyToClipboard(){
        document.querySelector('#link').select();
        document.execCommand('copy');
    }

    isSendButtonDisabled(){
        if(!this.state.roomId){
            return true;
        }
    }

    validateEmail(value){
        let errors = {};
        if(!value.email && value.sendViaEmail){
            errors.email = 'Required';
        } 
        else if(!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(value.email)){
            errors.email = 'Invalid Emails';
        }
        // if(value.email && value.sendViaEmail && /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(value.email)){
        //     errors.email = null;
        // }
        return errors.email;
    }

    render() { 
        let {vicos,rooms,depositPrice,roomId} = this.state;
        return ( <div className="invite_view">
                <div className="top-image">
                    <img src={Header}/>
                    <p className="title">INVITAR HUESPED</p>
                </div>

                <Formik
                    enableReinitialize
                    initialValues={{ 
                        depositPaid: false,
                        sendViaEmail:false,
                        isNewDepositPrice:false,
                        depositPrice:depositPrice,
                        email:'',
                        roomId: roomId }}
                    onSubmit={(values, actions) => {
                        axios.post('/api/invitation/send',values).then((response)=>{
                            this.setState({
                                link: window.location.host + '/invitation/' + response.data
                            })
                            document.querySelector('.loadersmall').classList.remove('loadersmall');
                        })
                    }}  
                    render={ (props,errors) => (
                        <form onSubmit={props.handleSubmit}>
                        <div>
                            <div className="vicos-container">
                            {vicos && <Dropdown>
                                <Dropdown.Toggle as={CustomDropdownToggle} className="btn" style={{margin: 0}}>
                                    {
                                        (this.state.vicoTitle.length > 0) ? `${this.state.vicoTitle}` : 'Seleccionar'
                                    }
                                </Dropdown.Toggle>
                                <Dropdown.Menu as={CustomDropdownMenu} className="custom-dropdown-menu">
                                    {
                                        this.state.vicos.map(({ id, name }) => {
                                            if (id == this.state.vicoId) {
                                                return <Dropdown.Item eventKey={id} key={id} selected onClick={(e) => this.getHouseRooms(id, name)}>{name}</Dropdown.Item>
                                            } else {
                                                return <Dropdown.Item eventKey={id} key={id} onClick={(e) => this.getHouseRooms(id, name)}>{name}</Dropdown.Item>
                                            }
                                        })
                                    }
                                </Dropdown.Menu>
                            </Dropdown>
                            }
                            {rooms && <Dropdown>
                                <Dropdown.Toggle as={CustomDropdownToggle} className="btn" style={{margin: 0}}>
                                    {
                                        (this.state.roomTitle.length > 0) ? `${this.state.roomTitle}` : 'Seleccionar'
                                    }
                                </Dropdown.Toggle>
                                <Dropdown.Menu as={CustomDropdownMenu} className="custom-dropdown-menu">
                                    {
                                        this.state.rooms.map(({ id,number }) => {
                                            if (id == roomId) {
                                                return <Dropdown.Item eventKey={id} key={id} selected onClick={(e) => this.handleRoomChange(id, number)}>Habitación #{number}</Dropdown.Item>
                                            } else {
                                                return <Dropdown.Item eventKey={id} key={id} onClick={(e) => this.handleRoomChange(id, number)}>Habitación #{number}</Dropdown.Item>
                                            }
                                        })
                                    }
                                </Dropdown.Menu>
                            </Dropdown>
                            }
                            </div>
                            <Field key="isNewDepositPrice" props={props} name="isNewDepositPrice" type="checkbox" component={({field})=>{
                                return <FormBootstrap.Group>
                                <FormBootstrap.Check 
                                    {...field}
                                    id="isNewDepositPrice"
                                    custom
                                    label="El valor del deposito es diferente al valor de la habitación"
                                    className="mb-2 mt-2"
                                    disabled={props.values.roomId ? false : true}
                                    checked={props.values.isNewDepositPrice}
                                />
                            </FormBootstrap.Group>
                            }

                            }/>
                            <Field 
                                name="depositPrice" 
                                props={props} 
                                render={({field})=>{
                                    return (<FormBootstrap.Label>Deposito
                                    <InputGroup>
                                        <FormBootstrap.Control
                                            {...field}
                                            type="number"
                                            value={props.values.depositPrice}
                                            disabled={!props.values.isNewDepositPrice}
                                        />
                                        <InputGroup.Append>
                                            <InputGroup.Text id="inputGroupPrepend">$</InputGroup.Text>
                                        </InputGroup.Append>
                                    </InputGroup>
                            </FormBootstrap.Label>);
                            }}/>
                            <Field name="depositPaid" type="checkbox" props={props} component={({field})=>{
                                return <FormBootstrap.Group>
                                <FormBootstrap.Check 
                                    {...field}
                                    id="depositPayed"
                                    disabled={props.values.roomId ? false : true}
                                    custom
                                    label="Deposito pagado al propietario"
                                    className="mb-2 mt-2 ml-0"
                                    checked={props.values.depositPaid}
                                />
                            </FormBootstrap.Group>
                            }}/>
                            <Field name="sendViaEmail" 
                            type="checkbox" 
                            props={props} 
                            component={({field})=>{
                                return <FormBootstrap.Group>
                                <FormBootstrap.Check 
                                    {...field}
                                    disabled={props.values.roomId ? false : true}
                                    name="sendViaEmail" 
                                    type="checkbox"
                                    id="sendEmail"
                                    custom
                                    label="Enviar por correo"
                                    className="mb-2 mt-2"
                                    checked={props.values.sendViaEmail}
                                />
                            </FormBootstrap.Group>
                            }}/>
                            {props.values.sendViaEmail && <div>
                                <Field props={props} 
                                    name="email"
                                    render={({field})=>{
                                        return (<div>
                                            <FormBootstrap.Group as={Col} md="4" controlId="validationCustomUsername">
                                            <InputGroup>
                                                <FormBootstrap.Control
                                                    {...field}
                                                    type="email"
                                                    placeholder="Email"
                                                    aria-describedby="inputGroupPrepend"
                                                    value={props.values.email}
                                                    onChange={props.handleChange}
                                                />
                                                <InputGroup.Append>
                                                    <InputGroup.Text id="inputGroupPrepend">@</InputGroup.Text>
                                                </InputGroup.Append>
                                            </InputGroup>
                                        </FormBootstrap.Group>
                                        </div>
                                        );
                                }}/>
                            </div>
                            }
                        </div>
                        <button className={"btn btn-primary invite-button"} type="submit" disabled={this.isSendButtonDisabled()}>Enviar</button>
                    </form>
                    )}
                />
                {this.state.link && <div className="share_container" onClick={this.copyToClipboard.bind(this)}>
                    <i className="fas fa-copy text-primary"></i>
                    <button className="share_button">Copiar Link</button>
                    <textarea className="link_text" id="link" value={this.state.link}/>
                </div>}
        </div> );
    }
}

// const invitationSchema = Yup.object().shape({
//     firstName: Yup.string()
//       .min(2, 'Too Short!')
//       .max(50, 'Too Long!')
//       .required('Required'),
//     lastName: Yup.string()
//       .min(2, 'Too Short!')
//       .max(50, 'Too Long!')
//       .required('Required'),
//     email: Yup.string()
//       .email('Invalid email')
//       .required('Required'),
//   });
 
let container = document.getElementById('react-sendInvitation')
if(container){
    let userId = container.dataset.userid;
    ReactDOM.render(<SendInvitation userId={userId}/>,container);
}