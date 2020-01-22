<?php

class ServiceEntityCest
{
    public function _before(ApiTester $I)
    {
      $I->sendGET('/services');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendGet('/services/123');
      $I->seeResponseCodeIs(404);
      $I->seeResponseIsJson();

      $I->sendGet('/services/1');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendPOST('/services', json_encode([
        'user_id' => 2,
        'tarif_id' => 3,
      ]));
      $I->seeResponseCodeIs(201);
      $I->seeResponseIsJson();

      $I->sendPUT('/users/2/services/2/tarif', json_encode([
        'tarif_id' => 4,
      ]));
      $I->seeResponseCodeIs(202);
      $I->seeResponseIsJson();
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }
}
