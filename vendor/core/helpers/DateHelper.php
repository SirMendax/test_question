<?php

namespace core\helpers;

use DateTime;

class DateHelper
{
  public static function addPayPeriod($payPeriod, $timezone, string $format) {
    try {
      $currentDate = new Datetime('midnight', $timezone);
      $newPayday = $currentDate->add(new \DateInterval('P'. $payPeriod . 'M'));
      return $newPayday->format($format);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}
