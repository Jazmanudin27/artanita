const db = require('../config/db');

exports.getJadwalPelajaran = async (req, res) => {
  try {
    const { kode_guru } = req.body;

    const [rows] = await db.query(
      `SELECT * FROM jadwal WHERE kode_guru = ? ORDER BY id DESC`,
      [kode_guru]
    ).catch(async () => {
      // Fallback if table is named jadwal_pelajaran
      return await db.query(
        `SELECT * FROM jadwal_pelajaran WHERE kode_guru = ? ORDER BY id DESC`,
        [kode_guru]
      );
    });

    return res.status(200).json({ data: rows || [] });
  } catch (error) {
    console.error('getJadwalPelajaran error:', error);
    return res.status(200).json({ data: [] });
  }
};
