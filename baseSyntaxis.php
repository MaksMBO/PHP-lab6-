<?php

echo "<h1>1. Продемонструвати базовий синтаксис PHP: </h1>";

// Робота зі змінними, рядками та конкатенація
echo "<h3>робота зі змінними, з рядками, конкатенація</h3>";
$nameRestaurant = "Пузата хата";
$openingYear = 2003;
$openingDate = "16";
echo "Перший ресторан «" . $nameRestaurant . "» відкрили " . $openingYear . " жовтня " . $openingDate . " року на першому 
поверсі будинку на вулиці Басейній, 1/2, що на Бессарабці в центрі Києва.<br><br>";

// масиви, асоціативні масиви
echo "<h3>масиви, асоціативні масиви</h3>";
$menu = [
    [
        "name" => "Борщ",
        "category" => "Перші страви",
        "description" => "Традиційний український борщ зі свіжими овочами та м'ясом. Подається зі сметаною та пампушками."
    ],
    [
        "name" => "Вареники з картоплею",
        "category" => "Головні страви",
        "description" => "Ніжні вареники, випічені з найсвіжішою картоплею та обсмаженими цибулею. Подаються з соусом."
    ],
    [
        "name" => "Суп 'Селянський'",
        "category" => "Перші страви",
        "description" => "Смачний селянський суп із смаженою ковбасою, крупою та овочами. Подається з часниковими грінками."
    ]
];

$specialDish = [
    "name" => "Запечена курка з грибами",
    "category" => "Спеціальна пропозиція",
    "price" => 30,
    "description" => "Соковита курка, запікана з ароматними грибами та подавана з картопляним пюре."
];

echo "Раді бачити вас в «{$nameRestaurant}»!<br>";
echo "<h3>Наша спеціальна пропозиція для вас:</h3>";
echo "<p><b>{$specialDish['name']}</b> - {$specialDish['description']}<br>price: {$specialDish['price']} грн</p>";
echo "<h3>Пункти меню:</h3>";
foreach ($menu as $item) {
    echo "<p><b>{$item['name']}</b><br>";
    echo "category: {$item['category']}<br>";
    echo "description: {$item['description']}</p>";
}


// Explode та implode
echo "<h3>explode, implode</h3>";
$goodsName = "Борщ,Бограч,Вареники";
$goodsArray = explode(",", $goodsName);
echo "Масив утворений за допомогою explode: $goodsArray <br>";
foreach ($goodsArray as $item) {
    echo "$item<br>";
}

$goodsString = implode(", ", $goodsArray);
echo "Новий рядок утворений за допомогою implode: $goodsString <br>";

// Розіменування змінних
echo "<h3>розіменування змінних</h3>";
$item = "Борщ";
$$item = "42 грн.";
echo "price за $item: $Борщ<br>";


// Порівняння
echo "<h3>порівняння</h3>";

$allPrices = [42, 47, 38, 47, 55, 75, 65, 55, 95, 85, 35];
echo "Початковий масив цін: " . implode(', ', $allPrices) . "<br>";

$n = count($allPrices);
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
        if ($allPrices[$j] > $allPrices[$j + 1]) {
            $temp = $allPrices[$j];
            $allPrices[$j] = $allPrices[$j + 1];
            $allPrices[$j + 1] = $temp;
        }
    }
}

echo "Відсортований масив цін: " . implode(', ', $allPrices) . "<br>";


// Приведення типів
echo "<h3>приведення типів</h3>";
$someDishs = [
    [
        "name" => "Запечена курка з грибами",
        "price" => "56"

    ],
    [
        "name" => "Борщ",
        "price" => "42"
    ],
    [
        "name" => "Вареники з картоплею",
        "price" => "45"
    ],
];

foreach ($someDishs as $dish) {
    echo "Назва: {$dish["name"]}, ціна: {$dish["price"]}, тип даних ціни: " . gettype((int)$dish["price"]) . "<br>";
}
