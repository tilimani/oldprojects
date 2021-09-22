import React from 'react';
import './styles.scss';

import HouseContainer, 
    {HouseContainerSimple, HouseOverlay, HouseBanner} 
    from '../../atoms/HouseContainer/HouseContainer';


const House = ({index, images: [], prices, name}) => {
    const price = Math.min(...prices);
    return (
        <div>
            <HouseContainerSimple images={[...images]}>
                <HouseOverlay price={price} name={name}/>
            </HouseContainerSimple>
        </div>
    )
};

export const HouseSlide = ({settings, index, images, price, name, id}) => {
    return (
        <div className="house-slide" key={`${index}-${name}`} 
            onClick={(e) => {e.preventDefault(); window.open(`/houses/${id}`)}}>
            <HouseContainerSimple image={images.shift()}>
                <HouseOverlay price={price} name={name}/>
            </HouseContainerSimple>
        </div>
    )
};

export const HouseSlideBanner = ({city}) => {
    return (
        <div className="house-slide" onClick={(e) => {e.preventDefault(); window.open(`/vicos/${city}`)}}>
            <HouseContainerSimple image={{image: 'house_116_0_2019429124731.jpeg'}}>
                <HouseBanner text={`Ver más Vicos en la ciudad de ${city}`}/>
            </HouseContainerSimple>
        </div>
    );
};

export default House;