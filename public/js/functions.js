const enlace = 'http://' + window.location.host + '/';
/* console.log(enlace);
 */
function calculoproducto() {
    var precio = $('#precio').val();
    var cantidad = $('#cantidad').val();
    var total = precio * cantidad;
    $('#precio_total').val(total);
}

function calcularVenta() {
    var id_producto = $('#id_producto').val();
    $.ajax({

        url: enlace + 'ventacalculo',
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
    var pagado = $('#campopagado').val()
    
    if (checkbox.is(':checked')) {
        $('#totalFinal').html('€' + (parseFloat(total) + parseFloat(servicio)))
        $('#campopagado_').html('€' + (parseFloat(total) + parseFloat(servicio) - parseFloat(pagado)))
        $('#ivatext').val(servicio)
        $('#valorTotalFinal').val( (parseFloat(total) + parseFloat(servicio) - parseFloat(pagado)))
    } else {
        $('#totalFinal').html('€' + (parseFloat(total)))
        $('#campopagado_').html('€' + (parseFloat(total) - parseFloat(pagado)))
        $('#ivatext').val(0)
        $('#valorTotalFinal').val( (parseFloat(total) - parseFloat(pagado)))

    }
}



function consultarMesaCerrada(id_ticket, id_mesa) {
    Swal.fire({
        title: "Seguro?",
        text: "Se re-abrirá el ticket #" + id_ticket + " de la mesa " + id_mesa,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Re-abrir!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: enlace + 'log-reabrir',
                data: { id_mesa: id_mesa, id_ticket: id_ticket },
                type: 'GET',
                dataType: 'json',
            });

            location.href = (enlace + 'venta/create/' + id_mesa + '/' + id_ticket)
        }
    });




}

function generarPDF(id_mesa, iva = 0) {
    var servicio = $('#ivatext').val()
    //a = window.open(enlace+'generate-pdf/' + id_mesa + '/' + iva +  '/' + servicio + '#toolbar=0', '_blank', 'height=650px, width=500px, top=20px, left=500px')
    //a.opener


    a = window.open(enlace + 'generate-pdf/' + id_mesa + '/' + iva + '/' + servicio + '#toolbar=0', '_blank', 'height=-10px, width=10px, top=10px, left=500px')

    //return false 
    // a.print()
    /*  setTimeout(function () {
         a.close()
     }, 8000) */
}

function reabrirmesa(id_mesa) {

    $.ajax({

        url: enlace + 'reabrir-venta',
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
                    location.href = (enlace + 'venta/create/' + id_mesa);
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
/* 
$(document).ready(function () {

    $('#modalprincipal').modal('show')
}) */
function cerrarVenta(id_mesa, id_ticket = null) {

    Swal.fire({
        title: "Como desea realizar el pago?",
        text: "Se cerrará la mesa número " + id_mesa,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0250c4",
        cancelButtonColor: "#967000",
        confirmButtonText: "EFECTIVO",
        cancelButtonText: "VISA",
    }).then((result) => {

        var total = $('#valorTotalFinal').val()
        $('#textoOk').html('COMPLETO (€' + total + ')')
        $('#contenedorValor').val('');
        if (result.isConfirmed) {
            $('#tipopago').html('EFECTIVO - €' + total);
            $('#modalprincipal').modal('show')
            $('#tpago').val(1)
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            $('#tipopago').html('VISA - €' + total);
            $('#modalprincipal').modal('show')
            $('#tpago').val(2)
        }

    })





    return

}

function calcularcantidad(signo) {
    var valor = $('#cantidad').val()
    if (signo == '-') {
        valor = parseInt(valor) - parseInt(1);
    }
    if (signo == '+') {
        valor = parseInt(valor) + parseInt(1);
    }
    if (valor < 0) {
        valor = 0;
    }
    $('#cantidad').val(valor)
    return false
}



function pintarNumero(numero, completo = 0) {

    var valor = $('#contenedorValor').val()
    if (completo == 1) {
        $('#contenedorValor').val(numero)
    } else {
        valor = valor + numero
        $('#contenedorValor').val(valor)
    }
}
btnCompletado()
function btnCompletado() {
    var contenedorValor = $('#contenedorValor').val();
    var valorTotalFinal = $('#valorTotalFinal').val();

    var valorFinal = 0;
    if (contenedorValor == valorTotalFinal || contenedorValor == 0) {
        $('#textoOk').html('COMPLETO (€' + valorTotalFinal + ')')
        valorFinal = valorTotalFinal
    } else {
        $('#textoOk').html('OK')
        valorFinal = contenedorValor
    }

    console.log(valorFinal);

    $('#valorFinal').val(valorFinal)
}


async function pagar() {
    var valor = $('#valorFinal').val();
    $('#contenedorValor').val(valor)

    var id_mesa = $('#id_mesa').val();
    var ticket = $('#_ticket').val();
    var tipo_pago = $('#tpago').val();

    var valorTotalFinal = $('#valorTotalFinal').val()

    var valor = parseFloat(valor)
    var valorTotalFinal = parseFloat(valorTotalFinal)

    $.ajax({
        url: enlace + 'pagar',
        data: { valor: valor, id_mesa: id_mesa, ticket: ticket, tipo_pago: tipo_pago },
        type: 'GET',
        dataType: 'json',
        success: await function (data) {




            if (valor > valorTotalFinal) {

                $.ajax({

                    url: enlace + 'cerrar-venta',
                    data: { id_mesa: id_mesa, id_ticket: ticket },
                    type: 'GET',
                    dataType: 'html',
                    success:  function (data) {
                       

                        Swal.fire({
                            title: "Devolucion de €" + (Math.abs(parseFloat(valor) - parseFloat(valorTotalFinal))),
                            text: "Mesa " + id_mesa + " cerrada correctamente",
                            icon: "warning",
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = (enlace + 'venta/create/' + id_mesa);
                            }
                        })

                    }
                });


                
            } else if (valor == valorTotalFinal) {

                $.ajax({

                    url: enlace + 'cerrar-venta',
                    data: { id_mesa: id_mesa, id_ticket: ticket },
                    type: 'GET',
                    dataType: 'html',
                    success:  function (data) {
                       
                        Swal.fire({
                            title: "Pago completo de €" + (Math.abs(parseFloat(valorTotalFinal))),
                            text:  "Mesa " + id_mesa + " cerrada correctamente",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 5000
                        })
                        
                        setTimeout(() => {
                            location.href = (enlace + 'venta/create/' + id_mesa);
                        }, 5000);
                    }
                });
                 
               
            } else if (valor < valorTotalFinal) {
                Swal.fire({
                    title: "Alerta!",
                    text: "Se ha generado un abono, restan €" + (Math.abs(parseFloat(valor) - parseFloat(valorTotalFinal))),
                    icon: "warning"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = (enlace + 'venta/create/' + id_mesa);
                    }
                })
            }


        }
    });

    return
}





function eliminarNumero() {
    str = $('#contenedorValor').val()
    str = str.slice(0, str.length - 1);
    /* if (str == '') {
        str = 0;
    } */
    $('#contenedorValor').val(str)
}
