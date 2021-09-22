import React from 'react';
import './styles.scss';

const HouseContainer = ({images}) => {
    return (
        <div>
            
        </div>
    );
};

export const HouseContainerSimple = ({image, children}) => {
    return (
        <div className="house-container" key={`house-image-${image.image}`}>
            <img className="image" 
                src={`https://fom.imgix.net/${image.image}?w=750&amp;h=500&amp;fit=crop`}/>
            {children}
        </div>
    );
};

export const HouseOverlay = ({name, price}) => {
    return (
        <div className="house overlay" key={`house-overlay-${name}`}>
            <p className="heading">{name}</p>
            <p className="sub-heading">Desde {price}$ COP/Mes</p>
        </div>
    );
};

export const HouseBanner = ({text}) => {
    return (
        <div className="house-overlay">
            <div className="house overlay">
                <p className="heading">{text}</p>
            </div>
        </div>
    );
}

export default HouseContainer;