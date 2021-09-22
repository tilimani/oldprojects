import React, { Component } from 'react';
import Modal from 'react-bootstrap/Modal';
import ReactDOM from 'react-dom';

import ButtonToolbar from 'react-bootstrap/ButtonToolbar';
import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import FormGroup from 'react-bootstrap/FormGroup';

import InputGroup from "react-bootstrap/InputGroup";
import FormControl from 'react-bootstrap/FormControl';
// import DatePicker from 'react-datepicker';
import Datepicker from '../Datepicker/Datepicker';
import "react-datepicker/dist/react-datepicker.css";
import "./DenyModal.scss";

import MaleInactive from '../images/male_inactive.png';
import MaleActive from '../images/male_active.png';
import FemaleInactive from '../images/female_inactive.png';
import FemaleActive from '../images/female_active.png';
import DropdownButton from 'react-bootstrap/DropdownButton';
import DropdownItem from 'react-bootstrap/DropdownItem';

import Radio from './../Radio/Radio'
import Axios from 'axios';

class DenyModal extends Component {
    constructor(props) {
        super(props);        
        this.state = {
            countries: '',
            show: false,
            startDate: '',
            endDate: '',
            panelIndex: 0,
            panelIndexCount: 3,
            showInfo: false,
            isDenyValid: '',
            isStartDateValid: '',
            isEndDateValid: '',
            isNameValid:'',
            isGenderValid: '',
            isCountryValid:'',
            selectedOptions: {
                name: '',
                deny: '',
                date_from: '',
                date_to: '',
                gender: '',
                country: '',
                id: '',
                room_id: '',
                changeRoomId:'',
                booking_id:''
            },
            managerRooms: false,
            managerVicos: false,
            vicoTitle: 'Mis VICO',
            roomTitle: '',
            roomId: '',
        };
        this.startDate = React.createRef();
        this.endDate = React.createRef();
        this.nameInput = React.createRef();
        this.country = React.createRef();
        this.maleInput = React.createRef();
        this.femaleInput = React.createRef();
        this.completedFormCorrectly = false;
    }
    
    handleShow() {
        this.setState({ show: true });
    }

    handleHide() {
        this.setState({ 
            show: false,
            panelIndex:0,
            startDate: '',
            endDate: '',
            isDenyValid: '',
            isStartDateValid: '',
            isEndDateValid: '',
            isNameValid:'',
            isGenderValid: '',
            isCountryValid:'',
        },()=>{
            if(this.props.onModalClose){
                this.props.onModalClose(this.completedFormCorrectly);
            }
        });
    };

    componentDidMount(){
        let selectedOptions = { ...this.state.selectedOptions };
        if(this.props.onRef){
            this.props.onRef(this);
            this.state.selectedOptions.deny = 'block';
            this.setState(selectedOptions);
        }        
        Axios.get('/countries.json').then((countries)=>{
            this.setState({
                countries:countries.data
            })
        });
        this.getHouses(this.props.notification.data.booking_id);
    }

    handleStartChange(value){
        this.setState({
            startDate: value
        })
        let selectedOptions = { ...this.state.selectedOptions };
        selectedOptions.date_from = value;
        this.setState({selectedOptions});
    }
    handleEndChange(value){        
        if(this.state.startDate){
            this.setState({
                endDate: value
            })
            let selectedOptions = { ...this.state.selectedOptions };
            selectedOptions.date_to = value;
            this.setState({ selectedOptions });
        } else{
            this.refs.startDate.classList.add('red-border');
        }
    }
    selectedOption(e) {
        this.setState({
            selectedOptions:{
                deny: e.target.value
            }
        });
    }
    selectGender(gender){
        let selectedOptions = { ...this.state.selectedOptions };
        selectedOptions.gender = gender;
        this.setState({ selectedOptions });
    }
    selectCountry(e){        
        let selectedOptions = { ...this.state.selectedOptions };
        selectedOptions.country = e.target.value;
        this.setState({ selectedOptions });       
    }

