import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Section from '../../organisms/PaymentHistory/Section';
import Axios from 'axios';
import Modal from '../../organisms/ModalCustom/Modal';
import '../../pages/PaymentHistory/styles.scss';
import MonthCarousel from '../../../TransactionHistory/MonthCarousel';

import data from '../../../TransactionHistory/data';

class App extends Component {
    constructor(props) {
        super(props);
        let month = "Historial de pagos";
        let tittle = "Julio";

        this.state = {
            openModal: false,
            tittle,
            properties: data.properties,
            property: data.properties[0],
            payments: [
                {
                    "booking_id": 1014,
                    "charge_id": "nn",
                    "eur": 0.000266,
                    "amountEur": 252.70000000000002,
                    "amountCop": 950000,
                    "status": 0,
                    "created_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "updated_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "cuota": 2,
                    "transaction_id": "nn",
                    "metadata": "Pago retrasado",
                    "import": "Rent",
                    "method": "",
                    "current_account": false,
                    "discount_cop": 0,
                    "discount_eur": 0,
                    "room_price_cop": 950000,
                    "room_price_eur": 252.70000000000002,
                    "vico_transaction_fee_cop": 0,
                    "vico_transaction_fee_eur": 0,
                    "stripe_fee_cop": 28500,
                    "stripe_fee_eur": 7.581,
                    "payment_amount": 0,
                    "payout_fee": 0,
                    "payout_batch": 0,
                    "payment_proof": "",
                    "additional_info": "",
                    "payment_flag": "attention",
                    "dayPrice": 31666.666666666668,
                    "payment_date": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "diffDays": 125,
                    "total_ammount": 950000,
                    "booking_date_from": {
                      "date": "2019-03-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "booking_date_to": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "vico_fee": 95000,
                    "payment_status": 0,
                    "user_name": "Bijan Baten",
                    "house_name": "vico Casa Jardin",
                    "room_number": 2
                  },
                  {
                    "booking_id": 1014,
                    "charge_id": "nn",
                    "eur": 0.000266,
                    "amountEur": 252.70000000000002,
                    "amountCop": 950000,
                    "status": 0,
                    "created_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "updated_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "cuota": 2,
                    "transaction_id": "nn",
                    "metadata": "Pago retrasado",
                    "import": "Rent",
                    "method": "",
                    "current_account": false,
                    "discount_cop": 0,
                    "discount_eur": 0,
                    "room_price_cop": 950000,
                    "room_price_eur": 252.70000000000002,
                    "vico_transaction_fee_cop": 0,
                    "vico_transaction_fee_eur": 0,
                    "stripe_fee_cop": 28500,
                    "stripe_fee_eur": 7.581,
                    "payment_amount": 0,
                    "payout_fee": 0,
                    "payout_batch": 0,
                    "payment_proof": "",
                    "additional_info": "",
                    "payment_flag": "attention",
                    "dayPrice": 31666.666666666668,
                    "payment_date": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "diffDays": 125,
                    "total_ammount": 950000,
                    "booking_date_from": {
                      "date": "2019-03-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "booking_date_to": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "vico_fee": 95000,
                    "payment_status": 0,
                    "user_name": "Bijan Baten",
                    "house_name": "vico Casa Jardin",
                    "room_number": 2
                  },
                  {
                    "booking_id": 1014,
                    "charge_id": "nn",
                    "eur": 0.000266,
                    "amountEur": 252.70000000000002,
                    "amountCop": 950000,
                    "status": 0,
                    "created_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "updated_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "cuota": 2,
                    "transaction_id": "nn",
                    "metadata": "Pago retrasado",
                    "import": "Rent",
                    "method": "",
                    "current_account": false,
                    "discount_cop": 0,
                    "discount_eur": 0,
                    "room_price_cop": 950000,
                    "room_price_eur": 252.70000000000002,
                    "vico_transaction_fee_cop": 0,
                    "vico_transaction_fee_eur": 0,
                    "stripe_fee_cop": 28500,
                    "stripe_fee_eur": 7.581,
                    "payment_amount": 0,
                    "payout_fee": 0,
                    "payout_batch": 0,
                    "payment_proof": "",
                    "additional_info": "",
                    "payment_flag": "attention",
                    "dayPrice": 31666.666666666668,
                    "payment_date": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "diffDays": 125,
                    "total_ammount": 950000,
                    "booking_date_from": {
                      "date": "2019-03-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "booking_date_to": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "vico_fee": 95000,
                    "payment_status": 0,
                    "user_name": "Bijan Baten",
                    "house_name": "vico Casa Jardin",
                    "room_number": 2
                  },
                  {
                    "booking_id": 1014,
                    "charge_id": "nn",
                    "eur": 0.000266,
                    "amountEur": 252.70000000000002,
                    "amountCop": 950000,
                    "status": 0,
                    "created_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "updated_at1": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "cuota": 2,
                    "transaction_id": "nn",
                    "metadata": "Pago retrasado",
                    "import": "Rent",
                    "method": "",
                    "current_account": false,
                    "discount_cop": 0,
                    "discount_eur": 0,
                    "room_price_cop": 950000,
                    "room_price_eur": 252.70000000000002,
                    "vico_transaction_fee_cop": 0,
                    "vico_transaction_fee_eur": 0,
                    "stripe_fee_cop": 28500,
                    "stripe_fee_eur": 7.581,
                    "payment_amount": 0,
                    "payout_fee": 0,
                    "payout_batch": 0,
                    "payment_proof": "",
                    "additional_info": "",
                    "payment_flag": "attention",
                    "dayPrice": 31666.666666666668,
                    "payment_date": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "diffDays": 125,
                    "total_ammount": 950000,
                    "booking_date_from": {
                      "date": "2019-03-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "booking_date_to": {
                      "date": "2019-04-01 00:00:00.000000",
                      "timezone_type": 3,
                      "timezone": "UTC"
                    },
                    "vico_fee": 95000,
                    "payment_status": 0,
                    "user_name": "Bijan Baten",
                    "house_name": "vico Casa Jardin",
                    "room_number": 2
                  },

            ]
        };
    }

    componentWillMount() {

    }

    componentDidMount() {
        // :)
    }

    componentDidUpdate(prevProps, prevState) {

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

    triggerModal(modalTittle, modalContent) {
        let open = this.state.openModal;
        open = open ? false: true;
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

const rootElement = document.getElementById("react-payments-test");
if (rootElement) {
    const connection = rootElement.dataset.info;
    ReactDOM.render(<App connection={connection}/>, rootElement);
}

export default App;