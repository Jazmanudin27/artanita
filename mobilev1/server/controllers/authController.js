const db = require('../config/db');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');
require('dotenv').config();

const JWT_SECRET = process.env.JWT_SECRET || 'artanita_jwt_secret_key_992718';

// Password match helper (supports Bcrypt & Plain text)
const verifyPassword = async (inputPassword, storedPassword) => {
  if (!storedPassword) return false;
  if (storedPassword.startsWith('$2a$') || storedPassword.startsWith('$2y$') || storedPassword.startsWith('$2b$')) {
    return await bcrypt.compare(inputPassword, storedPassword);
  }
  return inputPassword === storedPassword;
};

exports.login = async (req, res) => {
  try {
    const { username, password } = req.body;

    if (!username || !password) {
      return res.status(400).json({ message: 'Username dan password wajib diisi' });
    }

    // 1. Check in 'guru' table
    const [guruRows] = await db.query('SELECT * FROM guru WHERE username = ? LIMIT 1', [username]);
    if (guruRows.length > 0) {
      const guru = guruRows[0];
      const match = await verifyPassword(password, guru.password);
      if (match) {
        delete guru.password;
        const token = jwt.sign({ id: guru.kode_guru, role: 'Guru', username: guru.username }, JWT_SECRET, {
          expiresIn: '30d',
        });
        return res.status(200).json({
          kategori: 'Guru',
          token,
          data: guru,
        });
      }
    }

    // 2. Check in 'users' table
    const [userRows] = await db.query('SELECT * FROM users WHERE username = ? LIMIT 1', [username]);
    if (userRows.length > 0) {
      const user = userRows[0];
      const match = await verifyPassword(password, user.password);
      if (match) {
        delete user.password;
        const token = jwt.sign({ id: user.id, role: 'User', username: user.username }, JWT_SECRET, {
          expiresIn: '30d',
        });
        return res.status(200).json({
          kategori: 'User',
          token,
          data: user,
        });
      }
    }

    // 3. Check in 'siswa' table
    const [siswaRows] = await db.query('SELECT * FROM siswa WHERE username = ? LIMIT 1', [username]);
    if (siswaRows.length > 0) {
      const siswa = siswaRows[0];
      const match = await verifyPassword(password, siswa.password);
      if (match) {
        delete siswa.password;
        const token = jwt.sign({ id: siswa.kode_siswa, role: 'Siswa', username: siswa.username }, JWT_SECRET, {
          expiresIn: '30d',
        });
        return res.status(200).json({
          kategori: 'Siswa',
          token,
          data: siswa,
        });
      }
    }

    return res.status(401).json({ message: 'Username atau password salah' });
  } catch (error) {
    console.error('Login error:', error);
    return res.status(500).json({ message: 'Terjadi kesalahan pada server API', error: error.message });
  }
};

exports.logout = async (req, res) => {
  return res.status(200).json({ message: 'Logged out successfully' });
};
