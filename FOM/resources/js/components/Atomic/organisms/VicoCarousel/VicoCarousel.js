import React from 'react';


import Slider from 'react-slick';
import "slick-carousel/slick/slick.css"; 
import "slick-carousel/slick/slick-theme.css";
import './styles.scss';

import House, {HouseSlide, HouseSlideBanner} from '../../molecules/House/House';
import Tittle from '../../molecules/PaymentHistory/Title/Title'


const VicoCarousel = ({houses, title, city}) => {
    const CustomNextArrow = (props) => {
        const{className, style, onClick} = props;
        const customStyle ={
            
        }
        return (
            <div className={className}
                style={{...style, ...customStyle}}
                onClick={onClick}
            />
        );
    }
    
    const CustomPrevArrow = (props) => {
        const{className, style, onClick} = props;
        const customStyle ={
            
        }
        return (
            <div className={className}
                style={{...style, ...customStyle}}
                onClick={onClick}
            />
        );
    }
    
    const settings = {
        dots: true,
        infinite: false,
        speed: 250,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        swipeToSlide: false,
        nextArrow: <CustomNextArrow />,
        prevArrow: <CustomPrevArrow />,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    }

    return (
    <div>
        <Tittle title = {title}/>
        <Slider {...settings}>
            {
                houses.map((house, index) => {
                    let images = [... house.images];
                    return (
                        <HouseSlide settings={settings}
                            index={index}
                            images={images}
                            price={house.price}
                            name={house.name}
                            key={`slide-${house.name}-${index}`}
                            id={house.id}
                        />
                    )
                })
            }
            <HouseSlideBanner
                city={city}
            />
        </Slider>
    </div>
    );
    
};

export default VicoCarousel;