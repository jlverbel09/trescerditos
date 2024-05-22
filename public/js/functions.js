function calculoproducto() {
    var precio = $('#precio').val();
    var cantidad = $('#cantidad').val();
    var total = precio * cantidad;
    $('#precio_total').val(total);
}

function calcularVenta() {
    var id_producto = $('#id_producto').val();
    $.ajax({

        url: '../../ventacalculo',
        data: { id_producto: id_producto },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#precio').val(data)
            var cantidad = $('#cantidad').val();

            if (cantidad) {
                var precioTotal = data * cantidad
                $('#precio_total').val(precioTotal)
            }
        }
    });
}

function adicionarServicio(total, servicio = 0) {
    var checkbox = $('#checkiva')

    if (checkbox.is(':checked')) {
        $('#totalFinal').html('€' + (total + servicio))
        $('#ivatext').val(servicio)
    } else {
        $('#totalFinal').html('€' + (total))
        $('#ivatext').val(0)
    }
}



function consultarMesaCerrada(id_ticket, id_mesa) {
    Swal.fire({
        title: "Seguro?",
        text: "Se re-abrir el ticket #" + id_ticket + " de la mesa " + id_mesa,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Re-abrir!"
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = ('../../venta/create/' + id_mesa + '/' + id_ticket)
        }
    });




}

function generarPDF(id_mesa, iva = 0) {
    var servicio = $('#ivatext').val()
    //a = window.open('../../generate-pdf/' + id_mesa + '/' + iva +  '/' + servicio + '#toolbar=0', '_blank', 'height=650px, width=500px, top=20px, left=500px')
    //a.opener

    
    a = window.open('../../generate-pdf/' + id_mesa + '/' + iva +  '/' + servicio + '#toolbar=0', '_blank', 'height=-10px, width=10px, top=10px, left=500px')

    //return false 
   // a.print()
    setTimeout(function () {
        a.close()
    }, 8000)
}

function reabrirmesa(id_mesa) {

    $.ajax({

        url: '../../reabrir-venta',
        data: { id_mesa: id_mesa },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data != 0) {
                Swal.fire({
                    title: "Mesa Re-Abierta",
                    text: "Mesa " + id_mesa + " abierta correctamente",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    location.href = ('../../venta/create/' + id_mesa);
                }, 2000);
            } else {
                Swal.fire({
                    title: "Alerta!",
                    text: "La mesa " + id_mesa + " No contiene un historico de uso aún",
                    icon: "info",
                    showConfirmButton: false,
                    timer: 2000
                });
            }


        }
    });
}

function cerrarVenta(id_mesa) {
    Swal.fire({
        title: "Seguro?",
        text: "Se cerrará la mesa número " + id_mesa,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Cerrar!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({

                url: '../../cerrar-venta',
                data: { id_mesa: id_mesa },
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    Swal.fire({
                        title: "Mesa Cerrada",
                        text: "Mesa " + id_mesa + " cerrada correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.href = ('../../venta/create/' + id_mesa);
                    }, 2000);
                }
            });
        }
    });
}