    changePanel() {
        let panelIndex = this.state.panelIndex;
        //if radio buttons of first view are checked
        if (this.state.panelIndex === 0 && this.state.selectedOptions.deny != '') {
            let selectedOptions = { ...this.state.selectedOptions };
            selectedOptions.id = this.props.notification.data.booking_id;
            selectedOptions.room_id = this.props.notification.data.room_id;
            
            this.setState({
                selectedOptions
            })
            if(this.state.selectedOptions.deny == 'suggest'){
                panelIndex+=3;
            }
            if(this.state.selectedOptions.deny == 'deny'){
                panelIndex+=2;
            }
            if(this.state.selectedOptions.deny == 'block'){
                panelIndex++;
            }
        }else if(this.state.panelIndex === 0){
            this.setState({isDenyValid: false});
            return;
        }

        if(this.state.panelIndex === 1){
            //if the start and end dates are filled
            let selectedOptions = {...this.state.selectedOptions},
                startDateValid = '',
                endDateValid = '',
                name = '',
                genderValid = '',
                countryValid = '';
            console.log(this.state.startDate);
            
            if (this.state.startDate != ''){
                selectedOptions.date_from = this.state.startDate;
                startDateValid = true;
                this.setState({
                    isStartDateValid: true
                })
            }else{                
                startDateValid = false;

                this.setState({
                    isStartDateValid: false
                });
            }
            if(this.state.endDate != ''){
                endDateValid = true;
                selectedOptions.date_to = this.state.endDate;
                this.setState({
                    isEndDateValid: true
                })
            }else{
                endDateValid = false;
                this.setState({
                    isEndDateValid: false
                });
            }
            if(this.nameInput.current.value == ''){
                if(startDateValid && endDateValid){
                    panelIndex++;
                }
            } 
            //if name is empty, just the dates are filled
            if (this.nameInput.current.value != ''){
                selectedOptions.name = this.nameInput.current.value;                
                if(this.country.current.value != 0){
                    selectedOptions.country = this.country.current.value;
                    countryValid = true;
                    this.setState({
                        isCountryValid: true
                    })
                }else{
                    countryValid = false;
                    this.setState({
                        isCountryValid: false
                    });
                }
                if(this.state.selectedOptions.gender){
                    genderValid = true;
                    this.setState({
                        isGenderValid: true
                    });
                }else{
                   genderValid = false; 
                    this.setState({
                        isGenderValid: false
                    })
                }
                this.setState({ selectedOptions });
                if(this.nameInput.current.value != '' && startDateValid && endDateValid && genderValid && countryValid){
                    panelIndex++;
                }
            }
            
            if(startDateValid && endDateValid && this.nameInput.current.value == ''){
                panelIndex = 2;
            }
            
        }
        if(panelIndex === 3){
            this.setState({
                panelIndex:4
            })
        }
        if(panelIndex === 4){
            this.setState({
                panelIndex:1
            })
        }
        this.setState({panelIndex:panelIndex},()=>{
            if(panelIndex == 2){
                this.completedFormCorrectly = true;

                if(this.state.selectedOptions.deny == 'deny'){                    
                    Axios.post('/api/booking/deny',this.state.selectedOptions).catch((reason)=>{
                        console.log(reason);
                    })
                }else if(this.state.selectedOptions.deny == 'block'){
                    Axios.post('/api/booking/denyAndBlock', this.state.selectedOptions).catch((reason) => {
                        console.log(reason);
                    })
                }else if(this.state.selectedOptions.deny == 'suggest'){
                    Axios.post('/api/booking/blockAndSuggest',this.state.selectedOptions).catch((reason)=>{
                        console.log(reason);
                    })
                }
            }
        });
    }

