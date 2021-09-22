import React from 'react';
import PropTypes from 'prop-types';

const Month = ({property}) => {
    const {index, month} = property;
    return (
        <div id={`month-${index}`} className="month">
           <span>{month}</span>
        </div>
    )
}

Month.propTypes = {
    property: PropTypes.object.isRequired
}

export default Month;