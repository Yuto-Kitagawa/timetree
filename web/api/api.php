<?php
require_once(__DIR__ . '/database.php');

class API extends Database
{
    public function getEvent($year, $month, $date)
    {
        $startTime = $year . '-' . $month . '-01 00:00:00';
        $endTime = $year . '-' . $month . '-' . $date . ' 23:59:59';
        $getEventSQL = 'SELECT * FROM timetree WHERE start_time BETWEEN :starttime AND :endtime;';

        //SQL文を実行する準備
        $sth = $this->conn->prepare($getEventSQL);

        //バリデート(SQL用の正規表現[* → '*']など、脆弱性がないように変換)
        $sth->bindValue(':starttime', $startTime, PDO::PARAM_STR);
        $sth->bindValue(':endtime', $endTime, PDO::PARAM_STR);

        //SQL文を実行
        $sth->execute();

        $return_list = [];

        if ($sth->rowCount() > 0) {
            $message = 'True';
            //SQLで取得したデータを1行ずつ分解して配列に格納する
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                array_push($return_list, $row);
            };
        } else {
            $message = 'False';
        }

        return [$message, $return_list];
    }
}
