import axios from 'axios';
import { setupInterceptors } from './interceptor';

const client = setupInterceptors(axios.create({
  baseURL: 'http://localhost/api/v1/',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  timeout: 5000,
}));

export default client;
