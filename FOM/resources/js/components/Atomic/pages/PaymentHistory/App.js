import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Section from '../../organisms/PaymentHistory/Section';
import Axios from 'axios';
import Modal from '../../organisms/ModalCustom/Modal';
import './styles.scss';
import MonthCarousel from '../../../TransactionHistory/MonthCarousel';

import data from '../../../TransactionHistory/data';


class App extends Component {
    constructor(props) {
        super(props);
        let month = "Historial de pagos";
        let tittle = "Julio";
        let connection = props.connection.split(',');
        let user_id = (connection) ? connection[0]: '';
        let role_id = (connection) ? connection[1]: '';

        this.state = {
            user_id,
            role_id,
            openModal: false,
            tittle,
            payments: [
                {
                    "booking_id": 1506,
                    "user_name": "Cargando..",
                    "house_name": "VICO",
                    "room_number": 1,
                    "price": 0,
                    "count_actual": 1,
                    "created_at1": {
                      "date": "2020-06-29 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "status": 1,
                    "payment_flag": 'ok',
                    "diffDays": 0, 
                }

            ],
            properties: data.properties,
            property: data.properties[0],
        };
    }

    componentWillMount() {

    }

    nextProperty(){
        const newIndex = this.state.property.index+1;
        this.setState({
          property: data.properties[newIndex]
        })
    }
    
    prevProperty(){
        const newIndex = this.state.property.index-1;
        this.setState({
            property: data.properties[newIndex]
        })
    }

    componentDidMount() {
        if(this.state.user_id) {
            Axios.get(`/api/v1/payment/user/${this.state.user_id}`).then((response) => {
                const payments = response.data;
                if (payments.length > 0) {
                    this.setState({
                        payments: response.data
                    });
                } else {
                    this.setState({
                        payments: [
                            {
                                "booking_id": 1506,
                                "user_name": "Sin pagos",
                                "house_name": "VICO",
                                "room_number": 1,
                                "price": 0,
                                "count_actual": 1,
                                "created_at1": {
                                  "date": "2020-06-29 00:00:00.000000",
                                  "timezone_type": 3,
                                  "timezone": "UTC"
                                },
                                "status": 1,
                                "payment_flag": 'ok',
                                "diffDays": 0, 
                                "current_account": "manager cash"
                            }
            
                        ]
                    });
                }
            }).catch((e) => {
                this.setState({
                    payments: [
                        {
                            "booking_id": 1506,
                            "user_name": "Ocurrió un error",
                            "house_name": "VICO",
                            "room_number": 1,
                            "price": "0",
                            "count_actual": 1,
                            "created_at1": {
                              "date": "2020-06-29 00:00:00.000000",
                              "timezone_type": 3,
                              "timezone": "UTC"
                            },
                            "status": 0,
                            "payment_flag": 'attention',
                            "diffDays": 0, 
                            "current_account": "manager cash"
                        }
        
                    ]
                });
            });
        }

    }

    componentDidUpdate(prevProps, prevState) {

    }

    triggerModal(modalTittle, modalContent) {
        let open = this.state.openModal;
        open = open ? false: true;
        console.log(modalContent);
        this.setState({
            openModal: open,
            modalContent,
            modalTittle
        });
    }

    render() {
        let {payments, tittle, month, openModal, modalContent, modalTittle,properties,property, role_id} = this.state;
        let triggerModal = this.triggerModal.bind(this);
        return (
            <div className="box-container">
                <MonthCarousel 
                    properties={properties} 
                    property={property} 
                    nextMonth={this.nextProperty.bind(this)} 
                    prevMonth={this.prevProperty.bind(this)}
                />
                <Section
                    payments={payments}
                    tittle={tittle}
                    month={month}
                    triggerModal={triggerModal}
                    month={property}
                    role_id={role_id}
                    />
                <Modal 
                    open={openModal}
                    onHide={triggerModal}
                    modalTittle={modalTittle}
                    modalContent={modalContent}
                />
            </div>
        );
    }
}

const rootElement = document.getElementById("react-payments");
if (rootElement) {
    const connection = rootElement.dataset.connection;
    ReactDOM.render(<App connection={connection}/>, rootElement);
}

export default App;