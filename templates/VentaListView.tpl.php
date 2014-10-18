<?php
	$this->assign('title','Total Sound | Ventas');
	$this->assign('nav','ventas');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/ventas.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Ventas
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="ventaCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_ProductoId">Producto Id<% if (page.orderBy == 'ProductoId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_PrecioSugerido">Precio Sugerido<% if (page.orderBy == 'PrecioSugerido') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_PrecioFinal">Precio Final<% if (page.orderBy == 'PrecioFinal') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_CajaId">Caja Id<% if (page.orderBy == 'CajaId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Fecha">Fecha<% if (page.orderBy == 'Fecha') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Comentarios">Comentarios<% if (page.orderBy == 'Comentarios') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Estatus">Estatus<% if (page.orderBy == 'Estatus') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('productoId') || '') %></td>
				<td><%= _.escape(item.get('precioSugerido') || '') %></td>
				<td><%= _.escape(item.get('precioFinal') || '') %></td>
				<td><%= _.escape(item.get('cajaId') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%if (item.get('fecha')) { %><%= _date(app.parseDate(item.get('fecha'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('comentarios') || '') %></td>
				<td><%= _.escape(item.get('estatus') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="ventaModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="productoIdInputContainer" class="control-group">
					<label class="control-label" for="productoId">Producto Id</label>
					<div class="controls inline-inputs">
						<select id="productoId" name="productoId"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="precioSugeridoInputContainer" class="control-group">
					<label class="control-label" for="precioSugerido">Precio Sugerido</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="precioSugerido" placeholder="Precio Sugerido" value="<%= _.escape(item.get('precioSugerido') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="precioFinalInputContainer" class="control-group">
					<label class="control-label" for="precioFinal">Precio Final</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="precioFinal" placeholder="Precio Final" value="<%= _.escape(item.get('precioFinal') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="cajaIdInputContainer" class="control-group">
					<label class="control-label" for="cajaId">Caja Id</label>
					<div class="controls inline-inputs">
						<select id="cajaId" name="cajaId"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fechaInputContainer" class="control-group">
					<label class="control-label" for="fecha">Fecha</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="fecha" type="text" value="<%= _date(app.parseDate(item.get('fecha'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="fecha-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('fecha'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="comentariosInputContainer" class="control-group">
					<label class="control-label" for="comentarios">Comentarios</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="comentarios" placeholder="Comentarios" value="<%= _.escape(item.get('comentarios') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="estatusInputContainer" class="control-group">
					<label class="control-label" for="estatus">Estatus</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="estatus" placeholder="Estatus" value="<%= _.escape(item.get('estatus') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteVentaButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteVentaButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Venta</button>
						<span id="confirmDeleteVentaContainer" class="hide">
							<button id="cancelDeleteVentaButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteVentaButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="ventaDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Venta
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="ventaModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveVentaButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="ventaCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newVentaButton" class="btn btn-primary">Add Venta</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
