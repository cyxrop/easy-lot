import { Action, configureStore, ThunkAction } from '@reduxjs/toolkit';
import logger from 'redux-logger';
import authSlice  from './store/auth';
import formSlice  from './store/form';
import { useDispatch } from 'react-redux';

export const store = configureStore({
  reducer: {
    auth: authSlice,
    form: formSlice,
  },
  middleware: (getDefaultMiddleware) => getDefaultMiddleware({
    serializableCheck: false,
  }).concat(logger),
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
export const useAppDispatch = () => useDispatch<AppDispatch>()

export type AppThunk<T = void> = ThunkAction<T, RootState, unknown, Action>
