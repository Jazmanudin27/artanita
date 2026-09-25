import React, { useState } from 'react';
import {
  Modal,
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  Alert,
  ActivityIndicator,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import axios from 'axios';

interface DomainModalProps {
  visible: boolean;
  onClose: () => void;
}

export const DomainModal: React.FC<DomainModalProps> = ({ visible, onClose }) => {
  const { domain, updateDomain } = useAuth();
  const [inputDomain, setInputDomain] = useState<string>(domain);
  const [testing, setTesting] = useState<boolean>(false);

  const handleSave = async () => {
    if (!inputDomain.trim()) {
      Alert.alert('Perhatian', 'URL Server/Domain tidak boleh kosong');
      return;
    }
    await updateDomain(inputDomain.trim());
    Alert.alert('Sukses', 'Konfigurasi domain server berhasil disimpan!');
    onClose();
  };

  const handleTestConnection = async () => {
    let testUrl = inputDomain.trim().replace(/\/+$/, '');
    if (!testUrl.startsWith('http://') && !testUrl.startsWith('https://')) {
      testUrl = 'http://' + testUrl;
    }
    
    setTesting(true);
    try {
      // Test hit to domain
      await axios.get(`${testUrl}/api/user`, { timeout: 5000 }).catch((err) => {
        // Even 401 response means server is alive!
        if (err.response) return true;
        throw err;
      });
      Alert.alert('Koneksi Berhasil! ✅', `Server pada ${testUrl} terhubung dengan baik.`);
    } catch (error: any) {
      Alert.alert(
        'Koneksi Gagal ❌',
        `Tidak dapat terhubung ke ${testUrl}.\nError: ${error.message || 'Network Error'}`
      );
    } finally {
      setTesting(false);
    }
  };

  return (
    <Modal visible={visible} transparent animationType="slide">
      <View style={styles.overlay}>
        <View style={styles.container}>
          <View style={styles.header}>
            <View style={styles.titleContainer}>
              <Ionicons name="server-outline" size={24} color="#1e293b" style={{ marginRight: 8 }} />
              <Text style={styles.title}>Pengaturan Server API</Text>
            </View>
            <TouchableOpacity onPress={onClose}>
              <Ionicons name="close" size={24} color="#64748b" />
            </TouchableOpacity>
          </View>

          <Text style={styles.label}>URL Base Server / Domain Backend:</Text>
          <TextInput
            style={styles.input}
            value={inputDomain}
            onChangeText={setInputDomain}
            placeholder="https://mobile.sistemiartas.com/v1"
            placeholderTextColor="#94a3b8"
            autoCapitalize="none"
            autoCorrect={false}
          />
          <Text style={styles.hint}>
            Contoh: https://mobile.sistemiartas.com/v1 atau http://192.168.1.10:8000
          </Text>

          <TouchableOpacity
            style={styles.testButton}
            onPress={handleTestConnection}
            disabled={testing}
          >
            {testing ? (
              <ActivityIndicator color="#2563eb" size="small" />
            ) : (
              <>
                <Ionicons name="wifi-outline" size={18} color="#2563eb" style={{ marginRight: 6 }} />
                <Text style={styles.testText}>Tes Koneksi Server</Text>
              </>
            )}
          </TouchableOpacity>

          <View style={styles.actions}>
            <TouchableOpacity style={styles.cancelBtn} onPress={onClose}>
              <Text style={styles.cancelText}>Batal</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.saveBtn} onPress={handleSave}>
              <Text style={styles.saveText}>Simpan</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>
    </Modal>
  );
};

const styles = StyleSheet.create({
  overlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    justifyContent: 'center',
    padding: 20,
  },
  container: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.15,
    shadowRadius: 12,
    elevation: 8,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
  },
  titleContainer: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  title: {
    fontSize: 18,
    fontWeight: '700',
    color: '#0f172a',
  },
  label: {
    fontSize: 14,
    fontWeight: '600',
    color: '#334155',
    marginBottom: 8,
  },
  input: {
    borderWidth: 1,
    borderColor: '#cbd5e1',
    borderRadius: 10,
    paddingHorizontal: 14,
    paddingVertical: 12,
    fontSize: 15,
    color: '#0f172a',
    backgroundColor: '#f8fafc',
  },
  hint: {
    fontSize: 12,
    color: '#64748b',
    marginTop: 6,
    marginBottom: 16,
  },
  testButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 10,
    borderRadius: 10,
    borderWidth: 1,
    borderColor: '#bfdbfe',
    backgroundColor: '#eff6ff',
    marginBottom: 20,
  },
  testText: {
    color: '#2563eb',
    fontWeight: '600',
    fontSize: 14,
  },
  actions: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    gap: 12,
  },
  cancelBtn: {
    paddingHorizontal: 18,
    paddingVertical: 12,
    borderRadius: 10,
    backgroundColor: '#f1f5f9',
  },
  cancelText: {
    color: '#64748b',
    fontWeight: '600',
  },
  saveBtn: {
    paddingHorizontal: 22,
    paddingVertical: 12,
    borderRadius: 10,
    backgroundColor: '#2563eb',
  },
  saveText: {
    color: '#ffffff',
    fontWeight: '700',
  },
});
