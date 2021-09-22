import React from 'react';
import {Container, Row, Col} from 'reactstrap';
import "./MainView.css";

export default props => (
    <Container fluid className='d-flex justify-content-center align-items-center'>
      <Row Style="min-width: 70%; min-height: 60%"> 
        <Col className="text-center align-items-center" Style="font-size: 30px; border: red 10px solid; border-radius: 30px;"> 
          <Row Style="border: red 10px solid; min-height: 70%" className="justify-content-center align-items-center">
            <Col>
              <Row>
                <Col>Mucho</Col>
              </Row> 
              <Row className="align-items-baseline d-flex">
                <Col className="upper-case">
                  <p>English Translation</p>
                </Col>
                <Col>
                  <p>All Conjugations</p>
                </Col>
              </Row>
            </Col>
          </Row>
          <Row Style="border: red 10px solid; min-height: 30%;" className="justify-content-center align-items-center"> 
            <Col>
              <p>Verb</p>
              <p>Decir</p>
            </Col>
            //
            <Col>
              <p>Person</p>
              <p>Plural</p>
            </Col>
            //
            <Col>
              <p>Tense</p>
              <p>Future</p>
            </Col>
          </Row>
        </Col>
      </Row>
    </Container>
)
