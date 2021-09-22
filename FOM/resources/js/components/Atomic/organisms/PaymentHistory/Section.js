import React, { useState, useEffect } from 'react';
import Flex, {FlexItem, FlexItemText} from '../../atoms/Flex/Flex';
import SinglePaymentList from '../../molecules/PaymentHistory/SinglePaymentList/SinglePaymentList';
import Title from '../../molecules/PaymentHistory/Title/Title';

/**
 * 
 * @param {Object} payments 
 * @param {String} title 
 * @param {String} month 
 */
const Section = ({
    payments,
    title = "Historial de pagos",
    month = "Julio",
    openMenu,
    open,
    triggerModal,
    role_id,
}) => {

    let getCurrentMonth  = (date) =>{
        let paymentDate = new Date(date);
        return paymentDate.getMonth();
    }

    const [payment, setPayment] = useState(0);

    const calcPrices = () => {
        let sum = 0;
        payments.map(({room_price_cop, created_at1, payment_status}) =>{
            if(getCurrentMonth(created_at1.date) === month.index && payment_status > 0){
                sum += parseInt(room_price_cop); 
            }
        });
        setPayment(sum);
    };

    useEffect( () => {
        calcPrices(month)
    }, [month]);

    return (
        <div>
            <Flex>
                <FlexItem contentStart>
                    <Title title={title} content={month.month}></Title>
                    <Title title={"Rentas pagadas a VICO"} content={`${payment}$`} subColor="green"></Title>
                    <Title title={"Fecha de pago/Entrega"} content={"01.08.19"} subColor="yellow"></Title>
                </FlexItem>
                {
                    payments.map(({
                        booking_id,
                        user_name,
                        house_name,
                        room_number,
                        room_price_cop,
                        created_at1,
                        count_actual,
                        status,
                        payment_flag,
                        diffDays,
                        current_account,
                        payment_type,
                        booking_date_from,
                        booking_date_to,
                        vico_fee,
                        total_ammount,
                        payment_date,
                        payment_status,
                    }, index) => {

                        if(getCurrentMonth(created_at1.date) === month.index){
                            return(
                            <FlexItem key={index}>
                                    <SinglePaymentList
                                        key={index}
                                        booking_id={booking_id}
                                        user_name={user_name}
                                        house_name={house_name}
                                        room_number={room_number}
                                        price={room_price_cop}
                                        created_at={created_at1}
                                        count_actual={count_actual}
                                        status={status}
                                        payment_flag={payment_flag}
                                        diffDays={diffDays}
                                        current_account={current_account}
                                        triggerModal={triggerModal}
                                        payment_type={payment_type}
                                        booking_date_from={booking_date_from}
                                        booking_date_to={booking_date_to}
                                        vico_fee={vico_fee}
                                        total_ammount={total_ammount}
                                        payment_date={payment_date}
                                        payment_status={payment_status}
                                        payment_type={payments[index].import}
                                        role_id={role_id}
                                        />
                                </FlexItem>
                            )
                        }
                    })
                }
            </Flex>
        </div>
    );
};



export default Section;