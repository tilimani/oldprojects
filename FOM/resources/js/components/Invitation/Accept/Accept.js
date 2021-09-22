import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';
import RoomDescription from './../../Room/Description/RoomDescription';
// import HouseRules from './../../House/Rules';
import Datepicker from '../../Datepicker/Datepicker';

import './Accept.scss'
class AcceptInvitation extends Component {
    constructor(props){
        super(props)
        let connection = this.props.connection.split(',');
        let invitationId = connection[0];
        let isLogged = connection[1];
        let user_id = connection[2];
        this.state = {
            invitation: null,
            invitationId: invitationId,
            invitationLoaded: false,
            isLogged: isLogged,
            user_id: user_id,
        }   
    }

    componentDidMount(){        
        Axios.get('/api/invitation/show/'+this.state.invitationId).then((response)=>{
            let {invitation,room,room_images,house,neighborhood,manager,dates} = response.data;
            this.setState({
                invitation: invitation,
                room: room,
                room_images: room_images,
                house: house,
                neighborhood: neighborhood,
                manager: manager,
                dates: dates,
                invitationLoaded:true,
                bookingStartDate: null,
                bookingEndDate: null
            })
        })
    }

    seeHouseRules(){
        window.location.href = '/houses/'+this.state.house.id+'#rules';
    }

    confirmBooking(){
        let {invitationId,user_id,room,bookingStartDate,bookingEndDate} = this.state;
        let payload = {
            invitation_id: invitationId,
            user_id: user_id,
            room_id: room.id,
            date_from: bookingStartDate,
            date_to: bookingEndDate,
        }
        Axios.post('/api/invitation/accept',payload).then((response)=>{
            window.location.href = '/reserve/success/'+response.data
        })
    }

    handleBookingDates(startDate,endDate){
        this.setState({
            bookingStartDate: startDate,
            bookingEndDate: endDate
        })
    }

    render() { 
        let {invitationLoaded,room,room_images,house,neighborhood,manager,dates} = this.state;
        if(invitationLoaded){
            return ( <>
                <div className="container p-0">
                    <div className="show_invitation">
                    {screen.width <= 425 && 
                        <img className="room_image" src={`https://fom.imgix.net/${room_images[0].image}?w=320&h=275&fit=crop`}/>
                    }
                    <div className="images">

                        {screen.width > 425 && room_images.map((image,index)=>{
                            return <img key={`image-${index}`} className="room_image" src={`https://fom.imgix.net/${image.image}?w=320&h=275&fit=crop`}/>
                        })}
                    </div>
                    <div className="m-3">
                        <p className="title">Room #{room.number}</p>
                        <p className="text">{house.name} - {neighborhood.name}</p>
                        <p className="title">Anfitrion</p>
                        <p className="text">{manager.name} {manager.last_name}</p>
                        <p className="title">Room Price</p>
                        <p className="text">{room.price}</p>
                        <p className="title">Stay Dates</p>
                        {/* HERE GOES DATEPICKER */}
                        {screen.width <= 425 &&
                            <Datepicker type='booking-range-mobile' minStay={90} dates={dates} startDateHandler={this.handleBookingDates.bind(this)}/>
                        
                        }
                        {screen.width > 425 &&
                        <Datepicker className="transform_datepicker_up" type='booking-range-mobile' minStay={90} dates={dates} startDateHandler={this.handleBookingDates.bind(this)}/>

                        }
                        <p className="title">Room Description</p>
                        <RoomDescription room_id={room.id}/>
                        <a className="text-primary" onClick={this.seeHouseRules.bind(this)}>Ver Reglas de la VICO ></a>

                    </div>
                    {this.state.isLogged &&                    
                        <button className="btn btn-primary accept_button" onClick={this.confirmBooking.bind(this)}>Confirmar</button>
                    }
                    {!this.state.isLogged && 
                        <button data-toggle="modal" data-target="#Register" className="btn btn-primary accept_button" onClick={this.saveInfoInLocalstorage}>Confirmar</button>
                    }
                    </div>

                </div>
            </> );
        }
        else{
            return (<p>Cargando</p>);
        }
    }
}
 
let showInvitation = document.getElementById('react-showInvitation')
if(showInvitation){
    let connection = showInvitation.dataset.connection;
    ReactDOM.render(<AcceptInvitation connection={connection}/>,showInvitation);
}