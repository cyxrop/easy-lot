import React, { Dispatch, FC, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { actions, authState } from './store/auth';
import { Redirect } from 'react-router-dom';
import { getAuthToken } from './store/api/auth';
import { getCurrentUser } from './store/api/users';

export const loadInitData = (dispatch: Dispatch<any>) => {
  dispatch(getCurrentUser());
};

const SetupProvider: FC = ({ children }) => {
  const [shouldLogin, setShouldLogin] = useState(false);
  const auth = useSelector(authState);
  const dispatch = useDispatch();

  useEffect(() => {
    if (!auth.isAuth) {
      const token = getAuthToken();
      console.log('Token from local storage: ', token);

      if (token) {
        dispatch(actions.setAuthSuccess())
        loadInitData(dispatch);
        return;
      }

      setShouldLogin(true);
    }
  }, [auth.isAuth, dispatch, setShouldLogin]);

  return (
    shouldLogin ? (
      <Redirect to="/login"/>
    ) : (
      <div>{children}</div>
    )
  );
}

export default SetupProvider;
