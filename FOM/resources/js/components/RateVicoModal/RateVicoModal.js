import React, { Component } from 'react';
import Modal from 'react-bootstrap/Modal';
import './RateVicoModal.scss';
import Axios from 'axios';
import Localization from '../../Localization/Localization';
import Slider from '../ReservationModal/Slider';
import TextField from '@material-ui/core/TextField';
import ReactDOM from 'react-dom';

export default class RateVicoModal extends Component {
    // This is initializing our states
    constructor(props) {
        super(props);
        let lang = this.props.connection.split(",")[0];
        let userId = this.props.connection.split(",")[1].split(":")[1]
        this.state={
            show: true,
            Localization: '',
            step: 0,
            score: 5,
            lang,
            recommend: 1,
            textValue: '',
            userId,
        };
    }

    componentWillMount(){
        let localization = new Localization;
        localization.initialize('ratevico', this.state.lang);
        this.setState({
            Localization: localization,
            step: 0
        });
    }

    nextStep(){
        let nextStep = this.state.step+1;
        this.setState({
            step: nextStep,
            errorMessage: false
        }) 
    }

    closeModal(){
        this.setState({
            show: false,
            step: 0,
        })
    }

    setScore(value){
        this.setState({
            score: value
        })
        if (value < 6){
            this.setState({
                recommend: 0
            })
        }

        else if (value > 5 && value < 9){
            this.setState({
                recommend: 1
            })
        }

        else {this.setState({
            recommend: 2
        })}
    }

    valueLabelFormat(value){
        if (this.state.recommend == 0){return "🙁"}
        else if (this.state.recommend == 1){return "😐"}
        else if (this.state.recommend == 2){return "😀"}
    }

    handleSubmit(e){
        e.preventDefault();
        Axios.post('/reviews/submit', {
            user_id: this.state.userId,
            rating: this.state.score,
            reason: this.state.textValue
          })
        this.setState({
            step: this.state.step + 1,
        })
        setTimeout(() => {
            this.setState({
                show: false
            })
        }, 3000);
    }

    textChange(value){
        this.setState({
            textValue: value.target.value
        })
    }

    updateState(){
        this.setState({
            score: 5
        })
    }

    render() {
        let Localization = this.state.Localization;
        let recommend = ''
        if (this.state.recommend == 0){recommend = Localization.trans('would_not')}
        else if (this.state.recommend == 1){recommend = Localization.trans('maybe_would')}
        else {recommend = Localization.trans('would_recommend')}
        var marks = [
            {value: 1, label: '1',},
            {value: 2, label: '2',},
            {value: 3, label: '3',},
            {value: 4, label: '4',},
            {value: 5, label: '5',},
            {value: 6, label: '6',},
            {value: 7, label: '7',},
            {value: 8, label: '8',},
            {value: 9, label: '9',},
            {value: 10, label: '10',},
          ];
        return (
            <Modal centered={true} show={this.state.show} dialogClassName="w-modal" onHide={this.closeModal.bind(this)}>
                {(this.state.step === 0) && <>       
                <Modal.Header className="gutters" closeButton>
                    <p className="col-12 mb-0 text-center py-2 bold-words text-20">{Localization.trans('thanks_for_use')}</p>
                </Modal.Header>
                <Modal.Body className="gutters">
                    <div className="row">
                        <p className="col-12">{Localization.trans('how_likely')}</p>
                    </div>
                    <div className="my-4">
                        <Slider
                            min={1}
                            max={10}
                            marks={marks}
                            value={'hello'}
                            width={100}
                            value={this.state.score}
                            valueHandler={this.setScore.bind(this)}
                            className="py-5"
                            valueLabelDisplay="on"
                            valueLabelFormat= {this.valueLabelFormat.bind(this)}
                            aria-labelledby="discrete-slider-always"
                        />
                    <div className="row">
                        <div className="col-auto">
                            <p>1 |<span className="small-grey-text"> {Localization.trans('not_at_all')}</span></p>
                        </div>
                        <div className="col text-right">
                            <p><span className="small-grey-text">{Localization.trans('entirely_likely')}</span> | 10</p>
                        </div>
                    </div>
                    </div>
                    <div className="row">
                        <p className="col-12 bold-words">{recommend}</p>
                    </div>
                    <div className="row">
                        <div className="col-12">
                            <textarea type='textarea' rows="4" style={{width: "100%", padding: "15px", border: "1px grey solid", borderRadius: "15px"}} placeholder={Localization.trans('why_did_you_give')} value={this.textValue} onChange={this.textChange.bind(this)}/>
                        </div>
                    
                    </div>
                </Modal.Body>
                <Modal.Footer className="row justify-content-end m-0" id="footer">
                    <div className="col-auto" onClick={this.closeModal.bind(this)}>
                        <button className="btn btn-transparent">{Localization.trans('skip')}</button>
                    </div>
                    <div className="col-auto">
                        <button className="btn btn-primary" onClick={this.handleSubmit.bind(this)}>{Localization.trans('send')}</button>
                    </div>
                    <div id="click-me" onClick={this.updateState.bind(this)}></div>
                </Modal.Footer>
            </>
            }
            {(this.state.step === 1) && <>   
                <Modal.Header className="gutters" closeButton>
                    <p className="col-12 mb-0 text-center py-2 bold-words text-20"></p>
                </Modal.Header>
                <Modal.Body className="gutters">
                    <div className="row">
                        <div className="col-12 text-center">
                            <p style={{fontSize: "100px"}} className="m-0">😀</p>
                            <p style={{fontSize: "15px"}} className="bold-words">{Localization.trans('thanks_for_share')}</p>
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer className="row justify-content-end m-0" id="footer">
                    <div className="col-auto" onClick={this.closeModal.bind(this)}>
                        <button className="btn btn-primary">{Localization.trans('close')}</button>
                    </div>
                </Modal.Footer>
            </>
            }
            </Modal>
        );
    }
}

let reactRating = document.getElementById('react-rating');
if (reactRating) {
    let connection = reactRating.dataset.connection;
    ReactDOM.render(<RateVicoModal connection={connection} />, reactRating);
}

let clickMe = document.getElementById("click-me")
console.log(clickMe);

setTimeout(() => {
    clickMe.click();
}, 300);

