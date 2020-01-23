<?php
define('DB_USER', 'root');
define('DB_PASS', 'qwerty');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '33061');
define('DB_NAME', 'api_test');

$sql_array = [

  "DROP TABLE `services`;",
  "DROP TABLE `users`;",
  "DROP TABLE `tarifs`;",

  "CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` char(12) NOT NULL,
  `name_last` varchar(255) NOT NULL,
  `name_first` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;",

  "CREATE TABLE `tarifs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `link` varchar(255) NOT NULL,
  `speed` int(11) NOT NULL,
  `pay_period` int(11) NOT NULL,
  `tarif_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;",


  "CREATE TABLE `services` (
  `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `payday` date NOT NULL,
   FOREIGN KEY (user_id)  REFERENCES users (ID) ON DELETE CASCADE,
   FOREIGN KEY (tarif_id)  REFERENCES tarifs (ID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;",

  "INSERT INTO `tarifs` (`ID`, `title`, `price`, `link`, `speed`, `pay_period`, `tarif_group_id`) VALUES
(1, 'Земля', '500.0000', 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(2, 'Земля (3 мес)', 1350, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(3, 'Земля (12 мес)', 4200, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(4, 'Вода', 600, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3),
(5, 'Вода (3 мес)', 1650, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3),
(6, 'Вода (12 мес)', 5400, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3);",

  "INSERT INTO `users` (`ID`, `login`, `name_last`, `name_first`) VALUES
(1, 'test1', 'Петров', 'Василий'),
(2, 'test2', 'Васнецов', 'Пётр');",

  "INSERT INTO `services` (`ID`, `user_id`, `tarif_id`, `payday`) VALUES
(1, 1, 1, '2018-12-06'),
(2, 2, 3, '2018-12-06');",

  "CREATE TABLE oauth_clients (
  client_id             VARCHAR(80)   NOT NULL,
  client_secret         VARCHAR(80),
  redirect_uri          VARCHAR(2000),
  grant_types           VARCHAR(80),
  scope                 VARCHAR(4000),
  user_id               VARCHAR(80),
  PRIMARY KEY (client_id)
);",

  "CREATE TABLE oauth_access_tokens (
  access_token         VARCHAR(40)    NOT NULL,
  client_id            VARCHAR(80)    NOT NULL,
  user_id              VARCHAR(80),
  expires              TIMESTAMP      NOT NULL,
  scope                VARCHAR(4000),
  PRIMARY KEY (access_token)
);",

  "CREATE TABLE oauth_authorization_codes (
  authorization_code  VARCHAR(40)     NOT NULL,
  client_id           VARCHAR(80)     NOT NULL,
  user_id             VARCHAR(80),
  redirect_uri        VARCHAR(2000),
  expires             TIMESTAMP       NOT NULL,
  scope               VARCHAR(4000),
  id_token            VARCHAR(1000),
  PRIMARY KEY (authorization_code)
);",

  "CREATE TABLE oauth_refresh_tokens (
  refresh_token       VARCHAR(40)     NOT NULL,
  client_id           VARCHAR(80)     NOT NULL,
  user_id             VARCHAR(80),
  expires             TIMESTAMP       NOT NULL,
  scope               VARCHAR(4000),
  PRIMARY KEY (refresh_token)
);",

  "CREATE TABLE oauth_users (
  username            VARCHAR(80),
  password            VARCHAR(80),
  first_name          VARCHAR(80),
  last_name           VARCHAR(80),
  email               VARCHAR(80),
  email_verified      BOOLEAN,
  scope               VARCHAR(4000),
  PRIMARY KEY (username)
);",

  "CREATE TABLE oauth_scopes (
  scope               VARCHAR(80)     NOT NULL,
  is_default          BOOLEAN,
  PRIMARY KEY (scope)
);",

  "CREATE TABLE oauth_jwt (
  client_id           VARCHAR(80)     NOT NULL,
  subject             VARCHAR(80),
  public_key          VARCHAR(2000)   NOT NULL
);"

];

try {
  $dbh = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true));
  foreach ($sql_array as $sql) {
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  }
  $dbh = null;
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
