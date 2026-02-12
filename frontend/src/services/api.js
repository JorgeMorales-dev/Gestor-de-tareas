import axios from "axios";

console.log("🔧 Iniciando configuración de Axios...");

const api = axios.create({
  baseURL: "http://localhost:8000", // backend
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

console.log("🌐 Axios conectado a:", api.defaults.baseURL);

// Ver las peticiones que salen al backend
api.interceptors.request.use(
  (config) => {
    console.log(`📤 Enviando petición: ${config.method?.toUpperCase()} ${config.url}`);
    return config;
  },
  (error) => {
    console.error("❌ Error antes de enviar petición:", error);
    return Promise.reject(error);
  }
);

// Ver las respuestas del backend
api.interceptors.response.use(
  (response) => {
    console.log(`📥 Respuesta OK: ${response.status} - ${response.config.url}`);
    return response;
  },
  (error) => {
    if (error.response) {
      console.error(
        `❌ Error del backend (${error.response.status}) en: ${error.config?.url}`
      );
      console.error("Detalle:", error.response.data);
    } else {
      console.error("❌ Error de conexión con el backend:", error.message);
    }
    return Promise.reject(error);
  }
);

export default api;
