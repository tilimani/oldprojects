import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faHome, faBriefcase, faPaperPlane, faQuestion, faImage, faCopy } from '@fortawesome/free-solid-svg-icons';
import SubMenu from './SubMenu';
import { NavItem, NavLink, Nav } from 'reactstrap';
import classNames from 'classnames';
import {Link} from 'react-router-dom';

const SideBar = props => (
    <div className={classNames('sidebar', {'is-open': props.isOpen})}>
      <div className="sidebar-header">
        <span color="info" onClick={props.toggle} style={{color: '#fff'}}>&times;</span>
        <h3>yapyap</h3>
      </div>
      {/* Sidebar functionality from https://github.com/BilalBouk/reactstrap-basic-sidebar */}
      <div className="side-menu">
        <Nav vertical className="list-unstyled pb-3">
          <NavItem>
            <NavLink tag={Link} to={'/'}>
              <FontAwesomeIcon icon={faHome} className="mr-2"/>Home
            </NavLink>
          </NavItem>
          <NavItem>
            <NavLink tag={Link} to={'/about'}>
              <FontAwesomeIcon icon={faHome} className="mr-2"/>Account
            </NavLink>
          </NavItem>
          <NavItem>
            <NavLink tag={Link} to={'/about'}>
              <FontAwesomeIcon icon={faHome} className="mr-2"/>Settings
            </NavLink>
          </NavItem>
          {/* Multi-option menu item
          <SubMenu title="Pages" icon={faCopy} items={submenus[1]}/> */}
        </Nav>   
        <h3 ClassName="text-center"> Lifetime Progress </h3>
     
      </div>
    </div>
  );

  

export default SideBar;
