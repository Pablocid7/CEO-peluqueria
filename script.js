// Espera a que todo el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {

    // Validar que la fecha no sea fin de semana
    const fechaInput = document.getElementById('fecha');
    if (fechaInput) {
      fechaInput.addEventListener('change', function () {
        const fechaSeleccionada = new Date(this.value);
        const dia = fechaSeleccionada.getDay(); // 0 = Domingo, 6 = Sábado
  
        if (dia === 0 || dia === 6) {
          alert('Solo se permiten reservas de lunes a viernes.');
          this.value = '';
        }
      });
    }
  
    // Validar que la hora esté dentro del horario de atención
    const horaInput = document.getElementById('hora');
    if (horaInput) {
      horaInput.addEventListener('change', function () {
        const horaSeleccionada = this.value;
        if (horaSeleccionada < '10:00' || 
            (horaSeleccionada > '13:00' && horaSeleccionada < '16:00') ||
            horaSeleccionada > '19:00') {
          alert('La hora debe estar entre 10:00-13:00 o 16:00-19:00');
          this.value = '';
        }
      });
    }
  
    // Confirmación visual de envío del formulario y validación de los campos
    const form = document.querySelector('form');
    if (form) {
      form.addEventListener('submit', function (event) {
        let nombre = document.getElementById("nombre").value;
        let telefono = document.getElementById("telefono").value;
        let hora = document.getElementById("hora").value;
  
        // Verificar si los campos están completos
        if (!nombre || !telefono || !hora) {
          alert("Por favor, completa todos los campos.");
          event.preventDefault(); // Detener el envío del formulario
          return false; // Asegurarse de que el formulario no se envíe
        }
  
        // Validar que el nombre no contenga números
        let nombrePattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
        if (!nombrePattern.test(nombre)) {
          alert("El nombre no puede contener números.");
          event.preventDefault();
          return false;
        }
  
        // Validar el formato del teléfono (9 dígitos)
        let phonePattern = /^[0-9]{9}$/;
        if (!phonePattern.test(telefono)) {
          alert("El teléfono debe contener 9 dígitos.");
          event.preventDefault();
          return false;
        }
  
        // Confirmación visual
        alert('Su reserva se está procesando...');
      });
    }
  
  });
  
  