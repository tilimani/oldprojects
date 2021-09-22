import React from 'react';
import PropTypes from 'prop-types';

import './UserPicture.scss';

const UserPicture = props => {

    let setSize = () =>{
        switch (props.size) {
            case 'sm':
                return 40;
            case 'md':
                return 50;
            case 'lg':
                return 70;
            default:
                return 40;
        }
    }

    let userImage = () => {
        if(props.user_image == null){
            if(props.user_gender == "Hombre"){
                return 'manager_7.png';
            }else{
                return 'manager_47.png';
            }
        }else{
            return props.user_image;
        }
    }
    
    return (
        <div className={"picture_container-" + props.size}>
            <div className="user_image">
                <img className="_image" src={`https://fom.imgix.net/${userImage()}?w=${setSize()}&h=${setSize()}&fit=crop`} alt="User Image"/>               
                {props.country_icon != null &&
                    <img className="user_flag" src={`/../images/flags/${props.country_icon}`}
                        alt="User Flag"
                    />
                }

            </div>
        </div>
    );
};

UserPicture.propTypes = {
    size: PropTypes.string.isRequired,    
};

export default UserPicture;
