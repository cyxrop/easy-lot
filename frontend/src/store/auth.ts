import { emptyError, IErrorResponse, IUser } from '../models';
import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { RootState } from '../store';

export interface AuthState {
  isAuth: boolean;
  isLoading: boolean;
  user?: IUser;
  error: IErrorResponse;
}

const initialState: AuthState = {
  isAuth: false,
  isLoading: false,
  error: {message: ''}
};

export const authSlice = createSlice({
  name: 'auth',
  initialState,
  reducers: {
    setLoading: (state: AuthState, {payload}: PayloadAction<boolean>) => {
      state.isLoading = payload;
    },
    setUser: (state: AuthState, {payload}: PayloadAction<IUser|undefined>) => {
      state.user = payload;
    },
    setIsAuth: (state: AuthState, {payload}: PayloadAction<boolean>) => {
      state.isAuth = payload;
    },
    setAuthSuccess: (state: AuthState) => {
      state.isAuth = true;
      state.error = emptyError;
    },
    setAuthFailed: (state: AuthState, {payload}: PayloadAction<IErrorResponse>) => {
      state.error = payload;
      state.isAuth = false;
    },
    setLogOut: (state: AuthState) => {
      state.isAuth = false;
      state.user = undefined;
    },
  },
});

export const authState = (state: RootState): AuthState => state.auth;
export const isLoading = (state: RootState): boolean => authState(state).isLoading;

export const actions = authSlice.actions;
export default authSlice.reducer;