    saveRoomChange(){
        // let payload = {
        //     booking_id: this.props.notification.data.booking_id,
        //     room_id: this.state.roomId
        // };
        let selectedOptions = {...this.state.selectedOptions};
        selectedOptions.changeRoomId = this.state.roomId;
        selectedOptions.booking_id = this.props.notification.data.booking_id;
        this.setState({
            panelIndex: 4,
            selectedOptions
        })
        // Axios.post('/api/v1/notify/changeroom',payload).then(()=>{
        //     this.setState({
        //         panelIndex: 2
        //     })
        // });
    }

    checkRoomAvailable(room){
        let bookingDateFrom = this.props.notification.data.date_from.split('.');
        let bookingFrom = new Date('20' + bookingDateFrom[2],parseInt(bookingDateFrom[1])-1,bookingDateFrom[0]);
        let roomDate = room.available_from.split('-')
        let roomAvailableFrom = new Date('20'+roomDate[0],parseInt(roomDate[1])-1,roomDate[2]);
        if(bookingFrom >= roomAvailableFrom){
            return false;
        }else {
            return true;
        }
    }

    getHouses(booking_id) {
        Axios.get(`/api/v1/manager/houses/${booking_id}`).then((response)=>{
            this.setState({
                managerVicos: response.data
            })
        });
    }

    getHouseRooms(house_id,selected) {
        Axios.get(`/api/v1/rooms/house/${house_id}`).then((response) => {
            let rooms = response.data;
            this.setState({
                managerRooms: rooms,
                vicoTitle: selected
            });

        })
    }
    handleRoomChange(room) {
        this.setState({
            roomTitle: room.number,
            roomId: room.id
        });   
    }

    handleDates(startDate,endDate){
        let selectedOptions = {...this.state.selectedOptions}
        selectedOptions.date_from = startDate;
        selectedOptions.date_to = endDate;
        this.setState({
            selectedOptions,
            startDate,
            endDate
        })
    }

