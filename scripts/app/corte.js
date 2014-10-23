jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
/**
 * View logic for Empleados
 */

/**
 * application logic specific to the Empleado listing page
 */
var page = {

  // empleados: new model.EmpleadoCollection(),
  // collectionView: null,
  // empleado: null,
  // modelView: null,
  // isInitialized: false,
  // isInitializing: false,

  // fetchParams: { filter: '', orderBy: '', orderDesc: '', page: 1 },
  // fetchInProgress: false,
  // dialogIsOpen: false,
  elid: null,
  eltipo: null,
  /**
   *
   */
  init: function()
  {

    // // ensure initialization only occurs once
    if (page.isInitialized || page.isInitializing) return;
      page.isInitialized = true;
      page.isInitializing = false;
    $("#loader").hide();
    try {
      $('.date-picker')
        .datepicker()
        .on('changeDate', function(ev){
          console.log($('.date-picker').datepicker({ dateFormat: 'yyyy-mm-dd' }).val());
          console.log($('#fecha').val());
          window.location.href="./control/"+($('#fecha').val()).replace(/-/g,"_");
          $('.date-picker').datepicker('hide');
        });
    } catch (error) {
      // this happens if the datepicker input.value isn't a valid date
      if (console) console.log('datepicker error: '+error.message);
    }
    
    $('.timepicker-default').timepicker({ defaultTime: 'value' });
    
    $(':checkbox').click(function(e){
      
      

      tipo=$(this).attr("class")
      page.eltipo=tipo
      empleado=$(this).data("id")
      fecha=$(this).data("date")
      page.elid= empleado

      if($(this).attr("checked")!=undefined)
      {
        checado=1
      }
      else
        checado=0
      

      
      if(checado==1)
      {
        $("#contenido").attr("data-tipo",tipo);
        $("#contenido").attr("data-empleado",empleado);
        $("#contenido").attr("data-fecha",fecha);
        $("#contenido").attr("data-checado",checado);
        $("#contenido").val("");
        page.showDetailDialog();
      }
      else
      {
        $.ajax({
          type: "POST",
          url: "getupdate.php",
          data: { tipo: tipo, id: empleado,fecha:fecha,checado: checado  }
        })
          .done(function( msg ) {
            $("#"+empleado).html(msg)
          }); 
      }
      
      

      
    });

    $("#saveButton").click(function(e) {
      e.preventDefault();
      tipo= $("#contenido").attr("data-tipo");
      empleado= $("#contenido").attr("data-empleado");
      fecha= $("#contenido").attr("data-fecha");
      checado= $("#contenido").attr("data-checado");
      texto= $("#contenido").val();
      $.ajax({
        type: "POST",
        url: "getupdate.php",
        data: { tipo: tipo, id: empleado,fecha:fecha,checado: 1,descr:texto  }
      })
        .done(function( msg ) {
          $("#"+empleado).html(msg)
          page.hideDetailDialog();
        });
      
    });
    $("#cancelButton").click(function(e) {
      e.preventDefault();
      $("#"+page.eltipo+"_"+page.elid).attr("checked",false);
      
      page.hideDetailDialog();
    });
    $("#filter").on("keyup",function(event)
    {
      event.preventDefault();
      cadena= $(this).val();
      if(cadena.length>0)
      {
        $(".filterby").hide();
        $("tr:regex(class,.*"+cadena+"*)").each(function()
        {
          if($(this).hasClass("filterby"))
          {
            $(this).show(); 
          }
          
        });
      }
      else
      {
        $(".filterby").show();
      }
      console.log("cadena="+cadena);
      
    });

    $(".ver_total").on("click",function(event)
    {
        event.preventDefault();
        var elid= $(this).attr("ti");
        console.log(elid);
        //showControlDialog(elid);
        $('#controlDialog'+elid).modal({ show: true });
      });
    
    // if (!$.isReady && console) console.warn('page was initialized before dom is ready.  views may not render properly.');

    // // make the new button clickable
    // $("#newEmpleadoButton").click(function(e) {
    //  e.preventDefault();
    //  page.showDetailDialog();
    // });

    // // let the page know when the dialog is open
    // $('#empleadoDetailDialog').on('show',function(){
    //  page.dialogIsOpen = true;
    // });

    // // when the model dialog is closed, let page know and reset the model view
    // $('#empleadoDetailDialog').on('hidden',function(){
    //  $('#modelAlert').html('');
    //  page.dialogIsOpen = false;
    // });

    // // save the model when the save button is clicked
    // $("#saveEmpleadoButton").click(function(e) {
    //  e.preventDefault();
    //  page.updateModel();
    // });

    // // initialize the collection view
    // this.collectionView = new view.CollectionView({
    //  el: $("#empleadoCollectionContainer"),
    //  templateEl: $("#empleadoCollectionTemplate"),
    //  collection: page.empleados
    // });

    // // initialize the search filter
    // $('#filter').change(function(obj){
    //  page.fetchParams.filter = $('#filter').val();
    //  page.fetchParams.page = 1;
    //  page.fetchEmpleados(page.fetchParams);
    // });
    
    // // make the rows clickable ('rendered' is a custom event, not a standard backbone event)
    // this.collectionView.on('rendered',function(){

    //  // attach click handler to the table rows for editing
    //  $('table.collection tbody tr').click(function(e) {
    //    e.preventDefault();
    //    var m = page.empleados.get(this.id);
    //    page.showDetailDialog(m);
    //  });

    //  // make the headers clickable for sorting
  //    $('table.collection thead tr th').click(function(e) {
  //      e.preventDefault();
    //    var prop = this.id.replace('header_','');

    //    // toggle the ascending/descending before we change the sort prop
    //    page.fetchParams.orderDesc = (prop == page.fetchParams.orderBy && !page.fetchParams.orderDesc) ? '1' : '';
    //    page.fetchParams.orderBy = prop;
    //    page.fetchParams.page = 1;
  //      page.fetchEmpleados(page.fetchParams);
  //    });

    //  // attach click handlers to the pagination controls
    //  $('.pageButton').click(function(e) {
    //    e.preventDefault();
    //    page.fetchParams.page = this.id.substr(5);
    //    page.fetchEmpleados(page.fetchParams);
    //  });
      
    //  page.isInitialized = true;
    //  page.isInitializing = false;
    // });

    // // backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
    // this.fetchEmpleados({ page: 1 });

    // // initialize the model view
    // this.modelView = new view.ModelView({
    //  el: $("#empleadoModelContainer")
    // });

    // // tell the model view where it's template is located
    // this.modelView.templateEl = $("#empleadoModelTemplate");

    // if (model.longPollDuration > 0)
    // {
    //  setInterval(function () {

    //    if (!page.dialogIsOpen)
    //    {
    //      page.fetchEmpleados(page.fetchParams,true);
    //    }

    //  }, model.longPollDuration);
    // }
  },

  /**
   * Fetch the collection data from the server
   * @param object params passed through to collection.fetch
   * @param bool true to hide the loading animation
   */
  // fetchEmpleados: function(params, hideLoader)
  // {
  //  // persist the params so that paging/sorting/filtering will play together nicely
  //  page.fetchParams = params;

  //  if (page.fetchInProgress)
  //  {
  //    if (console) console.log('supressing fetch because it is already in progress');
  //  }

  //  page.fetchInProgress = true;

  //  if (!hideLoader) app.showProgress('loader');;

  //  page.empleados.fetch({

  //    data: params,

  //    success: function() {

  //      if (page.empleados.collectionHasChanged)
  //      {
  //        // TODO: add any logic necessary if the collection has changed
  //        // the sync event will trigger the view to re-render
  //      }

  //      app.hideProgress('loader');
  //      page.fetchInProgress = false;
  //    },

  //    error: function(m, r) {
  //      app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'collectionAlert');
  //      app.hideProgress('loader');
  //      page.fetchInProgress = false;
  //    }

  //  });
  // },

  /**
   * show the dialog for editing a model
   * @param model
   */
  showDetailDialog: function(m) {

    // show the modal dialog
    $('#controlDetailDialog').modal({ show: true });
  },
  showControlDialog: function(m) {

    // show the modal dialog
    $('#controlDialog'+m).modal({ show: true });
  },
  hideDetailDialog: function(m) {

    // show the modal dialog
    $('#controlDetailDialog').modal('hide');
  },

  /**$('#empleadoDetailDialog').modal('hide');
   * Render the model template in the popup
   * @param bool show the delete button
   */
  // renderModelView: function(showDeleteButton)
  // {
  //  page.modelView.render();

  //  app.hideProgress('modelLoader');

  //  // initialize any special controls
  //  try {
  //    $('.date-picker')
  //      .datepicker()
  //      .on('changeDate', function(ev){
  //        $('.date-picker').datepicker('hide');
  //      });
  //  } catch (error) {
  //    // this happens if the datepicker input.value isn't a valid date
  //    if (console) console.log('datepicker error: '+error.message);
  //  }
    
  //  $('.timepicker-default').timepicker({ defaultTime: 'value' });

  //  // populate the dropdown options for area
  //  // TODO: load only the selected value, then fetch all options when the drop-down is clicked
  //  var areaValues = new model.AreaCollection();
  //  areaValues.fetch({
  //    success: function(c){
  //      var dd = $('#area');
  //      dd.append('<option value=""></option>');
  //      c.forEach(function(item,index)
  //      {
  //        dd.append(app.getOptionHtml(
  //          item.get('id'),
  //          item.get('nombre'), // TODO: change fieldname if the dropdown doesn't show the desired column
  //          page.empleado.get('area') == item.get('id')
  //        ));
  //      });
        
  //      if (!app.browserSucks())
  //      {
  //        dd.combobox();
  //        $('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
  //      }

  //    },
  //    error: function(collection,response,scope){
  //      app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
  //    }
  //  });


  //  if (showDeleteButton)
  //  {
  //    // attach click handlers to the delete buttons

  //    $('#deleteEmpleadoButton').click(function(e) {
  //      e.preventDefault();
  //      $('#confirmDeleteEmpleadoContainer').show('fast');
  //    });

  //    $('#cancelDeleteEmpleadoButton').click(function(e) {
  //      e.preventDefault();
  //      $('#confirmDeleteEmpleadoContainer').hide('fast');
  //    });

  //    $('#confirmDeleteEmpleadoButton').click(function(e) {
  //      e.preventDefault();
  //      page.deleteModel();
  //    });

  //  }
  //  else
  //  {
  //    // no point in initializing the click handlers if we don't show the button
  //    $('#deleteEmpleadoButtonContainer').hide();
  //  }
  // },

  // /**
  //  * update the model that is currently displayed in the dialog
  //  */
  // updateModel: function()
  // {
  //  // reset any previous errors
  //  $('#modelAlert').html('');
  //  $('.control-group').removeClass('error');
  //  $('.help-inline').html('');

  //  // if this is new then on success we need to add it to the collection
  //  var isNew = page.empleado.isNew();

  //  app.showProgress('modelLoader');

  //  page.empleado.save({

  //    'nombre': $('input#nombre').val(),
  //    'apellido': $('input#apellido').val(),
  //    'materno': $('input#materno').val(),
  //    'area': $('select#area').val(),
  //    'fechaentrada': $('input#fechaentrada').val(),
  //    'dias': $('input#dias').val(),
  //    'reglas': $('textarea#reglas').val(),
  //    'correo': $('input#correo').val(),
  //    'pass': $('textarea#pass').val()
  //  }, {
  //    wait: true,
  //    success: function(){
  //      $('#empleadoDetailDialog').modal('hide');
  //      setTimeout("app.appendAlert('Empleado was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
  //      app.hideProgress('modelLoader');

  //      // if the collection was initally new then we need to add it to the collection now
  //      if (isNew) { page.empleados.add(page.empleado) }

  //      if (model.reloadCollectionOnModelUpdate)
  //      {
  //        // re-fetch and render the collection after the model has been updated
  //        page.fetchEmpleados(page.fetchParams,true);
  //      }
  //  },
  //    error: function(model,response,scope){

  //      app.hideProgress('modelLoader');

  //      app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');

  //      try {
  //        var json = $.parseJSON(response.responseText);

  //        if (json.errors)
  //        {
  //          $.each(json.errors, function(key, value) {
  //            $('#'+key+'InputContainer').addClass('error');
  //            $('#'+key+'InputContainer span.help-inline').html(value);
  //            $('#'+key+'InputContainer span.help-inline').show();
  //          });
  //        }
  //      } catch (e2) {
  //        if (console) console.log('error parsing server response: '+e2.message);
  //      }
  //    }
  //  });
  // },

  // /**
  //  * delete the model that is currently displayed in the dialog
  //  */
  // deleteModel: function()
  // {
  //  // reset any previous errors
  //  $('#modelAlert').html('');

  //  app.showProgress('modelLoader');

  //  page.empleado.destroy({
  //    wait: true,
  //    success: function(){
  //      $('#empleadoDetailDialog').modal('hide');
  //      setTimeout("app.appendAlert('The Empleado record was deleted','alert-success',3000,'collectionAlert')",500);
  //      app.hideProgress('modelLoader');

  //      if (model.reloadCollectionOnModelUpdate)
  //      {
  //        // re-fetch and render the collection after the model has been updated
  //        page.fetchEmpleados(page.fetchParams,true);
  //      }
  //    },
  //    error: function(model,response,scope){
  //      app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
  //      app.hideProgress('modelLoader');
  //    }
  //  });
  // }
};
