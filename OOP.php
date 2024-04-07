<?php

interface RestaurantInterface
{
    public function openHours();
}

trait Singleton
{
    private static $instance;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static(...func_get_args());
        }
        return static::$instance;
    }
}

class Good
{
    private static int $lastId = 0;
    public int $id;
    public string $name;
    public float $price;
    public string $currency = "грн.";

    public function __construct($name, $price)
    {
        $this->id = ++self::$lastId;
        $this->name = $name;
        $this->price = $price;
    }

    public static function resetLastId(): void
    {
        self::$lastId = 0;
    }

    public function __toString(): string
    {
        return "{$this->id}";
    }
}

class Menu
{
    private array $goods = [];

    public function addGood(Good $good): void
    {
        $this->goods[$good->id] = $good;
    }

    public function deleteGood(int $id): bool
    {
        if (array_key_exists($id, $this->goods)) {
            unset($this->goods[$id]);
            return true;
        } else {
            return false;
        }
    }

    public function editPrice(int $id, float $newPrice): bool
    {
        if (array_key_exists($id, $this->goods)) {
            $this->goods[$id]->price = $newPrice;
            return true;
        } else {
            echo "Товар з id {$id} не існує.\n";
            return false;
        }
    }

    public function getGoodPrice(int $id): float
    {
        if (array_key_exists($id, $this->goods)) {
            return $this->goods[$id]->price;
        } else {
            echo "Товар з id {$id} не існує.\n";
            return 0;
        }
    }

    public function displayGoods(): void
    {
        echo "<ul>";
        foreach ($this->goods as $good) {
            echo "<li>id: {$good->id}, товар: {$good->name}, ціна: {$good->price} {$good->currency}</li>";
        }
        echo "</ul>";
    }
}


class Restaurant implements RestaurantInterface
{
    public function __construct(
        public string $name,
        private Menu $menu
    ) {
    }

    public function addGoodToMenu(string $name, float $price): Good
    {
        $newGood = new Good($name, $price);
        $this->menu->addGood($newGood);
        return $newGood;
    }

    public function deleteGoodFromMenu(int $id): bool
    {
        return $this->menu->deleteGood($id);
    }

    public function editGoodPriceInMenu(int $id, float $newPrice): bool
    {
        return $this->menu->editPrice($id, $newPrice);
    }

    public function getGoodPriceFromMenu(int $id): float
    {
        return $this->menu->getGoodPrice($id);
    }

    public function displayMenu(): void
    {
        echo "<h3>Меню:</h3>";
        $this->menu->displayGoods();
    }

    public static function isRestaurant($object): bool
    {
        return is_subclass_of($object, 'Restaurant');
    }


    public function __toString(): string
    {
        return $this->name;
    }

    public function openHours(): string
    {
        return "Цей ресторан відкритий з 8:00 до 23:00.";
    }
}


class PuzataHata extends Restaurant
{
    use Singleton;

    public function __construct(
        public string $name,
        public Menu $menu
    ) {
        parent::__construct($name, $menu);
    }
}
