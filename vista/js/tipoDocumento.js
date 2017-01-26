$(document).ready(function () {
    listar();
});
alert(service);
$("#btnagregar").click(function () {
    $("#txttipooperacion").val("agregar");
    $("#txtcodigo").val("");
    $("#txtdescripcion").val("");
    $("#titulomodal").text("Agregar nuevo Tipo de Documento.");
});


$("#myModal").on("shown.bs.modal", function () {
    $("#txtdescripcion").focus();
});

function listar() {
    $.post(service+"tipodocumento.cargar.php", {}).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>TIPO DE DOCUMENTO</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td align="center">' + item.codigo_tipo_documento + '</td>';
                html += '<td>' + item.descripcion + '</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_tipo_documento + ')"><i class="fa fa-pencil"></i></button>';
                html += '&nbsp;&nbsp;';
                if (item.estado) {
                    html += '<button type="button" disabled="true" id="tblbtneliminar' + item.codigo_tipo_documento + '" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_tipo_documento + ')"><i class="fa fa-close"></i></button>';
                } else {
                    html += '<button type="button" id="tblbtneliminar' + item.codigo_tipo_documento + '" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_tipo_documento + ')"><i class="fa fa-close"></i></button>';
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
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
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
    }, function (isConfirm) {
        if (isConfirm) { 
            $.post(
                    //aqui va la direccion de la web service para agregar un tipo de documento
                    "",
                    {p_datosFormulario: $("#frmgrabar").serialize()}
            ).done(function (resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal("Exito", datosJSON.mensaje, "success");
                    $("#btncerrar").click(); 
                    listar();
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

function leerDatos(codigoTipoDocumento) {
    $.post(
            //aqui va la URL del web service de leer Tipos de documento por su codigo
            "",
            {p_codigoTipoDocumento: codigoTipoDocumento}
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function (i, item) {
                $("#txttipooperacion").val("editar");
                $("#txtcodigo").val(item.codigo_tipo_documento);
                $("#txtdescripcion").val(item.descripcion);
                $("#titulomodal").text("Editar Marca.");
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function eliminar(codigoTipoDocumento) {
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
                            //aqui va el URL del web service para eliminar un tipo de documento
                            "",
                            {
                                codigoTipoDocumento: codigoTipoDocumento
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