import React, { Component } from 'react';
import Modal from 'react-bootstrap/Modal';
import './ReservationModal.scss';
import Axios from 'axios';
import Datepicker from '../Datepicker/Datepicker';
import SuggestedTimes from './SuggestedTimes';
import List from './List';
import Localization from '../../Localization/Localization';
import { object } from 'prop-types';

export default class ReservationModal extends Component {
    // This is initializing our states
    constructor(props) {
        super(props);
        this.state={
            room:'',
            house:'',
            manager:'',
            dates:'',
            images:'',
            show: false,
            Localization: '',
            step:0,
            minStay:'',
            timeAdvance:'',
            showButton: 0,
            date: '',
            hour:[8, 20],
            suggestions: [],
            addTiempo: 1,
            verification: '',
            isVIP: '',
            vicoFee: '',
            bookingStartDate:null,
            bookingEndDate:null,
            errorMessage: false,
        };
    }
    
    // This executes when the component renders for the client
    componentDidMount(){
        // this.props.handleChange(this.getComponentData);
        this.props.onRef(this);
    }

    componentWillUnmount() {
        this.props.onRef(undefined)
    }

    getComponentData(roomId){
        let data = {
            roomId: roomId
        }
    
        // This is assigning values from Axios
        Axios.post('/api/room', data).then((response)=>{
            this.setState({
                room: response.data.room,
                house: response.data.house,
                dates: response.data.dates,
                manager: response.data.manager,
                verification: response.data.verification ? response.data.verification : '',
                images: response.data.images[0].image,
                minStay: parseInt(response.data.min_stay[0].description),
                timeAdvance: parseInt(response.data.time_advance.description),
                show: true,
                isVIP: response.data.is_vip
            })
            this.setState({
                vicoFee: this.state.isVIP == 1 ? this.state.room.price * 0.1 : this.state.room.price * 0.07
            }) 
        });
    }

    componentWillMount(){
        let localization = new Localization;
        localization.initialize('reservation',this.props.connection);
        this.setState({
            Localization: localization,
        })
    }

    nextStep(){
        if ((this.state.step == 2 && this.state.showButton == 1 && this.state.suggestions < 1)){
            this.setState({errorMessage: 2});
        }

        else if (this.state.step == 1 && this.state.bookingEndDate == null){
            this.setState({errorMessage: true});
        }
        else if(this.state.step == 1 && this.state.bookingStartDate == null){
            this.setState({errorMessage: true});
        }

        else {
            let nextStep = this.state.step+1;
            this.setState({
                step: nextStep,
                errorMessage: false
            }) 
        }
    }

    closeModal(){
        this.setState({
            show: false,
            step: 0,
        })
    }
    
    handleInfoUnshow(e){
        e.preventDefault();
        this.setState({showButton: 0});
    }

    handleInfoShow(e){
        e.preventDefault();
        this.setState({showButton: 1});
    }

    changeInputHandler(event) {
        this.setState({ date: event.target.value });
    }
    
    submitSuggestedTimeHandler(event) {
        event.preventDefault();
        if (this.state.date){
            this.setState({
                date: '',
                suggestions: [...this.state.suggestions, {date:this.state.date, hour:this.state.hour}],
                addTiempo: 0,
                errorMessage: false,
            });

        }
        
        else {
            this.setState({errorMessage: 1});
        }
    }

    removeHandler(index){
        event.preventDefault();
        let newList = [...this.state.suggestions];
        newList.splice(index,1);
        this.setState({
            suggestions: newList,
        });
        if (newList.length < 1){
            this.setState({
                addTiempo: 1
            })
        }
    }

    setHour(value){
        this.setState({
            hour: value
        })
    }

    handleAddTiempo(){
        this.setState({
            addTiempo: 1,
        })
    }

    handleBookingDates(startDate,endDate){
        this.setState({
            bookingStartDate: startDate,
            bookingEndDate: endDate
        })
    }

    handleVisitDates(date){
        this.setState({
            date: date
        })
    }

    handleSubmit(e){
        e.preventDefault();
        // format suggestions
        let suggestions = this.state.suggestions; 
        suggestions.forEach((el)=>{
            el.date = el.date.format('YYYY-MM-DD')
        })
        Axios.post('/rooms/reserve', {
            room_id: this.state.room.id,
            datefrom: this.state.bookingStartDate.format('YYYY-MM-DD'),
            dateto: this.state.bookingEndDate.format('YYYY-MM-DD'),
            mode: this.state.showButton ? 1 : 0,
            message: document.getElementById('message-to-owner').value,
            suggestions: suggestions
          })
          .then(function (response) {window.location.href = '/reserve/success/'+response.data;})
          .catch(function (error) {console.log(error);});
    }


