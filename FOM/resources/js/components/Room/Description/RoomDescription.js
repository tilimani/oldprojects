import Axios from "axios";
import React, {useEffect,useState} from 'react';


const RoomDescription = ({room_id}) => {
    const [roomDevices,setRoomDevices] = useState(0)

    useEffect(() => {
        Axios.get('/api/room/devices/'+room_id).then((response)=>{
            setRoomDevices(response.data[0]);
        })
    }, []);

    const windowType = () => {
        switch (roomDevices.windows_type) {
            case "afuera":
                return "Ventana afuera";
            case "adentro":
                return "Ventana al Interior";
            case "sin_ventana":
                return "Sin Ventana";
            case "patio":
                return "Ventana al Interior";
            default:
                return "Sin Ventana"
        }
    }
    const bathType = () => {
        switch (roomDevices.bath_type) {
            case "compartido":
                return "Baño Compartido"
            case "privado":
                return "Baño Privado"
            default:
                return "Baño Compartido"
        }
    }
    return (
        <div className="m-2">
                <p className="row">
                    <span className="icon-z-window-1"></span>
                    {
                        <span className="ml-2">{windowType()}</span>
                    }
                </p>
                <p className="row">
                    <span className="icon-z-bathroom-2"></span><span className="ml-2">{bathType()}</span>

                </p>
                {roomDevices.desk == 1 && <p className="row">
                    <span className="icon-z--desk"></span><span className="ml-2">Escritorio</span>
                </p>}
                <p className="row">
                    <span className="icon-z-bed"></span><span className="ml-2">Cama {roomDevices.bed_type}</span>
                </p>
                {roomDevices.closet == 1 && <p className="row">
                    <span className="icon-closet"></span><span className="ml-2">Closet</span>
                </p>
                }
                {roomDevices.tv == 1 && <p className="row">
                    <span className="icon-tv"></span><span className="ml-2">Televisor</span>
                </p>}
        </div>
    );
};

export default RoomDescription;