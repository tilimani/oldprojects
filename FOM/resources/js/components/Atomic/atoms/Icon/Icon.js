import React from 'react';
import './styles.scss';

const Icon = ({icon = "fas fa-check", color = 'red'}) => {
    return (
        <div className="_icon_image">
            <div className="_content">
                <div className={`_image ${color}`}>
                    <i className={icon}></i>
                </div>
            </div>
        </div>
    );
};

export default Icon;