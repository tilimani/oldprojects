import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import SideBar from './components/sidebar/SideBar';
import MainView from './components/content/MainView';
import { BrowserRouter as Router } from "react-router-dom";

export default () => {

  const [isOpen, setOpen] = useState(true)
  const toggle = () => setOpen(!isOpen)

  return (
    <Router>
      <div className="App wrapper">
        <SideBar toggle={toggle} isOpen={isOpen}/>
        <MainView toggle={toggle} isOpen={isOpen}/>
      </div>
    </Router>
  );
}

