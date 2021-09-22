import React from 'react';
import './styles.scss';

const Ellipsis = ({children, openMenu}) => {
    return (
        <div className="_button_container" onClick={openMenu.bind()}>
            <div className="_content">
                <div className="_item ellipsis">
                    <i className="fas fa-ellipsis-v"></i>
                    {children}
                </div>
            </div>
        </div>
    );
};

export const Menu = ({children, open}) => {
    return (
        <div className="_menu_holder">
            <div className={`menu ${open ? 'open':'closed'}`}>
                {children}
            </div>
        </div>
    );
};

export const Item = ({text, children, clickHandler = (e) => {e.preventDefault();}}) => {
    return (
        <div className="item" onClick={clickHandler}>
            {text}{children}
        </div>
    );
};

export const SecondMenu = ({children, open}) => {
    return (
        <div className="_menu_holder">
            <div className={`menu_second ${open ? 'open':'closed'}`}>
                {children}
            </div>
        </div>
    );
}

export default Ellipsis;