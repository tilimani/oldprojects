import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Slider from '@material-ui/core/Slider';



const RangeSlider = (props) => {

  let valueHandler = props.valueHandler;

  const useStyles = makeStyles({
    root: {
      width: props.width ? props.width + "%" : '20%',
      color: '#ea960f'
    },
  });

  const classes = useStyles();

  const handleSliderChange = (event, newValue) => {
    valueHandler(newValue);
  };
  
  return (
    <div>
      <Slider
        className={classes.root}
        value={props.value}
        min={props.min}
        max={props.max}
        marks={props.marks}
        defaultValue={props.defaultValue}
        getAriaValueText= {props.getAriaValueText}
        valueLabelDisplay={props.valueLabelDisplay}
        onChange={handleSliderChange}
        valueLabelFormat={props.valueLabelFormat}
        aria-labelledby="range-slider"
      />
    </div>
  );
}

export default RangeSlider;
