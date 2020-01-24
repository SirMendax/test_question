<?php


namespace src\Http\Controllers;


use core\AbstractClasses\Controller;
use Exception;
use src\Repositories\TarifRepository;

class TarifController extends Controller
{

  /**
   * Return all tarifs in JSON-format
   * @throws Exception
   */
  public function index()
  {
    $tarif = new TarifRepository();
    $data = $tarif->get();
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Return all tarif with selected id in JSON-format
   * @param $params
   * @throws Exception
   */
  public function show($params)
  {
    $tarif = new TarifRepository();
    $data = $tarif->find($params, 'id');
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Create tarif
   * Accept JSON-format only as POST-params
   * @throws Exception
   */
  public function store()
  {
    $tarif = new TarifRepository();
    $tarif->create($this->request->input());
    $this->response->sendResponse("ok", 201);
  }

  /**
   * Update tarif
   * Accept JSON-format only as POST-params
   * @param $params
   * @throws Exception
   */
  public function update($params)
  {
    $tarif = new TarifRepository();
    $tarif->update($params, $this->request->input());
    $this->response->sendResponse("ok", 202);
  }

  /**
   * Delete tarif
   * @param $params
   */
  public function delete($params)
  {
    $tarif = new TarifRepository();
    $tarif->delete($params);
    $this->response->sendResponse("ok", 202);
  }

  /**
   * Get tarif with service_id and user_id
   * @param $params
   * @throws Exception
   */
  public function getTarifs($params)
  {
    $tarif = new TarifRepository();
    $data = $tarif->getTarifsForGroup($params, ['ID', 'title', 'price', 'link', 'speed', 'pay_period']);
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Update tarif with service_id and user_id
   * Accept JSON-format only as POST-params
   * @param $params
   * @throws Exception
   */
  public function updateWithService($params)
  {
    $tarif = new TarifRepository();
    $tarif->updateWithService($params, $this->request->input());
    $this->response->sendResponse("ok", 202);
  }

}
