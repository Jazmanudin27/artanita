import { createApiClient } from '../config/api';
import { UserAuthData } from '../types';

/**
 * Service untuk Otentikasi Guru (Login & Logout)
 */

export const loginGuru = async (username: string, password: string): Promise<UserAuthData> => {
  const client = await createApiClient();
  const response = await client.post('/login', { username, password });
  return response.data;
};

export const logoutGuru = async (userId: number | string): Promise<void> => {
  const client = await createApiClient();
  await client.get(`/logout/${userId}`);
};
