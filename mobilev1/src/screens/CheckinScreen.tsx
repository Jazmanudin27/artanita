import React, { useState, useEffect } from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Alert,
  ActivityIndicator,
  ScrollView,
  Platform,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import * as Location from 'expo-location';
import * as ImagePicker from 'expo-image-picker';
import { useAuth } from '../context/AuthContext';
import { submitCheckin } from '../services/presensiService';
import { useNavigation } from '@react-navigation/native';

export const CheckinScreen: React.FC = () => {
  const { user } = useAuth();
  const navigation = useNavigation();

  const [location, setLocation] = useState<Location.LocationObject | null>(null);
  const [locationText, setLocationText] = useState<string>('Mengambil lokasi GPS...');
  const [locationLoading, setLocationLoading] = useState<boolean>(true);
  const [imageUri, setImageUri] = useState<string | null>(null);
  const [submitting, setSubmitting] = useState<boolean>(false);

  useEffect(() => {
    fetchLocation();
  }, []);

  const fetchLocation = async () => {
    setLocationLoading(true);
    try {
      const { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        Alert.alert('Izin Ditolak', 'Aplikasi memerlukan akses lokasi GPS untuk melakukan presensi.');
        setLocationText('Izin lokasi tidak diberikan');
        return;
      }

      const currentLocation = await Location.getCurrentPositionAsync({
        accuracy: Location.Accuracy.High,
      });

      setLocation(currentLocation);
      const coords = `${currentLocation.coords.latitude},${currentLocation.coords.longitude}`;
      setLocationText(coords);
    } catch (error) {
      console.error(error);
      Alert.alert('Gagal Mengambil Lokasi', 'Pastikan GPS perangkat anda aktif.');
      setLocationText('Gagal mendapatkan koordinat GPS');
    } finally {
      setLocationLoading(false);
    }
  };

  const takeSelfie = async () => {
    try {
      const permissionResult = await ImagePicker.requestCameraPermissionsAsync();
      if (!permissionResult.granted) {
        Alert.alert('Izin Kamera Ditolak', 'Aplikasi membutuhkan akses kamera untuk foto selfie presensi.');
        return;
      }

      const result = await ImagePicker.launchCameraAsync({
        cameraType: ImagePicker.CameraType.front,
        allowsEditing: true,
        aspect: [4, 3],
        quality: 0.7,
      });

      if (!result.canceled && result.assets && result.assets.length > 0) {
        setImageUri(result.assets[0].uri);
      }
    } catch (error) {
      console.error(error);
      Alert.alert('Error', 'Gagal membuka kamera');
    }
  };

  const handleSubmit = async () => {
    if (!user || !user.kode_guru) {
      Alert.alert('Error', 'Sesi login tidak valid.');
      return;
    }

    if (!locationText || locationText.includes('Mengambil') || locationText.includes('Gagal')) {
      Alert.alert('Perhatian', 'Lokasi GPS belum didapatkan. Silakan perbarui lokasi GPS terlebih dahulu.');
      return;
    }

    if (!imageUri) {
      Alert.alert('Perhatian', 'Anda wajib mengambil foto selfie untuk presensi check-in!');
      return;
    }

    setSubmitting(true);
    try {
      const response = await submitCheckin(user.kode_guru, locationText, imageUri);
      Alert.alert('Sukses 🎉', response.message || 'Presensi check-in berhasil dicatat!', [
        { text: 'OK', onPress: () => navigation.goBack() },
      ]);
    } catch (error: any) {
      console.error(error);
      const msg = error.response?.data?.message || 'Gagal mengirim presensi check-in.';
      Alert.alert('Gagal Check-In', msg);
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <ScrollView style={styles.container} contentContainerStyle={styles.content}>
      {/* Header Info */}
      <View style={styles.headerCard}>
        <Ionicons name="log-in" size={32} color="#22c55e" />
        <View style={styles.headerTextContainer}>
          <Text style={styles.title}>Absen Masuk (Check-In)</Text>
          <Text style={styles.subtitle}>
            {new Date().toLocaleDateString('id-ID', {
              weekday: 'long',
              day: 'numeric',
              month: 'long',
              year: 'numeric',
            })}
          </Text>
        </View>
      </View>

      {/* GPS Location Card */}
      <View style={styles.card}>
        <View style={styles.cardHeader}>
          <Ionicons name="location-outline" size={20} color="#2563eb" />
          <Text style={styles.cardTitle}>Koordinat Lokasi GPS</Text>
        </View>
        <Text style={styles.coordsText}>{locationText}</Text>
        <TouchableOpacity
          style={styles.refreshLocBtn}
          onPress={fetchLocation}
          disabled={locationLoading}
        >
          {locationLoading ? (
            <ActivityIndicator color="#2563eb" size="small" />
          ) : (
            <>
              <Ionicons name="refresh-outline" size={16} color="#2563eb" style={{ marginRight: 6 }} />
              <Text style={styles.refreshLocText}>Perbarui Koordinat GPS</Text>
            </>
          )}
        </TouchableOpacity>
      </View>

      {/* Photo Camera Card */}
      <View style={styles.card}>
        <View style={styles.cardHeader}>
          <Ionicons name="camera-outline" size={20} color="#2563eb" />
          <Text style={styles.cardTitle}>Foto Selfie Check-In</Text>
        </View>

        {imageUri ? (
          <View style={styles.imagePreviewContainer}>
            <Image source={{ uri: imageUri }} style={styles.imagePreview} />
            <TouchableOpacity style={styles.retakeBtn} onPress={takeSelfie}>
              <Ionicons name="camera-reverse-outline" size={18} color="#ffffff" style={{ marginRight: 6 }} />
              <Text style={styles.retakeText}>Foto Ulang</Text>
            </TouchableOpacity>
          </View>
        ) : (
          <TouchableOpacity style={styles.cameraPlaceholder} onPress={takeSelfie}>
            <Ionicons name="camera" size={48} color="#94a3b8" />
            <Text style={styles.cameraPlaceholderText}>Ambil Foto Selfie</Text>
            <Text style={styles.cameraSubtext}>Tekan untuk membuka kamera depan</Text>
          </TouchableOpacity>
        )}
      </View>

      {/* Submit Button */}
      <TouchableOpacity
        style={[styles.submitBtn, submitting && styles.submitBtnDisabled]}
        onPress={handleSubmit}
        disabled={submitting}
      >
        {submitting ? (
          <ActivityIndicator color="#ffffff" size="small" />
        ) : (
          <>
            <Ionicons name="checkmark-circle-outline" size={22} color="#ffffff" style={{ marginRight: 8 }} />
            <Text style={styles.submitBtnText}>KIRIM ABSEN MASUK</Text>
          </>
        )}
      </TouchableOpacity>
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
  headerCard: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#ffffff',
    padding: 18,
    borderRadius: 16,
    marginBottom: 20,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  headerTextContainer: {
    marginLeft: 14,
  },
  title: {
    fontSize: 18,
    fontWeight: '800',
    color: '#0f172a',
  },
  subtitle: {
    fontSize: 12,
    color: '#64748b',
    marginTop: 2,
  },
  card: {
    backgroundColor: '#ffffff',
    borderRadius: 16,
    padding: 18,
    marginBottom: 20,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.04,
    shadowRadius: 8,
    elevation: 2,
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 12,
  },
  cardTitle: {
    fontSize: 15,
    fontWeight: '700',
    color: '#1e293b',
    marginLeft: 8,
  },
  coordsText: {
    fontSize: 15,
    fontWeight: '600',
    color: '#0f172a',
    backgroundColor: '#f1f5f9',
    padding: 12,
    borderRadius: 10,
    marginBottom: 12,
    fontFamily: Platform.OS === 'ios' ? 'Courier' : 'monospace',
  },
  refreshLocBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 10,
    backgroundColor: '#eff6ff',
    borderRadius: 10,
  },
  refreshLocText: {
    color: '#2563eb',
    fontWeight: '600',
    fontSize: 13,
  },
  cameraPlaceholder: {
    height: 200,
    borderWidth: 2,
    borderColor: '#cbd5e1',
    borderStyle: 'dashed',
    borderRadius: 14,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f8fafc',
  },
  cameraPlaceholderText: {
    fontSize: 16,
    fontWeight: '700',
    color: '#334155',
    marginTop: 10,
  },
  cameraSubtext: {
    fontSize: 12,
    color: '#94a3b8',
    marginTop: 4,
  },
  imagePreviewContainer: {
    alignItems: 'center',
  },
  imagePreview: {
    width: '100%',
    height: 240,
    borderRadius: 14,
    marginBottom: 12,
  },
  retakeBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#475569',
    paddingHorizontal: 16,
    paddingVertical: 10,
    borderRadius: 10,
  },
  retakeText: {
    color: '#ffffff',
    fontWeight: '600',
    fontSize: 13,
  },
  submitBtn: {
    backgroundColor: '#22c55e',
    borderRadius: 14,
    paddingVertical: 16,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    shadowColor: '#22c55e',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 4,
    marginTop: 10,
  },
  submitBtnDisabled: {
    backgroundColor: '#94a3b8',
  },
  submitBtnText: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
});
