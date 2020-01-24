<?php


namespace src\Http\Controllers;

use core\AbstractClasses\Controller;

/**
 * Class IndexController
 * @package src\Http\Controllers
 */
class IndexController extends Controller
{
  /**
   * Readme file
   */
  public function index()
  {
    readfile('readme.html');
  }
}
