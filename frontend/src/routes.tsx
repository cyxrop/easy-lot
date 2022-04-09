import React, { FC } from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Login from './components/pages/login/Login';
import Home from './components/pages/home/Home';
import Profile from './components/pages/profile/Profile';

const RoutesProvider: FC = ({ children }) => (
  <Router>
    <div>
      { children }
      <Switch>
        <Route path="/about" component={ About }/>
        <Route path="/users" component={ Users }/>
        <Route path="/login" component={ Login }/>
        <Route path="/profile" component={ Profile }/>
        <Route path="/" component={ Home }/>
      </Switch>
    </div>
  </Router>
)

const About: FC = () => (<h2>About</h2>);
const Users: FC = () => (<h2>Users</h2>);

export default RoutesProvider;
