
export interface IResponse <T> {
  data: T;
}

export interface IListResponse <T> {
  data: T[];
}

export interface IErrorResponse {
  message: string;
}

export const emptyError = {message: ''}

export interface ISuccessResponse {
  success: string;
}
