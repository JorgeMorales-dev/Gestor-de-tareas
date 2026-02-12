<template>
  <v-app>
    <v-main class="bg-grey-lighten-4">
      <v-container class="d-flex justify-center">

        <v-card width="750" class="mt-10 elevation-8 rounded-xl">

          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h5 font-weight-bold">
              📝 Gestor de Tareas EDUPAN
            </span>
          </v-card-title>

          <v-divider></v-divider>

          <v-card-text>

            <v-snackbar v-model="showSuccessSnack" color="success" location="top" elevation="24" timeout="5000">
              {{ successMsg }}
            </v-snackbar>

            <v-snackbar v-model="showErrorSnack" color="error" location="top" elevation="24" timeout="5000">
              {{ errorMsg }}
            </v-snackbar>

            <v-row class="mb-4">

              <v-col cols="12" md="6">
                <v-select v-model="filtro" :items="opcionesFiltro" label="Filtrar tareas" placeholder="Seleccione"
                  variant="outlined" density="comfortable" clearable />
              </v-col>

              <v-col cols="12" md="3">
                <v-btn color="primary" block height="48" @click="dialog = true">
                  Nueva tarea
                </v-btn>
              </v-col>

            </v-row>

            <v-table class="rounded-lg shadow-sm" fixed-header height="450px">
              <thead class="bg-grey-lighten-3">
                <tr>
                  <th>Check</th>
                  <th>Estado</th>
                  <th>Título</th>
                  <th>Descripción</th>
                  <th>Fecha creación</th>
                  <th class="text-center">Eliminar</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="task in filteredTasks" :key="task.id">

                  <td width="80">
                    <v-checkbox v-model="task.completed" @update:modelValue="(val) => toggleCompleted(task, val)"
                      hide-details density="compact" />
                  </td>

                  <td width="140">
                    <v-chip :color="task.completed ? 'green' : 'amber'" size="small">
                      {{ task.completed ? 'Completada' : 'Pendiente' }}
                    </v-chip>
                  </td>

                  <td>{{ task.title }}</td>

                  <td class="text-grey-darken-1">
                    {{ task.description || 'Sin descripción' }}
                  </td>

                  <td>
                    {{ task.createdAt }}
                  </td>

                  <td class="text-center" width="100">
                    <v-btn icon="mdi-delete" variant="text" color="red" @click="removeTask(task)" />
                  </td>

                </tr>

              </tbody>
            </v-table>

          </v-card-text>

        </v-card>

        <v-dialog v-model="dialog" max-width="600">
          <v-card>

            <v-card-title class="text-h6 font-weight-bold">
              Nueva tarea
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text>
              <v-text-field v-model="newTask.title" label="Título" variant="outlined" class="mb-4" />
              <v-textarea v-model="newTask.description" label="Descripción" variant="outlined" rows="3" />
            </v-card-text>

            <v-card-actions class="justify-end">
              <v-btn variant="text" @click="dialog = false">
                Cancelar
              </v-btn>

              <v-btn color="primary" @click="saveTask">
                Guardar
              </v-btn>
            </v-card-actions>

          </v-card>
        </v-dialog>

      </v-container>
    </v-main>
  </v-app>
</template>


<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { listTasks, createTask, updateTask, deleteTask } from "./services/tasks";

const tasks = ref([]);
const dialog = ref(false);
const newTask = ref({ title: "", description: "" });

// Mensajes y estados de SnackBar
const successMsg = ref("");
const errorMsg = ref("");
const showSuccessSnack = ref(false);
const showErrorSnack = ref(false);

// Limpiar campos automáticamente al cerrar el diálogo (por botón o clic fuera)
watch(dialog, (val) => {
  if (!val) {
    newTask.value = { title: "", description: "" };
  }
});

const showSuccess = (msg) => {
  successMsg.value = msg;
  showSuccessSnack.value = true;
};

const showError = (msg) => {
  errorMsg.value = msg;
  showErrorSnack.value = true;
};

// Filtros
const filtro = ref("todas");
const opcionesFiltro = [
  { title: "Todas", value: "todas" },
  { title: "Pendientes", value: "pendientes" },
  { title: "Completadas", value: "completadas" },
];

const filteredTasks = computed(() => {
  if (filtro.value === "todas") return tasks.value;
  if (filtro.value === "pendientes") return tasks.value.filter(t => !t.completed);
  return tasks.value.filter(t => t.completed);
});

async function loadTasks() {
  try {
    const data = await listTasks();
    const arr = Array.isArray(data) ? data : (data.data ?? []);

    tasks.value = arr.map(t => ({
      id: t.id,
      title: t.title,
      description: t.description,
      completed: Boolean(t.completed),
      createdAt: t.created_at
        ? new Date(t.created_at).toLocaleDateString()
        : ""
    }));
  } catch (e) {
    console.error("Error cargando tareas");
    showError("❌ Error al cargar tareas.");
  }
}

// Crear tarea
const saveTask = async () => {
  if (!newTask.value.title || newTask.value.title.trim().length < 3) {
    showError("⚠️ El título debe tener al menos 3 caracteres.");
    return;
  }

  try {
    await createTask({
      title: newTask.value.title.trim(),
      description: newTask.value.description?.trim() || null,
      completed: false
    });

    dialog.value = false; // El watch se encargará de limpiar los campos al cerrarse
    showSuccess("✅ Tarea creada correctamente.");
    await loadTasks();
  } catch {
    showError("❌ No se pudo crear la tarea.");
  }
};

// Eliminar tarea
const removeTask = async (task) => {
  try {
    await deleteTask(task.id);
    showSuccess("🗑️ Tarea eliminada.");
    await loadTasks();
  } catch {
    showError("❌ No se pudo eliminar la tarea.");
  }
};

// Cambiar estado (checkbox)
const toggleCompleted = async (task, checked) => {
  const anterior = task.completed;
  task.completed = checked;

  try {
    await updateTask(task.id, { completed: checked });
    showSuccess("✅ Tarea Completa.");
  } catch {
    task.completed = anterior;
    showError("❌ No se pudo completar la tarea.");
  }
};

onMounted(() => {
  console.log("Cargando tareas...");
  loadTasks();
});
</script>
