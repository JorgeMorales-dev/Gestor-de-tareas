import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'

// Iconos MDI
import '@mdi/font/css/materialdesignicons.css'

console.log("🚀 Iniciando proyecto Vue...");

const app = createApp(App);
console.log("🟢 App de Vue creada");

app.use(vuetify);
console.log("🎨 Vuetify activado");

app.mount('#app');
console.log("✅ Aplicación montada correctamente en #app");
