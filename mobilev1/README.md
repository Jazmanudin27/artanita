# Artanita Mobile v1 - Presensi Guru Android App 📱🏫

Project React Native (Expo Managed Workflow & TypeScript) untuk aplikasi **Presensi Guru Artanita**.

---

## 🌟 Fitur Utama
1. **Fitur Presensi GPS & Camera Selfie**:
   - **Absen Masuk (Check-In)**: Pengambilan lokasi koordinat GPS akurat & foto selfie langsung dari kamera depan.
   - **Absen Pulang (Check-Out)**: Pengambilan lokasi koordinat GPS & foto selfie check-out.
2. **Dashboard Interactive Guru**:
   - Jam & tanggal digital realtime.
   - Ringkasan rekap bulanan (Hadir, Sakit, Izin, Cuti) terhubung ke API backend.
   - Status presensi hari ini (Jam Masuk & Jam Pulang).
3. **Riwayat Presensi Bulanan**:
   - Filter Bulan & Tahun.
   - Menampilkan jam masuk, jam pulang, status presensi, dan thumbnail foto selfie.
4. **Jadwal Pelajaran / Mengajar**:
   - Menampilkan jadwal mata pelajaran dan kelas mengajar guru.
5. **Konfigurasi Server & Custom Domain API**:
   - Bisa ganti URL Server / Domain backend kapan saja via aplikasi (misal: `http://192.168.1.100:8000`, `https://artanita.id`, dll).
   - Fitur **"Tes Koneksi Server"** langsung di aplikasi untuk memastikan API terhubung.

---

## 🚀 Cara Menjalankan Project

### 1. Prasyarat
- Node.js & npm / yarn
- Aplikasi **Expo Go** di Smartphone Android Anda (download di Play Store), atau Android Emulator (Android Studio).

### 2. Jalankan Server Dev
Masuk ke folder `mobilev1`:
```bash
cd mobilev1
npm start
```
atau untuk langsung membuka di Android Emulator / Device:
```bash
npm run android
```

### 3. Scan QR Code
- Buka aplikasi **Expo Go** di HP Android Anda.
- Scan QR Code yang muncul di terminal / browser setelah menjalankan `npm start`.

---

## 🌐 Menghubungkan ke Backend Domain / Localhost

Anda dapat mengatur URL Backend di halaman **Login** atau di menu **Pengaturan -> URL Base Domain API**:
- **Local Dev (Android Emulator)**: `http://10.0.2.2:8000`
- **Local Dev (HP Asli via Wi-Fi)**: `http://192.168.X.X:8000` (Gunakan IP Komputer Anda)
- **Domain Server Live**: `https://artanita.domainanda.com`

---

## 📦 Menghasilkan APK Android (Build Production)

Untuk membuat file `.apk` standalone yang bisa diinstall di HP Android tanpa Expo Go:

1. Install EAS CLI (jika belum):
```bash
npm install -g eas-cli
```

2. Build APK:
```bash
eas build -p android --profile preview
```
---
