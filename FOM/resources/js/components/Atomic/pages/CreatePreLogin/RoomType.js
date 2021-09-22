import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Flex, { FlexItem, FlexItemText } from "../../atoms/Flex/Flex";
import CustomDropdownMenu from "../../molecules/CreatePreLogin/CustomDropdownMenu";
import CustomDropdownToggle from "../../molecules/CreatePreLogin/CustomDropdownToggle";
import Button from "react-bootstrap/Button";
import Dropdown from "react-bootstrap/Dropdown";
import './Home.scss';
import Axios from 'axios';

export class RoomType extends Component {
    constructor(props) {
        super(props);
        let connection = this.props.isLogged.split(','),
            isLogged = parseInt(connection[0]),
            role_id = parseInt(connection[1]);
        this.inputHouseRef = React.createRef();
        this.inputApartmentRef = React.createRef();
        this.inputApartmentStudioRef = React.createRef();
        this.saveInfoInLocalstorage = this.saveInfoInLocalstorage.bind(this);
        this.redirectToCreate = this.redirectToCreate.bind(this);
        this.notifyAlert = this.notifyAlert.bind(this);
        this.setCookie = this.setCookie.bind(this);
        this.getDataLocalStorage = this.getDataLocalStorage.bind(this);
        this.selectNeighborhood = this.selectNeighborhood.bind(this);

        this.state = {
            'type': 'Casa',
            isLogged: isLogged,
            role_id: role_id,
            neighborhoodList: [],
            neighborhoodId: '',
            neighborhoodName: '',
            localStoragengbhId: ''
        }
    }

    componentDidMount() {
        this._isMounted = true;
        if(this._isMounted){
            this.inputHouseRef.current.click();
            this.getDataLocalStorage();
        }
    }
    componentWillUnmount() {
        this._isMounted = false;
    }

    getDataLocalStorage() {
        const data = JSON.parse(localStorage.getItem('data'));

        if (data) {
            this.getNeighborhoods(data.cityName);
            this.setState({ localStoragengbhId: data.ngbhId, neighborhoodId: data.ngbhId });
        }
    }

    getNeighborhoods(city_name) {
        if(this._isMounted){
            Axios.get(`/api/neighborhoods/${city_name}`).then(
                ({ data }) => {
                    this.setState({ neighborhoodList: data.neighborhoods })
                }
            )
        }
    }

    setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    saveInfoInLocalstorage() {
        let datos = JSON.parse(localStorage.getItem('data'));

        if (datos) {
            datos.type = this.state.type;
            datos.ngbhId = this.state.neighborhoodId;
            localStorage.setItem('data', JSON.stringify(datos));
        }
        localStorage.setItem('isCreatingHouse', JSON.stringify(true));
        this.setCookie('isCreatingHouse', true, 7);
    }

    redirectToCreate() {
        window.location.href = `/houses/map/1`;
    }

    notifyAlert() {
        alert('Debes ser un propietario para crear una VICO');
    }

    selectNeighborhood(NgbhId, name) {
        this.setState({ neighborhoodId: NgbhId, neighborhoodName: name });
        
    }

    render() {
        return (
            <Flex height={100}>
                <div className="home-container roomtype-container">
                    {
                        (this.state.localStoragengbhId.length === 0) &&
                        <div className="neighborhood-container">
                            <div className="neighborhood-title">
                                Selecciona tu barrio 
                            </div>
                            <Dropdown>
                                <Dropdown.Toggle as={CustomDropdownToggle} className="btn" style={{margin: 0}}>
                                    {
                                        (this.state.neighborhoodName.length > 0) ? `${this.state.neighborhoodName}` : 'Seleccionar'
                                    }
                                </Dropdown.Toggle>
                                <Dropdown.Menu as={CustomDropdownMenu} className="custom-dropdown-menu">
                                    {
                                        this.state.neighborhoodList.map(({ id, name }) => {
                                            if (id == this.state.neighborhoodId) {
                                                return <Dropdown.Item eventKey={id} key={id} selected onClick={(e) => this.selectNeighborhood(id, name)}>{name}</Dropdown.Item>
                                            } else {
                                                return <Dropdown.Item eventKey={id} key={id} onClick={(e) => this.selectNeighborhood(id, name)}>{name}</Dropdown.Item>
                                            }
                                        })
                                    }
                                </Dropdown.Menu>
                            </Dropdown>
                        </div>
                    }
                    <div className="title-container roomtype-title vico-color">
                        <strong>Tu <span>VICO</span> es ...</strong>
                    </div>
                    <FlexItem>
                        <div className="create-vico">
                            <div className="select-equip ">
                                <div className="row equip-selector justify-content-center mb-3">
                                    <div className="col-4 col-sm-3 equip form-check">
                                        <input type="radio" name="type" value="Casa" id="typeHouse" ref={this.inputHouseRef} onClick={(e) => this.setState({ type: this.inputHouseRef.current.value })} />
                                        <label htmlFor="typeHouse"><span className="icon-house-black vico-room-equip"></span></label>
                                        <p htmlFor="typeHouse">Casa</p>
                                    </div>

                                    <div className="col-4 col-sm-3 equip form-check">
                                        <input type="radio" name="type" value="Apartamento" id="typeApartment" ref={this.inputApartmentRef} onClick={(e) => this.setState({ type: this.inputApartmentRef.current.value })} />
                                        <label htmlFor="typeApartment"><span className="icon-apartment-black vico-room-equip"></span></label>
                                        <p htmlFor="typeApartment">Apartamento</p>
                                    </div>

                                    <div className="col-4 col-sm-3 equip form-check">
                                        <input type="radio" name="type" value="Aparta-estudio" id="typeApartmentStudio" ref={this.inputApartmentStudioRef} onClick={(e) => this.setState({ type: this.inputApartmentStudioRef.current.value })} />
                                        <label htmlFor="typeApartmentStudio"><span className="icon-window-black vico-room-equip"></span></label>
                                        <p htmlFor="typeApartmentStudio">Aparta-estudio</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </FlexItem>
                    <div className="cta-wrappers">
                        <Button variant="link" onClick={this.props.prevPage}>Atrás</Button>
                        {

                            (this.state.isLogged === 1 && this.state.role_id < 3) &&
                            <Button className={`btn btn-end ${(this.state.neighborhoodId.toString().length > 0 ? "": "disabled")}`} onClick={(e) => { this.saveInfoInLocalstorage(); this.redirectToCreate() }}>Terminar</Button>
                        }
                        {
                            (this.state.isLogged === 1 && this.state.role_id > 2) &&
                            <Button className={`btn btn-end ${(this.state.neighborhoodId.toString().length > 0 ? "": "disabled")}`} onClick={(e) => { this.notifyAlert() }}>Terminar</Button>
                        }
                        {
                            (this.state.isLogged === 0) &&
                            <a data-toggle="modal" data-target="#Register" className={`btn btn-end ${(this.state.neighborhoodId.toString().length > 0 ? "": "disabled")}`} onClick={this.saveInfoInLocalstorage}>Terminar</a>
                        }
                    </div>
                </div>
            </Flex>
        );
    }
}

export default RoomType;
