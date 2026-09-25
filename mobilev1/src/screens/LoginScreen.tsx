import React, { useState } from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  TouchableOpacity,
  ActivityIndicator,
  Alert,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  Image,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useAuth } from '../context/AuthContext';
import { DomainModal } from '../components/DomainModal';

export const LoginScreen: React.FC = () => {
  const { login, domain } = useAuth();
  const [username, setUsername] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [showPassword, setShowPassword] = useState<boolean>(false);
  const [loading, setLoading] = useState<boolean>(false);
  const [modalVisible, setModalVisible] = useState<boolean>(false);

  const handleLogin = async () => {
    if (!username.trim() || !password.trim()) {
      Alert.alert('Perhatian', 'Username dan password wajib diisi');
      return;
    }

    setLoading(true);
    try {
      const res = await login(username.trim(), password.trim());
      if (res.kategori !== 'Guru') {
        Alert.alert(
          'Perhatian',
          `Akun anda terdaftar sebagai (${res.kategori}). Aplikasi ini khusus untuk Presensi Guru.`
        );
      }
    } catch (error: any) {
      console.error(error);
      const msg =
        error.response?.data?.message ||
        error.message ||
        'Gagal login. Periksa username, password, atau koneksi server.';
      Alert.alert('Login Gagal', msg);
    } finally {
      setLoading(false);
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.flex}
      behavior={Platform.OS === 'ios' ? 'padding' : undefined}
    >
      <ScrollView contentContainerStyle={styles.container} keyboardShouldPersistTaps="handled">
        {/* Top Header Card */}
        <View style={styles.headerContainer}>
          <View style={styles.logoCircle}>
            <Ionicons name="school" size={48} color="#2563eb" />
          </View>
          <Text style={styles.appName}>ARTANITA</Text>
          <Text style={styles.appSub}>Presensi Guru Mobile</Text>
        </View>

        {/* Login Form */}
        <View style={styles.card}>
          <Text style={styles.formTitle}>Masuk Akun Guru</Text>
          <Text style={styles.formDesc}>Masukkan username & password terdaftar anda</Text>

          {/* Input Username */}
          <View style={styles.inputGroup}>
            <Text style={styles.label}>Username / NIP</Text>
            <View style={styles.inputWrapper}>
              <Ionicons name="person-outline" size={20} color="#64748b" style={styles.inputIcon} />
              <TextInput
                style={styles.input}
                placeholder="Masukkan username"
                placeholderTextColor="#94a3b8"
                value={username}
                onChangeText={setUsername}
                autoCapitalize="none"
              />
            </View>
          </View>

          {/* Input Password */}
          <View style={styles.inputGroup}>
            <Text style={styles.label}>Password</Text>
            <View style={styles.inputWrapper}>
              <Ionicons name="lock-closed-outline" size={20} color="#64748b" style={styles.inputIcon} />
              <TextInput
                style={styles.input}
                placeholder="Masukkan password"
                placeholderTextColor="#94a3b8"
                secureTextEntry={!showPassword}
                value={password}
                onChangeText={setPassword}
              />
              <TouchableOpacity onPress={() => setShowPassword(!showPassword)}>
                <Ionicons
                  name={showPassword ? 'eye-off-outline' : 'eye-outline'}
                  size={20}
                  color="#64748b"
                />
              </TouchableOpacity>
            </View>
          </View>

          {/* Submit Button */}
          <TouchableOpacity style={styles.loginBtn} onPress={handleLogin} disabled={loading}>
            {loading ? (
              <ActivityIndicator color="#ffffff" size="small" />
            ) : (
              <>
                <Text style={styles.loginBtnText}>MASUK PRESENSI</Text>
                <Ionicons name="arrow-forward" size={18} color="#ffffff" style={{ marginLeft: 8 }} />
              </>
            )}
          </TouchableOpacity>
        </View>

        {/* Server Domain Config Footer */}
        <TouchableOpacity style={styles.domainCard} onPress={() => setModalVisible(true)}>
          <Ionicons name="server-outline" size={20} color="#2563eb" />
          <View style={styles.domainInfo}>
            <Text style={styles.domainTitle}>Server Domain API</Text>
            <Text style={styles.domainText} numberOfLines={1}>
              {domain}
            </Text>
          </View>
          <Ionicons name="settings-outline" size={18} color="#64748b" />
        </TouchableOpacity>
      </ScrollView>

      <DomainModal visible={modalVisible} onClose={() => setModalVisible(false)} />
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  flex: {
    flex: 1,
    backgroundColor: '#f1f5f9',
  },
  container: {
    flexGrow: 1,
    justifyContent: 'center',
    padding: 24,
  },
  headerContainer: {
    alignItems: 'center',
    marginBottom: 32,
  },
  logoCircle: {
    width: 90,
    height: 90,
    borderRadius: 45,
    backgroundColor: '#dbeafe',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 16,
    shadowColor: '#2563eb',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 4,
  },
  appName: {
    fontSize: 28,
    fontWeight: '900',
    color: '#1e293b',
    letterSpacing: 2,
  },
  appSub: {
    fontSize: 14,
    color: '#64748b',
    fontWeight: '600',
    marginTop: 4,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 20,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 6 },
    shadowOpacity: 0.08,
    shadowRadius: 16,
    elevation: 4,
    marginBottom: 20,
  },
  formTitle: {
    fontSize: 20,
    fontWeight: '800',
    color: '#0f172a',
    marginBottom: 4,
  },
  formDesc: {
    fontSize: 13,
    color: '#64748b',
    marginBottom: 20,
  },
  inputGroup: {
    marginBottom: 16,
  },
  label: {
    fontSize: 13,
    fontWeight: '700',
    color: '#334155',
    marginBottom: 8,
  },
  inputWrapper: {
    flexDirection: 'row',
    alignItems: 'center',
    borderWidth: 1.5,
    borderColor: '#e2e8f0',
    borderRadius: 12,
    paddingHorizontal: 14,
    paddingVertical: 12,
    backgroundColor: '#f8fafc',
  },
  inputIcon: {
    marginRight: 10,
  },
  input: {
    flex: 1,
    fontSize: 15,
    color: '#0f172a',
  },
  loginBtn: {
    backgroundColor: '#2563eb',
    borderRadius: 14,
    paddingVertical: 16,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 10,
    shadowColor: '#2563eb',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 4,
  },
  loginBtnText: {
    color: '#ffffff',
    fontSize: 15,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
  domainCard: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#ffffff',
    borderRadius: 14,
    paddingHorizontal: 16,
    paddingVertical: 14,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  domainInfo: {
    flex: 1,
    marginLeft: 12,
  },
  domainTitle: {
    fontSize: 12,
    color: '#64748b',
    fontWeight: '600',
  },
  domainText: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0f172a',
  },
});
