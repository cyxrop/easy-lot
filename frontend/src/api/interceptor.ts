import { AxiosError, AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import { actions } from '../store/form';
import { store } from '../store';
import { getAuthToken } from '../store/api/auth';

const onRequest = (request: AxiosRequestConfig): AxiosRequestConfig => {
  if (request.headers) {
    request.headers['Authorization'] = `Bearer ${getAuthToken()}`;
  }

  return request;
}
const onResponse = (response: AxiosResponse): AxiosResponse => {
  // console.info(`[response] [${ JSON.stringify(response) }]`);
  return response;
}

const onResponseError = (error: AxiosError): Promise<AxiosError> => {
  // console.error(`[response error] [${JSON.stringify(error)}]`);

  if (error.response?.status === 422 && error.response?.data?.errors) {
    store.dispatch(actions.setFormErrors(error.response.data.errors));
  }

  return Promise.reject(error);
}

export function setupInterceptors(axiosInstance: AxiosInstance): AxiosInstance {
  axiosInstance.interceptors.request.use(onRequest);
  axiosInstance.interceptors.response.use(onResponse, onResponseError);
  return axiosInstance;
}
