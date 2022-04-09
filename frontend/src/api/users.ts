import { IResponse, IUser } from '../models';
import client from './client';
import { AxiosResponse } from 'axios';

export const Users = {
  current: (): Promise<AxiosResponse<IResponse<IUser>>> => client.get('users/current'),
};
