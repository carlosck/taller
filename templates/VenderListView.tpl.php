<?php
  $this->assign('title','Total Sound | Venta');
  $this->assign('nav','vender');

  $this->display('_Header.tpl.php');
?>

<script type="text/javascript">
  $LAB.script("scripts/app/vender.js").wait(function(){
    $(document).ready(function(){
      page.init();
    });
    
    // hack for IE9 which may respond inconsistently with document.ready
    // setTimeout(function(){
    //   if (!page.isInitialized) page.init();
    // },1000);
  });
</script>

<div class="container vender">

<h1 >
  <i class="icon-th-list"></i> Venta
    
</h1>
  <div class='input-append pull-right searchContainer'>
    <input id='filter' type="text" placeholder="Search..." />
    <button class='btn add-on'><i class="icon-search"></i></button>
    <div class="autocomplete_mask">
      <div id="autocomplete_item_container" class="autocomplete_item_container">
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
        <a href="#" class="autocomplete_item">
          <p>
            Estereo Sony 1500
          </p>
        </a>
      </div>
    </div>
  </div>
  <div id="cont_form">
    <form class="form-horizontal" onsubmit="return false;">
        <div class="show_bg" style="background-color: gray;"></div>
        <fieldset>
          <div id="nombreInputContainer" class="control-group">
            <label class="control-label" for="nombre">Nombre</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge " id="nombre" placeholder="Nombre" value="" readonly>
              <input type="hidden"  id="id_product_hidden" >
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="seccionInputContainer" class="control-group">
            <label class="control-label" for="seccion">Sección</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="seccion" placeholder="Sección" value="" readonly>
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="codigoInputContainer" class="control-group">
            <label class="control-label" for="codigo">Codigo</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="codigo" placeholder="Codigo" value="" readonly>
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="cantidadInputContainer" class="control-group">
            <label class="control-label" for="cantidad">Cantidad</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="cantidad" placeholder="cantidad" value="">
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="precioSugeridoInputContainer" class="control-group">
            <label class="control-label" for="precioSugerido">Precio Sugerido</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="precio_sugerido" placeholder="Precio Sugerido" value="" readonly>
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="precioFinalInputContainer" class="control-group">
            <label class="control-label" for="precioFinal">Precio Final</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="precio_final" placeholder="Precio Final" value="" >
              <span class="help-inline"></span>
            </div>
          </div>
          <div id="totalInputContainer" class="control-group">
            <label class="control-label" for="total">Total</label>
            <div class="controls inline-inputs">
              <input type="text" class="input-xlarge" id="total" placeholder="Total" value="" readonly>
              <span class="help-inline"></span>
            </div>
          </div>
          
          
          
         
        </fieldset>
      </form>
      <p id="newButtonContainer" class="buttonContainer">
        <button id="addVentaButton" class="btn btn-primary">Agregar</button>
      </p>
    </div>
<div id="resumen_total"> 
  <div class="resumen_item">
    <div class="resumen_item_quitar" ></div>  
    <div class="resumen_item_nombre">Producto</div>  
    <div class="resumen_item_cantidad">Cantidad</div>
    <div class="resumen_item_precio_final">Precio U.</div>  
    <div class="resumen_item_precio_total">Total</div>  
  </div>
  <div id="resumen_item_container">
    
  </div>
  <div id="resumen_item_total" class="resumen_item total">
    <div class="resumen_item_quitar" ></div>  
    <div class="resumen_item_nombre"></div>  
    <div class="resumen_item_cantidad"></div>
    <div class="resumen_item_precio_final">Total</div>  
    <div class="resumen_item_precio_total"></div>  
  </div>
  <div id="resumen_item_pago" class="resumen_item ">
    <div class="resumen_item_quitar" ></div>  
    <div class="resumen_item_nombre"></div>  
    <div class="resumen_item_cantidad"></div>
    <div class="resumen_item_precio_final">Pago</div>  
    <div class="resumen_item_precio_pago"><input type="text" class="input-small" id="pago" placeholder="0.00" value=""></div>  
  </div>
  <div id="resumen_item_cambio" class="resumen_item">
    <div class="resumen_item_quitar" ></div>  
    <div class="resumen_item_nombre"></div>  
    <div class="resumen_item_cantidad"></div>
    <div class="resumen_item_precio_final">Cambio</div>  
    <div class="resumen_item_precio_total"></div>  
  </div>
  <div id="comentariosInputContainer" class="control-group">
    <label class="control-label" for="comentarios">Comentarios</label>
    <div class="controls inline-inputs">
      <input type="text" class="input-xlarge" id="comentarios" placeholder="Comentarios" value="">
      <span class="help-inline"></span>
    </div>
  </div>
  <p id="newButtonContainer" class="buttonContainer pull-right">
    <button id="closeVentaButton" class="btn btn-primary">Cerrar Venta</button>
  </p>  
</div>
  
  

</div> <!-- /container -->
<script type="text/template" id="autocompleteItemTemplate">
    <a href="#" class="autocomplete_item" item="<%= _.escape(item.get('id') || '') %>">
      <p>
        <%= _.escape(item.get('nombre') || '') %>
      </p>
    </a>
            
<?php
  $this->display('_Footer.tpl.php');
?>
