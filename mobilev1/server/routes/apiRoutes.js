const express = require('express');
const router = express.Router();
const multer = require('multer');
const path = require('path');
const fs = require('fs');

const authController = require('../controllers/authController');
const presensiController = require('../controllers/presensiController');
const jadwalController = require('../controllers/jadwalController');

// Ensure upload directory exists
const uploadDir = path.join(__dirname, '../uploads/presensi');
if (!fs.existsSync(uploadDir)) {
  fs.mkdirSync(uploadDir, { recursive: true });
}

// Multer Storage Configuration
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, uploadDir);
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1e9);
    const ext = path.extname(file.originalname) || '.jpg';
    cb(null, `${file.fieldname}-${uniqueSuffix}${ext}`);
  },
});

const upload = multer({ storage });

// Health check status
router.get('/', (req, res) => {
  res.json({
    status: 'online',
    app: 'Artanita Node.js Express API Server',
    version: '1.0.0',
    timestamp: new Date().toISOString(),
  });
});

// Auth Routes
router.post('/login', authController.login);
router.get('/logout/:id', authController.logout);

// Presensi Routes
router.post('/presensi/countAbsensi', presensiController.countAbsensi);
router.post('/presensi/getPresensi', presensiController.getPresensi);
router.post('/presensi/checkin', upload.single('file'), presensiController.checkin);
router.post('/presensi/checkout', upload.single('file'), presensiController.checkout);

// Jadwal Routes
router.post('/jadwal/getJadwalPelajaran', jadwalController.getJadwalPelajaran);

module.exports = router;
