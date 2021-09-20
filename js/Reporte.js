$(document).ready(function(){
    buscar_usuario_actual();
    fillRutas();
    var funcion;
    fecha();
    $('.select2').select2();

    //Poner las rutas en el selector principal
    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#rutadad').html(template);
        });
        
    }
    //Obteniendo la fecha actual para poder trabajar
    function fecha() {
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;
        $('#fecha_reporte').html(output);
    }
    //Ubica al usuario que esta haciendo el reporte
    function buscar_usuario_actual(){
        let nombre = $('#nombre_usuario_reporta').val();
        $('#usuario_reporte').html(nombre);
    }
    $(document).on('click','#generarReporteBTN',(e)=>{ 
        let rutaReporte,fechaReporte;
        let date = new Date().toLocaleString();
        $('#fecha_reporte').html(date);
        rutaReporte = $('#rutadad').val();
        fechaReporte = $('#fecha_ventas_reporte').val();
        
        getNameRoute();

        if(fechaReporte == ''){
            Swal.fire({
                icon: "error",
                title: "No has seleccionado una fecha para el reporte",
                text: "Debes seleccionar la fecha de la que necesitas el reporte",
            });
        }else{
        totalesProductos(rutaReporte,fechaReporte);
        totalesProductosSecondary(rutaReporte,fechaReporte);
        totalesIngresados(rutaReporte,fechaReporte)
        }
    });
    $(document).on('click','#generateReport',(e)=>{ 
        let rutaReporte,fechaReporte;
        fechaReporte = $('#fecha_ventas_reporte').val();

         if(fechaReporte == ''){
            Swal.fire({
                icon: "error",
                title: "No has seleccionado una fecha para el reporte",
                text: "Debes seleccionar la fecha de la que necesitas el reporte",
            });
        }else{
            let date = new Date().toLocaleString();
            $('#fecha_reporte').html(date);
            window.print();
        
        }
    });
    

    function totalesProductos(id_ruta,fecha_reporte){
         funcion = "totalesProductos";
        $.post('../controlador/VentaProducto.php',{id_ruta,fecha_reporte,funcion},(response)=>{
            const totalesProducto = JSON.parse(response);
            let template='';
            totalesProducto.forEach(totale =>{
                template +=`
                 <tr>
                        <td class="text-black font-weight-bold">${totale.producto_nombre}</td>
                        <td>${totale.total_pzas_vend}</td>
                        <td>${totale.total_kg_vend}</td>
                        <td>${totale.total_pzas_dev}</td>
                        <td>${totale.total_kilos_dev}</td>
                        <td><input type="number" value="0" class="form-control"></td>
                        <td><input type="number" value="0" class="form-control"></td>
                        <td>${totale.sobtotal_producto}</td>
                    </tr>
            `;
            });
            $('#totalesProductoBody').html(template);
        });
     }
    function totalesProductosSecondary(id_ruta,fecha_reporte){
         funcion = "totalesProductos";
        $.post('../controlador/VentaProducto.php',{id_ruta,fecha_reporte,funcion},(response)=>{
            const totalesProducto = JSON.parse(response);
            let template='';
            totalesProducto.forEach(totale =>{
                let kilos_v = totale.total_kg_vend;
                let total_m = totale.sobtotal_producto;
                let kv = parseFloat(kilos_v);
                let tm = parseFloat(total_m);
                let precioPromedio = Number(tm/kv).toFixed(2);
                template +=`
                 <tr>
                        <td>${totale.producto_nombre}</td>
                        <td>${totale.sobtotal_producto}</td>
                        <td>${totale.total_kg_vend}</td>
                        <td>${precioPromedio}</td>
                    </tr>
            `;
            });
            $('#totalesProductoBodySecondary').html(template);
        });
     }
    function totalesIngresados(id_ruta,fecha_reporte){
        funcion = "totalesIngresados";
        $.post('../controlador/RegistroController.php',{id_ruta,fecha_reporte,funcion},(response)=>{
            //console.log(response);
            let totalesIngresadoz = JSON.parse(response);

            totalesIngresadoz.forEach(total =>{
                $('#r_efectivo').val(total.total_efectivo);
                $('#r_transferencia').val(total.total_transferencia);
                $('#r_deposito').val(total.total_deposito);
                $('#r_cheque').val(total.total_cheque);
                $('#r_total').val(total.total_ruta);
            });


        });

    }

    function getNameRoute() {

        funcion = 'searchSpecificItemById';
        let id_ruta = $('#rutadad').val();
        $.post('../controlador/RutaController.php',{id_ruta,funcion},(response)=>{
            let data = JSON.parse(response);
            data.forEach(dataObject =>{
                $('#ruta_show').html(dataObject.nombre_ruta);
            });
        });
    }
    
    });