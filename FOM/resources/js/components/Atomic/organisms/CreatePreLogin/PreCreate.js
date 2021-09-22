import React, { Component, useState, useEffect, useCallback } from 'react';

import ReactDOM from "react-dom";
import Home from "../../pages/CreatePreLogin/Home";
import Localization from "../../pages/CreatePreLogin/Localization";
import RoomType from "../../pages/CreatePreLogin/RoomType";
import "../../pages/PaymentHistory/styles.scss";
import "./CreatePreLoginOrganism.scss";
import { useTransition, animated } from "react-spring";

export default function PreCreate({connection}) {
    
    const [index, set] = useState(0);

    const AnimatedHome = animated(Home);
    const AnimatedLocalization = animated(Localization);
    const AnimatedRoomType = animated(RoomType);

    const nextPageHandler = useCallback(() =>
        set(index => (index === 2 ? 0 : index + 1)), []
    )

    const prevPageHandler = useCallback(() => 
        set(index => (index === 0 ? 0 : index - 1)), []
    )

    const transitions = useTransition(index, p => p, {
        from: { opacity: 0, transform: 'translate3d(100%,0,0)' },
        enter: { opacity: 1, transform: 'translate3d(0%,0,0)' },
        leave: { opacity: 0, transform: 'translate3d(-50%,0,0)' },
    })

    const pages = [
        ({ style, nextPage }) => <animated.div style={{ ...style }}><Home nextPage={nextPage}/></animated.div>,
        ({ style, nextPage  }) => <animated.div style={{ ...style }}><Localization nextPage={nextPage}/></animated.div>,
        ({ style, nextPage, prevPage, isLogged  }) => <animated.div style={{ ...style }}><RoomType nextPage={nextPage} prevPage={prevPage} isLogged={isLogged}/></animated.div>,
    ]

    function selectContent(type) {
        const pageType = type[index];
        switch (pageType) {
            case "home":
                return <AnimatedHome />;
            case "localization":
                return <AnimatedLocalization />;
            case "roomType":
                return <AnimatedRoomType />;
            default:
                return null;
        }
    }

    return (
        <div className="box-container pages-container">
            {
                transitions.map(({ item, props, key }) => {
                    const Page = pages[item]
                    return <Page nextPage={nextPageHandler} prevPage={prevPageHandler} isLogged={connection} key={key} style={props} />
                })
            }
        </div>
    )
}

const rootElement = document.getElementById("react-create");
if (rootElement) {
    let connection = rootElement.dataset.connection;
    ReactDOM.render(<PreCreate connection={connection}/>, rootElement);
}