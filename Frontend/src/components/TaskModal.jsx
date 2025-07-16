import React from "react";
import TaskForm from "./TaskForm";

const TaskModal = ({
  isOpen,
  mode = "create",
  task = null,
  onSave,
  onClose,
}) => {
  if (!isOpen) return null;

  const handleSave = async (formData) => {
    try {
      await onSave(formData);
      onClose();
    } catch (error) {
      console.error("Error al guardar la tarea:", error);
      throw error; // Re-throw para que TaskForm pueda manejarlo
    }
  };

  const modalTitle = mode === "create" ? "Crear Nueva Tarea" : "Editar Tarea";

  return (
    <>
      {/* Backdrop */}
      <div
        className="fixed inset-0 z-40 bg-black bg-opacity-50"
        onClick={onClose}
      />

      {/* Modal */}
      <div className="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full overflow-y-auto overflow-x-hidden">
        <div className="relative p-4 w-full max-w-2xl max-h-full">
          {/* Modal content */}
          <div className="relative bg-white rounded-lg shadow dark:bg-gray-700">
            {/* Modal header */}
            <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
                {modalTitle}
              </h3>
              <button
                type="button"
                onClick={onClose}
                className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              >
                <svg
                  className="w-3 h-3"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 14 14"
                >
                  <path
                    stroke="currentColor"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                  />
                </svg>
                <span className="sr-only">Cerrar modal</span>
              </button>
            </div>

            {/* Modal body */}
            <div className="p-4 md:p-5">
              <TaskForm
                task={task}
                mode={mode}
                onSave={handleSave}
                onCancel={onClose}
              />
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default TaskModal;
