
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
            $('#ruta_embarque').html(template);
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
            $('#vendedor_embarque').html(template);
        })
    }
    function fillProductos(){
        funcion = "llenarProductos";
        $.post('../controlador/ProductoController.php',{funcion},(response)=>{
            const productos = JSON.parse(response);
            let template = '';
            productos.forEach(producto => {
                template+=`<option value = "${producto.id}">${producto.nombre}</option>`;
            });
            $('#producto_embarque').html(template);
        });   
    }
    $('#form_embarque').submit(ev=>{
         registrarEmbarque();
        

        ev.preventDefault();
     });

    function registrarEmbarque(){
        let checador_id,producto_id,ruta_id,fecha_emb,vendedor_id,kg_emb,piezas_emb,comentarios;
        checador_id = $('#id_checador').val();
        fecha_emb = $('#fecha_embarque').val();
        ruta_id = $('#ruta_embarque').val();
        vendedor_id = $('#vendedor_embarque').val();
        producto_id = $('#producto_embarque').val();
        kg_emb = $('#kilos_embarcados').val();
        piezas_emb = $('#piezas_embarcadas').val();
        comentarios = $('#comentarios_embarque').val();

        //console.log(checador_id+producto_id+ruta_id+fecha_emb+vendedor_id+kg_emb+piezas_emb+comentarios);

        funcion = "registrar_embarque";
         $.post('../controlador/EmbarqueController.php',{funcion,checador_id,producto_id,ruta_id,fecha_emb,vendedor_id,kg_emb,piezas_emb,comentarios},(response)=>{
             console.log(response);
            if(response=='add'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Embarque registrado',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                    $('#form_embarque').trigger('reset');
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya registró el embarque de ese producto',
                    showConfirmButton: false,
                    timer: 1500 })
                    jQuery.noConflict();
                    $('#form_embarque').trigger('reset');
            }
        });
    }
});