import React, { FC } from 'react';
import './App.css';
import { createTheme, ThemeProvider } from '@mui/material/styles';

import RoutesProvider from './routes';
import SetupProvider from './setup';

const theme = createTheme();

const App: FC = () => (
  <ThemeProvider theme={ theme }>
    <RoutesProvider>
      <SetupProvider/>
    </RoutesProvider>
  </ThemeProvider>
);

export default App;
