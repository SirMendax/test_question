<?php


namespace src\Http\Controllers;


use core\Controller;
use Exception;
use src\Models\Tarif;
use src\Repositories\ServiceRepository;
use src\Repositories\TarifRepository;
use src\Validators\ServiceValidator;
use src\Models\Service;

class ServiceController extends Controller
{
  /**
   * Return all services in JSON-format
   * @throws Exception
   */
  public function index()
  {
    $services = new ServiceRepository();
    $data = $services->get();
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Return service with selected id in JSON-format
   * @param array $params
   * @throws Exception
   */
  public function show(array $params)
  {
    $services = new ServiceRepository();
    $data = $services->find($params, 'id');
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Create service with selected user_id and tarif_id
   * Accept JSON-format only as POST-params
   * @throws Exception
   */
  public function store()
  {
    $service = new ServiceRepository();;
    $service->createService($this->request->input());
    $this->response->sendResponse("ok", 201);
  }

  /**
   * Update tarif_id for selected service_id and user_id
   * Accept JSON-format only as POST-params
   * @param array $params
   * @throws Exception
   */
  public function updateWithUser(array $params)
  {
    $service = new ServiceRepository();
    ServiceValidator::validUpdate($this->request->input(), new TarifRepository());
    $service->updateWithUser($params, $this->request->input());
    $this->response->sendResponse("ok", 202);
  }

  /**
   * Delete service with selected id
   * @param array $params
   */
  public function delete(array $params)
  {
    $service = new ServiceRepository();
    $service->delete($params);
    $this->response->sendResponse("ok", 202);
  }
}
