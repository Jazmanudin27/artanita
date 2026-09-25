import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

export const DOMAIN_STORAGE_KEY = '@artanita_api_domain';
export const TOKEN_STORAGE_KEY = '@artanita_auth_token';
export const USER_STORAGE_KEY = '@artanita_user_data';

// Default Domain Resmi Artanita Mobile v1
export const DEFAULT_DOMAIN = 'https://mobile.sistemiartas.com/v1';

export const getBaseUrl = async (): Promise<string> => {
  try {
    const savedDomain = await AsyncStorage.getItem(DOMAIN_STORAGE_KEY);
    let targetDomain = (savedDomain && savedDomain.trim() !== '') ? savedDomain.trim() : DEFAULT_DOMAIN;

    let cleanDomain = targetDomain.replace(/\/+$/, '');
    if (!cleanDomain.startsWith('http://') && !cleanDomain.startsWith('https://')) {
      cleanDomain = 'https://' + cleanDomain;
    }

    if (!cleanDomain.endsWith('/api')) {
      return `${cleanDomain}/api`;
    }
    return cleanDomain;
  } catch (e) {
    console.warn('Error reading saved domain:', e);
  }
  return `${DEFAULT_DOMAIN}/api`;
};

export const getStorageDomain = async (): Promise<string> => {
  try {
    const savedDomain = await AsyncStorage.getItem(DOMAIN_STORAGE_KEY);
    let targetDomain = (savedDomain && savedDomain.trim() !== '') ? savedDomain.trim() : DEFAULT_DOMAIN;

    let cleanDomain = targetDomain.replace(/\/+$/, '');
    if (!cleanDomain.startsWith('http://') && !cleanDomain.startsWith('https://')) {
      cleanDomain = 'https://' + cleanDomain;
    }
    return cleanDomain;
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
