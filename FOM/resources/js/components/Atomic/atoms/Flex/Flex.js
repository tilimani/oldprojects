import React from "react";
import "./styles.scss";

const Flex = ({ children, height }) => {
  return <div className={`_flex ${height ? 'h-100':''}`}>{children}</div>;
};

export const FlexItem = ({ children, contentStart }) => {
  return <div className={`flex-item ${(contentStart) ? 'start':''}`}>{children}</div>;
};
export const FlexItemText = ({ children }) => {
  return <div className="flex-item-text">{children}</div>;
};

export default Flex;
