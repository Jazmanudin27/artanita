/**
 * Artanita Design System & Color Palette Tokens
 * Digunakan untuk menjaga konsistensi warna, font, dan spacing di seluruh aplikasi.
 */

export const COLORS = {
  primary: '#2563eb', // Blue Accent
  primaryLight: '#dbeafe',
  primaryDark: '#1d4ed8',

  success: '#22c55e', // Green Success
  successLight: '#dcfce7',

  warning: '#f97316', // Orange Warning
  warningLight: '#ffedd5',

  danger: '#ef4444', // Red Danger
  dangerLight: '#fef2f2',

  info: '#0284c7', // Sky Blue
  infoLight: '#e0f2fe',

  purple: '#9333ea', // Purple Accent
  purpleLight: '#f3e8ff',

  textPrimary: '#0f172a',
  textSecondary: '#475569',
  textMuted: '#94a3b8',

  bgMain: '#f8fafc',
  bgCard: '#ffffff',
  borderColor: '#e2e8f0',
};

export const SPACING = {
  xs: 4,
  sm: 8,
  md: 16,
  lg: 24,
  xl: 32,
};

export const SHADOWS = {
  light: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.04,
    shadowRadius: 6,
    elevation: 2,
  },
  medium: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.08,
    shadowRadius: 12,
    elevation: 4,
  },
};
