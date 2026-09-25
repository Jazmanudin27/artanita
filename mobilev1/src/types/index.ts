export interface Guru {
  id?: number;
  kode_guru: string;
  nama_guru: string;
  nik?: string;
  nip?: string;
  jk?: string;
  no_hp?: string;
  foto?: string;
  jabatan?: string;
}

export interface UserAuthData {
  kategori: 'Guru' | 'User' | 'Siswa';
  token: string;
  data: Guru | any;
}

export interface PresensiItem {
  id: number;
  tanggal: string;
  kode_guru: string;
  nama_guru?: string;
  jk?: string;
  jam_in: string | null;
  jam_out: string | null;
  foto_in: string | null;
  foto_out: string | null;
  lokasi_in?: string | null;
  lokasi_out?: string | null;
}

export interface AbsensiCount {
  hadir: number;
  sakit: number;
  izin: number;
  cuti: number;
}

export type RootStackParamList = {
  Login: undefined;
  MainTab: undefined;
  Checkin: undefined;
  Checkout: { todayPresensi?: PresensiItem };
  Riwayat: undefined;
  Jadwal: undefined;
  Settings: undefined;
};
