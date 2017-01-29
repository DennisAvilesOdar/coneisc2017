var service = "../controladores/";
$(document).ready(function () {
    cargarComboTD("#cbotipodocumento", "todos");
    cargarComboTD("#cbotipodocumentomodal", "seleccione");
    cargarComboUsuarios("#cbousuarios", "todos");
    alert('cualquier mamada xD ');
    listar();
});

$("#btnfiltrar").click(function () {
        listar();
});

$("#cbotipodocumento").change(function () {
    listar();
});

$("#cboestado").change(function () {
    listar();
});

$("#cbousuarios").change(function () {
    listar();
});


function cargarComboTD(p_nombreCombo, p_tipo) {
    $.post(
            service+"tipodocumento.cargar.php"
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";
            if (p_tipo === "seleccione") {
                html += '<option value="">Seleccione un Tipo de Documento</option>';
            } else {
                html += '<option value="0">Todos los Tipos de Documentos</option>';
            }
            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_tipo_documento + '">' + item.descripcion + '</option>';
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

    var codigoTipoDocumento = $("#cbotipodocumento").val();
    if (codigoTipoDocumento === null) {
        codigoTipoDocumento = 0;
    }
    var codigoEstado = $("#cboestado").val();

    $.post(service+"documento.listar.php", {
        p_fecha1: fecha1,
        p_fecha2: fecha2,
        p_estado: codigoEstado,
        p_usuario: codigoUsuario,
        p_td: codigoTipoDocumento
    }).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>Nro. Boleta</th>';
            html += '<th>DESCRIPCION</th>';
            html += '<th>MONTO</th>';
            html += '<th>TIPO DOC.</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td>' + item.numdocu + '</td>';
                html += '<td>' + item.docu + '</td>';
                html += '<td>' + item.monto + '</td>';
                html += '<td>' + item.tipodocu + '</td>';
                html += '<td align="center">';

                if (item.estado == "Anulado") {
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" class="btn btn-success btn-xs" onclick="recuperar(' + item.coddocu + ')"><i class="fa fa-mail-reply"></i></button>';
                } else {
                    html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.coddocu + ')"><i class="fa fa-pencil"></i></button>';
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" id="tblbtneliminar' + item.coddocu + '" class="btn btn-danger btn-xs" onclick="eliminar(' + item.coddocu + ')"><i class="fa fa-close"></i></button>';
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

function recuperar(){
    swal({
        title: "ATENCÓN!",
        text: "Para recuperar este elemento comuniquese con el encargado. \n Desea ir a su perfil?",
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
                    window.open("https://www.facebook.com/messages/luis.arceparedes");
                    window.location.reload();
                }
            });
}

function eliminar(codigoDocumento) {
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
                            service+"documento.eliminar.php",
                            {
                                p_codigo_documento: codigoDocumento
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

$("#frmgrabar").submit(function(evento){
    evento.preventDefault();
    
    if (! confirm("Esta seguro de grabar los datos del producto")){
        return 0;
    }
    
    var archivo_foto = $('#txtfoto').prop('files')[0];
    
    var datos_frm = new FormData();
    datos_frm.append( "p_datosFormulario", $("#frmgrabar").serialize() );
    datos_frm.append( "p_foto", archivo_foto);
    
    $.ajax({
        url: "../controladores/documento.agregar.editar.php",
        dataType: 'text',  
        cache: false,
        contentType: false,
        processData: false,
        data: datos_frm,                         
        type: 'post',
        success: function(resultado){
            alert(resultado);
            if (resultado === "exito"){
                document.location.reload();
            }
        },
        error: function(error){
             alert(error.responseText);
        }
     });
    
    
});

/*$("#frmgrabar").submit(function (evento) {
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
                               service+"documento.agregar.editar.php",
                            {
                                p_datosFormulario: $("#frmgrabar").serialize(),
                                p_foto: $('#txtfoto').prop('files')[0]
                            }
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
});*/

$("#btnagregar").click(function () {
    $("#txttipooperacion").val("agregar");
    $("#txtcodigo").val("");
    $("#txtnumerodocumento").val("");
    $("#txtdescripcion").val("");
    $("#txtmonto").val("");
    $("#cbotipodocumentomodal").val(null);
    $("#titulomodal").text("Agregar Documento");
});

$("#myModal").on("shown.bs.modal", function () {
    $("#txtnumerodocumento").focus();
});

function leerDatos(codigoDocumento) {
    $.post(
              service+"documento.leerdatos.php",
            {p_codigo_documento: codigoDocumento}
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function (i, item) {
                $("#txttipooperacion").val("editar");
                $("#txtcodigo").val(item.codigo_documento);
                $("#txtnumerodocumento").val(item.numero_documento);
                $("#txtmonto").val(item.monto);
                $("#txtdescripcion").val(item.descripcion);
                $("#cbotipodocumentomodal").val(item.codigo_tipo_documento);
                $("#titulomodal").text("Editar Documento.");
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });

}