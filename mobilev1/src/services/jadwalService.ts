import { createApiClient } from '../config/api';

export interface ScheduleItem {
  id: number;
  hari?: string;
  jam_mulai?: string;
  jam_selesai?: string;
  nama_mapel?: string;
  nama_kelas?: string;
  ruangan?: string;
}

/**
 * Service untuk mengambil jadwal mengajar guru dari API
 */
export const getJadwalPelajaran = async (kodeGuru: string): Promise<ScheduleItem[]> => {
  const client = await createApiClient();
  const response = await client.post('/jadwal/getJadwalPelajaran', {
    kode_guru: kodeGuru,
  });
  return response.data.data || response.data || [];
};
