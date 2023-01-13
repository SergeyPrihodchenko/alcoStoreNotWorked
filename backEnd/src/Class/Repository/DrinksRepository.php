<?php

namespace Alco\Gallery\Class\Repository;

use Alco\Gallery\Class\Drinks\Drink;
use Exception;
use PDO;

class DrinksRepository {

    function __construct(
        private \PDO $connect
    )
    {
    }

    public function save(Drink $drink): void 
    {
        try {
            $statement = $this->connect->prepare("INSERT INTO drinks (name, description, img_name) VALUES (:name, :description, :img_name);");
            $statement->execute([
                ':name' => $drink->name,
                ':description' => $drink->description,
                ':img_name' => $drink->description
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id): void
    {
        try {
            $this->connect->query("DELETE FROM drinks WHERE id = $id");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getDrinks(): array
    {
        $data_drinks = [];
        try {
            $statement = $this->connect->query("SELECT * FROM drinks;");
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $data_drinks[] = $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $data_drinks;
    }
}