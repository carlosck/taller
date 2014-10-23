<?php
  $this->assign('title','Total Sound | Corte');
  $this->assign('nav','corte');

  $this->display('_Header.tpl.php');
  $this->dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
?>

<script type="text/javascript">
  $LAB.script("/taller/scripts/app/corte.js").wait(function(){
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
  <div style="width: 50%;float: left">
    <?php echo $dia=$this->dias[date("w", mktime(0, 0, 0, $this->itemss->month, $this->itemss->day, $this->itemss->year))];?>   <?php echo $this->itemss->day;?> de  <?php echo $this->itemss->monthi;?> <?php echo $this->itemss->year;?>
  </div>  
  <div style="width: 50%;float: left;font-size: 22px;text-align: right" class="controls inline-inputs">
    Otra Fecha
    <div class="input-append date date-picker" style="margin-top: 10px" data-date-format="yyyy-mm-dd">
      <input id="fecha" type="text" value="" style="display: none"/>
      <span class="add-on"><i class="icon-calendar"></i></span>
    </div>
    <span class="help-inline"></span>
  </div>
</h1>
<h1>
  <i class="icon-th-list"></i> Ventas
  <span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
  <span class='input-append pull-right searchContainer'>
    <input id='filter' type="text" placeholder="Search..." />
    <button class='btn add-on'><i class="icon-search"></i></button>
  </span>
</h1>
<table class="collection table table-bordered table-hover">
<thead>
  <tr>
    <th id="header_Caja">Producto</th>        
    <th id="header_Fecha">Precio_sugerido</th>
    <th id="header_Fecha">Precio_final</th>
    <th id="header_Comentarios">Cantidad</th>
    <th id="header_Total">Total</th>    
  </tr>
</thead>
<tbody>
<?php 
// echo "<pre>";
//   var_dump($this->itemss);
$total=0;
foreach($this->itemss->rows as $item){ 
  ?>
  <tr class="corte_item">        
    <td><?php echo $item->caja;?></td>
    <td><?php echo $item->fecha;?></td>    
    <td colspan="2"><?php echo $item->comentarios;?></td>
    <td class="corte_total"><?php echo number_format($item->total,2);?></td>    
  </tr>
  <tr class="corte_subitem">  
  <?php foreach($item->productos as $subitem){ ?>
              
      <td><?php echo $subitem->producto;?></td>
      <td><?php echo number_format($subitem->sugerido,2);?></td>
      <td><?php echo number_format($subitem->precio,2);?></td>
      <td><?php echo $subitem->cantidad;?></td>
      <td class="corte_total"><?php echo number_format($subitem->total,2);?></td>    
    </tr>
    <?php } ?>        
  </tr>
<?php 
  $total+=$item->total;
}
  ?>
<tr>        
    <td></td>
    <td></td>
    <td></td>
    <td><h3><b>Total</b></h3></td>    
    <td class="corte_total"><h3><b><?php echo number_format($total,2);?></b></h3></td>
  </tr>

  

</div> <!-- /container -->

<?php
  $this->display('_Footer.tpl.php');
?>
