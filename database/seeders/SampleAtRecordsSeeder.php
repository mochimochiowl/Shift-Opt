<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\AttendanceRecord;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleAtRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $date_from = '2023/09/01';
        // $date_to = '2023/09/30';
        // $start_time_from = '09:30:00';
        // $start_time_to = '12:30:00';
        // $dataPerDay = 4;
        // $working_hours_from = 6.00;
        // $working_hours_to = 10.00;
        $this->create('2', '2023-09-01', '09:30:48');
        $this->create('3', '2023-09-01', '11:16:25');
        $this->create('4', '2023-09-01', '10:00:44');
        $this->create('5', '2023-09-01', '09:58:01');
        $this->create('6', '2023-09-01', '12:20:13');
    }

    private function create(string $user_id, string $date, string $time): void
    {
        $dateTime = new DateTime($date . ' ' . $time);
        $working_minutes = 540;
        $working_minutes_separated = [
            210, // 1回目の休憩前の労働時間
            180, // 2回目の休憩前の労働時間
        ];
        $breaking_minutes_separated = [
            20, // 1回目の休憩時間
            40, // 2回目の休憩時間
        ];

        $name = User::findUserByUserId($user_id)->getKanjiFullName();
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

    private function getInterval(int $minutesToAdd): DateInterval
    {
        $hours = floor($minutesToAdd / 60);
        $minutes = $minutesToAdd % 60;
        return new DateInterval(sprintf('PT%dH%dM', $hours, $minutes));
    }
}
