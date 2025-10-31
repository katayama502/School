import { useQuery } from '@tanstack/react-query';
import { apiClient, setAuthToken } from './api';

export const useAuth = () => {
  const query = useQuery({
    queryKey: ['auth', 'me'],
    queryFn: async () => {
      try {
        const response = await apiClient.get('/auth/me');
        return response.data;
      } catch (error: any) {
        if (error.response?.status === 401) {
          return null;
        }
        throw error;
      }
    },
    retry: false,
  });

  return {
    user: query.data ?? null,
    isLoading: query.isLoading,
    error: query.error,
    refresh: query.refetch,
  };
};

export const login = async (email: string, password: string) => {
  const response = await apiClient.post('/auth/login', { email, password });
  const token = response.data.token as string;
  setAuthToken(token);
  return response.data;
};

export const logout = async () => {
  await apiClient.post('/auth/logout');
  setAuthToken(null);
};
