function number_format(valor)
{
  return parseFloat(valor).toFixed(2)
}
/**
 * View logic for Ventas
 */

/**
 * application logic specific to the Venta listing page
 */
var page = {

  field: null,
  imagen:null,
  nombre: null,
  id_hidden: null,
  seccion: null,
  seccion_id: null,
  codigo: null,
  cantidad: null,
  precio_sugerido: null,
  precio_final: null,
  total_venta: null,
  comentarios: null,
  resultados: null,
  resultados_container: false,
  product_array: null,
  resumen_item_container: null,
  resumen_item_total: null,
  resumen_total: null,
  resumen_item_pago: null,
  resumen_item_cambio: null,
  busy:false,
  
  

  /**
   *
   */
  init: function() {
    // ensure initialization only occurs once
    if (page.isInitialized || page.isInitializing) return;
    page.isInitializing = true;
    page.isInitialized = true;
    if (!$.isReady && console) console.warn('page was initialized before dom is ready.  views may not render properly.');

    // make the new button clickable
    page.field = $('#filter');

    
    page.field.on('keyup',function() {      
      valor =page.field.val();
      
      if ( valor.length> 3)
      {
        page.search(valor);
      }
        
    });

    // when the model dialog is closed, let page know and reset the model view
    $('#ventaDetailDialog').on('hidden',function() {
      $('#modelAlert').html('');
      page.dialogIsOpen = false;
    });

    // save the model when the save button is clicked
    $("#addVentaButton").click(function(e) {
      e.preventDefault();
      page.add_product();
    });



    $("#closeVentaButton").click(function(e) {
      e.preventDefault();
      page.cerrar_venta();
    });


    $(".autocomplete_mask").on("click",".autocomplete_item",function(e) {
      e.preventDefault();
      item_id=$(this).attr("item");

      page.setProduct(page.resultados[item_id]);
    });
    

    page.resultados_container= $("#autocomplete_item_container")
    
    page.imagen =$(".show_bg"),
    page.nombre =$("#nombre"),
    page.id_hidden =$("#id_product_hidden"),
    page.seccion =$("#seccion"),
    page.seccion_id =$("#seccion_id"),
    page.codigo =$("#codigo"),
    page.cantidad =$("#cantidad"),
    page.precio_sugerido =$("#precio_sugerido"),
    page.precio_final =$("#precio_final"),
    page.total =$("#total"),
    page.comentarios =$("#comentarios"),    
    page.resumen_item_container=$("#resumen_item_container"),    
    page.resumen_item_total=$("#resumen_item_total .resumen_item_precio_total"),
    page.resumen_item_pago=$("#pago"),
    page.resumen_item_cambio=$("#resumen_item_cambio .resumen_item_precio_total"),

    page.cantidad.on('keyup',function() {      
      page.update_total();      
    });
    page.precio_final.on('keyup',function() {      
      page.update_total();      
    });
    page.resumen_item_pago.on('keyup',function() {      
      page.update_cambio();      
    });

    page.resumen_item_container.on("click",".resumen_item_quitar",function(e) {
      e.preventDefault();
      item_id=$(this).attr("item");

      page.del_product(item_id);
    });

    page.product_array=new Array();
      
      page.isInitializing = false;
    
  },

  /**
   * Fetch the collection data from the server
   * @param object params passed through to collection.fetch
   * @param bool true to hide the loading animation
   */
  search: function(valor) {
    // persist the params so that paging/sorting/filtering will play together nicely
    
    $.getJSON( "xcm/autocomplete.php", { to_find: valor } )
      .done(function( json ) {
        page.resultados=json.data.list
        list = json.data.list
        

        if(list.length ==0)
        {
          page.resultados_container.html("<a class='autocomplete_item'><p> No existe el artículo</p></a>");
        }
        else        
        {
          cont =0
          page.resultados_container.html("");
          while(cont<list.length)
          {
            context = list[cont];
            html ='<a href="#" class="autocomplete_item" item="'+cont+'"><p>'+context.nombre+'</p></a>'            
            page.resultados_container.append(html)
            cont++;
          }
          
        }
        if(list.length==1)
          page.setProduct(page.resultados[0]);
        else          
          page.resultados_container.show();
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        console.log( "Request Failed: " + err );
    });
  },

  /**
   * show the dialog for editing a model
   * @param model
   */
   setProduct: function(item)
   {
    
    page.resultados_container.hide();
    page.imagen.css("background-image","url(img/productos/"+item.foto+")")
    page.nombre.val(item.nombre)
    page.id_hidden.val(item.id)
    page.seccion.val(item.seccion)
    page.codigo.val(item.codigo)
    page.cantidad.val(1)
    page.precio_sugerido.val(number_format(item.precio_sugerido))
    page.precio_final.val(number_format(item.precio_sugerido))
    page.total.val(number_format(item.precio_sugerido))
    page.comentarios.val("")
    
   },
   update_total: function()
   {
    canti= page.cantidad.val()
    preci= page.precio_final.val()
    page.total.val(number_format(canti*preci))

   },
   add_product: function()
   {
    nombre = page.nombre.val()
    id = page.id_hidden.val()
    canti= page.cantidad.val()
    preci= page.precio_final.val()
    total = canti*preci
    page.product_array.push({nombre:nombre,id:id,cantidad:canti,precio:preci,total:total});
    page.update_venta();
   },
   del_product: function(item)
   {
    
    page.product_array.splice(item,1);
    page.update_venta();
   },
   update_venta:function ()
   {
    page.resumen_item_container.html("");
    total=0
    for(var i=0;i<page.product_array.length;i++)
    {
      producto=page.product_array[i];
      cadena='<div class="resumen_item">'+
      '<a class="resumen_item_quitar" href="#" item="'+i+'"><i class="icon-remove"></i></a>  '+
      '<div class="resumen_item_nombre">'+producto.nombre+'</div>  '+
      '<div class="resumen_item_cantidad">'+producto.cantidad+'</div>'+
      '<div class="resumen_item_precio_final">'+number_format(producto.precio)+'</div>  '+
      '<div class="resumen_item_precio_total">'+number_format(producto.total)+'</div>  '+
    '</div>';
      page.resumen_item_container.append(cadena);
      total+=producto.total
    }
    page.total_venta= total
    page.resumen_item_total.html(number_format(total));
    page.update_cambio();
   },
   update_cambio: function()
   {
    
    pago= page.resumen_item_pago.val()
    cambio= pago-page.total_venta
    if(cambio<0)
      page.resumen_item_cambio.addClass("error") ;
    else
      page.resumen_item_cambio.removeClass("error") ;
    page.resumen_item_cambio.html(number_format(cambio))
   },
   cerrar_venta: function()
   {
      console.log(page.product_array);
      comentario=page.comentarios.val();
      if(page.product_array.length<1)
      {
        alert("no hay productos agregados");
        return false
      }
      if (page.busy)
      {
        return false;
      }
      page.busy=true;

      var request = $.ajax({
        url: "xcm/save.php",
        type: "POST",
        data: {venta:page.product_array,comentario:comentario},        
      });
       
      request.done(function( msg ) {
        console.log(msg);
        error=msg.data.error;
        console.log(error);
        if(error.ID==0)
        {
          page.restart();
        }
      });
       
      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
   },
   restart: function()
   {
    page.imagen.css("background-image","none")
    page.nombre.val("")
    page.id_hidden.val("")
    page.seccion.val("")
    page.codigo.val("")
    page.cantidad.val("")
    page.precio_sugerido.val("")
    page.precio_final.val("")
    page.total.val("")
    page.comentarios.val("")

    page.resumen_item_total.html("");
    page.resumen_item_container.html("");
    page.resumen_item_cambio.html("");
    page.resumen_item_pago.val("");
    page.field.val("");
    page.busy=false;
   },
  showDetailDialog: function(m) {

    // show the modal dialog
    $('#ventaDetailDialog').modal({ show: true });

    // if a model was specified then that means a user is editing an existing record
    // if not, then the user is creating a new record
    page.venta = m ? m : new model.VentaModel();

    page.modelView.model = page.venta;

    if (page.venta.id == null || page.venta.id == '') {
      // this is a new record, there is no need to contact the server
      page.renderModelView(false);
    } else {
      app.showProgress('modelLoader');

      // fetch the model from the server so we are not updating stale data
      page.venta.fetch({

        success: function() {
          // data returned from the server.  render the model view
          page.renderModelView(true);
        },

        error: function(m, r) {
          app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'modelAlert');
          app.hideProgress('modelLoader');
        }

      });
    }

  },

  /**
   * Render the model template in the popup
   * @param bool show the delete button
   */
  renderModelView: function(showDeleteButton) {
    page.modelView.render();

    app.hideProgress('modelLoader');

    // initialize any special controls
    try {
      $('.date-picker')
        .datepicker()
        .on('changeDate', function(ev){
          $('.date-picker').datepicker('hide');
        });
    } catch (error) {
      // this happens if the datepicker input.value isn't a valid date
      if (console) console.log('datepicker error: '+error.message);
    }
    
    $('.timepicker-default').timepicker({ defaultTime: 'value' });

    // populate the dropdown options for productoId
    // TODO: load only the selected value, then fetch all options when the drop-down is clicked
    var productoIdValues = new model.ProductoCollection();
    productoIdValues.fetch({
      success: function(c){
        var dd = $('#productoId');
        dd.append('<option value=""></option>');
        c.forEach(function(item,index) {
          dd.append(app.getOptionHtml(
            item.get('id'),
            item.get('nombre'), // TODO: change fieldname if the dropdown doesn't show the desired column
            page.venta.get('productoId') == item.get('id')
          ));
        });
        
        if (!app.browserSucks()) {
          dd.combobox();
          $('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
        }

      },
      error: function(collection,response,scope) {
        app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
      }
    });

    // populate the dropdown options for cajaId
    // TODO: load only the selected value, then fetch all options when the drop-down is clicked
    var cajaIdValues = new model.CajaCollection();
    cajaIdValues.fetch({
      success: function(c){
        var dd = $('#cajaId');
        dd.append('<option value=""></option>');
        c.forEach(function(item,index) {
          dd.append(app.getOptionHtml(
            item.get('id'),
            item.get('nombre'), // TODO: change fieldname if the dropdown doesn't show the desired column
            page.venta.get('cajaId') == item.get('id')
          ));
        });
        
        if (!app.browserSucks()) {
          dd.combobox();
          $('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
        }

      },
      error: function(collection,response,scope) {
        app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
      }
    });


    if (showDeleteButton) {
      // attach click handlers to the delete buttons

      $('#deleteVentaButton').click(function(e) {
        e.preventDefault();
        $('#confirmDeleteVentaContainer').show('fast');
      });

      $('#cancelDeleteVentaButton').click(function(e) {
        e.preventDefault();
        $('#confirmDeleteVentaContainer').hide('fast');
      });

      $('#confirmDeleteVentaButton').click(function(e) {
        e.preventDefault();
        page.deleteModel();
      });

    } else {
      // no point in initializing the click handlers if we don't show the button
      $('#deleteVentaButtonContainer').hide();
    }
  }

  
  
};

