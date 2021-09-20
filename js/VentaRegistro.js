$(document).ready(function() {
    //Variables globales
    var funcion ;
    var usuarioActual = $('#id_usuario_actual').val();
    $('.select2').select2();
    //Funciones globales
    fecha();
    searchProducto();
    buscar_usuario_actual(usuarioActual);
    fillRutas();
    recuperarLocalStorage();
    listarLocalStorage();
    calculateTotal();
    


    //Buscar los datos del usuario que está registrando la información (Lista)
    function buscar_usuario_actual(dato){
        funcion = 'buscar_usuario';
        $.post('../controlador/userController.php',{dato,funcion},(response)=>{
           let nombre;
           nombre = $('#id_usuario_actual').val();
           //const usuario = JSON.parse(response); 
           $('#usuario_actual').html(nombre);  
    })
    }
    //Poner las rutas en el selector principal
    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#rutada').html(template);
        });
        
    }
    //Poner las rutas en el selector principal
    function fillClientes(){
        funcion = "llenarClientes";
        let cliente_ruta= $('#rutada').val();
        let idRuta;
        idRuta =  $('#rutada').val();
        console.log(cliente_ruta);
        $.post('../controlador/ClienteController.php',{funcion,idRuta},(response)=>{
            const clientes = JSON.parse(response);
            let template = '';
            clientes.forEach(cliente => {
                template+=`<option value = "${cliente.id}">${cliente.nombre}</option>`;
            });
            $('#clientela').html(template);
        });
        
    }
    ////    
    ///Recupera los datos del local storage
    function recuperarLocalStorage() {
        let productos;
        if (localStorage.getItem("productos") === null) {
            productos = [];
        } else {
            productos = JSON.parse(localStorage.getItem("productos"));
        }
        return productos;
    }
    ///Carga la ruta elegida en el local storage
    function agregarLocalStorage(producto) {
        let productos;
        productos = recuperarLocalStorage();
        productos.push(producto);
        localStorage.setItem("productos", JSON.stringify(productos));
    }
    ///Vaciar el local Storage para poder cambiar de ruta
    function deleteLocalStorage() {
    localStorage.clear();
    }
    
    
    //Obteniendo la fecha actual para poder trabajar
    function fecha() {
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        //var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;
        var output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/'  + d.getFullYear();
        $('#fecha_actual').html(output);
        $('#fecha_actuale').val(output);
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
    $(document).on('click','.punto',(e)=>{ 
        let eleccion;
        //eleccion = $('#rutada').val();
        fillClientes();
    });
    $(document).on('click','.limpiar',(e)=>{ 
        $("#lista-compra").empty();
    });
    
    //Listando los productos que van a ser registrados
    $(document).on("click", ".agregar_producto", (e) => {
    funcion = "agregar_producto";
    const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement;

    const productoID = $(elemento).attr("prodID");
    const productoNombre = $(elemento).attr("prodNombre");
    const productoAvatar = $(elemento).attr("prodAvatar");

    const producto = {
        productoID :productoID,
        productoNombre : productoNombre,
        productoAvatar : productoAvatar,
        piezas : 0,
        cantidad_kg : 0,
        precio_unitario : 0,
        piezas_devueltas : 0,
        kilos_devueltos : 0,
    };
    let IDProducto;
    let productos;
    productos = recuperarLocalStorage();
    productos.forEach((prod) => {
      if (prod.productoID === producto.productoID) {
        IDProducto = prod.productoID;
      }
    });
    if (IDProducto === producto.productoID) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Ya has agregado ese producto!",
        footer: "Solo puedes agregar una vez un mismo producto",
        });
    } else {      
      $("#lista-compra").empty();
      agregarLocalStorage(producto);
      listarLocalStorage();
      
    }
    });

    // function listarLocalStorage1() {
    // let productos, id_producto;
    // productos = recuperarLocalStorage();
    // //console.log(productos);
    // funcion = "buscar_producto_id";
    // productos.forEach((producto) => {
    //   id_producto = producto.productoID;
    //   console.log(id_producto);
    //   $.post("../controlador/ProductoController.php",{ funcion, id_producto },(response) => {
          
    //       let templateCompra = "";
    //       let json = JSON.parse(response);
    //       console.log(json.id)
    //       templateCompra = `
    //                 <tr prodId="${json.id}" prodPrecio="${json.nombre}">
    //                     <td>${json.nombre}</td> 
    //                     <td>
    //                         <input type="number" min="1" class="form-control piezas" value="${producto.piezas}"></input>
    //                     </td>
    //                     <td>
    //                         <input type="number" min="1" class="form-control cantidad_kg" value="${producto.cantidad_kg}"></input>
    //                     </td>
    //                     <td class="precio">
    //                         <input type="number" min="1" class="form-control precio_unitario" value="${producto.precio_unitario}"></input>
    //                     </td>
    //                     <td>
    //                         <input type="number" min="1" class="form-control piezas_devueltas" value="${producto.piezas_devueltas}"></input>
    //                     </td>
    //                     <td>
    //                         <input type="number" min="1" class="form-control kilos_devueltos" value="${producto.kilos_devueltos}"></input>
    //                     </td>
    //                     <td class="subtotales">
    //                         <h5>0</h5>
    //                     </td>
    //                     <td><button class="borrar_eleccion btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
    //                 </tr>
    //             `;
               
    //       $("#lista-compra").append(templateCompra);
    //     }
    //   );
    // });
    // }

    async function listarLocalStorage(){
        let productos;
        productos = recuperarLocalStorage();
        funcion = "carryProduct";
        const response = await fetch('../controlador/ProductoController.php',{
            method : 'POST',
            headers:{'Content-Type' : 'application/x-www-form-urlencoded'},
            body : 'funcion=' + funcion + '&&productos=' + JSON.stringify(productos)
        })
        let resultado = await response.text();
        $("#lista-compra").append(resultado);
    }


    $(document).on("click", ".borrar_eleccion", (e) => {
    const elemento = $(this)[0].activeElement.parentElement.parentElement;
    const ID = $(elemento).attr("prodId");
    elemento.remove();
    borrarProductoStorage(ID);
    calculateTotal();
    
     });
    //Borra un producto no requerido del local storage
    function borrarProductoStorage(ID) {
    let productos;
    productos = recuperarLocalStorage();
    productos.forEach(function (producto, indice) {
      if (producto.productoID === ID) {
        productos.splice(indice, 1);
      }
    });
    localStorage.setItem("productos", JSON.stringify(productos));
    }//Fin funcioón

    //Calcula dinamicamente los subtotales de cada producto
    $("#cpo").keyup((e) => {
    
    let id, precio_unitario,cantidad_kg,piezas_devueltas,llevo,kilos_devueltos, productq, productose, montos, precio;
    let piezas;
    productq = $(this)[0].activeElement.parentElement.parentElement;
    id = $(productq).attr("prodId");
    piezas = productq.querySelector(".piezas").value;
    cantidad_kg = productq.querySelector(".cantidad_kg").value;
    precio_unitario = productq.querySelector(".precio_unitario").value;
    piezas_devueltas = productq.querySelector(".piezas_devueltas").value;
    kilos_devueltos = productq.querySelector(".kilos_devueltos").value;
    
    //console.log(cantidad_kg + ' '+ vendio_kg+' '+ llevo + ' ' + d_a + ' ' + dev )
    montos = document.querySelectorAll(".subtotales");
    
    productose = recuperarLocalStorage();
    productose.forEach(function (prod, indice) {
      if (prod.productoID === id) {
        prod.piezas = piezas;  
        prod.precio_unitario = precio_unitario;
        prod.cantidad_kg = cantidad_kg;
        prod.piezas_devueltas = piezas_devueltas;
        prod.kilos_devueltos = kilos_devueltos;
        
        montos[indice].innerHTML = `<h5>${prod.cantidad_kg* prod.precio_unitario}</h5>`;
      }
    });
    localStorage.setItem("productos", JSON.stringify(productose));
    calculateTotal();
    });//Fin funcion

    //Calcular el total pedido
     function calculateTotal() {
        let productos;
        let total = 0;
    productos = recuperarLocalStorage();
    productos.forEach((producto) => {
      let subtotalProducto = Number(producto.precio_unitario * producto.cantidad_kg);
      total = total + subtotalProducto;
    });
    let totale;
          totale = total.toFixed(2);
          $("#total_pedido").val(totale);
    
    }//Fin funcion

    //Obtener total de  los metodos de pago
    function totalMetodoPago() {
        let pagoEfectivo, pagoTransferencia, pagoDeposito, pagoCheque, totalMetodos;
        let customer;

        
        pagoEfectivo = $('#m_efectivo').val();
        pagoTransferencia = $('#m_transferencia').val();
        pagoDeposito = $('#m_deposito').val();
        pagoCheque = $('#m_cheque').val();

        if(pagoEfectivo  == ""){
            pagoEfectivo = $('#m_efectivo').val("0");

        }
        if(pagoTransferencia  == ""){
            pagoTransferencia = $('#m_transferencia').val("0");

        }
        if(pagoDeposito  == ""){
            pagoDeposito = $('#m_deposito').val("0");

        }
        if(pagoCheque  == ""){
            pagoCheque = $('#m_cheque').val("0");

        }
        
        let pEfectivo = parseFloat(pagoEfectivo);
        let pTransferencia = parseFloat(pagoTransferencia);
        let pDeposito = parseFloat(pagoDeposito);
        let pCheque = parseFloat(pagoCheque);
        totalMetodos =Number(pEfectivo+pTransferencia+pDeposito+pCheque);
        $('#pago_final').val(totalMetodos);
        

        
    }


    //Valida si la nota es pagada o no 
    function validacionEstadoNota() {
        let totalPedido, totalPagado;
        let pPedido, pPagado;
        let faltante,faltant;
        totalPedido = $('#total_pedido').val();
        totalPagado = $('#pago_final').val();
        
        
        pPedido = parseFloat(totalPedido);
        pPagado = parseFloat(totalPagado);  
        faltante = Number(pPedido - pPagado);
        faltant = faltante.toFixed(2);

        $('#faltante_pago_final').val(faltant); 

        if(pPagado == pPedido){
            $('#id_estado_pago').val('1');
            $('#estado_nota_final').html('Pagado totalmente');
        }else if(pPagado == 0){
            $('#id_estado_pago').val('2');
            $('#estado_nota_final').html('No pagado');
        }else if(pPagado < pPedido && pPagado != 0){
            $('#id_estado_pago').val('3');
            $('#estado_nota_final').html('Pagado parcialmente');
        }else if(pPagado>pPedido){
            $('#m_efectivo').val('0');
            $('#m_transferencia').val('0');
            $('#m_deposito').val('0');
            $('#m_cheque').val('0');
            $('#pago_final').val('0');
            $('#faltante_pago_final').val('0');
            $('#estado_nota_final').html('Sin cargar pago');
            $('#id_estado_pago').val('2');

            Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Debe hacer una nota aparte!",
            footer: "Si desea abonar a una nota anterior vaya a la sección de editar notas",
          });
        }
        


    }

    $(document).on('click','#cargarPago',(e)=>{ 
        totalMetodoPago();
        validacionEstadoNota();
        cargarDeudaAcumulada();
        deudaActualizada();

    });
    $(document).on("click", "#procesar_compra", (e) => {
    procesarVenta();
    });

    /*Valida que toda la informaci+on requerida exista,
     que no existan errores dentro de el ingreso de los datos*/
    function procesarVenta() {
    let compra_ruta, compra_cliente, compra_folio, compra_capturista;
    
    compra_capturista = $('#id_capturista').val();
    compra_ruta    = $('#rutada').val();
    compra_cliente = $("#clientela").val();
    compra_folio   = $('#folio_venta').val();
    fecha_venta   = $('#fecha_venta').val();

    if (recuperarLocalStorage().length == 0) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Aún no has añadido productos para registrar!",
        footer: "No hay productos para registrar",
      });
    } else if (compra_folio == "") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Debes añadir el folio de la venta!",
        footer: "Especifica el folio",
      });
    }else if (fecha_venta == "") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Debes añadir la fecha de la venta!",
        footer: "Especifica la fecha en la que se realizó esa venta",
      });
    } else if (compra_cliente == null) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "No has seleccionado el cliente!",
        footer: "Especifica el cliente",
      });
    } else {
        registrarVenta(compra_ruta,compra_cliente,compra_capturista,compra_folio,fecha_venta);
        Swal.fire({
            icon: "success",
            title: "Compra registrada",
            text: "la compra ha sido registrada",
        }).then(function () {
              deleteLocalStorage();
              location.reload();
          });
    }
    }//Fin funcion

    /*Una vez validados los campos de el formulario, registramos la venta */
    function registrarVenta(v_ruta,v_cliente,v_capturista,v_folio,v_venta) {

        let totalPedido;
        let t_efectivo,t_transferencia,t_deposito,t_cheque;
        let informacionAdicional;
        let totalFinalPagado;
        let deudaVenta;
        let estado_venta;

        let productosRegistrar,json;
        funcion = "registrarVentas";

        informacionAdicional = $('#adicional_compra').val();
        totalPedido = $('#total_pedido').val();
        t_efectivo = $('#m_efectivo').val();
        t_transferencia = $('#m_transferencia').val();
        t_deposito = $('#m_deposito').val();
        t_cheque = $('#m_cheque').val();
        totalFinalPagado = $('#pago_final').val();
        deudaVenta = $('#faltante_pago_final').val();
        estado_venta = $('#id_estado_pago').val();

        productosRegistrar = recuperarLocalStorage();
        json = JSON.stringify(productosRegistrar);

        $.post("../controlador/RegistroController.php",{ funcion, 
            v_ruta,
            v_cliente,
            v_capturista,
            v_folio,
            v_venta,
            t_efectivo,
            t_transferencia,
            t_deposito,
            t_cheque,
            totalPedido,
            totalFinalPagado,
            deudaVenta,
            estado_venta,
            informacionAdicional,
            json },(response) => {
                console.log(response);
            });
    }

  //Cargar la deuda acumulada del cliente que estamos trabajando
    function cargarDeudaAcumulada() {
        let clienteActual;
        clienteActual = $("#clientela").val();
        funcion = "cargarDeudaAcumulada";
        $.post('../controlador/RegistroController.php',{clienteActual,funcion},(response)=>{
            let respuesta = JSON.parse(response);
            $("#deuda_acumulada").val(respuesta); 
        });
    }
    
    //Mostar el calculo de la nueva deuda
    function deudaActualizada() {
        let clienteActual;
        let faltante, deudaActuali,finalActualizada,d_acumulada;
        clienteActual = $("#clientela").val();
        faltante = $("#faltante_pago_final").val(); 
        funcion = "cargarDeudaAcumulada";

        $.post('../controlador/RegistroController.php',{clienteActual,funcion},(response)=>{
            d_acumulada = JSON.parse(response);
            deudaActuali = parseFloat(d_acumulada + faltante).toFixed(2);
            console.log(deudaActuali);
        });
        

        console.log(d_acumulada);
        console.log(faltante);
        console.log(finalActualizada);

    }




    
    
    
    
    

});