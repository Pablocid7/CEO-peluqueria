// Espera a que todo el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {

    const fechaInput = document.getElementById('fecha');
    const horaInput = document.getElementById('hora');

    // Validar que la fecha no sea fin de semana y cargar horas disponibles
    if (fechaInput) {
        fechaInput.addEventListener('change', function () {
            const fechaSeleccionada = new Date(this.value);
            const dia = fechaSeleccionada.getDay(); // 0 = Domingo, 6 = Sábado

            if (dia === 0 || dia === 6) {
                alert('Solo se permiten reservas de lunes a viernes.');
                this.value = '';
                limpiarHoras();
                return;
            }

            fetch('horas_disponibles.php?fecha=' + this.value)
                .then(response => response.json())
                .then(horasDisponibles => {
                    const opciones = horaInput.options;
                    for (let i = 0; i < opciones.length; i++) {
                        const opcion = opciones[i];
                        if (opcion.value === "") continue;

                        if (horasDisponibles.includes(opcion.value)) {
                            opcion.disabled = false;
                            opcion.style.color = 'black';
                        } else {
                            opcion.disabled = true;
                            opcion.style.color = 'gray';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al obtener horas disponibles:', error);
                });
        });
    }

    function limpiarHoras() {
        const opciones = horaInput.options;
        for (let i = 0; i < opciones.length; i++) {
            if (opciones[i].value !== "") {
                opciones[i].disabled = true;
                opciones[i].style.color = 'gray';
            }
        }
    }

    // Validar que la hora esté dentro del horario de atención
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

    // Validación para formularios
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const nombreInput = document.getElementById('nombre');
            const telefonoInput = document.getElementById('telefono');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            const nombre = nombreInput ? nombreInput.value.trim() : "";
            const telefono = telefonoInput ? telefonoInput.value.trim() : "";
            const hora = horaInput ? horaInput.value : "";
            const email = emailInput ? emailInput.value.trim() : "";
            const password = passwordInput ? passwordInput.value : "";

            if ((nombreInput && !nombre) || (telefonoInput && !telefono) || (horaInput && !hora)) {
                alert("Por favor, completa todos los campos obligatorios.");
                e.preventDefault();
                return;
            }

            const nombrePattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
            if (nombreInput && !nombrePattern.test(nombre)) {
                alert("El nombre no puede contener números ni caracteres especiales.");
                e.preventDefault();
                return;
            }

            const telefonoPattern = /^[0-9]{9}$/;
            if (telefonoInput && !telefonoPattern.test(telefono)) {
                alert("El teléfono debe contener exactamente 9 dígitos.");
                e.preventDefault();
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput && !emailPattern.test(email)) {
                alert("Introduce un correo electrónico válido.");
                e.preventDefault();
                return;
            }

        });
    }

});
