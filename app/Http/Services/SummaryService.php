<?php

namespace App\Http\Services;

use App\Const\ConstParams;
use App\Models\AttendanceRecord;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

class SummaryService
{
    /**
     * サマリー画面を返す
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return $this->generateSummary('2023-10-16');
    }

    /**
     * 画面からのリクエストを受け取り、データとして次の関数に渡す
     * @return RedirectResponse
     */
    public function post(Request $request): RedirectResponse
    {
        $date = $request->input('date');
        return $this->generateSummary($date);
    }

    /**
     * サマリー画面を返す
     * @return View
     */
    public function showSummary(): View
    {
        return view('summary.index', [
            'data' => session('data'),
        ]);
    }

    /** 
     * 特定の日のサマリー用データを準備する
     * @return RedirectResponse
     *  */
    private function generateSummary(string $date): RedirectResponse
    {
        try {
            $inputDate = DateTime::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0);
            $this->validateDate($inputDate);

            $recordSets = AttendanceRecord::getDataForSummary($inputDate);
            $rowsSums = $this->makeRowsSums($recordSets);
            $data = [
                'date' => $date,
                'rows' => $rowsSums['rows'],
                'sums' => $rowsSums['sums'],
            ];

            return redirect()->route('summary.show')->with(['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->route('top')->withErrors(['message' => 'SummaryService::generateSummaryでエラー' . $e->getMessage()])->withInput();
        }
    }

    /**
     * 入力された日付が今日を含め未来の日だった場合、例外を投げる
     * @return void
     */
    private function validateDate(DateTime $inputDate): void
    {
        $today = new DateTime();
        $today->setTime(0, 0, 0);

        if ($inputDate >= $today) {
            $yesterday = clone $today;
            $yesterday->modify('-1 day');
            throw new Exception($yesterday->format('Y-m-d') . '以前の日付を選択してください。');
        }
    }

    /**
     * rows配列とsums配列を作成し、返す
     * @return array
     */
    private function makeRowsSums(array $recordSets): array
    {
        //この後のforeach処理で使う変数をあらかじめ初期化
        $total_working_seconds = 0;
        $total_breaking_seconds = 0;
        $total_cost_of_labor = 0.;

        $rows = [];
        /*recordSetごとに以下の処理
            １$rowを作る
            ２$rowを$rowsに詰め込む
            */
        foreach ($recordSets as $recordSet) {
            $start_work_record = $recordSet['start_work_record'];
            $finish_work_record = $recordSet['finish_work_record'];
            $start_break_records = $recordSet['start_break_records'];
            $finish_break_records = $recordSet['finish_break_records'];

            //休憩時間を算出する
            $breaking_seconds = 0;
            for ($i = 0; $i < count($start_break_records); $i++) {
                $breaking_seconds += $this->calcBreakingSeconds(
                    $start_break_records[$i],
                    $finish_break_records[$i],
                );
            }
            $breaking_time = $this->secsToHours($breaking_seconds);

            //労働時間を算出する
            $working_seconds = $this->calcWorkingSeconds(
                $start_work_record,
                $finish_work_record,
                $breaking_seconds,
            );
            $working_time = $this->secsToHours($working_seconds);

            $cost_of_labor = $this->calcCostOfLabor(
                $finish_work_record[ConstParams::USER_ID],
                $working_time,
            );

            $row = [
                'name' => $finish_work_record[ConstParams::KANA_LAST_NAME] . $finish_work_record[ConstParams::KANJI_FIRST_NAME],
                'start_work_time' => $start_work_record[ConstParams::AT_RECORD_TIME],
                'finish_work_time' => $finish_work_record[ConstParams::AT_RECORD_TIME],
                'working_hours' => $working_time['hour'] . '時間' . $working_time['minute'] . '分',
                'breaking_hours' => $breaking_time['hour'] . '時間' . $breaking_time['minute'] . '分',
                'cost_of_labor' => $cost_of_labor,
            ];
            array_push($rows, $row);

            $total_working_seconds += $working_seconds;
            $total_breaking_seconds += $breaking_seconds;
            $total_cost_of_labor += $cost_of_labor;
        }

        $total_working_time = $this->secsToHours($total_working_seconds);
        $total_breaking_time = $this->secsToHours($total_breaking_seconds);

        $sums = [
            'working_hours' => $total_working_time['hour'] . '時間' . $total_working_time['minute'] . '分',
            'breaking_hours' => $total_breaking_time['hour'] . '時間' . $total_breaking_time['minute'] . '分',
            'cost_of_labor' => $total_cost_of_labor,
        ];

        return [
            'rows' => $rows,
            'sums' => $sums,
        ];
    }

    /**
     * 休憩開始と終了のレコード配列をat_record_dateとat_record_timeで昇順ソートし、開始と終了が対応するように並べる
     * @return Integer
     */
    // private function sortBreakRecords(array $start_break_records, array $finish_break_records): void
    // {
    //     usort($start_break_records, function ($a, $b) {
    //         if ($a['at_record_date'] === $b['at_record_date']) {
    //             return $a['at_record_time'] <=> $b['at_record_time'];
    //         }
    //         return $a['at_record_date'] <=> $b['at_record_date'];
    //     });

    //     usort($finish_break_records, function ($a, $b) {
    //         if ($a['at_record_date'] === $b['at_record_date']) {
    //             return $a['at_record_time'] <=> $b['at_record_time'];
    //         }
    //         return $a['at_record_date'] <=> $b['at_record_date'];
    //     });
    // }

    /**
     * 休憩時間を返す
     * @return int
     */
    private function calcBreakingSeconds(array $start_break_record, array $finish_break_record): int
    {
        $start_break_datetime = new DateTime(
            $start_break_record[ConstParams::AT_RECORD_DATE]
                . ' '
                . $start_break_record[ConstParams::AT_RECORD_TIME]
        );
        $finish_break_datetime = new DateTime(
            $finish_break_record[ConstParams::AT_RECORD_DATE]
                . ' '
                . $finish_break_record[ConstParams::AT_RECORD_TIME]
        );

        $interval = $start_break_datetime->diff($finish_break_datetime);
        $break_seconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
        return $break_seconds;
    }

    /**
     * 休憩時間を除いた労働時間を返す
     * @return int
     */
    private function calcWorkingSeconds(array $start_work_record, array $finish_work_record, int $total_breaking_seconds): int
    {
        $start_break_datetime = new DateTime(
            $start_work_record[ConstParams::AT_RECORD_DATE]
                . ' '
                . $start_work_record[ConstParams::AT_RECORD_TIME]
        );
        $finish_break_datetime = new DateTime(
            $finish_work_record[ConstParams::AT_RECORD_DATE]
                . ' '
                . $finish_work_record[ConstParams::AT_RECORD_TIME]
        );

        $interval = $start_break_datetime->diff($finish_break_datetime);
        $working_seconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
        return $working_seconds - $total_breaking_seconds;
    }

    /**
     * 秒の時間を時間と分に変換する
     * @return array
     */
    private function secsToHours(int $seconds): array
    {
        return [
            'hour' => floor($seconds / 3600),
            'minute' => floor(($seconds % 3600) / 60),
        ];
    }

    /**
     * 秒の時間を時間と分に変換する
     * @return float
     */
    private function calcCostOfLabor(string $user_id, array $working_time): float
    {
        $hourly_wage = User::findUserByUserId($user_id)->salary->hourly_wage;
        return $hourly_wage * $working_time['hour'] + $hourly_wage * ($working_time['minute'] / 60);
    }
}
