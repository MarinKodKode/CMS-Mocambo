
$(document).ready(function() {
    var funcion ;
    $('.select2').select2();
    fillRutas();
    fillVendedores();
    fillProductos();

    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#ruta_llegada').html(template);
        });
     }
    function fillVendedores(){
        funcion = "llenarVendedores";
        $.post('../controlador/VendedorController.php',{funcion},(response)=>{
            const vendedores = JSON.parse(response);
            let template = '';
            vendedores.forEach(vendedor => {
                template+=`<option value = "${vendedor.id}">${vendedor.nombre}</option>`;
            });
            $('#vendedor_llegada').html(template);
        });   }

    function fillProductos(){
        funcion = "llenarProductos";
        $.post('../controlador/ProductoController.php',{funcion},(response)=>{
            const productos = JSON.parse(response);
            let template = '';
            productos.forEach(producto => {
                template+=`<option value = "${producto.id}">${producto.nombre}</option>`;
            });
            $('#producto_llegada').html(template);
        });   
    }
    $('#form_llegadas').submit(ev=>{
         registrarLlegada();
        

        ev.preventDefault();
     });
    function registrarLlegada(){
        let checador_id,producto_id,ruta_id,fecha_arr,vendedor_id,kg_arr,piezas_arr,comentarios;
        checador_id = $('#id_checador_arr').val();
        fecha_arr = $('#fecha_llegada').val();
        ruta_id = $('#ruta_llegada').val();
        vendedor_id = $('#vendedor_llegada').val();
        producto_id = $('#producto_llegada').val();
        kg_arr = $('#kilos_devueltos').val();
        piezas_arr = $('#piezas_devueltas').val();
        comentarios = $('#comentarios_llegada').val();

        //console.log(checador_id+producto_id+ruta_id+fecha_arr+vendedor_id+kg_arr+piezas_arr+comentarios);

        funcion = "registrar_llegada";
         $.post('../controlador/LlegadaController.php',{funcion,checador_id,producto_id,ruta_id,fecha_arr,vendedor_id,kg_arr,piezas_arr,comentarios},(response)=>{
             console.log(response);
            if(response=='add'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Embarque registrado',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                    $('#form_llegadas').trigger('reset');
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya registró el embarque de ese producto',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                    $('#form_llegadas').trigger('reset');
            }
        });
    }
});