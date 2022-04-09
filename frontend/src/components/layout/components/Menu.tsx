import React, { FC } from 'react';
import { styled } from '@mui/material/styles';
import MuiDrawer from '@mui/material/Drawer';
import DashboardIcon from '@mui/icons-material/Dashboard';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import Toolbar from '@mui/material/Toolbar';
import IconButton from '@mui/material/IconButton';
import ChevronLeftIcon from '@mui/icons-material/ChevronLeft';
import Divider from '@mui/material/Divider';
import List from '@mui/material/List';
import ListItemLink from '../../common/ListItemLink';

const drawerWidth: number = 240;

const mainListItems = (
  <div>
    <ListItemLink to="/" icon={<DashboardIcon/>} primary="Home"/>
    <ListItemLink to="/profile" icon={<ShoppingCartIcon/>} primary="Profile"/>
  </div>
);

const DrawerContainer = styled(MuiDrawer, { shouldForwardProp: (prop) => prop !== 'open' })(
  ({ theme, open }) => ({
    '& .MuiDrawer-paper': {
      position: 'relative',
      whiteSpace: 'nowrap',
      width: drawerWidth,
      transition: theme.transitions.create('width', {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.enteringScreen
      }),
      boxSizing: 'border-box',
      ...(!open && {
        overflowX: 'hidden',
        transition: theme.transitions.create('width', {
          easing: theme.transitions.easing.sharp,
          duration: theme.transitions.duration.leavingScreen
        }),
        width: theme.spacing(7),
        [theme.breakpoints.up('sm')]: {
          width: theme.spacing(9)
        }
      })
    }
  })
);

export interface DrawerProps {
  open: boolean;
  toggleOpen: () => void;
}

const Menu: FC<DrawerProps> = ({open, toggleOpen}) => (
  <DrawerContainer variant="permanent" open={ open }>
    <Toolbar
      sx={ {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'flex-end',
        px: [1]
      } }
    >
      <IconButton onClick={ toggleOpen }>
        <ChevronLeftIcon/>
      </IconButton>
    </Toolbar>
    <Divider/>
    <List>{ mainListItems }</List>
  </DrawerContainer>
);

export default Menu;
