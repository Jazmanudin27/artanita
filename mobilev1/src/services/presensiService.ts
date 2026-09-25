import { createApiClient } from '../config/api';
import { AbsensiCount, PresensiItem } from '../types';

export const countAbsensi = async (kodeGuru: string): Promise<AbsensiCount> => {
  const client = await createApiClient();
  const response = await client.post('/presensi/countAbsensi', { id: kodeGuru });
  return response.data;
};

export const getPresensi = async (
  kodeGuru: string,
  bulan: string | number,
  tahun: string | number
): Promise<PresensiItem[]> => {
  const client = await createApiClient();
  const response = await client.post('/presensi/getPresensi', {
    kode_guru: kodeGuru,
    bulan: String(bulan).padStart(2, '0'),
    tahun: String(tahun),
  });
  return response.data.data || [];
};

export const submitCheckin = async (
  kodeGuru: string,
  lokasiIn: string,
  imageUri?: string
): Promise<{ message: string }> => {
  const client = await createApiClient();
  const formData = new FormData();
  formData.append('kode_guru', kodeGuru);
  formData.append('lokasi_in', lokasiIn);

  if (imageUri) {
    const filename = imageUri.split('/').pop() || 'checkin.jpg';
    const match = /\.(\w+)$/.exec(filename);
    const type = match ? `image/${match[1]}` : 'image/jpeg';
    
    // @ts-ignore - React Native FormData accepts uri object
    formData.append('file', {
      uri: imageUri,
      name: filename,
      type,
    });
  }

  const response = await client.post('/presensi/checkin', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  });

  return response.data;
};

export const submitCheckout = async (
  kodeGuru: string,
  lokasiOut: string,
  imageUri?: string
): Promise<{ message: string }> => {
  const client = await createApiClient();
  const formData = new FormData();
  formData.append('kode_guru', kodeGuru);
  formData.append('lokasi_out', lokasiOut);

  if (imageUri) {
    const filename = imageUri.split('/').pop() || 'checkout.jpg';
    const match = /\.(\w+)$/.exec(filename);
    const type = match ? `image/${match[1]}` : 'image/jpeg';
    
    // @ts-ignore - React Native FormData accepts uri object
    formData.append('file', {
      uri: imageUri,
      name: filename,
      type,
    });
  }

  const response = await client.post('/presensi/checkout', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  });

  return response.data;
};
