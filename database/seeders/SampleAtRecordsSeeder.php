<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\AttendanceRecord;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * 23年9月1日～シーディング実行前日までのサンプルat_recordデータをシーディング
 */
class SampleAtRecordsSeeder extends Seeder
{
    /**
     * シーディング実行
     * @return void
     */
    public function run(): void
    {
        // ここでどういうデータを入れたいか定義
        $start_date = new DateTime('2023/09/01');
        $end_date = new DateTime(getToday());
        $data_per_day_max = 5;
        $data_per_day_min = 3;
        $working_minutes_sum_max = 540;
        $working_minutes_sum_min = 240;

        //以降はいじらない
        $interval = $start_date->diff($end_date);
        $period = $interval->days + 1;

        $datetime = clone $start_date;
        $datetime->setTime(0, 0, 0);

        //毎回名前のためにUserテーブル検索させないために配列でしまっとく
        $name_list = [
            '1' => User::findUserByUserId('1')->getKanjiFullName(),
            '2' => User::findUserByUserId('2')->getKanjiFullName(),
            '3' => User::findUserByUserId('3')->getKanjiFullName(),
            '4' => User::findUserByUserId('4')->getKanjiFullName(),
            '5' => User::findUserByUserId('5')->getKanjiFullName(),
        ];

        //日数分だけ繰り返す
        for ($day = 0; $day < $period; $day++) {
            $user_ids = ['1', '2', '3', '4', '5'];
            shuffle($user_ids);

            $data_per_day = rand($data_per_day_min, $data_per_day_max);

            //1日当たりの生成データ数だけ繰り返す
            for ($i = 0; $i < $data_per_day; $i++) {

                $user_id = array_shift($user_ids);
                $date = $datetime->format('Y-m-d');
                $time = $this->getRandTime();

                //労働時間や休憩時間を用意
                $working_minutes = rand($working_minutes_sum_min, $working_minutes_sum_max);
                $minutes_separated = $this->getMinutesSeparated($working_minutes);
                $working_minutes_separated = [];
                $breaking_minutes_separated = [];
                if ($minutes_separated['work_1'] > 0) {
                    array_push($working_minutes_separated, $minutes_separated['work_1']);
                    array_push($breaking_minutes_separated, $minutes_separated['break_1']);
                }
                if ($minutes_separated['work_2'] > 0) {
                    array_push($working_minutes_separated, $minutes_separated['work_2']);
                    array_push($breaking_minutes_separated, $minutes_separated['break_2']);
                }

                $this->create(
                    $user_id,
                    $name_list,
                    $date,
                    $time,
                    $working_minutes,
                    $working_minutes_separated,
                    $breaking_minutes_separated,
                );
            }

            $datetime->modify('+1 day');
        }
    }

    /**
     * データを提供する ($working_minutes_separated, $breaking_minutes_separated用)
     * @return array
     */
    function getMinutesSeparated(int $working_minutes): array
    {
        if ($working_minutes < 300) {
            return [
                'work_1' => 0,
                'work_2' => 0,
                'break_1' => 0,
                'break_2' => 0,
            ];
        } elseif ($working_minutes < 480) {
            return [
                'work_1' => rand($working_minutes / 3, $working_minutes * 2 / 3),
                'work_2' => 0,
                'break_1' => 30,
                'break_2' => 0,
            ];
        } else {
            $randomNumber = random_int(0, 99);

            if ($randomNumber < 60) {
                return [
                    'work_1' => rand($working_minutes / 3, $working_minutes * 2 / 3),
                    'work_2' => 0,
                    'break_1' => 60,
                    'break_2' => 0,
                ];
            } else {
                $break_1 = rand(20, 40);
                return [
                    'work_1' => rand($working_minutes / 3, $working_minutes / 2),
                    'work_2' => rand($working_minutes / 4, $working_minutes / 3),
                    'break_1' => $break_1,
                    'break_2' => 60 - $break_1,
                ];
            }
        }
    }

