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
  seccion: null,
  seccion_id: null,
  codigo: null,
  cantidad: false,
  precio_sugerido: false,
  precio_final: false,
  total: false,
  precio_comentarios: false,
  resultados: false,
  resultados_container: false,
  
  
  

  /**
   *
   */
  init: function() {
    // ensure initialization only occurs once
    if (page.isInitialized || page.isInitializing) return;
    page.isInitializing = true;

    if (!$.isReady && console) console.warn('page was initialized before dom is ready.  views may not render properly.');

    // make the new button clickable
    page.field = $('#filter');

    
    page.field.on('keyup',function() {      
      valor =page.field.val();
      console.log("c="+valor);
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
      page.agregar();
    });


    $(".autocomplete_mask").on("click",".autocomplete_item",function(e) {
      e.preventDefault();
      item_id=$(this).attr("item");

      page.setProduct(page.resultados[item_id]);
    });
    

    page.resultados_container=$(".autocomplete_item_container")
    
    page.imagen =$(".show_bg"),
    page.nombre =$("#nombre"),
    page.seccion =$("#seccion"),
    page.seccion_id =$("#seccion_id"),
    page.codigo =$("#codigo"),
    page.cantidad =$("#cantidad"),
    page.precio_sugerido =$("#precio_sugerido"),
    page.precio_final =$("#precio_final"),
    page.total =$("#total"),
    page.precio_comentarios =$("#precio_comentarios"),    
      
    page.cantidad.on('keyup',function() {      
      page.update_total();      
    });
    page.precio_final.on('keyup',function() {      
      page.update_total();      
    });

      page.isInitialized = true;
      page.isInitializing = false;
    
  },

  /**
   * Fetch the collection data from the server
   * @param object params passed through to collection.fetch
   * @param bool true to hide the loading animation
   */
  search: function(valor) {
    // persist the params so that paging/sorting/filtering will play together nicely
    console.log("buscar");
    $.getJSON( "xcm/autocomplete.php", { to_find: valor } )
      .done(function( json ) {
        page.resultados=json.data.list
        list = json.data.list
        console.log(  list);
        console.log(list.length)

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
    console.log(item);
    page.resultados_container.hide();
    page.imagen.css("background-image","url(img/productos/"+item.imagen+")")
    page.nombre.val(item.nombre)
    page.seccion.val(item.seccion)
    page.codigo.val(item.codigo)
    page.cantidad.val(1)
    page.precio_sugerido.val(item.precio_sugerido)
    page.precio_final.val(item.precio_sugerido)
    page.total.val(item.precio_sugerido)
    page.comentarios.val("")
    
   },
   update_total: function()
   {
    canti= page.cantidad.val()
    preci= page.precio_final.val()
    page.total.val(canti*preci)
   },
   add_product: function()
   {
    
   }
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

