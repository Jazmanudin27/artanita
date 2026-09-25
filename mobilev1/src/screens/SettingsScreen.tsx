import React, { useState } from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  ScrollView,
  Alert,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import { DomainModal } from '../components/DomainModal';

export const SettingsScreen: React.FC = () => {
  const { user, domain, logout } = useAuth();
  const [modalVisible, setModalVisible] = useState<boolean>(false);

  const handleLogout = () => {
    Alert.alert('Konfirmasi Logout', 'Apakah anda yakin ingin keluar dari aplikasi presensi?', [
      { text: 'Batal', style: 'cancel' },
      {
        text: 'Keluar',
        style: 'destructive',
        onPress: () => logout(),
      },
    ]);
  };

  return (
    <ScrollView style={styles.container} contentContainerStyle={styles.content}>
      {/* Profile Card */}
      <View style={styles.profileCard}>
        <View style={styles.avatarCircle}>
          <Ionicons name="person" size={36} color="#2563eb" />
        </View>
        <Text style={styles.userName}>{user?.nama_guru || 'Guru Artanita'}</Text>
        <Text style={styles.userCode}>Kode Guru: {user?.kode_guru || '-'}</Text>
        {user?.nip && <Text style={styles.userSub}>NIP: {user.nip}</Text>}
      </View>

      {/* Account Details Section */}
      <Text style={styles.sectionTitle}>Informasi Akun</Text>
      <View style={styles.card}>
        <View style={styles.infoRow}>
          <Text style={styles.infoLabel}>Nama Lengkap</Text>
          <Text style={styles.infoValue}>{user?.nama_guru || '-'}</Text>
        </View>
        <View style={styles.divider} />
        <View style={styles.infoRow}>
          <Text style={styles.infoLabel}>Kode Guru</Text>
          <Text style={styles.infoValue}>{user?.kode_guru || '-'}</Text>
        </View>
        <View style={styles.divider} />
        <View style={styles.infoRow}>
          <Text style={styles.infoLabel}>Jenis Kelamin</Text>
          <Text style={styles.infoValue}>
            {user?.jk === 'L' ? 'Laki-laki' : user?.jk === 'P' ? 'Perempuan' : user?.jk || '-'}
          </Text>
        </View>
      </View>

      {/* Network Server Config Section */}
      <Text style={styles.sectionTitle}>Pengaturan Server</Text>
      <View style={styles.card}>
        <TouchableOpacity style={styles.settingItem} onPress={() => setModalVisible(true)}>
          <View style={styles.settingIconCircle}>
            <Ionicons name="server-outline" size={20} color="#2563eb" />
          </View>
          <View style={styles.settingTextContainer}>
            <Text style={styles.settingTitle}>URL Base Domain API</Text>
            <Text style={styles.settingSub} numberOfLines={1}>
              {domain}
            </Text>
          </View>
          <Ionicons name="pencil-outline" size={18} color="#94a3b8" />
        </TouchableOpacity>
      </View>

      {/* Logout Action */}
      <TouchableOpacity style={styles.logoutBtn} onPress={handleLogout}>
        <Ionicons name="log-out-outline" size={20} color="#ef4444" style={{ marginRight: 8 }} />
        <Text style={styles.logoutText}>KELUAR DARI AKUN</Text>
      </TouchableOpacity>

      <Text style={styles.appVersion}>Artanita Presensi Guru v1.0.0 (Android)</Text>

      <DomainModal visible={modalVisible} onClose={() => setModalVisible(false)} />
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
  profileCard: {
    backgroundColor: '#ffffff',
    borderRadius: 20,
    padding: 24,
    alignItems: 'center',
    marginBottom: 24,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 3,
  },
  avatarCircle: {
    width: 72,
    height: 72,
    borderRadius: 36,
    backgroundColor: '#dbeafe',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 12,
  },
  userName: {
    fontSize: 20,
    fontWeight: '800',
    color: '#0f172a',
  },
  userCode: {
    fontSize: 14,
    fontWeight: '700',
    color: '#2563eb',
    marginTop: 4,
  },
  userSub: {
    fontSize: 12,
    color: '#64748b',
    marginTop: 2,
  },
  sectionTitle: {
    fontSize: 15,
    fontWeight: '800',
    color: '#1e293b',
    marginBottom: 10,
    marginTop: 6,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    paddingHorizontal: 16,
    paddingVertical: 8,
    marginBottom: 20,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  infoRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 14,
  },
  divider: {
    height: 1,
    backgroundColor: '#f1f5f9',
  },
  infoLabel: {
    fontSize: 14,
    color: '#64748b',
    fontWeight: '600',
  },
  infoValue: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0f172a',
  },
  settingItem: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 12,
  },
  settingIconCircle: {
    width: 40,
    height: 40,
    borderRadius: 10,
    backgroundColor: '#eff6ff',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 12,
  },
  settingTextContainer: {
    flex: 1,
  },
  settingTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0f172a',
  },
  settingSub: {
    fontSize: 12,
    color: '#64748b',
    marginTop: 2,
  },
  logoutBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#fef2f2',
    borderWidth: 1.5,
    borderColor: '#fecaca',
    borderRadius: 14,
    paddingVertical: 16,
    marginTop: 10,
    marginBottom: 20,
  },
  logoutText: {
    color: '#ef4444',
    fontSize: 15,
    fontWeight: '800',
  },
  appVersion: {
    textAlign: 'center',
    fontSize: 12,
    color: '#94a3b8',
  },
});
