import React from 'react';
import { StatusBar } from 'expo-status-bar';
import { SafeAreaProvider } from 'react-native-safe-area-context';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { Ionicons } from '@expo/vector-icons';
import { ActivityIndicator, View, StyleSheet } from 'react-native';

import { AuthProvider, useAuth } from './src/context/AuthContext';
import { LoginScreen } from './src/screens/LoginScreen';
import { HomeScreen } from './src/screens/HomeScreen';
import { CheckinScreen } from './src/screens/CheckinScreen';
import { CheckoutScreen } from './src/screens/CheckoutScreen';
import { RiwayatScreen } from './src/screens/RiwayatScreen';
import { JadwalScreen } from './src/screens/JadwalScreen';
import { SettingsScreen } from './src/screens/SettingsScreen';
import { RootStackParamList } from './src/types';

const Stack = createNativeStackNavigator<RootStackParamList>();
const Tab = createBottomTabNavigator();

function MainTabNavigator() {
  return (
    <Tab.Navigator
      screenOptions={({ route }) => ({
        headerStyle: {
          backgroundColor: '#ffffff',
        },
        headerTitleStyle: {
          fontWeight: '800',
          color: '#0f172a',
        },
        tabBarActiveTintColor: '#2563eb',
        tabBarInactiveTintColor: '#94a3b8',
        tabBarStyle: {
          height: 60,
          paddingBottom: 8,
          paddingTop: 8,
          backgroundColor: '#ffffff',
          borderTopWidth: 1,
          borderTopColor: '#e2e8f0',
        },
        tabBarIcon: ({ color, size }) => {
          let iconName: keyof typeof Ionicons.glyphMap = 'help-outline';

          if (route.name === 'HomeTab') {
            iconName = 'grid-outline';
          } else if (route.name === 'RiwayatTab') {
            iconName = 'calendar-outline';
          } else if (route.name === 'JadwalTab') {
            iconName = 'book-outline';
          } else if (route.name === 'SettingsTab') {
            iconName = 'settings-outline';
          }

          return <Ionicons name={iconName} size={size} color={color} />;
        },
      })}
    >
      <Tab.Screen
        name="HomeTab"
        component={HomeScreen}
        options={{ title: 'Beranda', headerTitle: 'Artanita Presensi' }}
      />
      <Tab.Screen
        name="RiwayatTab"
        component={RiwayatScreen}
        options={{ title: 'Riwayat', headerTitle: 'Riwayat Presensi Guru' }}
      />
      <Tab.Screen
        name="JadwalTab"
        component={JadwalScreen}
        options={{ title: 'Jadwal', headerTitle: 'Jadwal Pelajaran Guru' }}
      />
      <Tab.Screen
        name="SettingsTab"
        component={SettingsScreen}
        options={{ title: 'Pengaturan', headerTitle: 'Pengaturan & Akun' }}
      />
    </Tab.Navigator>
  );
}

function NavigationRoot() {
  const { token, isLoading } = useAuth();

  if (isLoading) {
    return (
      <View style={styles.loadingCenter}>
        <ActivityIndicator size="large" color="#2563eb" />
      </View>
    );
  }

  return (
    <NavigationContainer>
      <Stack.Navigator
        screenOptions={{
          headerStyle: { backgroundColor: '#ffffff' },
          headerTitleStyle: { fontWeight: '800', color: '#0f172a' },
          headerTintColor: '#2563eb',
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

export default function App() {
  return (
    <SafeAreaProvider>
      <AuthProvider>
        <StatusBar style="dark" />
        <NavigationRoot />
      </AuthProvider>
    </SafeAreaProvider>
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
