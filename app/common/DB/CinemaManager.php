<?php

namespace app\common\DB;


/**
 * Class CinemaManager
 * @package app\common\DB
 */
class CinemaManager extends Base
{
    private $addCinema = "INSERT IGNORE INTO cinema (origin_id, title, category, image, description, year) VALUES (?, ?, ?, ?, ?, ?)";
    private $addRating = "INSERT INTO ratings (id, cinema_id, pos, category, average_score, calculated_score, votes, date_created) VALUES (null, ?, ?, ?, ?, ?, ?, CURRENT_DATE())";
    private $selectRatingIdIfDuplicate = "select id from ratings where date_created = CURRENT_DATE() and cinema_id = :cinema_id";
    private $updateRating = "UPDATE ratings SET pos=:pos, average_score =:average_score, calculated_score =:calculated_score, votes =:votes where date_created = CURRENT_DATE() and cinema_id = :cinema_id";
    private $getCinemaByOriginId = "select * from cinema where origin_id = :origin_id";

    /**
     * @param array $list
     * @param string $category
     */
    public function addCinemaList(array $list, string $category): void
    {
        $pdo = $this->getPdo();

        foreach ($list as $cinema) {

            $this->addCinema($pdo, $cinema, $category);

            $res = $this->selectRatingIdIfDuplicate($pdo, $cinema);

            if (isset($res['id'])) {
                $this->updateRating($pdo, $cinema);
                continue;
            }

            $this->addRating($pdo, $cinema, $category);
        }
    }

    private function addCinema(\PDO $pdo, array $cinema, string $category): void
    {
        $stmt = $pdo->prepare($this->addCinema);
        $stmt->execute([
                $cinema['detail']['id'],
                $cinema['title'],
                $category,
                $cinema['detail']['img_path'],
                $cinema['detail']['description'],
                $cinema['year']
            ]
        );
    }

    private function selectRatingIdIfDuplicate(\PDO $pdo, array $cinema)
    {
        $stmt = $pdo->prepare($this->selectRatingIdIfDuplicate);
        $stmt->execute([
                'cinema_id' => $cinema['detail']['id'],
            ]
        );
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function updateRating(\PDO $pdo, array $cinema): void
    {
        $stmt = $pdo->prepare($this->updateRating);
        $stmt->execute([
                'cinema_id' => $cinema['detail']['id'],
                'pos' => $cinema['position'],
                'average_score' => $cinema['average_score'],
                'calculated_score' => $cinema['calculated_score'],
                'votes' => $cinema['votes'],
            ]
        );
    }

    private function addRating(\PDO $pdo, array $cinema, string $category): void
    {
        $stmt = $pdo->prepare($this->addRating);
        $stmt->execute([
                $cinema['detail']['id'],
                $cinema['position'],
                $category,
                $cinema['average_score'],
                $cinema['calculated_score'],
                $cinema['votes'],
            ]
        );
    }

    /**
     * @param int $origin_id
     * @return array
     */
    public function getCinemaByOriginId(int $origin_id): array
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($this->getCinemaByOriginId);
        $stmt->execute([
                'origin_id' => $origin_id,
            ]
        );
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}