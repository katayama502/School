import axios from 'axios';

const TOKEN_KEY = 'crietto_token';

export const apiClient = axios.create({
  baseURL: '/api/v1',
  withCredentials: true,
});

export const setAuthToken = (token: string | null) => {
  if (typeof window === 'undefined') {
    return;
  }
  if (token) {
    window.localStorage.setItem(TOKEN_KEY, token);
    apiClient.defaults.headers.common.Authorization = `Bearer ${token}`;
  } else {
    window.localStorage.removeItem(TOKEN_KEY);
    delete apiClient.defaults.headers.common.Authorization;
  }
};

export const bootstrapAuthToken = () => {
  if (typeof window === 'undefined') {
    return;
  }
  const token = window.localStorage.getItem(TOKEN_KEY);
  if (token) {
    apiClient.defaults.headers.common.Authorization = `Bearer ${token}`;
  }
};
