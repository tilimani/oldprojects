import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Flex, { FlexItem, FlexItemText } from "../../atoms/Flex/Flex";
import ImageBg from "../../../images/CreatePreLogin/crea-tu-vico.jpg";
import './Home.scss';

const Home = (props) => {

    return (
        <Flex>
            <div className="home-container">
                <div className="title-container vico-color">
                    <strong>Crea</strong>
                    <strong>tu</strong>
                    <strong>VICO</strong>
                </div>
                <p className="description">Con pocos datos puedes tener tu vico en nuestra página</p>
                <button onClick={props.nextPage} className="btn">Comencemos</button>
            </div>
        </Flex>
    );
}

export default Home;
