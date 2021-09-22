import React from 'react';

const List = (props) => {
    let Localization = props.Localization;
    if (props.suggestions.length > 0){
        return (
            <div className="py-3 text-center justify-content-center">
                <p>{Localization.trans('suggestions')}</p>
                {props.suggestions.map((item, index) => 
                    <div className="row justify-content-center mr-4" key={index}>
                        <div style={{cursor: "pointer"}} className="col-auto" onClick={()=>{props.removeHandler(index)}}><a>❌</a></div>
                        <div className="col-auto small-grey-text"> {item.date.format('DD-MM-YYYY')} {Localization.trans('between')} {item.hour[0]}:00 {Localization.trans('and')} {item.hour[1]}:00</div>
                    </div>)
                }
            </div>
        );
    }
    else {
        return (<div></div>);
    }
}

export default List;