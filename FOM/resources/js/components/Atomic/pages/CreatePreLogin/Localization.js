import React, { Component } from 'react';
import Flex from "../../atoms/Flex/Flex";
import IconMarker from "../../../images/CreatePreLogin/vico_marker.png";
import { Map, Marker, GoogleApiWrapper } from 'google-maps-react';
import Geocode from "react-geocode";
import './Home.scss'

import Accordion from "react-bootstrap/Accordion";
import Card from "react-bootstrap/Card";
import ListGroup from 'react-bootstrap/ListGroup'
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";
import Axios from 'axios';
import { isThisSecond } from 'date-fns';

const mapStyles = {
  'width': '100%',
  'height': '100%',
  'top': 'unset'
};

export class Localization extends Component {
  constructor(props) {
    super(props);
    this.state = {
      value: '',
      lat: '',
      lng: '',
      countryList:[],
      selectedCity: {},
      animation: null,
      endProcess: false,
      neighborhoodList: [],
      neighborhood: '',
      collapsed: false
    };
    var _isMounted = false;
    var _value = '';
    this.handleChange = this.handleChange.bind(this);
    this.search = this.search.bind(this);
    this.centerMoved = this.centerMoved.bind(this);
    this.selectCity = this.selectCity.bind(this);
    this.saveInLocalstorage = this.saveInLocalstorage.bind(this);
    this.getInfoCityByLatLng = this.getInfoCityByLatLng.bind(this);
    this.getNeighborhoods = this.getNeighborhoods.bind(this);

  }


  componentDidMount() {
    this._isMounted = true;
    this.getLocation('Medellin');
    this.getCities();
  }
  componentWillUnmount() {
    this._isMounted = false;
  }
  getNeighborhoods(city_name) {
    
    Axios.get(`/api/neighborhoods/${city_name}`).then(
      ({data}) => {
        this.setState({ neighborhoodList: data.neighborhoods })
      }
    )
  }
  getCities() {
    Axios.get('/api/currentCities').then(({ data }) => {
      const countryList = data.map(({ name, cities }) => {
        return { country: name, cities: cities }
      })
      this.setState({ countryList: countryList });
    });
  }

  handleChange(event) {
    if (this._isMounted) {

      this.setState({ value: event.target.value, animation: null });
    }
  }

  search() {
    this.getLocation(this.state.value);
    this.setState({ animation: this.props.google.maps.Animation.BOUNCE, endProcess: true, neighborhood: '' });
  }

  getLocation(address) {
    Geocode.setApiKey("AIzaSyBZ0XewfPCqZ_iqFZUtxdUortSkpuYY7ho");
    Geocode.fromAddress(`${address.replace('#', ' ')}, ${this.state.selectedCity.city}, ${this.state.selectedCity.country}`).then(
      response => {
        const { lat, lng } = response.results[0].geometry.location;
        if (this._isMounted) {
          this.setState({ lat: lat, lng: lng });
          this.getInfoCityByLatLng({ lat: lat, lng: lng });
        }
      },
      error => {
        // console.error(error);
      }
    );
  }

  getInfoCityByLatLng({ lat, lng }) {
    Geocode.fromLatLng(lat, lng).then(
      ({ results }) => {
        const neiborhood = results.map(({ address_components }) => {
          return address_components
        });

        neiborhood.forEach((some) => {
          let flag = some.map(({ long_name, types }) => {
            return { long_name, types };
          }).filter(({ types }) => {
            let isNeiborhood = false;
            types.forEach(element => {
              if (element == "neighborhood") {
                isNeiborhood = true;
              }
            });
            return isNeiborhood
          });

          if (flag.length > 0) {
            let type = [];
            type.push(flag);
            type.map(el => {
              const neiborhood = el.map(({ long_name }) => {
                return long_name
              }).reduce((prev, curr) => prev == curr);
              if (neiborhood) {
                this.setState({ neighborhood: neiborhood });
              }
            })
          }
        });
      },
      error => {
        // console.error(error);
      }
    );
  }
  centerMoved(event, map) {
    this.setState({ lat: map.center.lat(), lng: map.center.lng(), animation: this.props.google.maps.Animation.DROP })
  }

  selectCity(country, city, city_id, country_id) {
    this.setState({ selectedCity: { city: city, country: country, cityId: city_id, countryId: country_id } });
    this.getNeighborhoods(city);
    this.accordionToggle.click();
    const neigbId = this.state.neighborhoodList.filter(({ id, name }) => {
      return name == this.state.neighborhood
    })
  }

