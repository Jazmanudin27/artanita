# Artanita Node.js Express API Backend 🚀

Backend API murni berbasis **Node.js + Express** (tanpa Laravel) untuk aplikasi **Artanita Presensi Guru**.

---

## 📋 Konfigurasi Database (.env)

Server ini terhubung langsung ke database MySQL `artanita`:

```env
PORT=5006
DB_HOST=localhost
DB_PORT=3306
DB_USER=artanita
DB_PASSWORD=Jazman@271998
DB_NAME=artanita
JWT_SECRET=artanita_jwt_secret_key_992718
```

---

## 🚀 Cara Menjalankan Server API

### 1. Mode Lokal / Development:
```bash
cd mobilev1/server
npm run dev
```

### 2. Mode Production (VPS / Server Linux):
Menggunakan **PM2** (Process Manager):
```bash
npm install -g pm2
cd mobilev1/server
pm2 start server.js --name "artanita-api"
pm2 save
```

---

## 📡 Endpoint REST API:

- `GET  /v1` atau `/api` -> Health Check Status
- `POST /api/login` -> Auth Login Guru/User/Siswa
- `GET  /api/logout/:id` -> Logout
- `POST /api/presensi/countAbsensi` -> Rekap Hitung Presensi (Hadir, Sakit, Izin, Cuti)
- `POST /api/presensi/getPresensi` -> Riwayat Presensi Bulanan
- `POST /api/presensi/checkin` -> Absen Masuk (Multipart Form: `kode_guru`, `lokasi_in`, `file` photo)
- `POST /api/presensi/checkout` -> Absen Pulang (Multipart Form: `kode_guru`, `lokasi_out`, `file` photo)
- `POST /api/jadwal/getJadwalPelajaran` -> Jadwal Mengajar Guru
