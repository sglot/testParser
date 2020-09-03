<?php

namespace app\common\DB;


/**
 * Class RatingManager
 * @package app\common\DB
 */
class RatingManager extends Base
{
    private $findRating = "select * from (select * from ratings where date_created = :date_created and pos <= 10 ) as r left join cinema on r.cinema_id = cinema.origin_id order by r.category asc, %s %s";
    private $findNewestDate = "select date_created from ratings order by id desc limit 1";

    /**
     * @param string $filter
     * @param string $sort
     * @param string $date
     * @return array
     */
    public function getRating(string $filter = 'pos', string $sort='asc', string $date = null)
    {
        $pdo = $this->getPdo();

        if (!$date) {
            $date = $this->findNewestDate();
        }
        $this->findRating = sprintf($this->findRating, $filter, $sort);
        $stmt = $pdo->prepare($this->findRating);
        $stmt->execute([
            'date_created' => $date,
        ]);
        $res = $stmt->fetchAll();

        return $res;
    }

    /**
     * @return string|null
     */
    private function findNewestDate()
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->query($this->findNewestDate);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res['date_created'] ?? null;
    }

}