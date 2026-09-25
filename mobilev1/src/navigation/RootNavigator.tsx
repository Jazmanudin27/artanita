import React from 'react';
import { View, ActivityIndicator, StyleSheet } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { useAuth } from '../context/AuthContext';
import { RootStackParamList } from '../types';
import { MainTabNavigator } from './TabNavigator';
import {
  LoginScreen,
  CheckinScreen,
  CheckoutScreen,
  RiwayatScreen,
  JadwalScreen,
} from '../screens';
import { COLORS } from '../constants/theme';

const Stack = createNativeStackNavigator<RootStackParamList>();

/**
 * Root Stack Navigation (Switching between Auth & Main App Stack)
 */
export function RootNavigator() {
  const { token, isLoading } = useAuth();

  if (isLoading) {
    return (
      <View style={styles.loadingCenter}>
        <ActivityIndicator size="large" color={COLORS.primary} />
      </View>
    );
  }

  return (
    <NavigationContainer>
      <Stack.Navigator
        screenOptions={{
          headerStyle: { backgroundColor: '#ffffff' },
          headerTitleStyle: { fontWeight: '800', color: COLORS.textPrimary },
          headerTintColor: COLORS.primary,
        }}
      >
        {token ? (
          <>
            <Stack.Screen
              name="MainTab"
              component={MainTabNavigator}
              options={{ headerShown: false }}
            />
            <Stack.Screen
              name="Checkin"
              component={CheckinScreen}
              options={{ title: 'Absen Masuk (Check-In)' }}
            />
            <Stack.Screen
              name="Checkout"
              component={CheckoutScreen}
              options={{ title: 'Absen Pulang (Check-Out)' }}
            />
            <Stack.Screen
              name="Riwayat"
              component={RiwayatScreen}
              options={{ title: 'Riwayat Presensi' }}
            />
            <Stack.Screen
              name="Jadwal"
              component={JadwalScreen}
              options={{ title: 'Jadwal Pelajaran' }}
            />
          </>
        ) : (
          <Stack.Screen
            name="Login"
            component={LoginScreen}
            options={{ headerShown: false }}
          />
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  loadingCenter: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#ffffff',
  },
});
