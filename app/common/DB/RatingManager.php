<?php

namespace app\common\DB;


/**
 * Class RatingManager
 * @package app\common\DB
 */
class RatingManager extends Base
{
    private $findRating = "select * from ratings where date_created = :date_created order by category asc, :field_filter asc limit 10";

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
        $res = $stmt->fetchAll();

        return $res;
    }

}