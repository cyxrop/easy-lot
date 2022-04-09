import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { RootState } from '../store';

interface FormErrors {
  [key: string]: string[];
}

export interface FormState {
  formErrors: FormErrors;
}

const initialState: FormState = {
  formErrors: {},
};

export const formSlice = createSlice({
  name: 'form',
  initialState,
  reducers: {
    setFormErrors: (state: FormState, {payload}: PayloadAction<FormErrors>) => {
      state.formErrors = payload;
    },
    clearFormErrors: (state: FormState) => {
      state.formErrors = {};
    },
  },
});

export const formState = (state: RootState): FormState => state.form;
export const formErrors = (state: RootState): FormErrors => formState(state).formErrors;

export const actions = formSlice.actions;
export default formSlice.reducer;
