import React from 'react';
import './styles.scss';
import Text from '../../../atoms/Text/Text';

/**
 * 
 * @param {String} tittle 
 * @param {String} month 
 */
const Title = ({title, content, color = false, subColor=false}) => {

    return (
        <div className="_text_container">
            <Text text={title} type="heading" left color={color}/>
            {
                content &&
                <Text text={content} type="subheading" gutterBottom color={subColor}/>
            }
        </div>
    );
};

export default Title;