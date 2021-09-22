// import React, { Component } from "react";
// import ReactDOM from "react-dom";
// import { Link } from "react-router-dom";

// import { BrowserRouter, Route, Switch } from "react-router-dom";

// class TopAlert extends Component {
//     constructor() {
//         super();
//         this.state = {
//             message: "",
//             route: "/",
//             show: false
//         };    
//     }
    
//     render() {        

//         // const { message, route, show } = this.state;        
        
//         this.props.alert.message = decodeURI(this.props.alert.message);
//         if(this.props.alert.show){
//             return (
//                 <BrowserRouter>
//                     <div className="info-navbar">
//                         <p className="info-navbar-text">{this.props.alert.message}</p>
//                         <Link className="info-navbar-text" to={this.props.alert.route} />
//                         <span className="info-navbar-close close">X</span>
//                     </div>
//                 </BrowserRouter>                    
//             );
//         }
//         return null;
//     }
// }
// if($('#info')){
//     var alert = $('#info').data("alert");
    
//     ReactDOM.render(<TopAlert alert={alert}/>, document.getElementById("info"));
// }