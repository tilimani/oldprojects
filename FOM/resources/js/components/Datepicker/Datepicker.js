import React, { Component } from 'react';
import { DateRangePicker, SingleDatePicker, DayPickerRangeController } from 'react-dates';
import PropTypes from 'prop-types';
import 'react-dates/initialize';
import 'react-dates/lib/css/_datepicker.css';
import  moment  from 'moment';

class Datepicker extends Component {
    constructor(props) {
        super(props);
        this.state = {
            focusedInput:'startDate',
            startDate:null,
            endDate:null,
            dates: props.dates,
            minStay:props.minStay,
        }
    }

    isStartDayBlocked(day){
        let {dates,minStay} = this.state;
        let _day = moment(day,'YYYY-MM-DD').add(minStay,'days');
        let dateFrom,dateTo;
        for (let i = 0; i < dates.length; i++) {
            const date = dates[i];
            dateFrom = new Date(date.date_from);
            dateTo = new Date(date.date_to)
            if(day >= dateFrom && day <= dateTo){
                return true;
            }
            if(_day > dateFrom && day < dateFrom){
                return true;
            }
        }
    }

    isEndDayBlocked(day){
        let {dates,startDate} = this.state;
        let dateFrom,dateTo;
        for (let i = 0; i < dates.length; i++) {
            const date = dates[i];
            dateFrom = new Date(date.date_from);
            dateTo = new Date(date.date_to)
            if(dateFrom <= day && day <= dateTo){
                return true;
            }
            if(startDate < dateTo && day > dateTo){
                return true;
            }
        };

        return false;
    }

    showEndDateMonth(){
        let {startDate,minStay} = this.state;
        if(startDate != null){
            return moment(startDate).add(minStay,'days');
        }
        return moment()
    }
    
    render() {
        const {type,minStay} = this.props;
        const {focusedInput} = this.state;
        const isDayBlocked = focusedInput === "startDate" ? this.isStartDayBlocked.bind(this) : this.isEndDayBlocked.bind(this); 

        return (
            <>
            {type == 'single' &&

            <SingleDatePicker
                date={this.state.startDate} // momentPropTypes.momentObj or null
                onDateChange={date => {this.setState({ startDate:date }); this.props.startDateHandler(date)}} // PropTypes.func.isRequired
                focused={this.state.focused} // PropTypes.bool
                onFocusChange={({ focused }) => this.setState({ focused })} // PropTypes.func.isRequired
                id="single_datepicker" // PropTypes.string.isRequired,
            />
            }
            {type == 'range' && 
                <DateRangePicker 
                    startDate={this.state.startDate} // momentPropTypes.momentObj or null,
                    startDateId="startDate" // PropTypes.string.isRequired,
                    endDate={this.state.endDate} // momentPropTypes.momentObj or null,
                    endDateId="endDate" // PropTypes.string.isRequired,                      
                    onDatesChange={({ startDate, endDate }) => {this.setState({ startDate, endDate }); this.props.startDateHandler(startDate,endDate)}} // PropTypes.func.isRequired,
                    focusedInput={this.state.focusedInput} // PropTypes.oneOf([START_DATE, END_DATE]) or null,
                    onFocusChange={focusedInput => this.setState({ focusedInput })} // PropTypes.func.isRequired,
                    orientation="vertical"

                />
            }
            {type == 'booking-range-mobile' &&
                <DateRangePicker
                    startDate={this.state.startDate} // momentPropTypes.momentObj or null,
                    startDateId="startDate" // PropTypes.string.isRequired,
                    endDate={this.state.endDate} // momentPropTypes.momentObj or null,
                    endDateId="endDate" // PropTypes.string.isRequired,                      
                    onDatesChange={({ startDate, endDate }) => {this.setState({ startDate, endDate }); this.props.startDateHandler(startDate,endDate)}} // PropTypes.func.isRequired,
                    // focusedInput={this.state.focusedInput} // PropTypes.oneOf([START_DATE, END_DATE]) or null,
                    onFocusChange={focusedInput => this.setState({ focusedInput })} // PropTypes.func.isRequired,
                    isDayBlocked={isDayBlocked}
                    minimumNights={minStay}
                    initialVisibleMonth={this.showEndDateMonth.bind(this)}
                    orientation="vertical"
                />
            }
            {type == 'booking-range' &&
                <DateRangePicker
                    startDate={this.state.startDate} // momentPropTypes.momentObj or null,
                    startDateId="startDate" // PropTypes.string.isRequired,
                    endDate={this.state.endDate} // momentPropTypes.momentObj or null,
                    endDateId="endDate" // PropTypes.string.isRequired,                      
                    onDatesChange={({ startDate, endDate }) => {this.setState({ startDate, endDate }); this.props.startDateHandler(startDate,endDate)}} // PropTypes.func.isRequired,
                    focusedInput={this.state.focusedInput} // PropTypes.oneOf([START_DATE, END_DATE]) or null,
                    onFocusChange={focusedInput => this.setState({ focusedInput })} // PropTypes.func.isRequired,
                    isDayBlocked={isDayBlocked}
                    minimumNights={minStay}
                    initialVisibleMonth={this.showEndDateMonth.bind(this)}
                />
            }
            {type == 'calendar' &&
                <DayPickerRangeController
                    startDate={this.state.startDate} // momentPropTypes.momentObj or null,
                    endDate={this.state.endDate} // momentPropTypes.momentObj or null,
                    onDatesChange={({ startDate, endDate }) => this.setState({ startDate, endDate })} // PropTypes.func.isRequired,
                    focusedInput={this.state.focusedInput} // PropTypes.oneOf([START_DATE, END_DATE]) or null,
                    onFocusChange={focusedInput => this.setState({ focusedInput })} // PropTypes.func.isRequired,
                    initialVisibleMonth={() => moment().add(2, "M")} // PropTypes.func or null,
                    isDayBlocked={isDayBlocked}
                    minimumNights={minStay}
                />
            }
            </>
        );
    }
}

export default Datepicker;