  saveInLocalstorage() {
    localStorage.removeItem('data');

    const neigbId = this.state.neighborhoodList.filter(({ name }) => {
      return name == this.state.neighborhood
    });

    let data = {
      address: this.state.value,
      city: this.state.selectedCity.cityId,
      country: this.state.selectedCity.countryId,
      info: "",
      lat: this.state.lat,
      lng: this.state.lng,
      ngbhId: (neigbId.length > 0) ? neigbId[0].id : '',
      cityName: this.state.selectedCity.city
    }

    localStorage.setItem('data', JSON.stringify(data));
  }

  render() {
    return (
      <Flex>
        <div className="home-container" style={{ height: 'inherit', background: 'none' }}>
          <div className="cta-wrapper">
            <div className="title">
              <h1>La ubicación de tu VICO</h1>
            </div>
            <div className="accordion-container">
              <Accordion className={`${this.state.collapsed ? 'collapsed-arrow':''}`}>
                <Card style={{border:'none'}}>
                  <Accordion.Toggle as={Card.Header} eventKey="0" ref={toggle => this.accordionToggle = toggle} style={{backgroundColor:'#fff'}} onClick={(e) => this.setState({collapsed: !this.state.collapsed})}>
                    {
                      (Object.keys(this.state.selectedCity).length > 0) ? (`${this.state.selectedCity.city}`) : 
                        (
                          "Escoge tu ciudad"
                        )
                    }
                    <span className="icon-next-fom arrow-down"></span>
                  </Accordion.Toggle>
                  <Accordion.Collapse eventKey="0">
                    <Card.Body>
                      {this.state.countryList &&
                        this.state.countryList.map(({ country, cities }, index) => {
                          return (
                            <ListGroup as="ul" key={index}>
                              <ListGroup.Item disabled className="country">
                                {country}
                              </ListGroup.Item>
                              {
                                cities &&
                                cities.map(({ id, name, country_id }) => {
                                    return (
                                      <ListGroup.Item key={id} className="city" onClick={(e) => { this.selectCity(country, name, id, country_id) }}>
                                        {name}
                                      </ListGroup.Item>
                                    );
                                })
                              }
                            </ListGroup>
                          );
                        })
                      }
                    </Card.Body>
                  </Accordion.Collapse>
                </Card>
              </Accordion>
            </div>
            <div className="cta-container">
              <InputGroup style={{ height: '100%' }}>
                <FormControl
                  placeholder="Busca la dirección de tu VICO"
                  aria-label="Busca la dirección de tu VICO"
                  aria-describedby="basic-addon2"
                  value={this.state.value}
                  onChange={this.handleChange}
                  className="addressInput"
                  disabled={(Object.keys(this.state.selectedCity).length > 0) ? false : true}
                  required
                />
                <InputGroup.Append>
                  <Button
                    variant="outline-secondary"
                    onClick={this.search}
                    className="searchButton"
                    disabled={(Object.keys(this.state.selectedCity).length > 0) ? false : true}
                  >Buscar</Button>
                </InputGroup.Append>
              </InputGroup>
              {/* <input type="text" value={this.state.value} onChange={this.handleChange} className="btn input" /> */}
              {/* <button onClick={this.search} className="btn input" style={{ top: '50px' }}>Buscar</button> */}
            </div>
          </div>

          <Map
            google={this.props.google}
            zoom={16}
            style={mapStyles}
            className="map-localization"
            initialCenter={{ lat: 6.244203, lng: -75.5812119 }}
            center={{ lat: this.state.lat, lng: this.state.lng }}
            onDragend={this.centerMoved}
            mapTypeId={this.props.google.maps.MapTypeId.ROADMAP}
            mapTypeControl={false}
          >
            <Marker
              title={'The marker`s title will appear as a tooltip.'}
              name={'SOMA'}
              style={{ position: 'absolute', top: '50%', left: '50%' }}
              position={{ lat: this.state.lat, lng: this.state.lng }}
              draggable={false}
              animation={this.state.animation}
              icon={{
                url: IconMarker,
                anchor: this.props.google.maps.Point(32, 32),
                scaledSize: this.props.google.maps.Size(64, 64)
              }}
              ref={marker => this.marker = marker}
            />
          </Map>
          <button
            onClick={(e) => { this.props.nextPage(); this.saveInLocalstorage() }}
            className={(this.state.endProcess && this.state.value) ? "nextButton active" : "nextButton"}
            disabled={(this.state.endProcess && this.state.value) ? false : true}
          >Confirmar</button>
        </div>
      </Flex>
    );
  }
}

// export default Localization;
export default GoogleApiWrapper({
  apiKey: 'AIzaSyBZ0XewfPCqZ_iqFZUtxdUortSkpuYY7ho'
})(Localization);