    /**
     * 出勤時刻用のランダムな時刻を提供する (08:00:00~10:29:59の間)
     * @return string
     */
    private function getRandTime(): string
    {
        $startHour = rand(8, 10);

        $startMinute = ($startHour == 10) ? rand(0, 29) : rand(0, 59);

        $startSecond = rand(0, 59);

        $dateTime = new DateTime();
        $dateTime->setTime($startHour, $startMinute, $startSecond);

        return $dateTime->format('H:i:s');
    }

    /**
     * 出勤から退勤まで1セッションのレコード群を作成する
     * @return void
     */
    private function create(
        string $user_id,
        array $name_list,
        string $date,
        string $time,
        int $working_minutes,
        array $working_minutes_separated,
        array $breaking_minutes_separated,
    ): void {
        $dateTime = new DateTime($date . ' ' . $time);

        $name = $name_list[$user_id];
        $session_id = Str::uuid()->toString();

        $data =  [
            'target_user_id' => $user_id,
            ConstParams::AT_SESSION_ID => $session_id,
            ConstParams::AT_RECORD_DATE => $dateTime->format('Y-m-d'),
            ConstParams::AT_RECORD_TIME => $dateTime->format('H:i:s'),
            ConstParams::CREATED_BY => $name,
            ConstParams::UPDATED_BY => $name,
        ];

        //出勤レコードを作る
        $this->createNewRecord($data, $dateTime, ConstParams::AT_RECORD_START_WORK);

        while (count($working_minutes_separated) > 0) {
            //時間を進める
            $working_minute = array_shift($working_minutes_separated);
            $interval = $this->getInterval($working_minute);
            $dateTime->add($interval);

            //休憩開始レコードを作る
            $this->createNewRecord($data, $dateTime, ConstParams::AT_RECORD_START_BREAK);
            //時間を進める
            $breaking_minute = array_shift($breaking_minutes_separated);
            $interval = $this->getInterval($breaking_minute);
            $dateTime->add($interval);

            //休憩終了レコードを作る
            $this->createNewRecord($data, $dateTime, ConstParams::AT_RECORD_FINISH_BREAK);

            //引く
            $working_minutes -= $working_minute;
        }

        //時間を進める
        $interval = $this->getInterval($working_minutes);
        $dateTime->add($interval);

        //退勤レコードを作る
        $this->createNewRecord($data, $dateTime, ConstParams::AT_RECORD_FINISH_WORK);
    }

    /**
     * at_recordを1つ作成する
     * @return array
     */
    private function createNewRecord(array $data, DateTime $dateTime, string $at_record_type): void
    {
        $data =  [
            'target_user_id' => $data['target_user_id'],
            ConstParams::AT_SESSION_ID => $data[ConstParams::AT_SESSION_ID],
            ConstParams::AT_RECORD_TYPE => $at_record_type,
            ConstParams::AT_RECORD_DATE => $dateTime->format('Y-m-d'),
            ConstParams::AT_RECORD_TIME => $dateTime->format('H:i:s'),
            ConstParams::CREATED_BY => $data[ConstParams::CREATED_BY],
            ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
        ];

        $new_record = AttendanceRecord::createNewRecord($data);

        // 登録・更新日時を、打刻日時と同じにする
        $new_record->created_at = $dateTime->format('Y-m-d H:i:s');
        $new_record->updated_at = $dateTime->format('Y-m-d H:i:s');
        $new_record->save();
    }

    /**
     * DateTimeの時刻を進めるためにつかうDateIntervalを作成する
     * @return DateInterval
     */
    private function getInterval(int $minutesToAdd): DateInterval
    {
        $hours = floor($minutesToAdd / 60);
        $minutes = $minutesToAdd % 60;
        return new DateInterval(sprintf('PT%dH%dM', $hours, $minutes));
    }
}
