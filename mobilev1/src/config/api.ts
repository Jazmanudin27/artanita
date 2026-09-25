import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

export const DOMAIN_STORAGE_KEY = '@artanita_api_domain';
export const TOKEN_STORAGE_KEY = '@artanita_auth_token';
export const USER_STORAGE_KEY = '@artanita_user_data';

// Default base domain. Can be overwritten in app settings!
export const DEFAULT_DOMAIN = 'http://10.0.2.2:5006'; // Port 5006 sesuai server Laravel Backend Artanita

export const getBaseUrl = async (): Promise<string> => {
  try {
    const savedDomain = await AsyncStorage.getItem(DOMAIN_STORAGE_KEY);
    if (savedDomain && savedDomain.trim() !== '') {
      let cleanDomain = savedDomain.trim().replace(/\/+$/, '');
      if (!cleanDomain.startsWith('http://') && !cleanDomain.startsWith('https://')) {
        cleanDomain = 'http://' + cleanDomain;
      }
      return `${cleanDomain}/api`;
    }
  } catch (e) {
    console.warn('Error reading saved domain:', e);
  }
  return `${DEFAULT_DOMAIN}/api`;
};

export const getStorageDomain = async (): Promise<string> => {
  try {
    const savedDomain = await AsyncStorage.getItem(DOMAIN_STORAGE_KEY);
    if (savedDomain && savedDomain.trim() !== '') {
      let cleanDomain = savedDomain.trim().replace(/\/+$/, '');
      if (!cleanDomain.startsWith('http://') && !cleanDomain.startsWith('https://')) {
        cleanDomain = 'http://' + cleanDomain;
      }
      return cleanDomain;
    }
  } catch (e) {}
  return DEFAULT_DOMAIN;
};

export const createApiClient = async () => {
  const baseURL = await getBaseUrl();
  const token = await AsyncStorage.getItem(TOKEN_STORAGE_KEY);

  const client = axios.create({
    baseURL,
    timeout: 15000,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
    },
  });

  return client;
};

export const getPhotoUrl = async (photoPath: string | null): Promise<string | null> => {
  if (!photoPath) return null;
  if (photoPath.startsWith('http://') || photoPath.startsWith('https://')) {
    return photoPath;
  }
  const domain = await getStorageDomain();
  const cleanPath = photoPath.startsWith('/') ? photoPath : `/${photoPath}`;
  return `${domain}/storage${cleanPath}`;
};
