import React, { useState, useEffect } from 'react';
import {
  StyleSheet,
  Text,
  View,
  FlatList,
  TouchableOpacity,
  ActivityIndicator,
  RefreshControl,
  Image,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import { getPresensi } from '../services/presensiService';
import { PresensiItem } from '../types';
import { getPhotoUrl } from '../config/api';

const MONTH_NAMES = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

export const RiwayatScreen: React.FC = () => {
  const { user } = useAuth();
  
  const now = new Date();
  const [selectedMonth, setSelectedMonth] = useState<number>(now.getMonth() + 1);
  const [selectedYear, setSelectedYear] = useState<number>(now.getFullYear());
  
  const [presensiList, setPresensiList] = useState<PresensiItem[]>([]);
  const [photoMap, setPhotoMap] = useState<Record<string, string>>({});
  const [loading, setLoading] = useState<boolean>(true);
  const [refreshing, setRefreshing] = useState<boolean>(false);

  useEffect(() => {
    fetchHistory();
  }, [selectedMonth, selectedYear]);

  const fetchHistory = async () => {
    if (!user || !user.kode_guru) return;
    setLoading(true);
    try {
      const data = await getPresensi(user.kode_guru, selectedMonth, selectedYear);
      setPresensiList(data);

      // Resolve photo URLs
      const map: Record<string, string> = {};
      for (const item of data) {
        if (item.foto_in) {
          const urlIn = await getPhotoUrl(item.foto_in);
          if (urlIn) map[`in_${item.id}`] = urlIn;
        }
        if (item.foto_out) {
          const urlOut = await getPhotoUrl(item.foto_out);
          if (urlOut) map[`out_${item.id}`] = urlOut;
        }
      }
      setPhotoMap(map);
    } catch (error) {
      console.error('Error fetching presensi history', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const handlePrevMonth = () => {
    if (selectedMonth === 1) {
      setSelectedMonth(12);
      setSelectedYear((prev) => prev - 1);
    } else {
      setSelectedMonth((prev) => prev - 1);
    }
  };

  const handleNextMonth = () => {
    if (selectedMonth === 12) {
      setSelectedMonth(1);
      setSelectedYear((prev) => prev + 1);
    } else {
      setSelectedMonth((prev) => prev + 1);
    }
  };

  const renderItem = ({ item }: { item: PresensiItem }) => {
    const dateObj = new Date(item.tanggal);
    const dateFormatted = dateObj.toLocaleDateString('id-ID', {
      weekday: 'long',
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    });

    const photoIn = photoMap[`in_${item.id}`];
    const photoOut = photoMap[`out_${item.id}`];

    return (
      <View style={styles.card}>
        <View style={styles.cardHeader}>
          <Text style={styles.dateText}>{dateFormatted}</Text>
          <View style={[styles.badge, item.jam_out ? styles.badgeSuccess : styles.badgeWarning]}>
            <Text style={[styles.badgeText, item.jam_out ? styles.badgeTextSuccess : styles.badgeTextWarning]}>
              {item.jam_out ? 'Lengkap' : 'Belum Out'}
            </Text>
          </View>
        </View>

        <View style={styles.detailsRow}>
          {/* Check-In Column */}
          <View style={styles.detailCol}>
            <Text style={styles.detailLabel}>Check-In (Masuk)</Text>
            <Text style={styles.timeIn}>{item.jam_in || '-'}</Text>
            {photoIn && <Image source={{ uri: photoIn }} style={styles.thumbnail} />}
          </View>

          <View style={styles.divider} />

          {/* Check-Out Column */}
          <View style={styles.detailCol}>
            <Text style={styles.detailLabel}>Check-Out (Pulang)</Text>
            <Text style={styles.timeOut}>{item.jam_out || '-'}</Text>
            {photoOut && <Image source={{ uri: photoOut }} style={styles.thumbnail} />}
          </View>
        </View>
      </View>
    );
  };

  return (
    <View style={styles.container}>
      {/* Month Picker Header */}
      <View style={styles.pickerHeader}>
        <TouchableOpacity style={styles.arrowBtn} onPress={handlePrevMonth}>
          <Ionicons name="chevron-back" size={22} color="#2563eb" />
        </TouchableOpacity>
        <Text style={styles.pickerText}>
          {MONTH_NAMES[selectedMonth - 1]} {selectedYear}
        </Text>
        <TouchableOpacity style={styles.arrowBtn} onPress={handleNextMonth}>
          <Ionicons name="chevron-forward" size={22} color="#2563eb" />
        </TouchableOpacity>
      </View>

      {loading ? (
        <View style={styles.centerContainer}>
          <ActivityIndicator size="large" color="#2563eb" />
          <Text style={styles.loadingText}>Memuat riwayat presensi...</Text>
        </View>
      ) : presensiList.length === 0 ? (
        <View style={styles.centerContainer}>
          <Ionicons name="calendar-outline" size={64} color="#cbd5e1" />
          <Text style={styles.emptyTitle}>Belum Ada Data Presensi</Text>
          <Text style={styles.emptySub}>Tidak ada riwayat presensi pada bulan ini</Text>
        </View>
      ) : (
        <FlatList
          data={presensiList}
          keyExtractor={(item) => String(item.id)}
          renderItem={renderItem}
          contentContainerStyle={styles.listContent}
          refreshControl={
            <RefreshControl
              refreshing={refreshing}
              onRefresh={() => {
                setRefreshing(true);
                fetchHistory();
              }}
            />
          }
        />
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f8fafc',
  },
  pickerHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    backgroundColor: '#ffffff',
    paddingVertical: 14,
    paddingHorizontal: 20,
    borderBottomWidth: 1,
    borderBottomColor: '#e2e8f0',
  },
  arrowBtn: {
    padding: 6,
    borderRadius: 8,
    backgroundColor: '#eff6ff',
  },
  pickerText: {
    fontSize: 16,
    fontWeight: '800',
    color: '#0f172a',
  },
  listContent: {
    padding: 16,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    padding: 16,
    marginBottom: 12,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.04,
    shadowRadius: 6,
    elevation: 2,
  },
  cardHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 12,
    paddingBottom: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#f1f5f9',
  },
  dateText: {
    fontSize: 14,
    fontWeight: '800',
    color: '#1e293b',
  },
  badge: {
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  badgeSuccess: {
    backgroundColor: '#dcfce7',
  },
  badgeWarning: {
    backgroundColor: '#ffedd5',
  },
  badgeText: {
    fontSize: 11,
    fontWeight: '700',
  },
  badgeTextSuccess: {
    color: '#15803d',
  },
  badgeTextWarning: {
    color: '#c2410c',
  },
  detailsRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  detailCol: {
    flex: 1,
    alignItems: 'center',
  },
  divider: {
    width: 1,
    backgroundColor: '#e2e8f0',
    marginHorizontal: 12,
  },
  detailLabel: {
    fontSize: 11,
    color: '#64748b',
    marginBottom: 4,
  },
  timeIn: {
    fontSize: 16,
    fontWeight: '800',
    color: '#16a34a',
  },
  timeOut: {
    fontSize: 16,
    fontWeight: '800',
    color: '#ea580c',
  },
  thumbnail: {
    width: 60,
    height: 60,
    borderRadius: 8,
    marginTop: 8,
  },
  centerContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  loadingText: {
    marginTop: 12,
    color: '#64748b',
    fontWeight: '600',
  },
  emptyTitle: {
    fontSize: 18,
    fontWeight: '800',
    color: '#334155',
    marginTop: 16,
  },
  emptySub: {
    fontSize: 13,
    color: '#94a3b8',
    marginTop: 4,
  },
});
