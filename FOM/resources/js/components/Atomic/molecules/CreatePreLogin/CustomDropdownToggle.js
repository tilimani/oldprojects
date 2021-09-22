import React, { Component } from 'react';


export default class CustomToggle extends Component {
    constructor(props, context) {
        super(props, context);

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(e) {
        e.preventDefault();

        this.props.onClick(e);
    }

    render() {
        return (
            <a href="" onClick={this.handleClick}>
                {this.props.children}
                <span className="icon-next-fom arrow-down" style={{color: '#ff9b00', fontWeight: '800'}}></span>
            </a>
        );
    }
}