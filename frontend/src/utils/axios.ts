import { AxiosError } from 'axios';

export const isAxiosError = (error: any): boolean => (error as AxiosError).isAxiosError !== undefined
