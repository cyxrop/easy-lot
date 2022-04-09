import * as React from 'react';
import { FC, useCallback, useEffect } from 'react';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import Box from '@mui/material/Box';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import LoadingButton from '@mui/lab/LoadingButton';
import SaveIcon from '@mui/icons-material/Save';
import { FormContainer, TextFieldElement } from 'react-hook-form-mui';
import { FieldPath, SubmitHandler, useForm } from 'react-hook-form';
import { useDispatch, useSelector } from 'react-redux';
import { login } from '../../../../store/api/auth';
import { formErrors } from '../../../../store/form';
import { authState } from '../../../../store/auth';
import { Redirect } from 'react-router-dom';

type LoginValues = {
  email: string;
  password: string;
}

const LoginForm: FC = () => {
  const dispatch = useDispatch();
  const auth = useSelector(authState);
  const errors = useSelector(formErrors);
  const formContext = useForm<LoginValues>();

  const onSubmit = useCallback<SubmitHandler<LoginValues>>(data => {
    dispatch(login(data));
  }, [dispatch]);

  useEffect(() => {
    Object.keys(errors).forEach(key => formContext.setError(key as FieldPath<LoginValues>, {
      type: 'manual',
      message: errors[key][0],
    }));
    console.log('Errors:', errors);
  }, [errors, formContext])

  return (
    auth.isAuth ? (
        <Redirect to="/" />
      ) : (
        <Container component="main" maxWidth="xs">
          <CssBaseline/>
          <Box
            sx={{
              marginTop: 8,
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'center',
            }}
          >
            <Avatar sx={ { m: 1, bgcolor: 'secondary.main' } }>
              <LockOutlinedIcon/>
            </Avatar>
            <Typography component="h1" variant="h5">
              Sign in
            </Typography>
            <Box sx={ { mt: 1 } }>
              <FormContainer
                defaultValues={{
                  email: '',
                  password: '',
                }}
                formContext={ formContext }
                handleSubmit={ formContext.handleSubmit(onSubmit) }
              >
                <TextFieldElement
                  margin="normal"
                  required
                  fullWidth
                  id="email"
                  label="Email Address"
                  name="email"
                  autoComplete="email"
                  autoFocus
                />
                <TextFieldElement
                  margin="normal"
                  required
                  fullWidth
                  name="password"
                  label="Password"
                  type="password"
                  id="password"
                  autoComplete="current-password"
                />
                {
                  auth.isLoading ? (
                    <LoadingButton
                      loading
                      loadingPosition="start"
                      startIcon={ <SaveIcon/> }
                      variant="contained"
                      fullWidth
                    >
                      Sign In
                    </LoadingButton>
                  ) : (
                    <Button
                      type="submit"
                      fullWidth
                      variant="contained"
                      sx={ { mt: 3, mb: 2 } }
                    >
                      Sign In
                    </Button>
                  )
                }
              </FormContainer>
            </Box>
          </Box>
        </Container>
      )
  );
}

export default LoginForm;
