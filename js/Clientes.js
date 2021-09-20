
$(document).ready(function() {
    var funcion ;
    $('.select2').select2();
    //rellenar_laboratorios();
    //rellenar_provedores();
    buscarCliente();
    fillRutas();
    
     $('#form_crear_cliente').submit(ev=>{
         let new_cliente_nombre = $('#nombre_new_cliente').val();
         let new_cliente_telefono = $('#telefono_new_cliente').val();
         let new_cliente_correo = $('#correo_new_cliente').val();
         let new_cliente_adicional = $('#adicional_new_cliente').val();
         let new_cliente_ruta = $('#rutase').val();
         funcion = "crearCliente";
         $.post('../controlador/ClienteController.php',{funcion,new_cliente_nombre,new_cliente_telefono,new_cliente_correo,new_cliente_adicional,new_cliente_ruta},(response)=>{
             console.log(response);
            if(response=='add'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente creado',
                    showConfirmButton: false,
                    timer: 1500 })
                $('#form_crear_cliente').trigger('reset');
                jQuery.noConflict();
                $('#modal_crear_cliente').modal('hide');
                buscarCliente();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un cliente con ese nombre en la misma ruta',
                    showConfirmButton: false,
                    timer: 2500 })
                    jQuery.noConflict();
                $('#modal_crear_cliente').modal('hide');
                $('#form_crear_cliente').trigger('reset');
                buscarCliente();
            }
            ev.preventDefault();
         });
        buscarCliente();
        ev.preventDefault();
     });
     //Funcion buscar cliente
     function buscarCliente(consultaCliente){
         funcion = "buscarCliente";
        $.post('../controlador/ClienteController.php',{consultaCliente,funcion},(response)=>{
            const clientes = JSON.parse(response);
            let template='';
            clientes.forEach(cliente =>{
                template +=`
                 <tr clienteID="${cliente.cliente_id}" clienteNombre="${cliente.cliente_nombre}" clienteAvatar="${cliente.cliente_ruta}" avatar="${cliente.cliente_avatar}" clienteTelefono="${cliente.cliente_telefono}" clienteAdicional="${cliente.cliente_adicional}" clienteRutaID="${cliente.cliente_ruta_id}" clienteCorreo="${cliente.cliente_correo}">
                        <td>${cliente.cliente_nombre}</td>
                        <td>${cliente.cliente_telefono}</td>
                        <td>${cliente.cliente_ruta}</td>
                        <td>
                            <button class="detalleCliente btn btn-info" title="Cambiar imagen de ruta" type:"button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-info-circle"></i></button>
                            <button class="editarCliente btn btn-success" title="Editar detalles de ruta"  type:"button" data-toggle="modal" data-target="#modal_editar_cliente"><i class="fas fa-pencil-alt"></i></button>
                            <button class="deleteCliente btn btn-danger" title="Borrar ruta"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
            `;
            });
            $('#clientes_body').html(template);
        });
     }
     $(document).on('keyup','#buscar_cliente',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscarCliente(valor);
        }else{
            buscarCliente();
        }
     });
    ////
    //Borrar una ruta

    $(document).on('click','.deleteCliente',(e)=>{
        funcion ="deleteCliente";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idCliente = $(elemento).attr('clienteID');
        const nombreCliente = $(elemento).attr('clienteNombre');
        const avatarCliente= $(elemento).attr('avatar');
        console.log(avatarCliente);
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger mr-1'
        },
        buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Seguro que quieres borrar el cliente '+nombreCliente+'?',
            text: "Será borrado permanentemente",
            imageUrl:''+avatarCliente+'',
            imageWidth:100,
            imageHeight:100,
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/ClienteController.php',{idCliente,funcion},(response)=>{
                    console.log(response);
                    if(response=='borrado'){
                            swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'La ruta '+nombreCliente+' ha sido eliminada.',
                            'success' )
                            buscarCliente();
                        }else{
                            swalWithBootstrapButtons.fire(
                            'Error!',
                            'La ruta '+nombreCliente+' está siendo usada.',
                            'error' )
                            buscarCliente();}});
            } else if (result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'No ha sido borrado',
                'Ningun cliente ha sido eliminado.',
                'error')
                 buscarCliente();}});
    });
//////
    //Funcion editar cliente
    $(document).on('click','.editarCliente',(e)=>{
        funcion ="editarCliente";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idCliente = $(elemento).attr('clienteID');
        const nombreCliente = $(elemento).attr('clienteNombre');
        const telefonoCliente = $(elemento).attr('clienteTelefono');
        const correoCliente = $(elemento).attr('clienteCorreo');
        const adicionalCliente = $(elemento).attr('clienteAdicional');
        const rutaCliente = $(elemento).attr('clienteRutaID');

        $('#funcion').val(funcion);
        $('#id_edit_cliente').val(idCliente);
        $('#edit_cliente_nombre').val(nombreCliente);
        $('#edit_cliente_telefono').val(telefonoCliente);
        $('#edit_cliente_correo').val(correoCliente);
        $('#edit_cliente_adicional').val(adicionalCliente);
        $('#edit_cliente_rutase').val(rutaCliente).trigger('change');
    });

    $('#V_form_editar_cliente').submit(e=>{
        let edit_cliente_id= $('#id_edit_cliente').val();
        let edit_cliente_nombre= $('#edit_cliente_nombre').val();
        let edit_cliente_telefono= $('#edit_cliente_telefono').val();
        let edit_cliente_correo= $('#edit_cliente_correo').val();
        let edit_cliente_adicional= $('#edit_cliente_adicional').val();
        let edit_cliente_ruta= $('#edit_cliente_rutase').val();
        funcion = 'editarCliente';
        $.post('../controlador/ClienteController.php',{edit_cliente_id,edit_cliente_nombre,edit_cliente_telefono,edit_cliente_correo,edit_cliente_adicional,edit_cliente_ruta,funcion},(response)=>{
            console.log(response);
           if(response == 'edit'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente actualizado',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                $('#modal_editar_cliente').modal('hide');
                $('#V_form_editar_cliente').trigger('reset');
                buscarCliente();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un cliente con los mismos datos en esta ruta',
                    showConfirmButton: false,
                    timer: 1500
                        })
                        jQuery.noConflict();
                $('#modal_editar_cliente').modal('hide');
                $('#V_form_editar_cliente').trigger('reset');
                buscarCliente();
            }
        });
        e.preventDefault();

    });
//////
//////
    //Funcion detalle cliente
    $(document).on('click','.detalleCliente',(e)=>{
        funcion ="detalleCliente";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        
        const det_nombreCliente = $(elemento).attr('clienteNombre');
        const det_telefonoCliente = $(elemento).attr('clienteTelefono');
        const det_correoCliente = $(elemento).attr('clienteCorreo');
        const det_adicionalCliente = $(elemento).attr('clienteAdicional');
        const det_rutaCliente = $(elemento).attr('clienteAvatar');

        $('#funcion').val(funcion);
        //$('#id_edit_cliente').val(idCliente);
        $('#det_cliente').html(det_nombreCliente);
        $('#det_telefono').html(det_telefonoCliente);
        $('#det_correo').html(det_correoCliente);
        $('#det_adicional').html(det_adicionalCliente);
        $('#det_ruta').html(det_rutaCliente);
    });
    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#rutase').html(template);
            $('#edit_cliente_rutase').html(template);
        });
        
     }
    ////


    


});