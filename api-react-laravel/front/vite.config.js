import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  css: {
    preprocessorOptions: {
      css: {
        // Opciones para manejar correctamente los imports de CSS desde node_modules
        additionalData: `
          @import "~datatables.net-dt/css/jquery.dataTables.min.css";
          @import "~datatables.net-buttons-dt/css/buttons.dataTables.min.css";
        `,
      },
    },
  },
});
