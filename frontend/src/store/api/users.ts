import { AppThunk } from '../../store';
import { actions } from '../auth';
import { AUTH_TOKEN_KEY } from './auth';
import { Users } from '../../api/users';

export const getCurrentUser = (): AppThunk => async (dispatch) => {
  try {
    dispatch(actions.setLoading(true));
    const { data: { data: user }} = await Users.current();
    dispatch(actions.setUser(user));

    localStorage.removeItem(AUTH_TOKEN_KEY);
  } finally {
    dispatch(actions.setLoading(false));
  }
}
