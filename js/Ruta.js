$(document).ready(function(){

    buscarRutas();
    var funcion;

/////
    //Función crear una  ruta nueva
    $('#form_crear_ruta').submit(e=>{
        let nombre_new_ruta= $('#nombre_new_ruta').val();
        funcion = 'crear_ruta';
        $.post('../controlador/RutaController.php',{nombre_new_ruta,funcion},(response)=>{
            if(response == 'add'){
                let user_mov =  $('#id_user_history').val();
                let detail_mov =  'ruta: '+nombre_new_ruta;
                let movimiento = "creó";
                historialRuta(user_mov,movimiento,detail_mov);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Ruta creada',
                    showConfirmButton: false,
                    timer: 1500 })
                $('#form_crear_laboratorio').trigger('reset');
                $('#crear_ruta').modal('hide');
                buscarRutas();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Parece que esa ruta ya existe',
                    showConfirmButton: false,
                    timer: 1500 })
                $('#crear_ruta').modal('hide');
                $('#form_crear_laboratorio').trigger('reset');
                buscarRutas();
                }
        });
        e.preventDefault();
    });
////////

    //Funcion que busca todas las rutas y las lista en una tabla en el main div
    function buscarRutas(consulta_ruta){
        funcion ='buscar_ruta';
        $.post('../controlador/RutaController.php',{consulta_ruta,funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
               template+=`
                    <tr rutaID="${ruta.id}" rutaNombre="${ruta.nombre_ruta}" rutaAvatar="${ruta.avatar_ruta}">
                        <td>${ruta.nombre_ruta}</td>
                        <td><img src="${ruta.avatar_ruta}" class="img-fluid rounded" width="70" height="70"></td>
                        <td>${ruta.nombre_ruta}</td>
                        <td>
                            <button class="avatarRuta btn btn-info" title="Cambiar imagen de ruta" type:"button" data-toggle="modal" data-target="#cambioFotoLab"><i class="far fa-image"></i></button>
                            <button class="editarRuta btn btn-success" title="Editar detalles de ruta"  type:"button" data-toggle="modal" data-target="#editar_ruta"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                    </tr>
                `;
            });
            $('#rutas_body').html(template);
        });
    }
///////
    //Función que captura el evento click de el input y busca dinamicamente entre todas las rutas
    //Función altamente relacionada con la funcion buscarRutas();
    $(document).on('keyup','#buscar_ruta',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscarRutas(valor);
        }else{
            buscarRutas();
        }
    });
//////
    
//Borrar una ruta

    $(document).on('click','.deleteRoute',(e)=>{
        funcion ="deleteRuta";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idRuta = $(elemento).attr('rutaID');
        const nombreRuta = $(elemento).attr('rutaNombre');
        const avatarRuta= $(elemento).attr('rutaAvatar');
        
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger mr-1'
        },
        buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Seguro que quieres borrar la ruta '+nombreRuta+'?',
            text: "Será borrado permanentemente",
            imageUrl:''+avatarRuta+'',
            imageWidth:100,
            imageHeight:100,
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/RutaController.php',{idRuta,funcion},(response)=>{
                    if(response=='borrado'){
                            swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'La ruta '+nombreRuta+' ha sido eliminada.',
                            'success' )
                            buscarRutas();
                        }else{
                            swalWithBootstrapButtons.fire(
                            'Error!',
                            'La ruta '+nombreRuta+' está siendo usada.',
                            'error' )
                            buscarRutas();}});
            } else if (result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'No ha sido borrado',
                'Ninguna ruta ha sido eliminada.',
                'error')
                 buscarRutas();}});
    });
///

////Captura los datos de la ruta a la que se le debe cambiar el logo
    $(document).on('click','.avatarRuta',(e)=>{
        funcion ="cambiarFotoRuta";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idRuta = $(elemento).attr('rutaID');
        const nombreRuta = $(elemento).attr('rutaNombre');
        const avatarRuta= $(elemento).attr('rutaAvatar');
        
        $('#rutaAvatar').attr('src',avatarRuta);
        $('#nombre_ruta_modal').html(nombreRuta);
        $('#funcion').val(funcion);
        $('#id_logo_ruta').val(idRuta);
    });
////Llamada al controlador y modificacion en la base de datos
    $('#formLogoRuta').submit(eve=>{
            let formData = new FormData($('#formLogoRuta')[0]);
            $.ajax({
                url:'../controlador/RutaController.php',
                type:'POST',
                data:formData,
                cache:false,
                processData:false,
                contentType:false
            }).done(function(response){
                console.log(response)
                const json = JSON.parse(response);
                if(json.alert=='edit'){
                    $('#rutaAvatar').attr('src',json.ruta);
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Foto de ruta actualizada',
                    showConfirmButton: false,
                    timer: 1500
                        })
                    $('#cambioFotoLab').modal('hide');
                    $('#formLogoRuta').trigger('reset');
                    buscarRutas();
                }else{
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Archivo incorrecto',
                    showConfirmButton: false,
                    timer: 1500
                        })
                    $('#formLogoRuta').trigger('reset');
                   buscarRutas();
                }
            }); 
             eve.preventDefault();
    });
/////
////Editar el nombre de una ruta ya existente
    $(document).on('click','.editarRuta',(e)=>{
        funcion = 'editarRuta';
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idRuta = $(elemento).attr('rutaID');
        const nombreRuta = $(elemento).attr('rutaNombre');
        $('#idEditarRuta').val(idRuta);
        $('#nombreRutaEdit').val(nombreRuta);
        
    });
    $('#form_editar_ruta').submit(e=>{
        let nombreRutaEdit= $('#nombreRutaEdit').val();
        let idRutaEdit = $('#idEditarRuta').val();    
        funcion = 'editarRuta';
        $.post('../controlador/RutaController.php',{nombreRutaEdit,idRutaEdit,funcion},(response)=>{
            if(response == 'editado'){
                let user_mov =  $('#id_user_historya').val();
                let detail_mov =  nombreRutaEdit;
                let movimiento = "modificó";
                historialRuta(user_mov,movimiento,detail_mov);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Ruta actualizada',
                    showConfirmButton: false,
                    timer: 1500 })
                $('#editar_ruta').modal('hide');
                buscarRutas();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay una ruta con ese nombre',
                    showConfirmButton: false,
                    timer: 1500
                        })
                $('#editar_ruta').modal('hide');
                buscarRutas();
            }
        });
        e.preventDefault();
    }); 
    ////
    function historialRuta(user_mov,movimiento,detail_mov){
        let objeto_mov = "ruta";
        funcion = "registrarMovimiento";
         $.post('../controlador/MovimientosController.php',{funcion,user_mov,movimiento,objeto_mov,detail_mov},(response)=>{
             console.log(response);
         });
    }
    
    
    //Fin 
    });