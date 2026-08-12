//Explicacion:
//Este script ejecuta una funcion al cargar el DOM que busca el elemento con id "okRegistro".
//Si el modal existe (controlado por la logica PHP en el index), crea una instancia del modal
//usando la clase Bootstrap.Modal y la guarda en la constante execModal.
//Finalmente, muestra el modal automaticamente cuando el parametro "status" es "ok".

document.addEventListener('DOMContentLoaded', () => {
  const execModal = document.getElementById('okRegistro');
  if (execModal) {
    const modal = new bootstrap.Modal(execModal);
    modal.show();
  }
});

// Función para mostrar mensajes de éxito/acción, reemplazando el uso de alert()
function showAdminMessage(message) {
  const toastElement = document.getElementById('adminToast');
  const toastBody = document.getElementById('toastBodyMessage');

  // Asigna el nuevo mensaje
  toastBody.textContent = message;

  // Crea una nueva instancia de Bootstrap Toast y la muestra
  const toast = new bootstrap.Toast(toastElement, {
    delay: 4000 // Se oculta después de 4 segundos
  });
  toast.show();
}