    render() {
        let Localization = this.props.Localization,
        vicos = this.state.managerVicos,
        rooms = this.state.managerRooms;
        return (
            <div>
                {!this.props.onRef && <Button variant="primary process-deny-button ml-auto" onClick={this.handleShow.bind(this)}>
                    {this.props.text}
                </Button>}
                <Modal
                    show={this.state.show}
                    onHide={this.handleHide.bind(this)}
                    dialogClassName="modal-90w"
                    aria-labelledby="deny-booking-modal"
                    animation
                    size="lg">
                    <Modal.Header closeButton>
                        <Modal.Title id="deny-booking-modal">
                            Habitacion #{this.props.notification.data.room_number}
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        {this.state.panelIndex === 0 && <div className="add-opacity">
                        <FormGroup>
                            <Form.Check name="deny" 
                                        type="radio" 
                                        custom 
                                        label="Rechazar y bloquear" 
                                        id="deny-block"                                        
                                        onChange={this.selectedOption.bind(this)}
                                        value="block"
                                        className="mb-2 mt-2 "
                                        defaultChecked={this.props.onRef ? true : false}
                                        />
                            <Form.Text className="text-muted">
                                Con esta opción puedes definir hasta 
                                cuando no quieres recibir nuevas solicitudes.
                            </Form.Text>
                                <Form.Check 
                                        name="deny" 
                                        type="radio" 
                                        custom 
                                        label="Rechazar" 
                                        id="deny"
                                        onChange={this.selectedOption.bind(this)}
                                        value="deny"
                                        className="mb-2 mt-2"/>
                            <Form.Text className="text-muted">
                                Con esta opción puedes elegir o cambiar tu
                                disponibilidad para la visita de tu vico.
                            </Form.Text>
                            <Form.Check name="deny" 
                                        type="radio" 
                                        custom 
                                        label="Sugerir otra habitación" 
                                        id="suggest"                                        
                                        onChange={this.selectedOption.bind(this)}
                                        value="suggest"
                                        className="mb-2 mt-2 "
                                        />
                            <Form.Text className="text-muted">
                                Con esta opción puedes sugerir otra habitación
                                para el usuario
                            </Form.Text>
                        </FormGroup>
                        {this.state.isDenyValid === false && <p className="text-danger">
                                Es necesario que elijas alguno de los campos.
                            </p>
                        }
                        <div className="d-flex flex-row justify-content-around">
                            <ButtonToolbar >
                                <Button variant="outline-secondary" onClick={this.handleHide.bind(this)}>Cancelar</Button>
                                <Button variant="primary" onClick={this.changePanel.bind(this)}>Confirmar</Button>
                            </ButtonToolbar>
                        </div>
                    </div>}
                        {this.state.panelIndex === 1 && <div className="add-opacity">                            
                            <FormGroup>                                    
                                <InputGroup className="mb-3" >
                                    <Form.Label>¿Hasta cuando ocupa la habitación?</Form.Label>
                                    <Datepicker 
                                        type="range"
                                        startDateHandler={this.handleDates.bind(this)}
                                    />
                                    {/* <DatePicker
                                        customInput={<FormControl ref={this.startDate} placeholder="Fecha inicio" className="w-50"/>}
                                        selected={this.state.startDate}
                                        onChange={this.handleStartChange.bind(this)}
                                        minDate={new Date()}
                                        placeholderText="Fecha inicio"
                                        className={"border-radius-left " + (this.state.isStartDateValid === false ? 'is-invalid' : '')}/>
                                    <DatePicker
                                        customInput={<FormControl ref={this.endDate} placeholder="Fecha fin" className="border-radius-right w-50"/>}
                                        selected={this.state.endDate}                                        
                                        onChange={this.handleEndChange.bind(this)}
                                        minDate={this.state.startDate}
                                        placeholderText="Fecha fin"
                                        className={"border-radius-right " + (this.state.isEndDateValid === false ? 'is-invalid' : '')}/>                                     */}
                                </InputGroup>
                                <FormGroup >
                                    <Form.Label>Nombre del Ocupante</Form.Label>
                                    <FormControl ref={this.nameInput} placeholder="John Doe" className="border-radius"/>
                                </FormGroup>
                                <FormGroup>
                                    <Form.Label className="d-block">Genero</Form.Label>
                                    <Radio
                                        image={true}
                                        name="gender"
                                        value="male"
                                        current={this.state.selectedOptions.gender}
                                        active={MaleActive}
                                        inactive={MaleInactive}
                                        text="Masculino"
                                        selectCallback={this.selectGender.bind(this, "male")}
                                        className={(this.state.isGenderValid === false ? 'is-invalid' : '')} />
                                    <Radio
                                        image={true}
                                        name="gender"
                                        value="female"
                                        current={this.state.selectedOptions.gender}
                                        active={FemaleActive}
                                        inactive={FemaleInactive}
                                        text="Femenino"
                                        selectCallback={this.selectGender.bind(this, "female")} 
                                        className={(this.state.isGenderValid === false ? 'is-invalid' : '')}
                                        />
                                    {this.state.isGenderValid === false && <p className="text-danger">Es necesario elegir genero</p>}
                                </FormGroup>
                                <FormGroup>
                                    <Form.Label>¿Donde vive?</Form.Label>
                                    <div>
                                        <select ref={this.country} 
                                                key="country" 
                                                className={"browser-default custom-select " + (this.state.isCountryValid === false ? 'is-invalid' : '')}
                                                onChange={this.selectCountry.bind(this)}>
                                                <option key='country-0' value={0} defaultValue={0} disabled>Pais</option>
                                            {this.state.countries.map((country)=>{
                                                return <option key={'country-' + country.id} value={country.id}>{country.name}</option>
                                            })}
                                            
                                        </select>
                                    </div>  
                                    {this.state.isCountryValid === false && <p className="text-danger">Es necesario elegir nacionalidad</p>}

                                </FormGroup>
                            </FormGroup>
                            {this.state.showInfo && <p className="text-danger">
                                Es necesario llenar los campos.
                            </p>
                            }
                            <div className="d-flex flex-row justify-content-around">
                                <ButtonToolbar >
                                    <Button variant="outline-secondary" onClick={this.handleHide.bind(this)}>Cancelar</Button>
                                    <Button variant="primary" onClick={this.changePanel.bind(this)}>Confirmar</Button>
                                </ButtonToolbar>
                            </div>
                    </div>}
                    {this.state.panelIndex === 2 && <div className="add-opacity">
                        {this.state.selectedOptions.deny == 'deny' && <div>
                                <div className="text-center">
                                    <img src="/images/accepted.png" />
                                    <p className="text-success">¡SOLICITUD RECHAZADA!</p>
                                    <p className="">¡haz rechazado la solicitud!</p>
                                </div>
                                <div className="d-flex flex-row justify-content-around">
                                    <ButtonToolbar >
                                        <Button variant="success" onClick={this.handleHide.bind(this)}>OK</Button>
                                    </ButtonToolbar>
                                </div>  
                        </div>}
                        {this.state.selectedOptions.deny == 'block' && <div>
                            <div className="text-center">
                                <img src="/images/accepted.png"/>
                                <p className="text-success">¡TENGO UN INVITADO ACTIVO!</p>
                                <p className="">¡Esta habitación ya está habitada!</p>
                            </div>
                            <div className="d-flex flex-row justify-content-around">
                                <ButtonToolbar >                                    
                                    <Button variant="success" onClick={this.handleHide.bind(this)}>OK</Button>
                                </ButtonToolbar>
                            </div>
                        </div>}
                    </div>}
                    {this.state.panelIndex === 3 && <div className="add-opacity">
                            <div className="text-center">
                            <h2 className="text-muted bold">{Localization.trans('change_room')}</h2>

                                {vicos && 
                                    <DropdownButton title={this.state.vicoTitle} ref={this.roomDropdown} className="mb-2">
                                        {
                                            vicos.map((vico)=>{
                                                return (
                                                    <DropdownItem onClick={this.getHouseRooms.bind(this, vico.id,vico.name)} 
                                                        key={`dropdown-${vico.id }`}>{vico.name}
                                                    </DropdownItem>
                                                );
                                            })
                                        }
                                    </DropdownButton>
                                }
                                {
                                    rooms && 
                                    <DropdownButton title={'Habitación #' + this.state.roomTitle} ref={this.roomDropdown} className="mb-2">
                                        {
                                            rooms.map((room)=>{
                                                return (
                                                    <DropdownItem disabled={this.checkRoomAvailable(room)} key={`dropdown-${room.id }`} onClick={this.handleRoomChange.bind(this,room)}>{Localization.trans('room')} #{room.number}</DropdownItem>
                                                );
                                            })
                                        }
                                    </DropdownButton>
                                }
                                <Button onClick={this.saveRoomChange.bind(this)}>{Localization.trans('accept')}</Button>
                            </div>
                    </div>}
                    {this.state.panelIndex === 4 && <div className="add-opacity">
                        <div className="text-center">
                            <h3>Gracias por sugerir el cambio de habitación</h3>
                            <p>Por favor completa la información para bloquear la habitación</p>
                            <Button onClick={()=>{this.setState({panelIndex:1})}}>Aceptar</Button>
                        </div>
                    </div>}
                    </Modal.Body>
                </Modal>  
            </div>
        );
    }
}

// if(document.getElementById('react-deny-modal')){
//     let denyDiv = document.getElementById('react-deny-modal');
//     let connection = denyDiv.dataset.connection;
//     ReactDOM.render( <DenyModal connection={connection}/>, document.getElementById('react-deny-modal'));
// }
export default DenyModal;