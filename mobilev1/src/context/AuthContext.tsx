import React, { createContext, useState, useEffect, useContext } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { DEFAULT_DOMAIN, DOMAIN_STORAGE_KEY, TOKEN_STORAGE_KEY, USER_STORAGE_KEY } from '../config/api';
import { Guru, UserAuthData } from '../types';
import { loginGuru, logoutGuru } from '../services/authService';

interface AuthContextType {
  user: Guru | null;
  token: string | null;
  domain: string;
  isLoading: boolean;
  login: (username: string, password: string) => Promise<UserAuthData>;
  logout: () => Promise<void>;
  updateDomain: (newDomain: string) => Promise<void>;
}

const AuthContext = createContext<AuthContextType>({} as AuthContextType);

export const AuthProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [user, setUser] = useState<Guru | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [domain, setDomain] = useState<string>(DEFAULT_DOMAIN);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    loadStoredAuth();
  }, []);

  const loadStoredAuth = async () => {
    try {
      const storedDomain = await AsyncStorage.getItem(DOMAIN_STORAGE_KEY);
      if (storedDomain) {
        setDomain(storedDomain);
      }

      const storedToken = await AsyncStorage.getItem(TOKEN_STORAGE_KEY);
      const storedUser = await AsyncStorage.getItem(USER_STORAGE_KEY);

      if (storedToken && storedUser) {
        setToken(storedToken);
        setUser(JSON.parse(storedUser));
      }
    } catch (e) {
      console.error('Failed to load auth state', e);
    } finally {
      setIsLoading(false);
    }
  };

  const login = async (username: string, password: string): Promise<UserAuthData> => {
    const authData = await loginGuru(username, password);
    
    if (authData.token) {
      const guruData = authData.data;
      await AsyncStorage.setItem(TOKEN_STORAGE_KEY, authData.token);
      await AsyncStorage.setItem(USER_STORAGE_KEY, JSON.stringify(guruData));
      
      setToken(authData.token);
      setUser(guruData);
    }

    return authData;
  };

  const logout = async () => {
    try {
      if (user && user.id) {
        await logoutGuru(user.id).catch(() => {});
      }
    } catch (e) {
      console.warn('Logout endpoint failed', e);
    } finally {
      await AsyncStorage.removeItem(TOKEN_STORAGE_KEY);
      await AsyncStorage.removeItem(USER_STORAGE_KEY);
      setToken(null);
      setUser(null);
    }
  };

  const updateDomain = async (newDomain: string) => {
    let clean = newDomain.trim().replace(/\/+$/, '');
    if (clean && !clean.startsWith('http://') && !clean.startsWith('https://')) {
      clean = 'http://' + clean;
    }
    await AsyncStorage.setItem(DOMAIN_STORAGE_KEY, clean);
    setDomain(clean);
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        token,
        domain,
        isLoading,
        login,
        logout,
        updateDomain,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
