$(document).ready(function() {
    var funcion ;
    var usuarioActual = $('#id_usuario_actual').val();
    buscarProducto();
    buscar_usuario_actual(usuarioActual);
    searchProducto();
    fecha();
    
    
    $(document).on('keyup','#buscar_producto',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscarProducto(valor);
        }else{
            buscarProducto();
        }
    });
    ///Recupera los datos del local storage
    function recuperarLocalStorage() {
        let ruta;
        if (localStorage.getItem("ruta") === null) {
            ruta = [];
        } else {
            ruta = JSON.parse(localStorage.getItem("ruta"));
        }
        return ruta;
    }
    ///Carga la ruta elegida en el local storage
    function agregarLocalStorage(ruta) {
        let rutas;
        rutas = recuperarLocalStorage();
        rutas.push(ruta);
        localStorage.setItem("ruta", JSON.stringify(rutas));
        $(location).attr('href','../vista/adm_venta.php');
    }
    ///Vaciar el local Storage para poder cambiar de ruta
    function deleteLocalStorage() {
    localStorage.clear();
    }
    ///IMprimir la ruta elegida para trabajar
    function imprimeRuta() {
    let rutas, id_ruta;
    let rutaNombre;
    
    rutas = recuperarLocalStorage();
    console.log(rutas);
    rutas.forEach((ruta) => {
      let nombreRuta = ruta.ruta_nombre;
      $('#title_pages').html(nombreRuta);
      console.log(nombreRuta);
    });
    }
    //Buscar los datos del usuario que está registrando la información
    function buscar_usuario_actual(dato){
        funcion = 'buscar_usuario';
        $.post('../controlador/userController.php',{dato,funcion},(response)=>{
           let nombre;
           nombre = $('#id_usuario_actual').val();
           //const usuario = JSON.parse(response); 
           $('#usuario_actual').html(nombre);  
    })}
    //Obteniendo la fecha actual para poder trabajar
    function fecha() {
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;
        $('#fecha_actual').html(output);
    }
    //Buscar los productos y colocarlos en el catalogo de compra
    function searchProducto(consultaProducto){
         funcion = "buscarProducto";
        $.post('../controlador/ProductoController.php',{consultaProducto,funcion},(response)=>{
            const productos = JSON.parse(response);
            let template='';
            productos.forEach(producto =>{
                template +=`
                <div prodID="${producto.id}" prodNombre="${producto.nombre}" prodAvatar="${producto.avatar_prod}" class="align-items-center">
                    <div class="card bg-light m-1">
                        <div class="card-header text-muted border-bottom-0">
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center">
                            <!--    <img src="${producto.avatar_prod}" width="100" height="100" alt="" class="img-circle img-fluid">-->
                                <h2 class="lead"><b>${producto.nombre}</b></h2>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="agregar_producto btn btn-sm btn-danger">
                            <i class="far fa-plus-square"></i> 
                            </button>
                        </div>
                        
                    </div>
                </div>`;
            });
            $('#productos_catalogo_body').html(template);
        });
    }

    $(document).on("click","#procesar_compra",(e) =>{
        if(productosAComprar.length == 0){
            alert("No ha añadidio nada");
        }else{
            alert("Registro hecho");
        }
    });
});