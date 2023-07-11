$('.nav li').click(function() {
    
    $('li').removeClass('active'); 
    $(this).addClass('active'); 

    var id = $(this).attr('id');

    switch (id) {
        case '1':
            $('#content').html('')
            $('#content').load('partials/conductores.php');
            break;
        case '2':
            $('#content').html('')
            $('#content').load('partials/registrar-conductor.php');
            break;
    
        default:
            break;
    }

});

function cargarListaConductores(){

    $.ajax({
        url: "api/conductores/conductores-lista.php",
        method: "POST",
        dataType: "json",
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#table-lista-conductores > tbody").html('');
            //$.blockUI();
        },
        success: function (data) {
            if(data){
                
                html = '';
                
                for (var i = 0; i < data.Conductores.length; i++) {

                    html += '<tr class="">';
                        html += '<td class="text-center">';
                            html += '<a href="#" onclick="editarConductor('+data.Conductores[i].id+');" title="Editar Conductor" style="margin-right:5px;"><i class="nc-icon nc-circle-10"></i></a>';
                            switch (data.Conductores[i].id_estado) {
                                case '2':
                                    html += '<a href="#" onclick="cambiarEstadoConductor('+data.Conductores[i].id+',1);" title="Activar Conductor"><i class="nc-icon nc-simple-add"></i></a>';
                                    break;
                                default:
                                    html += '<a href="#" onclick="cambiarEstadoConductor('+data.Conductores[i].id+',2);" title="Inactivar Conductor"><i class="nc-icon nc-simple-remove"></i></a>';
                                    break;
                                }
                        html += '</td>';
                        html += '<td>' + data.Conductores[i].nombre + ' ' + data.Conductores[i].apellido + '</td>';
                        html += '<td>' + data.Conductores[i].ci + '</td>';
                        switch (data.Conductores[i].id_estado) {
                            case '1':
                                html += '<td class="text-center"><div class="alert alert-success"><span>Activo</span></div></td>';
                                break;
                            case '2':
                                html += '<td class="text-center"><div class="alert alert-warning"><span>Inactivo</span></div></td>';
                                break;
                            case '3':
                                html += '<td class="text-center"><div class="alert alert-danger" style="background-color: #000000;"><span>Lista Negra</span></div></td>';
                                break;
                            default:
                                break;
                        }
                        html += '<td class="text-center">';
                            html += '<a href="#" onclick="verHistorialConductor('+data.Conductores[i].id+'); return false;" title="Ver Historial Conductor" style="margin-right:5px;"><i class="nc-icon nc-paper"></i></a>';
                            html += '<a href="#" onclick="agregarHistorialConductor('+data.Conductores[i].id+',\'rminarro\'); return false;" title="Agregar Historial Conductor"><i class="nc-icon nc-book-bookmark"></i></a>';
                        html += '</td>';
                    html += '</tr>';
                }
                
                $("#table-lista-conductores > tbody").append(html);
            } else {
                $("#table-lista-conductores > tbody").html('<tr class="align-middle"><td colspan="5" height="60">Sin conductores</td></tr>');
            }

            var table = $('#table-lista-conductores').DataTable({
                language: {
                    url: 'assets/js/plugins/es-ES.json',
                },
            });
            
        }
    });

}

