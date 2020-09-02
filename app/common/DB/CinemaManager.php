<?php

namespace app\common\DB;


class CinemaManager extends Base
{
    private $addCinema = "INSERT INTO cinema (origin_id, title, category, image, description) VALUES (?, ?, ?, ?, ?)";

    public function addCinemaList($list, $category)
    {
        $pdo = $this->getPdo();
        foreach ($list as $cinema) {
            $stmt = $pdo->prepare($this->addCinema);

            $stmt->execute([
                    $cinema['detail']['id'],
                    $cinema['title'],
                    $category,
                    $cinema['detail']['img_path'],
                    $cinema['detail']['description']
                ]
            );
        }
    }

}