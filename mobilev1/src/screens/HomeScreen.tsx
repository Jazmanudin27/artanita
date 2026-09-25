import React, { useState, useEffect, useCallback } from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  TouchableOpacity,
  RefreshControl,
  ActivityIndicator,
  Image,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import { StatCard } from '../components/StatCard';
import { countAbsensi, getPresensi } from '../services/presensiService';
import { AbsensiCount, PresensiItem } from '../types';
import { getPhotoUrl } from '../config/api';
import { useNavigation, useFocusEffect } from '@react-navigation/native';
import { NativeStackNavigationProp } from '@react-navigation/native-stack';
import { RootStackParamList } from '../types';

type NavigationProp = NativeStackNavigationProp<RootStackParamList>;

export const HomeScreen: React.FC = () => {
  const { user } = useAuth();
  const navigation = useNavigation<NavigationProp>();

  const [stats, setStats] = useState<AbsensiCount>({ hadir: 0, sakit: 0, izin: 0, cuti: 0 });
  const [todayPresensi, setTodayPresensi] = useState<PresensiItem | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [refreshing, setRefreshing] = useState<boolean>(false);
  const [fotoUrl, setFotoUrl] = useState<string | null>(null);
  const [currentTime, setCurrentTime] = useState<string>('');

  // Live Digital Clock
  useEffect(() => {
    const timer = setInterval(() => {
      const now = new Date();
      setCurrentTime(
        now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
      );
    }, 1000);
    return () => clearInterval(timer);
  }, []);

  const loadDashboardData = async () => {
    if (!user || !user.kode_guru) return;

    try {
      // 1. Fetch Absensi Stats
      const absensiData = await countAbsensi(user.kode_guru);
      setStats(absensiData);

      // 2. Fetch Today Presensi
      const now = new Date();
      const month = now.getMonth() + 1;
      const year = now.getFullYear();
      const todayStr = now.toISOString().split('T')[0];

      const presensiList = await getPresensi(user.kode_guru, month, year);
      const foundToday = presensiList.find((item) => item.tanggal === todayStr) || null;
      setTodayPresensi(foundToday);

      // 3. User Avatar photo URL if exists
      if (user.foto) {
        const fullUrl = await getPhotoUrl(user.foto);
        setFotoUrl(fullUrl);
      }
    } catch (error) {
      console.error('Failed to load dashboard data', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useFocusEffect(
    useCallback(() => {
      loadDashboardData();
    }, [user])
  );

  const onRefresh = () => {
    setRefreshing(true);
    loadDashboardData();
  };

  const todayFormatted = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });

  return (
    <ScrollView
      style={styles.container}
      contentContainerStyle={styles.content}
      refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />}
    >
      {/* Header Profile */}
      <View style={styles.header}>
        <View style={styles.profileRow}>
          <View style={styles.avatarContainer}>
            {fotoUrl ? (
              <Image source={{ uri: fotoUrl }} style={styles.avatar} />
            ) : (
              <View style={styles.avatarFallback}>
                <Ionicons name="person" size={28} color="#2563eb" />
              </View>
            )}
          </View>
          <View style={styles.headerText}>
            <Text style={styles.greeting}>Selamat Datang 👋</Text>
            <Text style={styles.userName}>{user?.nama_guru || 'Guru Artanita'}</Text>
            <Text style={styles.userCode}>Kode: {user?.kode_guru || '-'}</Text>
          </View>
        </View>
      </View>

      {/* Clock & Date Card */}
      <View style={styles.clockCard}>
        <View>
          <Text style={styles.clockDate}>{todayFormatted}</Text>
          <Text style={styles.clockTime}>{currentTime || '--:--:--'}</Text>
        </View>
        <Ionicons name="time-outline" size={40} color="#2563eb" opacity={0.8} />
      </View>

      {/* Main Attendance Buttons */}
      <Text style={styles.sectionTitle}>Aksi Presensi</Text>
      <View style={styles.actionRow}>
        <TouchableOpacity
          style={[styles.actionBtn, styles.checkinBtn]}
          onPress={() => navigation.navigate('Checkin')}
        >
          <View style={[styles.actionIconCircle, { backgroundColor: '#22c55e' }]}>
            <Ionicons name="log-in-outline" size={26} color="#ffffff" />
          </View>
          <Text style={styles.actionBtnTitle}>Absen Masuk</Text>
          <Text style={styles.actionBtnSub}>Form Check-In</Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.actionBtn, styles.checkoutBtn]}
          onPress={() => navigation.navigate('Checkout', { todayPresensi: todayPresensi || undefined })}
        >
          <View style={[styles.actionIconCircle, { backgroundColor: '#f97316' }]}>
            <Ionicons name="log-out-outline" size={26} color="#ffffff" />
          </View>
          <Text style={styles.actionBtnTitle}>Absen Pulang</Text>
          <Text style={styles.actionBtnSub}>Form Check-Out</Text>
        </TouchableOpacity>
      </View>

      {/* Today's Presensi Status */}
      <View style={styles.todayCard}>
        <Text style={styles.todayTitle}>Status Presensi Hari Ini</Text>
        <View style={styles.todayRow}>
          <View style={styles.todayItem}>
            <Text style={styles.todayLabel}>Jam Masuk (Check-In)</Text>
            <Text style={styles.todayValueIn}>
              {todayPresensi?.jam_in ? todayPresensi.jam_in : 'Belum Absen'}
            </Text>
          </View>
          <View style={styles.divider} />
          <View style={styles.todayItem}>
            <Text style={styles.todayLabel}>Jam Pulang (Check-Out)</Text>
            <Text style={styles.todayValueOut}>
              {todayPresensi?.jam_out ? todayPresensi.jam_out : 'Belum Absen'}
            </Text>
          </View>
        </View>
      </View>

      {/* Attendance Summary */}
      <Text style={styles.sectionTitle}>Rekap Bulan Ini</Text>
      {loading ? (
        <ActivityIndicator color="#2563eb" style={{ marginVertical: 20 }} />
      ) : (
        <View style={styles.statsGrid}>
          <StatCard
            title="Hadir"
            count={stats.hadir}
            icon="checkmark-circle-outline"
            color="#16a34a"
            bgColor="#dcfce7"
          />
          <StatCard
            title="Sakit"
            count={stats.sakit}
            icon="medkit-outline"
            color="#eab308"
            bgColor="#fef9c3"
          />
          <StatCard
            title="Izin"
            count={stats.izin}
            icon="document-text-outline"
            color="#0284c7"
            bgColor="#e0f2fe"
          />
          <StatCard
            title="Cuti"
            count={stats.cuti}
            icon="calendar-outline"
            color="#9333ea"
            bgColor="#f3e8ff"
          />
        </View>
      )}

      {/* Navigation Quick Links */}
      <Text style={styles.sectionTitle}>Menu Lainnya</Text>
      <View style={styles.menuContainer}>
        <TouchableOpacity style={styles.menuItem} onPress={() => navigation.navigate('Riwayat')}>
          <Ionicons name="calendar-outline" size={24} color="#2563eb" />
          <Text style={styles.menuText}>Riwayat Presensi</Text>
          <Ionicons name="chevron-forward" size={18} color="#94a3b8" />
        </TouchableOpacity>

        <TouchableOpacity style={styles.menuItem} onPress={() => navigation.navigate('Jadwal')}>
          <Ionicons name="book-outline" size={24} color="#0d9488" />
          <Text style={styles.menuText}>Jadwal Pelajaran</Text>
          <Ionicons name="chevron-forward" size={18} color="#94a3b8" />
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f8fafc',
  },
  content: {
    padding: 20,
    paddingBottom: 40,
  },
  header: {
    marginBottom: 20,
  },
  profileRow: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  avatarContainer: {
    marginRight: 14,
  },
  avatar: {
    width: 60,
    height: 60,
    borderRadius: 30,
    borderWidth: 2,
    borderColor: '#2563eb',
  },
  avatarFallback: {
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: '#dbeafe',
    justifyContent: 'center',
    alignItems: 'center',
  },
  headerText: {
    flex: 1,
  },
  greeting: {
    fontSize: 13,
    color: '#64748b',
    fontWeight: '600',
  },
  userName: {
    fontSize: 18,
    fontWeight: '800',
    color: '#0f172a',
  },
  userCode: {
    fontSize: 12,
    color: '#2563eb',
    fontWeight: '700',
    marginTop: 2,
  },
  clockCard: {
    backgroundColor: '#ffffff',
    borderRadius: 18,
    padding: 20,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 3,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  clockDate: {
    fontSize: 13,
    color: '#64748b',
    fontWeight: '600',
  },
  clockTime: {
    fontSize: 26,
    fontWeight: '900',
    color: '#0f172a',
    marginTop: 4,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: '800',
    color: '#1e293b',
    marginBottom: 12,
    marginTop: 8,
  },
  actionRow: {
    flexDirection: 'row',
    gap: 12,
    marginBottom: 24,
  },
  actionBtn: {
    flex: 1,
    backgroundColor: '#ffffff',
    borderRadius: 18,
    padding: 16,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.06,
    shadowRadius: 10,
    elevation: 3,
    borderWidth: 1,
    borderColor: '#f1f5f9',
  },
  checkinBtn: {
    borderLeftWidth: 4,
    borderLeftColor: '#22c55e',
  },
  checkoutBtn: {
    borderLeftWidth: 4,
    borderLeftColor: '#f97316',
  },
  actionIconCircle: {
    width: 48,
    height: 48,
    borderRadius: 24,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 10,
  },
  actionBtnTitle: {
    fontSize: 15,
    fontWeight: '800',
    color: '#0f172a',
  },
  actionBtnSub: {
    fontSize: 11,
    color: '#64748b',
    marginTop: 2,
  },
  todayCard: {
    backgroundColor: '#ffffff',
    borderRadius: 18,
    padding: 18,
    marginBottom: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.04,
    shadowRadius: 8,
    elevation: 2,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  todayTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: '#334155',
    marginBottom: 12,
  },
  todayRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  todayItem: {
    flex: 1,
    alignItems: 'center',
  },
  divider: {
    width: 1,
    height: 36,
    backgroundColor: '#e2e8f0',
  },
  todayLabel: {
    fontSize: 12,
    color: '#64748b',
    marginBottom: 4,
  },
  todayValueIn: {
    fontSize: 16,
    fontWeight: '800',
    color: '#16a34a',
  },
  todayValueOut: {
    fontSize: 16,
    fontWeight: '800',
    color: '#ea580c',
  },
  statsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    marginHorizontal: -6,
    marginBottom: 20,
  },
  menuContainer: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    overflow: 'hidden',
  },
  menuItem: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 16,
    paddingVertical: 14,
    borderBottomWidth: 1,
    borderBottomColor: '#f1f5f9',
  },
  menuText: {
    flex: 1,
    marginLeft: 12,
    fontSize: 14,
    fontWeight: '600',
    color: '#1e293b',
  },
});