function verHistorialConductor(id) {

    var datos = {};
    datos["id"] = id;

    $.ajax({
        url: "api/conductores/historial-conductores.php",
        method: "POST",
        dataType: "json",
        data: datos,
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#historialConductorModal > .modal-dialog > .modal-content > .modal-body").html('');
            $("#historialConductorModalLabel").html('');
            //$.blockUI();
        },
        success: function (data) {
            if(data){
                
                html = '';
                html += '<div class="table-responsive">';
                    html += '<table id="table-lista-historial" class="table">';
                        html += '<thead class=" text-primary">';
                            html += '<tr>';
                                html += '<th>Motivo</th>';
                                html += '<th>Observación</th>';
                                html += '<th>Fecha creación</th>';
                                html += '<th>Última modificación</th>';
                            html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';
                            if(data.ConductorHistorialCount > 0){
                                for (var i = 0; i < data.ConductorHistorialCount; i++) {
                                    html += '<tr>';
                                        html += '<td>'+data.ConductorHistorial[i].motivo+'</td>';
                                        html += '<td>'+data.ConductorHistorial[i].observacion+'</td>';
                                        html += '<td>'+data.ConductorHistorial[i].fecha_creacion+'</td>';
                                        html += '<td>'+data.ConductorHistorial[i].fecha_modificacion+'</td>';
                                    html += '</tr>';
                                }
                            }else{
                                html += '<tr class="align-middle"><td class="text-center" colspan="4" height="60">No existe historial del conductor</td></tr>';
                            }
                        html += '<tbody>';
                    html += '</table>';
                html += '</div>';
                
                if(data.ConductorHistorialCount > 0){
                    $("#historialConductorModalLabel").append('Historial del conductor: '+data.ConductorHistorial[0].nombre_completo);
                }else{
                    $("#historialConductorModalLabel").append('Historial del conductor vacio.');
                }           

                $("#historialConductorModal > .modal-dialog > .modal-content > .modal-body").append(html);
            
            }else{
                $("#table-lista-historial > tbody").html('<tr class="align-middle"><td class="text-center" colspan="4" height="60">No existe historial del conductor</td></tr>');
            }
            $('#historialConductorModal').modal();
        }
    });
}

async function agregarHistorialConductor(id_condutor,usuario) {

    $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html('');

    const motivo = await cargarMotivos();

    select = '';
    select += '<select class="form-control" id="id_motivo" name="id_motivo">';
        if(motivo.ConductorMotivosCount > 0){
            for (var i = 0; i < motivo.ConductorMotivosCount; i++) {
                select += '<option value="'+motivo.ConductorMotivos[i].id+'">'+motivo.ConductorMotivos[i].descripcion;
            }
        }else{
            select += '<option>No existen motivos cargados</option>';
        }
    select += '</select>';

    html = '';

    html += '<input type="hidden" id="id_conductor" name="id_conductor" value='+id_condutor+'>';
    html += '<input type="hidden" id="id_estado" name="id_estado" value="1">';
    html += '<input type="hidden" id="creado_por" name="creado_por" value='+usuario+'>';
    html += '<div class="form-group">';
        html += '<label for="id_motivo" class="col-form-label">Motivo:</label>';
        html += select;
    html += '</div>';
    html += '<div class="form-group">';
        html += '<label for="observacion" class="col-form-label">Observación:</label>';
        html += '<textarea id="observacion" class="form-control" name="observacion" rows="4" cols="50"></textarea>';
    html += '</div>';
    
    $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").append(html);
    $('#agregarHistorialConductorModal').modal();

}

function guardarHistorialConductor(){

    $.ajax({
        url: "api/conductores/agregar-historial-conductor.php",
        method: "POST",
        dataType: "json",
        data: $('#form-agregar-historial-conductor').serialize(),
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html('');
            //$.blockUI();
        },
        success: function (data) {

            mensaje = '<div class="alert alert-success"><span>'+data.mensaje+'</span></div>';
            $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html(mensaje);
            
            $("#btn-guardar-historial-conductor").hide();

        }
    });
}

async function cargarMotivos(){

    const res = await $.ajax({
        url: "api/conductores/motivos.php",
        method: "POST",
        dataType: "json",
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            //$.blockUI();
        },
        success: function (data) {
            return data;
        }
    });

    return res;

}

function cambiarEstadoConductor(id_conductor,id_estado){

    var datos = {};
    datos["id_conductor"] = id_conductor;
    datos["id_estado"] = id_estado;
    datos["modificado_por"] = 'rminarro';

    $.ajax({
        url: "api/conductores/cambiar-estado-conductor.php",
        method: "POST",
        dataType: "json",
        data: datos,
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            //$("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html('');
            //$.blockUI();
        },
        success: function (data) {
            if(data.status == 'ok'){
                mensaje = '<div class="alert alert-success alert-dismissible fade show"><button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close"><iclass="nc-icon nc-simple-remove"></i></button><span>'+data.mensaje+'"</span></div>';
            }else{
                mensaje = '<div class="alert alert-danger alert-dismissible fade show"><button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close"><i class="nc-icon nc-simple-remove"></i></button><span>'+data.mensaje+'"</span></div>';
            }
            $("#alerts").html(mensaje);
        }
    });
}