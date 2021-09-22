import React from 'react';
import './styles.scss';

const Table = ({children, size}) => {
    return (
        <div className={`_table _table_${size}`}>
            {children}
        </div>
    );
};

export const TableCell = ({children, clickHandler= (e) => {e.preventDefault()}}) => {
    return(
        <div className="_table_cell">
            {children}
        </div>
    );
};

export default Table;