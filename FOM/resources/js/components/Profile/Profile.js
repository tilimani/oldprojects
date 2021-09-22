import React from 'react';
import UserPicture from '../UserPicture/UserPicture';
import CheckIcon from '../images/accepted.png'
import './Profile.scss';
import StarRatings from 'react-star-ratings';

const Profile = (props) => {
    // if(props.booking.id != null){

    let getDateDay = (date) =>{
        let dateInfo = date.split('.');
        let newDate = new Date(('20'+dateInfo[2]),parseInt(dateInfo[1])-1,dateInfo[0]);        
        let weekDays = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];        
        return weekDays[newDate.getDay()];
    }

    return (
        <div className="profile_app" key={`booking-profile`}>
                <i className="d-md-none fas fa-arrow-left fa-2x" onClick={props.onBackArrow}></i>
                <div className="profile_info">
                    <UserPicture size='lg' user_image={props.booking.user_image} user_gender={props.booking.user_gender} country_icon={props.booking.country_icon}/>
                    <span className="text-capitalize user_name">{props.booking.user_name} {props.booking.user_lastname}</span>
                    <span className="d-block light-text">{props.booking.user_genere}</span>
                    <hr />
                </div>
                <div className="profile_reviews">
                    <p>{props.Localization.trans('reviews')}</p>           
                    <StarRatings rating={props.qualification} 
                        starRatedColor="#fffa57" 
                        starDimension='30px' 
                        starEmptyColor="#ebebeb" 
                        svgIconViewBox="0 0 31.93 30.46" 
                        svgIconPath="M16.83.54,21,9a1,1,0,0,0,.73.53l9.36,1.36a1,1,0,0,1,.53,1.64l-6.77,6.6a1,1,0,0,0-.28.86l1.6,9.32a1,1,0,0,1-1.4,1l-8.37-4.4a1,1,0,0,0-.9,0l-8.37,4.4a1,1,0,0,1-1.4-1L7.34,20a1,1,0,0,0-.28-.86L.29,12.55a1,1,0,0,1,.54-1.64l9.35-1.36A1,1,0,0,0,10.91,9L15.1.54A1,1,0,0,1,16.83.54Z"/>
                    {props.verifications != null &&
                        <div className="verifications mt-3">
                                <div className="verification_item">
                                    <div className="button_image">
                                        <div className="_content_status">
                                            <div className={`_image_status ${(props.verifications.document == 1) ? 'check' : 'uncheck'}`}>
                                                <i className="fas fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span className="light-text pl-2">{props.Localization.trans('id_verified')}</span>
                                </div>
                                <div className="verification_item">
                                    <div className="button_image">
                                        <div className="_content_status">
                                            <div className={`_image_status ${(props.verifications.phone == 1) ? 'check' : 'uncheck'}`}>
                                                <i className="fas fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span className="light-text pl-2">{props.Localization.trans('mobile')}</span>
                                </div>
                                <div className="verification_item">
                                    <div className="button_image">
                                        <div className="_content_status">
                                            <div className={`_image_status ${(props.verifications.email == 1) ? 'check' : 'uncheck'}`}>
                                                <i className="fas fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span className="light-text pl-2">{props.Localization.trans('email')}</span>
                                </div>
                        </div>
                    }    
                </div>
                <hr />
                <p className="house_name my-3">{props.booking.house_name} - {props.Localization.trans('room')} {props.booking.room_number}</p>
                <div className="user_dates" key={props.booking.booking_id}>
                    <div className="start_date" key={props.booking.booking_id + "_start"}>
                        <span className="week_day">{getDateDay(props.booking.date_from)}</span>
                        <span className="light-text">{props.booking.date_from}</span>
                        <span className="light-text">{props.Localization.trans('arrival')}</span>
                    </div>
                    <span className="dates_arrow"><i className="fas fa-chevron-right fa-3x"></i></span>
                    <div className="end_date" key={props.booking.booking_id + "_end"}>
                        <span className="week_day"> {getDateDay(props.booking.date_to)}</span>
                        <span className="light-text">{props.booking.date_to}</span>
                        <span className="light-text">{props.Localization.trans('end')}</span>
                    </div>
                </div>
                <hr />
                {
                    props.booking.status == 5 &&
                    <div className="_content_user">
                        <div className="_text">
                            <span>{props.Localization.trans('name')}:</span>
                            <span>{props.user.name} {props.user.lastname}</span>
                        </div>
                        <div className="_text">
                            <span>{props.Localization.trans('mobile')}:</span>
                            <span>{props.user.phone}</span>
                        </div>
                        <div className="_text">
                            <span>{props.Localization.trans('email')}:</span>
                            <span>{props.user.email}</span>
                        </div>
                    </div>
                }
                
        </div>        
    );
        
    // }
};

export default Profile;