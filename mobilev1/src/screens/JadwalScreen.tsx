import React, { useState, useEffect } from 'react';
import {
  StyleSheet,
  Text,
  View,
  FlatList,
  ActivityIndicator,
  RefreshControl,
  TouchableOpacity,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import { createApiClient } from '../config/api';

interface ScheduleItem {
  id: number;
  hari?: string;
  jam_mulai?: string;
  jam_selesai?: string;
  nama_mapel?: string;
  nama_kelas?: string;
  ruangan?: string;
}

export const JadwalScreen: React.FC = () => {
  const { user } = useAuth();
  const [schedules, setSchedules] = useState<ScheduleItem[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [refreshing, setRefreshing] = useState<boolean>(false);

  useEffect(() => {
    fetchJadwal();
  }, []);

  const fetchJadwal = async () => {
    if (!user || !user.kode_guru) return;
    setLoading(true);
    try {
      const client = await createApiClient();
      const response = await client.post('/jadwal/getJadwalPelajaran', {
        kode_guru: user.kode_guru,
      });
      setSchedules(response.data.data || response.data || []);
    } catch (error) {
      console.error('Error fetching teaching schedule', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const renderItem = ({ item }: { item: ScheduleItem }) => (
    <View style={styles.card}>
      <View style={styles.cardHeader}>
        <View style={styles.dayBadge}>
          <Ionicons name="time-outline" size={14} color="#2563eb" style={{ marginRight: 4 }} />
          <Text style={styles.dayText}>{item.hari || 'Hari Mengajar'}</Text>
        </View>
        <Text style={styles.timeText}>
          {item.jam_mulai || '07:00'} - {item.jam_selesai || '08:30'}
        </Text>
      </View>

      <Text style={styles.subjectTitle}>{item.nama_mapel || 'Mata Pelajaran'}</Text>
      <View style={styles.infoRow}>
        <View style={styles.infoBadge}>
          <Ionicons name="school-outline" size={14} color="#64748b" style={{ marginRight: 4 }} />
          <Text style={styles.infoText}>Kelas: {item.nama_kelas || '-'}</Text>
        </View>
        {item.ruangan && (
          <View style={styles.infoBadge}>
            <Ionicons name="location-outline" size={14} color="#64748b" style={{ marginRight: 4 }} />
            <Text style={styles.infoText}>Ruang: {item.ruangan}</Text>
          </View>
        )}
      </View>
    </View>
  );

  return (
    <View style={styles.container}>
      {loading ? (
        <View style={styles.centerContainer}>
          <ActivityIndicator size="large" color="#2563eb" />
          <Text style={styles.loadingText}>Memuat jadwal pelajaran...</Text>
        </View>
      ) : schedules.length === 0 ? (
        <View style={styles.centerContainer}>
          <Ionicons name="book-outline" size={64} color="#cbd5e1" />
          <Text style={styles.emptyTitle}>Belum Ada Jadwal Pelajaran</Text>
          <Text style={styles.emptySub}>Jadwal mengajar anda akan ditampilkan di sini</Text>
        </View>
      ) : (
        <FlatList
          data={schedules}
          keyExtractor={(item, index) => String(item.id || index)}
          renderItem={renderItem}
          contentContainerStyle={styles.listContent}
          refreshControl={
            <RefreshControl
              refreshing={refreshing}
              onRefresh={() => {
                setRefreshing(true);
                fetchJadwal();
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
  listContent: {
    padding: 16,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    padding: 18,
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
    marginBottom: 10,
  },
  dayBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#eff6ff',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  dayText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#2563eb',
  },
  timeText: {
    fontSize: 13,
    fontWeight: '700',
    color: '#475569',
  },
  subjectTitle: {
    fontSize: 17,
    fontWeight: '800',
    color: '#0f172a',
    marginBottom: 10,
  },
  infoRow: {
    flexDirection: 'row',
    gap: 10,
  },
  infoBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#f1f5f9',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 6,
  },
  infoText: {
    fontSize: 12,
    color: '#475569',
    fontWeight: '600',
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
