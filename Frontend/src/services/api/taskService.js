// Configuración base de la API
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

// Configuración de headers por defecto
const DEFAULTHEADERS = {
  "Content-Type": "application/json",
  Accept: "application/json",
  "X-Requested-With": "XMLHttpRequest",
};

// Función auxiliar para manejar respuestas HTTP
const handleResponse = async (response) => {
  if (!response.ok) {
    const errorData = await response.text();
    let errorMessage;

    try {
      const parsedError = JSON.parse(errorData);
      errorMessage =
        parsedError.message ||
        `Error ${response.status}: ${response.statusText}`;
    } catch {
      errorMessage = `Error ${response.status}: ${response.statusText}`;
    }

    throw new Error(errorMessage);
  }

  const contentType = response.headers.get("content-type");
  if (contentType && contentType.includes("application/json")) {
    return await response.json();
  }

  return await response.text();
};

// Función auxiliar para realizar peticiones HTTP
const apiRequest = async (endpoint, options = {}) => {
  const url = `${API_BASE_URL}${endpoint}`;

  const config = {
    headers: { ...DEFAULTHEADERS },
    ...options,
  };

  try {
    const response = await fetch(url, config);
    return await handleResponse(response);
  } catch (error) {
    console.error(`Error en petición a ${endpoint}:`, error);
    throw error;
  }
};

/**
 * Obtiene todas las tareas
 * @returns {Promise<Array>} Lista de tareas
 */
 const getAllTasks = async () => {
  return await apiRequest("/tasks", {
    method: "GET",
  });
};

/**
 * Obtiene una tarea por su ID
 * @param {number|string} id - ID de la tarea
 * @returns {Promise<Object>} Datos de la tarea
 */
 const getTaskById = async (id) => {
  if (!id) {
    throw new Error("El ID de la tarea es requerido");
  }

  return await apiRequest(`/tasks/${id}`, {
    method: "GET",
  });
};

/**
 * Crea una nueva tarea
 * @param {Object} taskData - Datos de la tarea a crear
 * @returns {Promise<Object>} Tarea creada
 */
 const createTask = async (taskData) => {
  if (!taskData) {
    throw new Error("Los datos de la tarea son requeridos");
  }

  return await apiRequest("/tasks", {
    method: "POST",
    body: JSON.stringify(taskData),
  });
};

/**
 * Actualiza una tarea existente
 * @param {number|string} id - ID de la tarea a actualizar
 * @param {Object} taskData - Nuevos datos de la tarea
 * @returns {Promise<Object>} Tarea actualizada
 */
 const updateTask = async (id, taskData) => {
  if (!id) {
    throw new Error("El ID de la tarea es requerido");
  }

  if (!taskData) {
    throw new Error("Los datos de la tarea son requeridos");
  }

  return await apiRequest(`/tasks/${id}`, {
    method: "PUT",
    body: JSON.stringify(taskData),
  });
};

/**
 * Elimina una tarea
 * @param {number|string} id - ID de la tarea a eliminar
 * @returns {Promise<Object>} Respuesta de confirmación
 */
 const deleteTask = async (id) => {
  if (!id) {
    throw new Error("El ID de la tarea es requerido");
  }

  return await apiRequest(`/tasks/${id}`, {
    method: "DELETE",
  });
};

// Exportación por defecto con todas las funciones
const taskService = {
  getAllTasks,
  getTaskById,
  createTask,
  updateTask,
  deleteTask,
};

export default taskService;
