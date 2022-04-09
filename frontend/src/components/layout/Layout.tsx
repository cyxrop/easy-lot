import React, { FC } from 'react';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import TopBar from './components/TopBar';
import Menu from './components/Menu';

export interface ILayout {
  name: string;
}

const Layout: FC<ILayout> = ({name, children}) => {
  const [open, setOpen] = React.useState(true);
  const toggleDrawer = () => {
    setOpen(!open);
  };

  return (
    <Box sx={ { display: 'flex' } }>
      <TopBar name={name} open={open} toggleOpen={toggleDrawer}/>
      <Menu open={open} toggleOpen={toggleDrawer}/>
      <Box
        component="main"
        sx={ {
          backgroundColor: (theme) =>
            theme.palette.mode === 'light'
              ? theme.palette.grey[100]
              : theme.palette.grey[900],
          flexGrow: 1,
          height: '100vh',
          overflow: 'auto'
        } }
      >
        <Toolbar/>
        {children}
      </Box>
    </Box>
  );
}

export default Layout;

