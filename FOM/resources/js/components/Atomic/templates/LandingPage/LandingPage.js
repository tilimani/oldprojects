import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import './styles.scss';

import VicoCarousel from '../../organisms/VicoCarousel/VicoCarousel';
import Axios from 'axios';
class LandingPage extends Component {
    constructor(props) {
        super(props);
        this.state = {
            housesBog: [],
            housesMed: []
        };
    }

    componentDidMount() {
        Axios.get('api/v1/houses/landingpage/med').then((response) => {
            this.setState({housesMed: response.data});
        });
        Axios.get('api/v1/houses/landingpage/bog').then((response) => {
            this.setState({housesBog: response.data});
        });
    }

    render() {
        const housesBog = this.state.housesBog;
        const housesMed = this.state.housesMed;
        return (
            <div className="houses-container">
                <VicoCarousel city="Medellín" houses={housesMed} title="VICOs en Medellín" />
                <VicoCarousel city="Bogotá" houses={housesBog} title="VICOs en Bogotá" />
            </div>
        );
    }
}

LandingPage.propTypes = {

};

const rootElement = document.getElementById("react-landingpagecarousel-test");
if (rootElement) {
    const connection = rootElement.dataset.info;
    ReactDOM.render(<LandingPage connection={connection}/>, rootElement);
}
export default LandingPage;