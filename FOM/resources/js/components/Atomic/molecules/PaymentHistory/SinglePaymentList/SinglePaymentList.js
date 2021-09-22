import React, { Component } from 'react';
import './styles.scss';

import Icon from '../../../atoms/Icon/Icon';
import Text from '../../../atoms/Text/Text';
import Ellipsis, {Menu, Item, SecondMenu} from '../../../atoms/Ellipsis/Ellipsis';
import Axios from 'axios';

/**
 * 
 * @param {Int} booking_id  
 * @param {Int} count_actual  
 * @param {Date} created_at  
 * @param {String} user_name  
 * @param {String} house_name  
 * @param {Int} room_number  
 * @param {Double} price  
 * @param {Int} price  
 * @param {Int} status  
 */
class SinglePaymentList extends Component {
    constructor(props) {
        super(props);
        const months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ];

        this.state = {
            months,
            open: false,
            openSecond: false,
            paymentInfo: {}
        };

    }

    componentWillMount() {

    }

    componentDidMount() {
        
    }

    getPaymentInfo(payment_id) {
        Axios.get(`/api/v1/payment/${payment_id}`).then((response) => {
            this.setState({
                paymentInfo: response.data
            });
        })
    }
    componentDidUpdate(prevProps, prevState) {

    }
    formatPrice (price)  {
        price = parseInt(price);
        return Number(price.toFixed(0)).toLocaleString();
    }

    appendZeroes (n)  {
        if (n <= 9) {
            return "0" + n;
        } else {
            return n;
        }
    }

    paymentStatus (status, payment_flag, diffDays, current_account)  {
        let res = {
            icon: '',
            color: '',
            text: '',
        };
        if (status > 0) {
            res.icon = "fas fa-check";
            res.color = "green";
    
            if (current_account == "manager cash") {
                res.text = "Entregado";
            } else {    
                res.text = "Pagado, no entregado";
            }
        } else {
            if (payment_flag === "warning") {
                res.icon = "fas fa-exclamation";
                res.color = "yellow";
                res.text = `Pendiente en ${diffDays} días`;
            } else if(payment_flag === "attention") {
                res.icon = "fas fa-minus";
                res.color = "red";
                res.text = `Atrasado por ${diffDays} días`;
            }
        }
    
        return res;
    }

    formatDate (created_at) {
        const date = new Date(created_at);
        
        let res = `${this.appendZeroes(date.getDate())} ${this.state.months[date.getMonth()].substring(0, 3)}.${date.getFullYear() - 2000}`;
        return res;
    }
    openMenu (e) {

        e.preventDefault();
        e.stopPropagation();

        let open = this.state.open;

        open = open ? false: true;

        this.setState({
            open
        });
    }
    openSecondMenu (e) {

        e.preventDefault();
        e.stopPropagation();

        let openSecond = this.state.openSecond;

        openSecond = openSecond ? false: true;

        this.setState({
            openSecond
        });
    }

    render() {
        let {
            booking_id,
            count_actual,
            created_at,
            user_name, 
            house_name, 
            room_number,
            price,
            status,
            payment_flag,
            diffDays,
            current_account,
            triggerModal,
            payment_type,
            booking_date_from,
            booking_date_to,
            vico_fee,
            total_ammount,
            payment_date,
            payment_status,
            role_id

        } = this.props;
        payment_type  = payment_type === "Deposit" ? "Deposito":"Renta";
        let modalTittle = "Resumen";
        const proc_status = this.paymentStatus(status, payment_flag, diffDays, current_account);
        let modalContent = {
            vico_name: house_name,
            payment_type: payment_type,
            booking_date_from: this.formatDate(booking_date_from.date),
            booking_date_to: this.formatDate(booking_date_to.date),
            room_price: price,
            vico_fee: vico_fee,
            total_ammount: total_ammount,
            payment_date: this.formatDate(payment_date.date),
            payment_status: proc_status.text
        };
        return (
            <div className="_responsive_block" >
                <div className="_container">
                    <Icon icon={proc_status.icon} color={proc_status.color}/>
                    <div className="_content_text">
                        <div className="_tittle">
                            <Text text={user_name} type="heading" left></Text>
                            {
                                proc_status.color != "yellow" && 
                                <Ellipsis openMenu={this.openMenu.bind(this)}>
                                    <Menu open={this.state.open}>
                                        <Item text="Ver Detalles" clickHandler={triggerModal.bind(this, modalTittle, modalContent)}/>
                                        {/* <Item text="Marcar como pagado"/> */}
                                        {   proc_status.color != 'green' && role_id < 3 && 
                                            <Item text="Registrar evidencia de pago"/>
                                        }
                                    </Menu>
                                </Ellipsis>

                            }
                            <Text text={this.formatDate(created_at.date)} type="subheading" right></Text>
                        </div>
                        <Text text={`${house_name} - Habitación ${room_number}`} type="subheading"></Text>
                        <Text text={`${'$'+this.formatPrice(price)} - ${proc_status.text}`} type="subheading" gutterBottom color={proc_status.color}></Text>
                    </div>
                </div>
            </div>
        );
    }
}

export default SinglePaymentList;