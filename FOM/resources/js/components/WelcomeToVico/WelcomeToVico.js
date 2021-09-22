import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import './welcomeToVico.scss';

//Images
import ImageCasaVico from "../images/welcomeToVico/casaVico.png";
import ImageMapa from "../images/welcomeToVico/mapa.png";
import ImageRoom from "../images/welcomeToVico/cama.svg";
import ImageShield from "../images/welcomeToVico/escudo.svg";
import ImageCalendar from "../images/welcomeToVico/tiempo.svg";

// class WelcomeToVico extends Component {
const WelcomeToVico = (props) => {
    const loadCreateVico = () => {
        window.location.href = `/houses/create/1`;
    }

    return (
        <main className="app-welcome-container">
            <div className="app-welcome-wrapper">
                <section className="section section-welcome">
                    <div className="welcome-title">
                        <h1>¡Bienvenido a VICO!</h1>
                    </div>
                    <div className="welcome-text">
                        <p>Subir tu VICO (vivienda compartida) a nuestra plataforma es muy fácil y rápido. Una vez publicadas, tus habitaciones estarán visibles para los estudiantes (extranjeros) y jóvenes profesionales.</p>
                    </div>
                </section>
                <section className="section section-requirements">
                    <div className="requirements-title">
                        <h2>¿Cumples con los siguientes requisitos?</h2>
                    </div>
                    <div className="requirements-wrapper">
                        <div className="requirements-house">
                            <div className="house-title">
                                <h3>VICO completamente amoblada</h3>
                            </div>
                            <div className="house-img">
                                <img src={ImageCasaVico} alt="Casa vico con sus partes"/>
                            </div>
                            <div className="house-description">
                                <p>¿Qué es una VICO completamente amoblada? Cocina: Completamente dotada y con horno ó microondas ó estufa. Habitaciones: Mínimo closet y cama.</p>
                            </div>
                        </div>
                        <div className="requirements-location">
                            <div className="location-title">
                                <h3>Ubicación</h3>
                            </div>
                            <div className="location-img">
                                <img src={ImageMapa} alt="Mapa con un indicador encima"/>
                            </div>
                            <div className="location-description">
                                <p>En VICO trabajamos con estudiantes y jóvenes profesionales. Por eso, nos parece importante que tu VICO (viviendas compartida) quede cerca a universidades y medios de transporte público.</p>
                            </div>
                        </div>
                    </div>
                </section>
                <div className="button-section-container">
                    {
                        props.connection == null &&
                        <a onClick={loadCreateVico} className="btn btn-primary">Publica tu VICO ahora</a>
                    }
                    {
                        props.connection < 3 &&
                        <a onClick={loadCreateVico} className="btn btn-primary">Publica tu VICO ahora</a>
                    }
                </div>
                <section className="section section-success-cases">
                    <div className="success-cases-title">
                        <h2>Casos de éxito VICO</h2>
                    </div>
                    <div className="success-cases-wrapper">
                        <div className="room-case-container">
                            <div className="room-case-img">
                                <img src={ImageRoom} alt="Cuarto con una cama y un armario"/>
                            </div>
                            <div className="room-case-info-container">
                                <div className="info-values style-value">
                                    <strong>+500</strong>
                                </div>
                                <div className="info-text">
                                    <h4 className="style-text">Habitaciones</h4>
                                </div>
                                <div className="info-text-description style-description">
                                    <p>Entre las ciudades de Medellín y Bogotá poseemos más de 500 habitaciones en la red de VICOs.</p>
                                </div>
                            </div>
                        </div>
                        <div className="contract-case-container">
                            <div className="contract-case-img">
                                <img src={ImageShield} alt="Cuarto con una cama y un armario"/>
                            </div>
                            <div className="contract-case-info-container">
                                <div className="info-values style-value">
                                    <strong>96%</strong>
                                </div>
                                <div className="info-text">
                                    <h4 className="style-text">Cumplimiento del contrato</h4>
                                </div>
                                <div className="info-text-description style-description">
                                    <p>Alto rango en el cumplimiento del contrato por parte de los invitados y los anfitriones.</p>
                                </div>
                            </div>
                        </div>
                        <div className="time-case-container">
                            <div className="time-case-img">
                                <img src={ImageCalendar} alt="imagen de un calendario"/>
                            </div>
                            <div className="time-case-info-container">
                                <div className="info-values style-value">
                                    <strong>4 Meses</strong>
                                </div>
                                <div className="info-text">
                                    <h4 className="style-text">Tiempo promedio de estancia</h4>
                                </div>
                                <div className="info-text-description style-description">
                                    <p>La estancia promedio de los invitados se encuentra entre 4 a 24 meses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    );
}

if (document.getElementById('react-welcome-vico')) {
    let communicationDiv = document.getElementById('react-welcome-vico');
    let connection = communicationDiv.dataset.connection;
    ReactDOM.render(<WelcomeToVico connection={connection}/>, document.getElementById('react-welcome-vico'));
}