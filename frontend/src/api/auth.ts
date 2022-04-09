import { ILoginRequest, ILoginResponse, IResponse, ISuccessResponse } from '../models';
import client from './client';

export const Auth = {
  login: (data: ILoginRequest): Promise<IResponse<ILoginResponse>> => client.post('auth/login', data),
  logout: (): Promise<IResponse<ISuccessResponse>> => client.delete('auth/delete'),
};
