<?php
	$this->assign('title','Total Sound | Secciones');
	$this->assign('nav','secciones');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/libs/jquery.form.js")
	.script("scripts/app/secciones.js").wait(function(){
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
	<i class="icon-th-list"></i> Secciones
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="seccionCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<!-- <th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th> -->
				<th id="header_Nombre">Nombre<% if (page.orderBy == 'Nombre') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Foto">Foto<% if (page.orderBy == 'Foto') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Estatus">Estatus<% if (page.orderBy == 'Estatus') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<!--<td><%= _.escape(item.get('id') || '') %></td> -->
				<td><%= _.escape(item.get('nombre') || '') %></td>
				<td><div class="show_bg" style="background-image: url('img/secciones/<%= _.escape(item.get('foto') || '') %>')"></td>
				<td><%if (item.get('estatus')==1) { %><i class="icon-ok"><% } else { %><i class="icon-remove"><% } %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="seccionModelTemplate">
		<div class="form-horizontal" >
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="nombreInputContainer" class="control-group">
					<label class="control-label" for="nombre">Nombre</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="nombre" placeholder="Nombre" value="<%= _.escape(item.get('nombre') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<form id="miform1" class="form-horizontal" action="xcm/subir_img.php?item=seccion" method="post"  enctype="multipart/form-data">
				<div id="fotoInputContainer" class="control-group">
					<label class="control-label" for="foto">Foto</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="foto" placeholder="Foto" value="<%= _.escape(item.get('foto') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
					<div id="archivoInputContainer" class="control-group">
						<label class="control-label" for="archivo"></label>
						<div class="controls inline-inputs">
							<input type="file" name="archivo_upload" class="input-xlarge" id="archivo_upload1" placeholder="archivo_upload" value="<%= _.escape(item.get('archivo') || '') %>">
							<span class="help-inline"></span>
						</div>					
					</div>
					<div id="archivoInputContainer" class="control-group">										
						<div class="progress controls inline-inputs">
						    <div class="bar bar1"></div >
						    <div class="percent1">0%</div >
						</div>
					</div>
				</form>
				<div id="estatusInputContainer" class="control-group">
					<label class="control-label" for="estatus">Estatus</label>
					<div class="controls inline-inputs">
						<input type="checkbox" id="estatus" name="estatus" value="1" <% if(_.escape(item.get('estatus'))==1) { %> checked<%} %>> 						
						<span class="help-inline"></span>
					</div>
				</div>

				
			</fieldset>
		</div>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteSeccionButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSeccionButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Seccion</button>
						<span id="confirmDeleteSeccionContainer" class="hide">
							<button id="cancelDeleteSeccionButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSeccionButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="seccionDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Seccion
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="seccionModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSeccionButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="seccionCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSeccionButton" class="btn btn-primary">Add Seccion</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
