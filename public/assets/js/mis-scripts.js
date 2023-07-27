// mis-scripts.js
document.getElementById('form-guardar').addEventListener('submit', function(event) {
    event.preventDefault();

    // ...

    Swal.fire({
        icon: 'success',
        title: 'Guardado exitoso',
        text: 'La información ha sido guardada correctamente.',
        showCancelButton: true,
        confirmButtonText: 'Visualizar',
        cancelButtonText: 'Cerrar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Abrir una nueva ventana para visualizar el PDF
            window.open('/visualizar-pdf', '_blank'); // Utilizamos la ruta directamente aquí
        }
    });
});
