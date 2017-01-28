var service = "../controladores/";
$(document).ready(function () {
    cargarComboUsuarios("#cbousuarios", "todos");
    listar();
});


$("#btnfiltrar").click(function () {
        listar();
});

$("#cbousuarios").change(function () {
    listar();
});

$("#cboestado").change(function () {
    listar();
});

$("#cbotipo").change(function () {
    listar();
});

function listar() {

    var fecha1 = $("#txtfecha1").val();
    if (fecha1 === null) {
        fecha1 = date('Y-m-d');
    }

    var fecha2 = $("#txtfecha2").val();
    if (fecha2 === null) {
        fecha2 = date('Y-m-d');
    }

    var codigoUsuario = $("#cbousuarios").val();
    if (codigoUsuario === null) {
        codigoUsuario = 0;
    }
    var codigoEstado = $("#cboestado").val();

    var tipo = $("#cbotipo").val();
    $.post(
                service+"pago.listar.php", 
    {
        p_fecha1: fecha1,
        p_fecha2: fecha2,
        p_estado: codigoEstado,
        p_usuario: codigoUsuario,
        p_tipo: tipo
    }).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>Codigo</th>';
            html += '<th>F. REGISTRO</th>';
            html += '<th>DESCRIPCION</th>';
            html += '<th>MONTO</th>';
            html += '<th>FECHA A PAGAR</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td>' + item.cod + '</td>';
                html += '<td>' + item.fechareg + '</td>';
                html += '<td>' + item.pago + '</td>';
                html += '<td>' + item.monto + '</td>';
                html += '<td>' + item.fechapagar + '</td>';
                html += '<td align="center">';

                if (item.estado == "Anulado") {
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" class="btn btn-success btn-xs" onclick="recuperar(' + item.cod + ')"><i class="fa fa-mail-reply"></i></button>';
                } else {
                    html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.cod + ')"><i class="fa fa-pencil"></i></button>';
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" id="tblbtneliminar' + item.cod + '" class="btn btn-danger btn-xs" onclick="eliminar(' + item.cod + ')"><i class="fa fa-close"></i></button>';
                }
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[2, "asc"]]
            });

        } else {
            swal("Mensaje del sistema", "Este es el error :" + resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarComboUsuarios(p_nombreCombo, p_tipo) {
    $.post(
            service+"usuario.listar.php"
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";
            if (p_tipo === "seleccione") {
                html += '<option value="">Seleccione un usuario</option>';
            } else {
                html += '<option value="0">Todos los Usuarios</option>';
            }
            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_usuario + '">' + item.nombre + '</option>';
            });

            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function eliminar(codigoPago) {
    swal({
        title: "Confirme",
        text: "¿Esta seguro de eliminar el registro seleccionado?",
        showCancelButton: true,
        confirmButtonColor: '#d93f1f',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/eliminar.png"
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            service+"pago.eliminar.php",
                            {
                                p_codigo_pago: codigoPago
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) { //ok
                            listar();
                            swal("Exito", datosJSON.mensaje, "success");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                }
            });
}

$("#frmgrabar").submit(function (evento) {
    evento.preventDefault();
    swal({
        title: "Confirme",
        text: "¿Esta seguro de grabar los datos ingresados?",
        showCancelButton: true,
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/pregunta.png"
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            service+"pago.agregar.editar.php",
                            {p_datosFormulario: $("#frmgrabar").serialize()}
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) {
                            swal("Exito", datosJSON.mensaje, "success");
                            $("#btncerrar").click(); //cerrar ventana
                            listar();//refrescar los datos
                        } else {
                            swal("Mensaje del sistema", resultado, "warning");
                        }
                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                }
            });
});

$("#btnagregar").click(function () {
    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1; //months from 1-12
    var day = dateObj.getUTCDate();
    var year = dateObj.getUTCFullYear();

    newdate = year + "/" + month + "/" + day;
    $("#txttipooperacion").val("agregar");
    $("#txtcodigo").val("");
    $("#txtfechapago").val(year + "-" + month + "-" + day);
    $("#txtdescripcion").val("");
    $("#txtmonto").val("");
    $("#titulomodal").text("Agregar Pago");
});

$("#myModal").on("shown.bs.modal", function () {
    $("#txtdescripcion").focus();
});


function leerDatos(codigoPago) {
    $.post(
              service+"pago.leerdatos.php",
            {p_codigo_pago: codigoPago}
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function (i, item) {
                $("#txttipooperacion").val("editar");
                $("#txtcodigo").val(item.codigo_pago);
                $("#txtfechapago").val(item.fecha_a_pagar);
                $("#txtmonto").val(item.monto);
                $("#txtdescripcion").val(item.descripcion);
                $("#cboestadomodal").val(item.estado);
                $("#titulomodal").text("Editar Pago.");
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });

}