    render() {
        let Localization = this.state.Localization;
        return (            
            <Modal show={this.state.show} onHide={this.closeModal.bind(this)}>
                <Modal.Header className="pb-0" closeButton>
                    <div className="modal-header align-items-center justify-content-center row pt-0" style={{border: 0}}>
                        <div className="col-auto text-right pr-0 pl-0">
                            <img style={{width: 45+'px', alignSelf: 'start'}} src={'https://fom.imgix.net/' + this.state.manager.image + '?w=250&mask=ellipse&h=250&fit=crop'}/>
                        </div>
                        <div className="col pl-2 pr-0 pt-3" style={{alignSelf: 'start'}}>
                            <p className="h5 d-inline bold">{Localization.trans('contact_to')} {this.state.manager.name}</p>
                            
                            {this.state.verification.document_verified == 1 && <div>
                                <img className="checkmark d-inline" src="/icons/checkmark-white-green.svg" alt=""/>
                                <p className="d-inline small-grey-text">{Localization.trans('id_verified')}</p>
                            </div>}

                            {this.state.verification.phone_verified == 1 && <div className="text-nowrap">
                                <img className="checkmark d-inline" src='/icons/checkmark-white-green.svg'/>
                                <p className="d-inline small-grey-text">{Localization.trans('cell_verified')}</p>
                            </div>}

                            {this.state.verification.email_verified == 1 && <div>
                                <img className="checkmark d-inline" src="/icons/checkmark-white-green.svg" alt=""/>
                                <p className="d-inline small-grey-text">{Localization.trans('email_verified')}</p>
                            </div>}

                        </div>
                    </div>
                    <div className="row ml-2 mr-2 mb-2" style={{borderTop: 1+'px solid #7f7f7f'}}></div>
                </Modal.Header>
                <Modal.Body>
                     <div className="row" style={{paddingTop: 15+'px'}}>
                        <div className="col">
                        <p style={{fontSize: "16px"}}>{Localization.trans('reservation_request')}</p>
                        </div>
                        <div className="col-auto text-right small-grey-text" id="paso-style" style={{fontSize: 14+'px'}}>
                        {Localization.trans('step')} <span id="paso">{this.state.step+1}</span> {Localization.trans('of')} 4
                        </div>
                    </div>
                    <form onSubmit={this.handleSubmit.bind(this)}>                                
                        {/* Step 1 */}
                        {(this.state.step === 0) && <div>
                            <div className="row justify-content-center">
                            <div className="pr-0">
                            <img src='/icons/checkmark-white-green.svg' style= {{height: "20px"}}/>
                            </div>
                            <div className="col-auto">
                                <p className="mb-0">{Localization.trans('room')} {this.state.room.number}</p> 
                                <p className="mb-0 small-grey-text">{this.state.house.name}</p>
                            </div>                                      
                            </div>
                            <div className="row">
                            <div className="col-12 text-center justify-content-end">
                            <img className="room-image" src={'https://fom.imgix.net/' + this.state.images + '?w=1280&h=853&fit=crop'}/>
                            </div>
                            </div>
                            <div className="row justify-content-center">
                            <div className="col-auto pr-2" style={{minWidth: 50+"%"}}>
                                <p className="small-title">{Localization.trans('deposit')}:</p>
                                <p className="small-grey-text">{Localization.trans('one_month_rent')}</p>
                                <p className="small-title">{Localization.trans('vico_fee')}:</p>
                                <p className="small-grey-text">{Localization.trans('one_time_cost')}</p>
                                <p className="small-title">{Localization.trans('total')}:</p>
                            </div>
                            <div className="col-auto pl-3">
                                <p className="small-grey-text prices">{this.state.room.price} COP</p>
                                <p className="small-grey-text prices">{Math.round(this.state.vicoFee)} COP</p>
                                <p className="small-grey-text prices m-0">{Math.round(Number(this.state.room.price) + Number(this.state.vicoFee))} COP</p>
                            </div>
                            </div>
                            </div>
                        }
                        {/* Step 2 */}
                        {(this.state.step === 1) && <div>
                        {/* // <div className="modal-body step d-none" id="step-2"> */}
                            <div className="row">
                            <div className="col-auto pr-0">
                                <img src="/images/reserveRequest/1-green-1-orange.svg" style={{height: '100px', paddingTop: '15px'}}/>
                            </div>
                            <div className="col" style={{marginTop: 10+'px'}}>
                                <div>
                                <p className="mb-0">{Localization.trans('room')} {this.state.room.number}</p>
                                <p className="small-grey-text">{this.state.house.name}</p>
                                </div>
                                <div style={{marginTop: 30+"px"}}>
                                <p className="mb-0">{Localization.trans('how_long_stay')}</p>
                                <p className="small-grey-text">{Localization.trans('minimum_time')} {this.state.minStay} {Localization.trans('days')}</p>
                                </div>
                            </div>
                            <div className="col-auto text-center d-lg-flex d-none justify-content-end">
                                <img className="small-room-image" src={'https://fom.imgix.net/' + this.state.images + '?w=1280&h=853&fit=crop'} style={{margin: "0"}}/>
                            </div>
                            </div>
                            {/* Mobile datepicker (vertical) */}
                            <div className="row justify-content-center text-center my-4 d-sm-none">
                            <Datepicker type={'booking-range-mobile'} 
                                dates={this.state.dates} 
                                minStay={this.state.minStay} 
                                startDateHandler={this.handleBookingDates.bind(this)}/>
                            </div>
                            {/* Desktop datepicker (horizontal) */}
                            <div className="row justify-content-center text-center my-4 d-sm-flex d-none">
                            <Datepicker type={'booking-range'} 
                                dates={this.state.dates} 
                                minStay={this.state.minStay} 
                                startDateHandler={this.handleBookingDates.bind(this)}/>
                            </div>
                            {this.state.errorMessage && 
                                <div className="alert alert-danger text-center"> 🤚 {Localization.trans('add_start_end')}</div>
                            }
                            </div>
                        }
                        {/* Step 3 */}
                        {(this.state.step === 2) && <div className="row">        
                            <div className="col-auto">
                                <img src='/images/reserveRequest/2-dot-green-1-orange.svg' style={{height: '150px', paddingTop: '15px'}}/>
                            </div>
                            <div className="col-auto pl-0">
                                <div>
                                    <p className="mb-0 mt-2">{Localization.trans('room')} {this.state.room.number}</p>
                                    <p className="small-grey-text">{this.state.house.name}</p>
                                </div>
                                <div className="mt-3">
                                    <p className="mb-0 ">{this.state.bookingStartDate.format('DD/MM/YYYY')} - {this.state.bookingEndDate.format('DD/MM/YYYY')}</p>
                                    <p className="small-grey-text">{Localization.trans('reservation_date')}</p>
                                </div>
                                <div className="mt-3" style={{paddingTop: "3px"}}>
                                    <p>{Localization.trans('do_it_your_way')}</p>
                                </div> 
                                </div>
                                <div className="col-auto text-center d-lg-flex d-none justify-content-end">
                                    <img className="small-room-image" src={'https://fom.imgix.net/' + this.state.images + '?w=1280&h=853&fit=crop'} style={{margin: "0"}}/>
                            </div>
                            {/* Custom Radio Buttons */}
                            <div className="ml-5 mt-3">
                                {/* Reserve Online */}
                                <div className="row" onClick={this.handleInfoUnshow.bind(this)}>
                                <div className="col-auto m-0 p-0">
                                    <div className="custom-control custom-radio" id="online">
                                    <input id="credit" name="option" type="radio" className="custom-control-input" checked={!this.state.showButton} required/>
                                    <label className="custom-control-label" htmlFor="credit"></label>
                                    </div>
                                </div>
                                <div className="col-10" id="reserve-online">
                                    <div>
                                    <p className="mb-0">{Localization.trans('reserve_online')}</p>
                                    <p className="small-grey-text">{Localization.trans('with_this_option')}</p>
                                    </div>
                                </div>
                            </div>
                                {/* Reserve Offline */}
                                <div className="row" onClick={this.handleInfoShow.bind(this)}>
                                    <div className="col-auto m-0 p-0">
                                        <div className="custom-control custom-radio" id="offline" style={{marginTop: 15+"px"}}>
                                        <input id="paypal" name="option" type="radio" className="custom-control-input" checked={this.state.showButton} required/>
                                        <label className="custom-control-label" htmlFor="paypal"></label>
                                    </div>
                                    </div>
                                    <div className="col-10" id="reserve-offline">
                                        <div style={{marginTop: 10+'px'}}>
                                        <p className="mb-0">{Localization.trans('visit_house_in_person')}</p>
                                        <p className="small-grey-text m-0">{Localization.trans('if_want_visit')}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {/* End Radio Buttons // Start Hidden Section */}
                            {this.state.showButton == 1 &&  
                                <div className="div justify-content-center w-100 mt-3 mb-2">
                                    {/* List that always shows */}
                                    <List 
                                        suggestions={this.state.suggestions}
                                        removeHandler={(index)=>{this.removeHandler(index)}}
                                        Localization={Localization}
                                        />
                                    {/* If they want to add a time */}
                                    {this.state.addTiempo == 1 && 
                                        <SuggestedTimes 
                                            hour={this.state.hour} 
                                            submitSuggestedTimeHandler={this.submitSuggestedTimeHandler.bind(this)}
                                            handleVisitDates={this.handleVisitDates.bind(this)}
                                            hourHandler={this.setHour.bind(this)}
                                            suggestions={this.state.suggestions} 
                                            date={this.state.date}
                                            Localization={this.state.Localization}
                                        />
                                    }
                                    {this.state.addTiempo == 0 && 
                                        <p className="text-center" onClick={this.handleAddTiempo.bind(this)}>➕ {Localization.trans('add_another_date')}</p>
                                    }
                                    {this.state.errorMessage == 1 && 
                                        <div className="alert alert-danger text-center my-4 mx-3"> 🤚{Localization.trans('add_time')}</div>
                                    }
                                    {this.state.errorMessage == 2 && 
                                        <div className="alert alert-danger text-center my-4 mx-3"> 🤚{Localization.trans('add_suggestion')}</div>
                                    }

                                </div>
                            }
                        </div>
                        }
                        {/* Step 4 */}
                        {(this.state.step === 3) && <div>
                            <div className="row" style={{marginTop: "15px"}}>
                                <div className="col-auto justify-content-end">
                                    <img src='/images/reserveRequest/3-dot-green-1-orange.svg' style={{height: "200px", paddingTop: "15px"}}/>
                                </div>
                                <div className="col pl-0">
                                <div>
                                    <p className="mb-0 mt-2">{Localization.trans('room')} {this.state.room.number}</p>
                                    <p className="small-grey-text">{this.state.house.name}</p>
                                </div>
                                <div className="mt-3">
                                    <p className="mb-0 ">{this.state.bookingStartDate.format('DD/MM/YYYY')} - {this.state.bookingEndDate.format('DD/MM/YYYY')}</p>
                                    <p className="small-grey-text">{Localization.trans('reservation_date')}</p>
                                </div>
                                <div className="" id="finnicky-title-1">
                                    <p>{Localization.trans('you_want_reserve')} {this.state.showButton ? 'online' : 'online'}</p>
                                </div> 
                                <div id="finnicky-title-2" className="">
                                    <p>{Localization.trans('get_in_touch_with')} {this.state.manager.name} {Localization.trans('and_let_them_know')}</p>
                                    </div> 
                                </div>
                                <div className="col-auto text-center d-lg-flex d-none justify-content-end">
                                <img className="small-room-image" src={'https://fom.imgix.net/' + this.state.images + '?w=1280&h=853&fit=crop'} style={{margin: '0'}}/>
                                </div>
                            </div> 
                            <div className="row justify-content-center justify-content-lg-start">
                                <textarea name="" id="message-to-owner" cols="40" rows="5" placeholder="Escribe tu mensaje" style={{borderRadius: 20+'px', borderColor: '#c9c9c9', padding: 20+'px', width: 87+'%'}} defaultValue=""></textarea>
                            </div>
                            </div>
                        }
                        {/* END OF STEPS */}
                        {/* buttons on all pages except last */}
                        <Modal.Footer className="row justify-content-center mt-4 pb-0" id='footer'>
                            {(this.state.step <= 2) && <div className="d-flex" id="first-buttons">
                            <div className="col-auto align-self-center">
                                <button style={{padding: '0 25px 0 25px'}} className="btn" onClick={this.closeModal.bind(this)} id="transparent-btn">
                                    {Localization.trans('cancel')}
                                </button>
                            </div>
                            <div className="col-auto"><a className="btn btn-primary" onClick={this.nextStep.bind(this)}>{Localization.trans('next')}</a></div>
                        </div>
                        }
                            {/* buttons on last page */}
                            {(this.state.step > 2) && <div className='row'>
                                    <div className="col-12 text-center"><button className="btn btn-primary" style={{width: "80%"}}>{Localization.trans('send_request')}</button></div>
                                    <div className="col-12 justify-content-center text-center bold-words pt-3 small-grey-text"><p className="mb-0">{Localization.trans('payment_realized')}</p></div>
                                </div>
                            }
                        </Modal.Footer>
                    </form>
                </Modal.Body>
            </Modal>
        );
    }
}