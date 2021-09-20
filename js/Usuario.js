$(document).ready(function(){
    
    
    var funcion = '';
    var id_usuario = $('#id_user').val();
    buscar_usuario(id_usuario);
    var edit = false;

    function buscar_usuario(dato){
        funcion = 'buscar_usuario';
        $.post('../controlador/userController.php',{dato,funcion},(response)=>{
            
            let nombre  = '';
            let apellidos  = '';
            let dni  = '';
            let tipo  = '';
            let telefono  = '';
            let telefono_ref  = '';
            let correo  = '';
            let info  = '';

            const usuario = JSON.parse(response);
            

            //Hooks JSon and PHP
            nombre+=`${usuario.nombre}`;
            apellidos+=`${usuario.apellidos}`;
            dni+=`${usuario.dni}`;
            if(usuario.tipo== 1){
                    tipo +=`<h1 class = "badge badge-danger">${usuario.tipo_desc}</h1>`;
                  }else if(usuario.tipo== 2){
                    tipo +=`<h1 class = "badge badge-warning">${usuario.tipo_desc}</h1>`;
                  }else{
                    tipo +=`<h1 class = "badge badge-info">${usuario.tipo_desc}</h1>`;
                  }       
            telefono+=`${usuario.telefono}`;
            telefono_ref+=`${usuario.phone}`;
            correo+=`${usuario.correo}`;
            info+=`${usuario.info}`;
            //Hooks HTML and DataBase
            $('#nombre_us').html(nombre);
            $('#apellidos_us').html(apellidos);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);
            $('#telefono_us').html(telefono);
            $('#correo_us').html(correo);
            $('#phone_us').html(telefono_ref);
            $('#info_us').html(info);
            $('#changeAvatar').attr('src',usuario.avatar);
            $('#mainCardAvatar').attr('src',usuario.avatar);
            $('#nav_img').attr('src',usuario.avatar);
            $('#modal_pass_img').attr('src',usuario.avatar);
        })}

    $(document).on('click','.edita',(_e)=>{

        securityMark();
        
        funcion = 'capturar_datos';
        edit = true;
        $.post('../controlador/userController.php',{id_usuario,funcion},(response)=>{
            const usuario = JSON.parse(response);
            $('#telefono').val(usuario.telefono);
            $('#phone_form').val(usuario.telefono_ref);
            $('#correo').val(usuario.correo);
            $('#informacion').val(usuario.info);
        })

    });

    //1
    $(document).on( 'click', '.actualiza',(e)=>
    {
        
        if(edit){
            let telefono = $('#telefono').val();
            let telefono_referencia = $('#phone_form').val();
            let correo = $('#correo').val();
            let informacion = $('#informacion').val();
            funcion  ='editar_usuario';
            console.log(id_usuario);
            $.post('../controlador/userController.php',{funcion,id_usuario,telefono,telefono_referencia,correo,informacion},(response)=>{
                if(response == 'editado'){
                    $('#form-usuario').trigger('reset');
                }
                buscar_usuario(id_usuario);
                })
            updateMark();
            //e.preventDefault();
        }else{
            blankMark()
            //e.preventDefault();
        }
        //e.preventDefault();
        
    });//End 1

    //Change passwrod function
    $('#editarDatosFormularioPasswordChange').submit(ev=>{
        let oldpass = $('#formOldPasswordChange').val();
        let newpass = $('#formNewPasswordChange').val();
        funcion = 'cambiarConstrasena';
        $.post('../controlador/userController.php',{id_usuario,funcion,oldpass,newpass},(response)=>{
            console.log(response);
            if(response=='not'){
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Contraseña actualizada',
                    showConfirmButton: false,
                    timer: 1500
                        }).then(function () {
                        location.reload();});
                    jQuery.noConflict();
            }else if(response=='updated'){
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al actualizar la contraseña',
                    showConfirmButton: false,
                    timer: 1500
                        }).then(function () {
                        location.reload();});
                    jQuery.noConflict();
            }
        });

        ev.preventDefault();
    })

    //Cambiar foto de perfil
    $('#editarDatosFormularioPhotoChange').submit(eve=>{
            let formData = new FormData($('#editarDatosFormularioPhotoChange')[0]);
            $.ajax({
                url:'../controlador/userController.php',
                type:'POST',
                data:formData,
                cache:false,
                processData:false,
                contentType:false
            }).done(function(response){
                const json  = JSON.parse(response);
                if(json.alert=='edit'){
                    $('#mainCardAvatar').attr('src',json.ruta);
                    $('#nav_img').attr('src',json.ruta);
                    $('#editarDatosFormularioPhotoChange').trigger('reset');
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Foto de perfil actualizada',
                    showConfirmButton: false,
                    timer: 1500
                        }).then(function () {
                        location.reload();});
                    jQuery.noConflict();
                    buscar_usuario(id_usuario);
                }else{
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Parece que el formato de archivo es incorrecto',
                    showConfirmButton: false,
                    timer: 1500
                        }).then(function () {
                        location.reload();});
                    jQuery.noConflict();
                    $('#editarDatosFormularioPhotoChange').trigger('reset');
                }
            }); 
             eve.preventDefault();
    })
});

function securityMark(){
   alert("Precacución está a punto de editar datos personales, toda actividad que haga quedará registrada.");
 
}
function updateMark(){
   alert("Sus datos han sido actualizados.");
 
}
function blankMark(){
   alert("No se pueden guardar los datos.");
 
}