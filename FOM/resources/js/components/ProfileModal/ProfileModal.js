import React, { Component } from 'react';
import Modal from 'react-bootstrap/Modal';
import './ProfileModal.scss';
import Axios from 'axios';
import Localization from '../../Localization/Localization';

export default class ReservationModal extends Component {
    // This is initializing our states
    constructor(props) {
        super(props);
        this.state={
            show: false,
            Localization: '',
            step:0,
        };
    }
    
    // This executes when the component renders for the client
    // componentDidMount(){
    //     // this.props.handleChange(this.getComponentData);
    //     this.props.onRef(this);
    // }

    // componentWillUnmount() {
    //     this.props.onRef(undefined)
    // }

    // getComponentData(variable){
    //     Axios.post('/api/room', data).then((response)=>{
    //         this.setState({
    //             room: response.data.room,
    //         });
    //     });
    // }

    componentWillMount(){
        let localization = new Localization;
        localization.initialize('reservation',this.props.connection);
        this.setState({
            Localization: localization,
            load: false
        })
    }

    nextStep(){
        let nextStep = this.state.step+1;
        this.setState({
            step: nextStep,
            errorMessage: false
        }) 
    }

    closeModal(){
        this.setState({
            show: false,
            step: 0,
        })
    }


    render() {
        let Localization = this.state.Localization;
        return (            
            <Modal show={true} onHide={this.closeModal.bind(this)}>
                <Modal.Header className="gutters" closeButton>
                    <div className="row d-flex w-100" id="modal-header-content">
                        <div className="col-4 align-items-center d-flex">
                            <img class='thumbnail' src="https://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop&mask=ellipse&border=10,f19528" id="user-photo"/>
                        </div>
                        <div className="col-6">
                            <p className="text-uppercase mb-0 bold-words text-30" id="header-name">Alex</p>
                            <p className="mb-0">🌏Vancouver, Canada</p>
                            <p className="mb-0">💼Programador</p>
                        </div>
                    </div>
                </Modal.Header>
                <Modal.Body className="gutters">
                    <p><span className="bold-words">Hablo:</span> Inglés y Español</p>
                    <p><span className="bold-words">Sobre yo:</span> Hola, soy Alex! Tengo 22 años y soy de Canada. Estoy trabajando en Medellín como programador por 6 meses :).</p>
                    <p><span className="bold-words">Algo que me emociona:</span> Mejorar mi español y conocer gente nueva del mundo entero!</p>
                    <div>
                        <p className="bold-words mb-0">Hechos rapidos... </p>
                        <p className="mb-0">💃 Me gusta salir de fiesta</p>
                        <p className="mb-0">🌕 Soy nóctambulo </p>
                        <p className="mb-0">🥕 Soy vegetariano</p>
                        <p className="mb-0">💪 Voy al gimnasio</p>
                    </div>
                </Modal.Body>
                <Modal.Footer className="bt-1 text-center justify-content-center" id="footer">
                    <div className="col-auto p-1">
                        <img id="instagram" src="/images/instagram-logo.png"></img>    
                    </div>   
                    <div className="col-auto p-1" id="instagram-handle">@alextheyuppie</div>              
                </Modal.Footer>
                
            </Modal>

        );
    }
}