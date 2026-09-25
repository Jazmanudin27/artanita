import React from 'react';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { Ionicons } from '@expo/vector-icons';
import { HomeScreen, RiwayatScreen, JadwalScreen, SettingsScreen } from '../screens';
import { COLORS } from '../constants/theme';

const Tab = createBottomTabNavigator();

/**
 * Tab Navigator (Beranda, Riwayat, Jadwal, Pengaturan)
 */
export function MainTabNavigator() {
  return (
    <Tab.Navigator
      screenOptions={({ route }) => ({
        headerStyle: {
          backgroundColor: '#ffffff',
        },
        headerTitleStyle: {
          fontWeight: '800',
          color: COLORS.textPrimary,
        },
        tabBarActiveTintColor: COLORS.primary,
        tabBarInactiveTintColor: COLORS.textMuted,
        tabBarStyle: {
          height: 60,
          paddingBottom: 8,
          paddingTop: 8,
          backgroundColor: '#ffffff',
          borderTopWidth: 1,
          borderTopColor: COLORS.borderColor,
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
