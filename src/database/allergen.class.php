<?php
    declare(strict_types = 1);

    class Allergen {
        public int $idAllergen;
        public string $name;

        public function __construct(int $idAllergen, string $name)
        {
            $this->idAllergen = $idAllergen;
            $this->name = $name;
        }

        static function getAllAllergens(PDO $db) : array {
            $stmt = $db->prepare('SELECT *
                                  FROM Allergen
                                  ORDER BY name');
            $stmt->execute();
            $allergens = array();

            while ($allergen = $stmt->fetch()) {
                $allergens[] = new Allergen(
                    intval($allergen['idAllergen']), 
                    $allergen['name']
                );
            }

            return $allergens;
        }

        static function getDishAllergens(PDO $db, int $idDish) : array {
            $stmt = $db->prepare('SELECT name
                                  FROM DishAllergen
                                  JOIN Allergen Using (idAllergen)
                                  WHERE idDish = ?
                                  ORDER BY name');
            $stmt->execute(array($idDish));
            $allergens = array();

            while ($allergen = $stmt->fetch()) {
                $allergens[] = new Allergen(
                    intval($allergen['idAllergen']), 
                    $allergen['name']
                );
            }

            return $allergens;
        }

    }
?>