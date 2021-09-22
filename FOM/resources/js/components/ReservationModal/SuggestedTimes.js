import React, { Component } from 'react';
import Slider from './Slider';
import Typography from '@material-ui/core/Typography';
import Datepicker from '../Datepicker/Datepicker';

const SuggestedTimes = (props)=> {
    let Localization = props.Localization;
    return (
        <div className="text-center">
            <p className="py-2">{Localization.trans('propose_date_and_time')}</p>
            <Datepicker type={'single'} 
                dates={props.dates} 
                startDateHandler={(date)=>props.handleVisitDates(date)}/>
            <p className="py-1 small-grey-text">{Localization.trans('date')}</p>
            <Slider min={8} max={20} hour={props.hour} hourHandler={props.hourHandler}/>
            <p className="py-0 small-grey-text" style={{marginTop: "-10px"}}>{Localization.trans('time')}</p>
            <p className="py-0 small-grey-text" style={{marginTop: "-10px"}}>{props.hour[0]}:00 - {props.hour[1]}:00</p>
            <button className="btn btn-primary mt-4" onClick={props.submitSuggestedTimeHandler}>{Localization.trans('add')}</button>
        </div>
    );
}

export default SuggestedTimes