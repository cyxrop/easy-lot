import { ILoginRequest } from '../../models';
import { AppThunk } from '../../store';
import { Auth } from '../../api';
import { actions } from '../auth';
import { AxiosError } from 'axios';
import { isAxiosError } from '../../utils/axios';
import { loadInitData } from '../../setup';

export const AUTH_TOKEN_KEY = 'token';

export const getAuthToken = (): string | null => localStorage.getItem(AUTH_TOKEN_KEY);

export const login = (request: ILoginRequest): AppThunk => async (dispatch) => {
  try {
    dispatch(actions.setLoading(true));

    const response = await Auth.login(request);
    dispatch(actions.setAuthSuccess());

    console.log('set token: ', response.data.token);
    localStorage.setItem(AUTH_TOKEN_KEY, response.data.token);

    loadInitData(dispatch);
  } catch (error) {
    if (isAxiosError(error)) {
      console.log('login failed: ', (error as AxiosError).response);
    }
    // dispatch(actions.setAuthFailed(error));
  } finally {
    dispatch(actions.setLoading(false));
  }
}

export const logout = (): AppThunk => async (dispatch) => {
  try {
    dispatch(actions.setLoading(true));

    await Auth.logout();
    dispatch(actions.setIsAuth(false));

    localStorage.removeItem(AUTH_TOKEN_KEY);
  } finally {
    dispatch(actions.setLoading(false));
  }
}
