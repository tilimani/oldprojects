import React, { Component } from 'react';
import "./Radio.scss";


class Radio extends Component {
    constructor(props) {
        super(props);
        this.state={
            isActive: false
        }
        this.radioInput = React.createRef();
    }
            

    render() {
        return (
            <div className="custom-control custom-radio d-inline-block" onClick={this.props.selectCallback}>
                <input ref={this.radioInput} 
                    name={this.props.name} 
                    value={this.props.value} 
                    type="radio" 
                    id={this.props.id}                     
                    className="custom-control-input"/>
                {!this.props.image && <label title="" htmlFor={this.props.id} className="custom-control-label">
                    {this.props.text}
                </label>}
            
            {
                    this.props.image && <figure className={"radio-image " + (this.props.current === this.props.value ? "active" : "")} onClick={this.props.selectCallback}>
                    <input ref={this.radioInput}
                        name={this.props.name}
                        value={this.props.value}
                        type="radio"
                        className="custom-control-input"
                        defaultChecked={this.props.current === this.props.value} />
                    <div className="image-border">
                        <img src={this.props.current === this.props.value ? this.props.active : this.props.inactive} />
                    </div>
                    <figcaption>{this.props.text}</figcaption>
                </figure>
            }
            </div>
        );
    }
}

export default Radio;