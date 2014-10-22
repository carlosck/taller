<?php
/** @package    Total Sound::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Producto.php");

/**
 * ProductoController is the controller class for the Producto object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Total Sound::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class ProductoController extends AppBaseController
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
	 * Displays a list view of Producto objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Producto records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new ProductoCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,SeccionId,Nombre,Foto,Codigo,PrecioSugerido,Estatus'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$productos = $this->Phreezer->Query('ProductoReporter',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $productos->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $productos->TotalResults;
				$output->totalPages = $productos->TotalPages;
				$output->pageSize = $productos->PageSize;
				$output->currentPage = $productos->CurrentPage;
			}
			else
			{
				// return all results
				$productos = $this->Phreezer->Query('ProductoReporter',$criteria);
				$output->rows = $productos->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Producto record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$producto = $this->Phreezer->Get('Producto',$pk);
			$this->RenderJSON($producto, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Producto record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$producto = new Producto($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $producto->Id = $this->SafeGetVal($json, 'id');

			$producto->SeccionId = $this->SafeGetVal($json, 'seccionId');
			$producto->Nombre = $this->SafeGetVal($json, 'nombre');
			$producto->Foto = $this->SafeGetVal($json, 'foto');
			$producto->Codigo = $this->SafeGetVal($json, 'codigo');
			$producto->PrecioSugerido = $this->SafeGetVal($json, 'precioSugerido');
			$producto->Estatus = $this->SafeGetVal($json, 'estatus');

			$producto->Validate();
			$errors = $producto->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$producto->Save();
				$this->RenderJSON($producto, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Producto record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$producto = $this->Phreezer->Get('Producto',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $producto->Id = $this->SafeGetVal($json, 'id', $producto->Id);

			$producto->SeccionId = $this->SafeGetVal($json, 'seccionId', $producto->SeccionId);
			$producto->Nombre = $this->SafeGetVal($json, 'nombre', $producto->Nombre);
			$producto->Foto = $this->SafeGetVal($json, 'foto', $producto->Foto);
			$producto->Codigo = $this->SafeGetVal($json, 'codigo', $producto->Codigo);
			$producto->PrecioSugerido = $this->SafeGetVal($json, 'precioSugerido', $producto->PrecioSugerido);
			$producto->Estatus = $this->SafeGetVal($json, 'estatus', $producto->Estatus);

			$producto->Validate();
			$errors = $producto->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$producto->Save();
				$this->RenderJSON($producto, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Producto record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$producto = $this->Phreezer->Get('Producto',$pk);

			$producto->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
