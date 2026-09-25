const db = require('../config/db');

exports.countAbsensi = async (req, res) => {
  try {
    const { id } = req.body;
    const kodeGuru = id || req.query.kode_guru;

    const now = new Date();
    const bulan = now.getMonth() + 1;
    const tahun = now.getFullYear();

    const [hadirRows] = await db.query(
      `SELECT COUNT(*) as count FROM presensi 
       WHERE kode_guru = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND jam_out IS NOT NULL`,
      [kodeGuru, bulan, tahun]
    );

    const [sakitRows] = await db.query(
      `SELECT COUNT(*) as count FROM surat_absen 
       WHERE kode_guru = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND jenis_absen = 'Sakit'`,
      [kodeGuru, bulan, tahun]
    );

    const [izinRows] = await db.query(
      `SELECT COUNT(*) as count FROM surat_absen 
       WHERE kode_guru = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND jenis_absen = 'Izin'`,
      [kodeGuru, bulan, tahun]
    );

    const [cutiRows] = await db.query(
      `SELECT COUNT(*) as count FROM surat_absen 
       WHERE kode_guru = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND jenis_absen = 'Cuti'`,
      [kodeGuru, bulan, tahun]
    );

    return res.status(200).json({
      hadir: hadirRows[0]?.count || 0,
      sakit: sakitRows[0]?.count || 0,
      izin: izinRows[0]?.count || 0,
      cuti: cutiRows[0]?.count || 0,
    });
  } catch (error) {
    console.error('countAbsensi error:', error);
    return res.status(500).json({ message: 'Error countAbsensi', error: error.message });
  }
};

exports.getPresensi = async (req, res) => {
  try {
    const { kode_guru, bulan, tahun } = req.body;

    const [rows] = await db.query(
      `SELECT p.tanggal, p.id, p.kode_guru, p.jam_in, p.jam_out, p.foto_in, p.foto_out, g.nama_guru, g.jk 
       FROM presensi p
       JOIN guru g ON g.kode_guru = p.kode_guru
       WHERE g.kode_guru = ? AND MONTH(p.tanggal) = ? AND YEAR(p.tanggal) = ?
       ORDER BY p.tanggal DESC`,
      [kode_guru, bulan, tahun]
    );

    return res.status(200).json({ data: rows });
  } catch (error) {
    console.error('getPresensi error:', error);
    return res.status(500).json({ message: 'Error getPresensi', error: error.message });
  }
};

exports.checkin = async (req, res) => {
  try {
    const { kode_guru, lokasi_in } = req.body;
    const tanggal = new Date().toISOString().split('T')[0];
    const jamSekarang = new Date().toTimeString().split(' ')[0];

    let fotoIn = null;
    if (req.file) {
      fotoIn = `upload/presensi/${req.file.filename}`;
    }

    await db.query(
      `INSERT INTO presensi (kode_guru, tanggal, jam_in, jam_out, foto_in, foto_out, lokasi_in, lokasi_out, created_at, updated_at) 
       VALUES (?, ?, ?, NULL, ?, NULL, ?, NULL, NOW(), NOW())`,
      [kode_guru, tanggal, jamSekarang, fotoIn, lokasi_in]
    );

    return res.status(201).json({ message: 'Presensi berhasil ditambahkan' });
  } catch (error) {
    console.error('checkin error:', error);
    return res.status(500).json({ message: 'Gagal menambahkan presensi', error: error.message });
  }
};

exports.checkout = async (req, res) => {
  try {
    const { kode_guru, lokasi_out } = req.body;
    const tanggal = new Date().toISOString().split('T')[0];
    const jamSekarang = new Date().toTimeString().split(' ')[0];

    const [existing] = await db.query(
      `SELECT * FROM presensi WHERE kode_guru = ? AND tanggal = ? LIMIT 1`,
      [kode_guru, tanggal]
    );

    if (existing.length === 0) {
      return res.status(404).json({ message: 'Data presensi hari ini tidak ditemukan' });
    }

    let fotoOut = existing[0].foto_out;
    if (req.file) {
      fotoOut = `upload/presensi/${req.file.filename}`;
    }

    await db.query(
      `UPDATE presensi SET jam_out = ?, foto_out = ?, lokasi_out = ?, updated_at = NOW() 
       WHERE kode_guru = ? AND tanggal = ?`,
      [jamSekarang, fotoOut, lokasi_out, kode_guru, tanggal]
    );

    return res.status(200).json({ message: 'Presensi berhasil diperbarui' });
  } catch (error) {
    console.error('checkout error:', error);
    return res.status(500).json({ message: 'Gagal memperbarui presensi', error: error.message });
  }
};
