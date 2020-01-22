<?php

class TarifEntityCest
{
    public function _before(ApiTester $I)
    {
      $I->sendGET('/tarifs');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendGET('/users/1/services/1/tarifs');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendGET('/users/2/services/2/tarifs');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendGet('/tarifs/123');
      $I->seeResponseCodeIs(404);
      $I->seeResponseIsJson();

      $I->sendGet('/tarifs/1');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendPOST('/tarifs', json_encode([
        'title' => 'Нептун',
        'price' => 500.0000,
        'link' => "http://dev-arven.ru",
        'speed' => 120,
        'pay_period' => 12,
        'tarif_group_id' => 4
      ]));
      $I->seeResponseCodeIs(201);
      $I->seeResponseIsJson();

      $I->sendPUT('/tarifs/7', json_encode([
        'price' => 700.0000,
        'speed' => 150,
      ]));

      $I->seeResponseCodeIs(202);
      $I->seeResponseIsJson();

      $I->sendDELETE('/tarifs/6');
      $I->seeResponseCodeIs(202);
      $I->seeResponseIsJson();
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }
}
