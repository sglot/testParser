<?php

namespace app\common\DB;


/**
 * Class RatingManager
 * @package app\common\DB
 */
class RatingManager extends Base
{
    private $findRating = "select * from (select * from ratings where date_created = :date_created and pos <= 10 order by category asc, :field_filter asc) as r left join cinema on r.cinema_id = cinema.origin_id";

    /**
     * @param string $filter
     * @param string $date
     * @return array
     */
    public function getRating(string $filter = 'pos', string $date = '2020-09-02')
    {
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare($this->findRating);
        $stmt->execute([
            'date_created' => $date,
            'field_filter' => $filter
        ]);
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $res;
    }

}