import React from "react";
import "./styles.scss";

/**
 * Simple customizable atom text
 * @param {String} text Text that will be displayed
 * @param {String} type Swtichs into: paragraph, subheading, heading 
 * @param {*} gutterBottom Drops text to bottom 
 */
const Text = ({ text, type, gutterBottom, right, left, color, children, clear }) => {
  return (
    <p className={`text ${type} ${gutterBottom ? "gutterBottom" : ""} ${right ? "alignright" : ""} ${left ? "alignleft" : ""} ${color ? color: ''} ${clear ? "clear": ''}`}>
      {children}{text}
    </p>
  );
};

export default Text;
