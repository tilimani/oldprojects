import React, { Component } from 'react';
import PropTypes from 'prop-types';
import ModalDialog from 'react-bootstrap/ModalDialog';
import ModalTitle from 'react-bootstrap/ModalTitle';
import ModalBody from 'react-bootstrap/ModalBody';
import ModalFooter from 'react-bootstrap/ModalFooter';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import Table, {TableCell} from '../../atoms/Table/Table';
import Text from '../../atoms/Text/Text';
import Title from '../../molecules/PaymentHistory/Title/Title';

class ModalCustom extends Component {
    constructor(props) {
        super(props);
    }

    componentWillMount() {

    }

    componentDidMount() {

    }

    componentWillReceiveProps(nextProps) {

    }

    componentWillUpdate(nextProps, nextState) {

    }

    componentDidUpdate(prevProps, prevState) {

    }

    componentWillUnmount() {

    }

    render() {
        let {open, onHide, modalTittle, modalContent} = this.props;
        return (
            <div>
            {
                modalContent &&
                <Modal
                    show={open}
                    size="lg"
                    aria-labelledby="contained-modal-title-vcenter"
                    onHide={onHide}
                    centered
                    >
                    <Modal.Header closeButton>
                        <Modal.Title id="contained-modal-title-vcenter">
                            <Title title={modalTittle}/>
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <Table size={1}>
                            <TableCell>
                                <Text text="VICO:" type="paragraph" left/>
                                <Text text={modalContent.vico_name} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Tipo de pago:" type="paragraph" left/>
                                <Text text={modalContent.payment_type} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Fecha:" type="paragraph" left/>
                                <Text text={`${modalContent.booking_date_from} - ${modalContent.booking_date_to}`} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Valor habitación:" type="paragraph" left/>
                                <Text text={modalContent.room_price} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Comisión de VICO:" type="paragraph" left/>
                                <Text text={modalContent.vico_fee} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Valor entregado:" type="paragraph" left/>
                                <Text text={modalContent.total_ammount} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Fecha de entrega:" type="paragraph" left/>
                                <Text text={modalContent.payment_date} type="paragraph" right/>
                            </TableCell>
                            <TableCell>
                                <Text text="Status:" type="paragraph" left/>
                                <Text text={modalContent.payment_status} type="paragraph" right/>
                            </TableCell>
                        </Table>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button onClick={onHide}>Close</Button>
                    </Modal.Footer>
                </Modal>
            }
            </div>
        );
    }
}

export default ModalCustom;