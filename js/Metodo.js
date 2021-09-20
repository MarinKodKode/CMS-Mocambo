
$(document).ready(function() {
    var funcion ;
    buscarMetodo();
    
     $('#form_crear_metodo').submit(ev=>{
         let new_metodo_nombre = $('#nombre_new_metodo').val();
         funcion = "crearMetodo";
         $.post('../controlador/MetodoController.php',{funcion,new_metodo_nombre},(response)=>{
            if(response=='add'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Método creado',
                    showConfirmButton: false,
                    timer: 1500 })
                $('#form_crear_metodo').trigger('reset');
                jQuery.noConflict();
                $('#nuevo_metodo_pago').modal('hide');
                buscarMetodo();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya existe ese metodo de pago',
                    showConfirmButton: false,
                    timer: 2500 })
                    jQuery.noConflict();
                $('#nuevo_metodo_pago').modal('hide');
                $('#form_crear_metodo').trigger('reset');
                buscarMetodo();
            }
            ev.preventDefault();
         });
        buscarMetodo();
        ev.preventDefault();
     });
     //Funcion buscar cliente
     function buscarMetodo(){
         funcion = "buscarMetodo";
        $.post('../controlador/MetodoController.php',{funcion},(response)=>{
            const metodos = JSON.parse(response);
            let template='';
            metodos.forEach(metodo =>{
                template +=`
                 <tr metodoID="${metodo.id}" metodoNombre="${metodo.nombre_metodo}" metodoAvatar="${metodo.avatar_metodo}">
                        <td>${metodo.nombre_metodo}</td>
                        <td>
                            <button class="deleteMetodo btn btn-danger" title="Borrar método de pago"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
            `;
            });
            $('#metodos_body').html(template);
        });
     }
    ////
    //Borrar un metodo de pago
    $(document).on('click','.deleteMetodo',(e)=>{
        funcion ="deleteMetodo";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const idMetodo = $(elemento).attr('metodoID');
        const nombreMetodo = $(elemento).attr('metodoNombre');
        const avatarMetodo= $(elemento).attr('metodoAvatar');
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger mr-1'
        },
        buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Seguro que quieres borrar el metodo '+nombreMetodo+'?',
            text: "Será borrado permanentemente",
            imageUrl:''+avatarMetodo+'',
            imageWidth:100,
            imageHeight:100,
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/MetodoController.php',{idMetodo,funcion},(response)=>{
                    console.log(response);
                    if(response=='borrado'){
                            swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'La ruta '+nombreMetodo+' ha sido eliminada.',
                            'success' )
                            buscarMetodo();
                        }else{
                            swalWithBootstrapButtons.fire(
                            'Error!',
                            'La ruta '+nombreCliente+' está siendo usada.',
                            'error' )
                            buscarMetodo();}});
            } else if (result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'No ha sido borrado',
                'Ningun cliente ha sido eliminado.',
                'error')
                 buscarMetodo();}});
    });
//////
});