<?php

session_start();

require_once 'OOP.php';

class RequestWrapper
{
  public static function get($key)
  {
    return isset($_GET[$key]) ? $_GET[$key] : null;
  }

  public static function post($key)
  {
    return isset($_POST[$key]) ? $_POST[$key] : null;
  }

  public static function request($key)
  {
    return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
  }
}

if (isset($_COOKIE['goods'])) {
  $goods = json_decode($_COOKIE['goods'], true);
  $_SESSION['goods'] = $goods;
}

$menu = new Menu();

if (isset($_SESSION['goods'])) {
  foreach ($_SESSION['goods'] as $good) {
    $menu->addGood(new Good($good['name'], $good['price']));
  }
}

$puzataHata = PuzataHata::getInstance("Пузата хата", $menu);


if (RequestWrapper::get('good_id') && RequestWrapper::get('action')) {
  $goodId = RequestWrapper::get('good_id');
  $action = RequestWrapper::get('action');

  switch ($action) {
    case 'price':
      $price = $puzataHata->getGoodPriceFromMenu($goodId);
      if ($price != 0) {
        echo "Ціна товару з ID {$goodId}: {$puzataHata->getGoodPriceFromMenu($goodId)} грн.";
      }
      break;
    default:
      echo "Невідома дія: {$action}";
  }
}

if (RequestWrapper::post('good_id') && RequestWrapper::post('new_price')) {
  $goodId = RequestWrapper::post('good_id');
  $newPrice = RequestWrapper::post('new_price');
  $isEdit = $puzataHata->editGoodPriceInMenu($goodId, $newPrice);
  if ($isEdit) {
    echo "Ціна товару з ID {$goodId} змінено на {$newPrice} грн.";

    if (isset($_SESSION['goods'])) {
      foreach ($_SESSION['goods'] as &$good) {
        if ($good['id'] == $goodId) {
          $good['price'] = $newPrice;
          break;
        }
      }
      setcookie('goods', json_encode($_SESSION['goods']), time() + (86400 * 30), "/");
    }
  }
}

if (RequestWrapper::request('name') && RequestWrapper::request('price')) {
  $name = RequestWrapper::request('name');
  $price = RequestWrapper::request('price');
  $newGood = $puzataHata->addGoodToMenu($name, $price);

  $goods = isset($_SESSION['goods']) ? $_SESSION['goods'] : array();
  $goods[] = ['id' => $newGood->id, 'name' => $name, 'price' => $price];
  $_SESSION['goods'] = $goods;
  setcookie('goods', json_encode($goods), time() + (86400 * 30), "/");
  echo "Товар {$name} з ціною {$price} грн. додано до меню з ID {$newGood->id}.";
}

echo <<<HTML
<form method="get">
  <input type="text" name="good_id" placeholder="Введіть ID товару">
  <select name="action">
    <option value="price">Отримати ціну</option>
  </select>
  <button type="submit">Відправити</button>
</form>
HTML;

echo <<<HTML
<form method="post">
  <input type="text" name="good_id" placeholder="Введіть ID товару">
  <input type="number" name="new_price" placeholder="Введіть нову ціну товару">
  <button type="submit">Редагувати ціну</button>
</form>
HTML;

echo <<<HTML
<form method="post">
  <input type="text" name="name" placeholder="Введіть назву товару">
  <input type="number" name="price" placeholder="Введіть ціну товару">
  <button type="submit">Додати до меню</button>
</form>
HTML;


if (Restaurant::isRestaurant($puzataHata)) {
  echo "<h2>Назва: " . $puzataHata . "</h2>";
  echo $puzataHata->displayMenu();
  echo "<h4>" . $puzataHata->openHours() . "<h4>";
}
// session_unset();
// session_destroy();
