<?php

class UserEntityCest
{
    public function _before(ApiTester $I)
    {
      $I->sendGET('/users');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendGet('/users/123');
      $I->seeResponseCodeIs(404);
      $I->seeResponseIsJson();

      $I->sendGet('/users/1');
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();

      $I->sendPOST('/users', json_encode([
        'login' => 'Mendax',
        'name_last' => "Telegin",
        'name_first' => "Kirill"
      ]));
      $I->seeResponseCodeIs(201);
      $I->seeResponseIsJson();

      $I->sendPUT('/users/1', json_encode([
        'login' => 'norman',
        'name_last' => 'Voodoo',
        'name_first' => 'People',
      ]));

      $I->seeResponseCodeIs(202);
      $I->seeResponseIsJson();

      $I->sendDELETE('/users/4');
      $I->seeResponseCodeIs(202);
      $I->seeResponseIsJson();
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }
}
