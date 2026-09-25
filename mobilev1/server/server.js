const express = require('express');
const cors = require('cors');
const path = require('path');
require('dotenv').config();

const apiRoutes = require('./routes/apiRoutes');

const app = express();
const PORT = process.env.PORT || 5006;

// Middlewares
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Serve static uploaded photos at /storage
app.use('/storage', express.static(path.join(__dirname, 'uploads')));

// Mount API Routes (Supports /api, /v1/api, and /v1)
app.use('/api', apiRoutes);
app.use('/v1/api', apiRoutes);
app.use('/v1', apiRoutes);

// Root landing endpoint
app.get('/', (req, res) => {
  res.json({
    status: 'online',
    app: 'Artanita Presensi Guru Node.js API Backend',
    version: '1.0.0',
    endpoints: {
      health: '/api',
      login: '/api/login',
      presensi_checkin: '/api/presensi/checkin',
      presensi_checkout: '/api/presensi/checkout',
      presensi_history: '/api/presensi/getPresensi',
      presensi_count: '/api/presensi/countAbsensi',
    },
  });
});

// Start Server
app.listen(PORT, '0.0.0.0', () => {
  console.log(`🚀 Artanita Node.js API Server running on port ${PORT}`);
  console.log(`📡 URL API: http://localhost:${PORT}/api`);
});
