<?php
/** @package    Total Sound::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
// require_once("Model/Venta.php");

/**
 * VentaController is the controller class for the Venta object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Total Sound::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class CorteController extends AppBaseController
{

  /**
   * Override here for any controller-specific functionality
   *
   * @inheritdocs
   */
  protected function Init()
  {
    parent::Init();

    // TODO: add controller-wide bootstrap code
    
    // TODO: if authentiation is required for this entire controller, for example:
    // $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
  }

  /**
   * Displays a list view of Venta objects
   */
  public function ListView()
  {
    $output = new stdClass();
        $fecha = $this->GetRouter()->GetUrlParam('id');
        $meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");    
        
        if($fecha!="0")
        {
          
          $array_fecha=explode("_", $fecha);
          $output->day=$array_fecha[2];
          $output->month=$array_fecha[1];
          $output->monthi=$meses[(int)$array_fecha[1]];
          $output->year=$array_fecha[0];      
        }
        else
        {
          $output->day=date("d");
          $output->month=date("m");
          $output->monthi=$meses[(int)date("m")];
          $output->year=date("Y");
        }
        $fecha=$output->year."-".$output->month."-".$output->day;
        $output->fecha=$fecha;
        
        $fil=new StdClass();
        $fil->fecha=$fecha;
        $fil->day=$output->day;
        $fil->month=$output->month;
        $fil->year=$output->year;
        // $fil->area=$this->GetCurrentUser()->Area;
        // $criteria = new Criteria();
        // $criteria->Area_Equals = $this->GetCurrentUser()->Area;
        // $criteria->Fecha_Equals = $this->GetCurrentUser()->Area;

        $proyectos = $this->Phreezer->Query('CorteReporter',$fil);
        $output->rows = $proyectos->ToObjectArray(true, $this->SimpleObjectParams());
        $output->totalResults = count($output->rows);
        
        $output->totalPages = 1;
        $output->pageSize = $output->totalResults;
        $output->currentPage = 1;
        //$this->RenderJSON($output, $this->JSONPCallback());
        $output->user = $this->GetCurrentUser();
        
        $this->Assign('itemss',$output);
        $this->Render("CorteListView");
  }

  /**
   * API Method queries for Venta records and render as JSON
  */
}

?>
