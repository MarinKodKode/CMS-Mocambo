$(document).ready(function(){


    var tipo_usuario_gu = $('#tipo_usuario_gu').val();
    if(tipo_usuario_gu==2){
      $('#button_crear_usuario').hide();
    }

    buscarDatosADM();
    var funcion;
    function buscarDatosADM(consulta){
        funcion = 'buscar_usuario_adm';
        $.post('../controlador/userController.php',{consulta,funcion},(response)=>{
           const gu_usuarios = JSON.parse(response);
           let template = '';
           gu_usuarios.forEach(usuario=>{
               template+=`
                    <div usuarioID="${usuario.id_usuario}" usuarioNombre="${usuario.nombre}" usuarioAvatar="${usuario.avatar}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">`;
                  //${usuario.tipo}
                  if(usuario.id_tipo_usuario==1){
                    template +=`<h1 class = "badge badge-danger">${usuario.tipo_usuario}</h1>`;
                  }else if(usuario.id_tipo_usuario==2){
                    template +=`<h1 class = "badge badge-warning">${usuario.tipo_usuario}</h1>`;
                  }else{
                    template +=`<h1 class = "badge badge-info">${usuario.tipo_usuario}</h1>`;
                  }
               template +=` </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${usuario.nombre} ${usuario.apellidos}</b></h2>
                      <p class="text-muted text-sm"><b>Información: </b> ${usuario.adicional}  </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span> DNI: ${usuario.dni}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono #: ${usuario.telefono}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo: ${usuario.correo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone-alt"></i></span> Teléfono referencia: ${usuario.telefono_ref}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${usuario.avatar}" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">`;
                  if(tipo_usuario_gu==1){
                    if(usuario.id_tipo_usuario>1){
                      template+=`
                      <!--button class="borrar_usuario btn btn-danger" type="button" data-toggle="modal" data-target="#seguridadAsc">
                      <i class="fas fa-window-close mr-1"></i> Eliminar
                    </button>-->
                      `;
                    }
                   if(usuario.id_tipo_usuario==3){
                      template+=`
                      <button class="ascender btn btn-info" type="button" data-toggle="modal" data-target="#seguridadAsc">
                      <i class="fas fa-sort-amount-up "></i> Ascender
                    </button>
                      `;
                      
                    } 
                    if(usuario.id_tipo_usuario==2){
                      template+=`
                      <button class=" descender btn btn-warning" type="button" data-toggle="modal" data-target="#seguridadAsc">
                      <i class="fas fa-sort-amount-down "></i> Descender
                    </button>
                      `;
                    }
                    
                  }
                  else{
                    if(tipo_usuario_gu==2 && usuario.id_tipo_usuario!=2 &&usuario.id_tipo_usuario != 1){
                         template+=`
                      <button class="borrar_usuario btn btn-danger" type="button" data-toggle="modal" data-target="#seguridadAsc">
                      <i class="fas fa-window-close mr-1"></i> Eliminar
                    </button>
                      `;
                    }
                  }
                    template+=`
                  </div>
                </div>
              </div>
            </div>
               `;
           })
           $('#div_usuarios').html(template);
        });
    }

    $(document).on('keyup','#buscar_usuario',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscarDatosADM(valor);
        }else{
            buscarDatosADM();
        }
    });
    /*Crea un usuario con la información del modal "Crear nuevo usuario"*/
    $('#form_crear_usuario').submit(e=>{
        let new_user_nombre = $('#nombre_new_user').val();
        let new_user_apellido = $('#apellido_new_user').val();
        let new_user_telefono = $('#telefono_new_user').val();
        let new_user_dni = $('#dni_new_user').val();
        let new_user_password = $('#password_new_user').val();
        funcion = 'create_new_user';
        $.post('../controlador/userController.php',{new_user_nombre,new_user_apellido,new_user_dni,new_user_telefono,new_user_password,funcion},(response)=>{
          console.log(response);
          if(response == 'add'){
                let user_mov =  $('#history_gu').val();
                let detail_mov = new_user_nombre;
                let movimiento = "Dió de alta";
                historialGestionUsuarios(user_mov,movimiento,detail_mov);
            Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Alta de usuario exitosa.',
                    showConfirmButton: false,
                    timer: 1500 })
              jQuery.noConflict();
              $('#crear_usuario').modal('hide');
              $('#form_crear_usuario').trigger('reset');
               buscarDatosADM();
          }else{
             Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un usuario con el mismo DNI',
                    showConfirmButton: false,
                    timer: 2500 })
            jQuery.noConflict();
            $('#crear_usuario').modal('hide');
            $('#form_crear_usuario').trigger('reset');
          }
        });
        e.preventDefault();
    });

    $(document).on('click','.ascender',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id_user = $(elemento).attr('usuarioID');
      
      funcion = 'ascender';
      $('#id_user').val(id_user);
      $('#funcion_adm').val(funcion);
    });
    $(document).on('click','.descender',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id_user = $(elemento).attr('usuarioID');
      funcion = 'descender';
      $('#id_user').val(id_user);
      $('#funcion_adm').val(funcion);
      $('#nombre_user').val(funcion);
    });
    $(document).on('click','.borrar_usuario',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id_user = $(elemento).attr('usuarioID');
      funcion = 'borrarUsuario';
      $('#id_user').val(id_user);
      $('#funcion_adm').val(funcion);
    })

    $('#formSecurity').submit(e=>{
      let pass = $('#confirmpass').val();
      let id_usuario = $('#id_user').val();
      funcion =  $('#funcion_adm').val();
      $.post('../controlador/userController.php',{pass,id_usuario,funcion},(response)=>{
        if(response == 'ascendido' || response=='descendido' || response=='borrado'){
          
                let user_mov =  $('#history_gus').val();
                let detail_mov = 'Usuario'+id_usuario;
                let movimiento = "Cambió preferencias";
                historialGestionUsuarios(user_mov,movimiento,detail_mov);
            Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Datos actualizados',
                    showConfirmButton: false,
                    timer: 1500 })
            jQuery.noConflict();
            $('#formSecurity').trigger('reset');
            $('#seguridadAsc').modal('hide');
            buscarDatosADM();
        }else{
             Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'La contraseña es incorrecta',
                    showConfirmButton: false,
                    timer: 1500
                        }) 
             $('#formSecurity').trigger('reset');
             buscarDatosADM();
        }
        buscarDatosADM();
      });
     e.preventDefault();
    });
    function historialGestionUsuarios(user_mov,movimiento,detail_mov){
        let objeto_mov = "usuario";
        funcion = "registrarMovimiento";
         $.post('../controlador/MovimientosController.php',{funcion,user_mov,movimiento,objeto_mov,detail_mov},(response)=>{
             console.log(response);
         });
    }

    
})