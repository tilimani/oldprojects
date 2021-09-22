import React, { Component } from 'react';

const NotificationContext = React.createContext({});

export const NotificationProvider = NotificationContext.Provider;
export const NotificationConsumer = NotificationContext.Consumer;
