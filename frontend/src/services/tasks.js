import api from "./api";

console.log("📂 tasks.js cargado");

// Listar tareas
export const listTasks = async () => {
  console.log("📥 Pidiendo lista de tareas al backend...");
  const res = await api.get("/api/tasks");
  console.log("✅ Tareas recibidas:", res.data);
  return res.data;
};

// Crear tarea
export const createTask = async (payload) => {
  console.log("📤 Enviando nueva tarea:", payload);
  const res = await api.post("/api/tasks", payload);
  console.log("✅ Tarea creada:", res.data);
  return res.data;
};

// Actualizar tarea
export const updateTask = async (id, payload) => {
  console.log(`🔄 Actualizando tarea ${id}:`, payload);
  const res = await api.put(`/api/tasks/${id}`, payload);
  console.log("✅ Tarea actualizada:", res.data);
  return res.data;
};

// Eliminar tarea
export const deleteTask = async (id) => {
  console.log(`🗑️ Eliminando tarea con ID: ${id}`);
  const res = await api.delete(`/api/tasks/${id}`);
  console.log("✅ Tarea eliminada:", res.data);
  return res.data;
};
