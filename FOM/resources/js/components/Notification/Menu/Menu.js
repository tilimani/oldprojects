import React from 'react';
import FormControl from 'react-bootstrap/FormControl';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import './Menu.scss';
class Menu extends React.Component {
    constructor(props, context) {
      super(props, context);
  
      this.handleChange = this.handleChange.bind(this);
  
      this.state = { value: '' };
    }
  
    handleChange(e) {
      this.setState({ value: e.target.value.toLowerCase().trim() });
    }
  
    render() {
      const {
        children,
        style,
        className,
        'aria-labelledby': labeledBy,
      } = this.props;
  
      const { value } = this.state;
  
      return (
        <div className="notification-menu">
          <Container className={`${className} custom`} aria-labelledby={labeledBy}>
            <Row>
              {React.Children.toArray(children).filter(
                  child =>
                    !value || child.props.children.toLowerCase().startsWith(value),
                )}
            </Row>
          </Container>
        </div>
        // <div style={style} className={className} aria-labelledby={labeledBy}>
        //   {/* <FormControl
        //     autoFocus
        //     className="mx-3 my-2 w-auto"
        //     placeholder="Type to filter..."
        //     onChange={this.handleChange}
        //     value={value}
        //   /> */}
        //   <ul className="list-unstyled">
            
        //   </ul>
        // </div>
      );
    }
}

export default Menu;