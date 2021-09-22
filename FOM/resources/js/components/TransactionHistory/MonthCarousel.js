import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Month from "./Month";
import './TransactionHistory.scss';
import Axios from 'axios';
import PaymentsHistory from './../Atomic/organisms/PaymentHistory/Section';

const months = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre', 
    'Noviembre',
    'Diciembre'
];


// class MonthCarousel extends Component{
let MonthCarousel = ({properties,property,nextMonth,prevMonth}) =>{
    // constructor(props){
    //     super(props);
    //     let userId = props.info;
    //     this.state = {
    //         properties: data.properties,
    //         property: data.properties[0],
    //         payments: [],
    //         userId,
    //     }
    // }

    // componentDidMount(){
    //     Axios.get(`/api/v1/payments/${this.state.userId}`).then((response)=>{
    //         this.setState({
    //             payments: response.data
    //         })
    //     });
    // }
    
    let updateMonthX = (index, xdistance) => {
        return {x: index * xdistance, className: 'month-unselected', sc: 1 * (index / 100)}
    }

    // const {properties, property,payments} = this.state;
    return (
        <div className="month-carousel">
            <div className="carousel-months">
                <button 
                    onClick={() => nextMonth()} 
                    disabled={property.index === properties.length-1}
                    className="btn-next icon-next-fom"
                    ></button>
                <button 
                    onClick={() => prevMonth()} 
                    disabled={property.index === 0}
                    className="btn-prev icon-next-fom"
                    ></button>
            <div className={`month-slider active-slide-${property.index}`}>
                <div className="month-slider-wrapper" style={{
                'transform': `translateX(-${property.index*(100/properties.length)}%)`
                }}>
                {
                    properties.map(property => <Month key={property._id} property={property} />)
                }
                </div>
            </div>
            </div>
        </div>
    );
}

// if (document.getElementById('react-monthCarousel')) {
//     let monthCarouselDiv = document.getElementById('react-monthCarousel');
//     let info = monthCarouselDiv.dataset.info;
//     ReactDOM.render(<MonthCarousel info={info} />, document.getElementById('react-monthCarousel'));
// }
export default MonthCarousel;