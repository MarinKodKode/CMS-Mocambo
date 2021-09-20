$(document).ready(function() {
    var funcion ;
    buscarProducto();
    
     $('#form_crear_producto').submit(ev=>{
         let nombre = $('#nombre_new_producto').val();
         funcion = "crear_nuevo_producto";
         $.post('../controlador/ProductoController.php',{funcion,nombre},(response)=>{
            if(response=='add'){
                let user_mov =  $('#id_history_user').val();
                let detail_mov =  nombre;
                let movimiento = "creó";
                historialProducto(user_mov,movimiento,detail_mov);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Producto creado',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                $('#form_crear_producto').trigger('reset');
                $('#modal_crear_prodcuto').modal('hide');
                buscarProducto();
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Parece que ese producto ya existe',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                $('#modal_crear_prodcuto').modal('hide');
                $('#form_crear_producto').trigger('reset');
                buscarProducto();
            }
         });

        ev.preventDefault();
     });
     //Funcion buscar producto
     function buscarProducto(consultaProducto){
         funcion = "buscarProducto";
        $.post('../controlador/ProductoController.php',{consultaProducto,funcion},(response)=>{
            const productos = JSON.parse(response);
            let template='';
            productos.forEach(producto =>{
                template +=`
                <div prodID="${producto.id}" prodNombre="${producto.nombre}" prodAvatar="${producto.avatar_prod}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                    <h1 class = "badge badge-secondary">Quesos Camacho</h1>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${producto.nombre}</b></h2>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle"></i></span> Producto Lácteo</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${producto.avatar_prod}" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="avatar_prod btn btn-sm bg-blue" type="button" data-toggle="modal" data-target="#cambioFotoProducto">
                      <i class="fas fa-image"></i>
                    </button>
                <!--    <button class="delete_prod btn btn-sm btn-danger">
                      <i class="fas fa-trash-alt"></i> 
                    </button>-->
                  </div>
                </div>
              </div>
            </div>`;
            });
            $('#div_productos').html(template);
        });
     }
     $(document).on('keyup','#buscar_producto',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscarProducto(valor);
        }else{
            buscarProducto();
        }
    });
    //Funcion cambiar imagen del
    $(document).on('click','.avatar_prod',(e)=>{
        funcion ="cambiarLogoProducto";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id_producto = $(elemento).attr('prodID');
        const nombre_producto = $(elemento).attr('prodNombre');
        const avatar_producto= $(elemento).attr('prodAvatar');

        $('#prodAvatar').attr('src',avatar_producto);
        $('#nombre_prod_modal').html(nombre_producto);
        $('#funcion').val(funcion);
        $('#id_logo_prod').val(id_producto);
    });
    $('#formLogoProd').submit(eve=>{
            let formData = new FormData($('#formLogoProd')[0]);
            $.ajax({
                url:'../controlador/ProductoController.php',
                type:'POST',
                data:formData,
                cache:false,
                processData:false,
                contentType:false
            }).done(function(response){
                
                const json = JSON.parse(response);
              if(json.alert=='edit'){
                    $('#prodAvatar').attr('src',json.ruta);
                    
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Foto de ruta actualizada',
                    showConfirmButton: false,
                    timer: 1500
                        })
                    jQuery.noConflict();
                    $('#cambioFotoProducto').modal('hide');
                    $('#formLogoProd').trigger('reset');
                    buscarProducto();
                }else{
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Archivo incorrecto',
                    showConfirmButton: false,
                    timer: 1500
                        })
                    $('#formLogoProd').trigger('reset');
                   buscarProducto();
                }
            }); 
            eve.preventDefault();
    });
    //Funcion borrar producto
     $(document).on('click','.delete_prod',(e)=>{
        funcion ="deleteProducto";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const CB_producto_id = $(elemento).attr('prodID');
        const CB_producto_nombre = $(elemento).attr('prodNombre');
        const CB_producto_avatar= $(elemento).attr('prodAvatar');
        const swalWithBootstrapButtons = Swal.mixin({customClass: {confirmButton: 'btn btn-success',cancelButton: 'btn btn-danger mr-1'},buttonsStyling: false});

        swalWithBootstrapButtons.fire({
        title: '¿Seguro que quieres borrar '+CB_producto_nombre+' de tu lista de productos?',
        text: "Será borrado permanentemente",
        imageUrl:''+CB_producto_avatar+'',
        imageWidth:100,
        imageHeight:100,
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/ProductoController.php',{CB_producto_id,funcion},(response)=>{
                    if(response=='borrado'){
                    swalWithBootstrapButtons.fire('Eliminado!','El producto '+CB_producto_nombre+' ha sido eliminado.','success')
                        buscarProducto();
                    }else{
                        swalWithBootstrapButtons.fire('Error!','El producto '+CB_producto_nombre+' está siendo usado.','error')
                        buscarProducto();
                    }
                });
            }else if (result.dismiss === Swal.DismissReason.cancel) 
                {
                    swalWithBootstrapButtons.fire('No ha sido borrado','Ningun producto ha sido eliminado.','error')
                    buscar_prod();
                }
                })       
    });
    function historialProducto(user_mov,movimiento,detail_mov){
        let objeto_mov = "producto";
        funcion = "registrarMovimiento";
         $.post('../controlador/MovimientosController.php',{funcion,user_mov,movimiento,objeto_mov,detail_mov},(response)=>{
             console.log(response);
         });
    }
});