<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use App\Http\Requests\AtRecordStoreRequest;
use App\Http\Requests\AtRecordUpdateRequest;
use App\Http\Requests\SearchAtRecordsRequest;
use App\Http\Requests\StampRequest;
use App\Models\AttendanceRecord;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * 打刻レコードに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class AttendanceRecordController extends Controller
{

    /**
     * 打刻画面を返す
     * @return View|RedirectResponse 登録画面か、トップ画面へのリダイレクト
     */
    public function showStamp(): View
    {
        try {
            return view('stamps.index');
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * 出勤のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function startWork(StampRequest $request): RedirectResponse
    {
        try {
            if (!$request->input('target_login_id')) {
                ExceptionThrower::unauthorizedAccess(1103);
            }
            $data = [
                'target_login_id' => $request->input('target_login_id'),
                'at_record_type' => ConstParams::AT_RECORD_START_WORK,
            ];
            return $this->createRecord($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    /** 
     * 退勤のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function finishWork(StampRequest $request): RedirectResponse
    {
        try {
            if (!$request->input('target_login_id')) {
                ExceptionThrower::unauthorizedAccess(1104);
            }
            $data = [
                'target_login_id' => $request->input('target_login_id'),
                'at_record_type' => ConstParams::AT_RECORD_FINISH_WORK,
            ];
            return $this->createRecord($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    /** 
     * 休憩始のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function startBreak(StampRequest $request): RedirectResponse
    {
        try {
            if (!$request->input('target_login_id')) {
                ExceptionThrower::unauthorizedAccess(1105);
            }
            $data = [
                'target_login_id' => $request->input('target_login_id'),
                'at_record_type' => ConstParams::AT_RECORD_START_BREAK,
            ];
            return $this->createRecord($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    /** 
     * 休憩終のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function finishBreak(StampRequest $request): RedirectResponse
    {
        try {
            if (!$request->input('target_login_id')) {
                ExceptionThrower::unauthorizedAccess(1106);
            }
            $data = [
                'target_login_id' => $request->input('target_login_id'),
                'at_record_type' => ConstParams::AT_RECORD_FINISH_BREAK,
            ];
            return $this->createRecord($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    /** 
     * 打刻レコードの新規作成＋コンディションデータの更新 打刻画面からのみ呼び出される。
     * @param array $data バリデーション済みのデータ
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    private function createRecord(array $data): RedirectResponse
    {
        try {
            if (!$data['target_login_id']) {
                ExceptionThrower::unauthorizedAccess(1107);
            }
            return DB::transaction(function () use ($data) {
                $target_user = User::findByLoginId($data['target_login_id']);
                $user_condition = $target_user->condition;

                if (!$user_condition) {
                    ExceptionThrower::fetchFailed(ConstParams::USER_CONDITION_JP, 1101);
                }

                $user_condition->validateConditions($target_user, $data[ConstParams::AT_RECORD_TYPE]);

                if ($data[ConstParams::AT_RECORD_TYPE] === ConstParams::AT_RECORD_START_WORK) {
                    $data[ConstParams::AT_SESSION_ID] = Str::uuid()->toString();
                } else {
                    $data[ConstParams::AT_SESSION_ID] = AttendanceRecord::findSessionId($target_user->user_id);
                }

                $name = $target_user->getKanjiFullName();
                $data[ConstParams::AT_RECORD_DATE] = getToday();
                $data[ConstParams::AT_RECORD_TIME] = getCurrentTime();

                $formatted_data = $this->formatDataForAtRecord($target_user->user_id, $name, $data);

                $new_record = AttendanceRecord::createNewRecord($formatted_data);

                $param = [
                    'login_id' => $target_user->login_id,
                    'name' => $target_user->getKanjiFullName(),
                    'type' => getAtRecordTypeNameJP($formatted_data[ConstParams::AT_RECORD_TYPE]),
                    'date' => $new_record->at_record_date,
                    'time' => $new_record->at_record_time,
                ];

                return redirect()
                    ->route('stamps.result')
                    ->with(['param' => $param]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    /**
     * 打刻処理成功画面を返す
     * @return View|RedirectResponse 登録画面か、打刻画面へのリダイレクト
     */
    public function showStampResult(): View
    {
        try {
            if (!session('param')) {
                ExceptionThrower::unauthorizedAccess(1108);
            }
            return view('stamps.result', session('param'));
        } catch (Exception $e) {
            return redirect()
                ->route('stamps.index')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの登録画面（打刻画面ではない）を返す
     * @return View|RedirectResponse 登録画面か、トップ画面へのリダイレクト
     */
    public function create(): View | RedirectResponse
    {
        try {
            return view('at_records.create');
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * 打刻レコードの新規作成　管理者用作成画面からのみ呼び出される。
     * @param AtRecordStoreRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function createRecordByAdmin(AtRecordStoreRequest $request): RedirectResponse
    {
        try {
            if (!$request->target_login_id) {
                ExceptionThrower::unauthorizedAccess(1109);
            }

            return DB::transaction(function () use ($request) {
                $user_id = User::findByLoginId($request->target_login_id)->user_id;
                $validated_data = $request->validated();
                $name = User::findByUserId($validated_data['created_by_user_id'])->getKanjiFullName();
                $formatted_data = $this->formatDataForAtRecord($user_id, $name, $validated_data);

                $new_record_id = AttendanceRecord::createNewRecord($formatted_data)->at_record_id;
                $record = AttendanceRecord::searchById($new_record_id);
                $at_record_labels = $record->labels();
                $at_record_data = $record->data();

                return redirect()
                    ->route('at_records.create.result', [
                        ConstParams::AT_RECORD_ID => $new_record_id,
                    ])->with([
                        'at_record_id' => $new_record_id,
                        'at_record_labels' => $at_record_labels,
                        'at_record_data' => $at_record_data,
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors([
                    'messages' => $e->getMessage()
                ])
                ->withInput();
        }
    }

    /**
     * 打刻レコードの新規作成結果画面を返す
     * @return View|RedirectResponse 結果表示画面か、トップ画面へのリダイレクト
     */
    public function showCreateResult(): View | RedirectResponse
    {
        try {
            if (!session('at_record_id')) {
                ExceptionThrower::unauthorizedAccess(1110);
            }
            return view('at_records.createResult', [
                'at_record_id' => session('at_record_id'),
                'at_record_labels' => session('at_record_labels'),
                'at_record_data' => session('at_record_data'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコード詳細画面を返す
     * @param int $at_record_id 表示対象のID
     * @return View|RedirectResponse  詳細画面か、検索画面へのリダイレクト
     */
    public function show(int $at_record_id): View | RedirectResponse
    {
        try {
            $record = AttendanceRecord::searchById($at_record_id);
            $at_record_labels = $record->labels();
            $at_record_data = $record->data();
            return view('at_records.show', [
                'at_record_id' => $record->at_record_id,
                'at_record_labels' => $at_record_labels,
                'at_record_data' => $at_record_data,
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコード検索画面を返す
     * @param Request $request バリデーション未実施のリクエスト
     * @return View|RedirectResponse 検索画面か、トップ画面へのリダイレクト
     */
    public function showSearchPage(Request $request): View | RedirectResponse
    {
        try {
            if ($request->input('column')) {
                // 検索ボタンを押下したとき

                // カスタムフォームリクエストを初めから利用すると、
                // リダイレクトループが発生してしまうため、あえてここでバリエーション実行
                $validator = Validator::make(
                    $request->all(),
                    (new SearchAtRecordsRequest)->rules(),
                    (new SearchAtRecordsRequest)->messages(),
                    (new SearchAtRecordsRequest)->attributes(),
                );

                if ($validator->fails()) {
                    return redirect('at_records/search')
                        ->withErrors($validator)
                        ->withInput();
                }

                $validated_data = $validator->validated();
                $formatted_data = $this->formatSearchRequirements(false, $validated_data);
                $results = $this->search($formatted_data['search_requirements'], false);
            } else {
                // 検索画面を最初に開いたとき
                $formatted_data = $this->formatSearchRequirements(true);
                $results = null;
            }

            return view('at_records/search', [
                'results' => $results,
                'search_requirements' => $formatted_data['search_requirements'],
                'search_requirement_labels' => $formatted_data['search_requirement_labels'],
                'search_requirements_data' => $formatted_data['search_requirements_data'],
                'default_dates' => $formatted_data['default_dates'],
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 検索条件に基づき、打刻レコードの検索結果をCSVで出力する
     * @param Request $request バリデーション未実施のリクエスト
     * @return Response|RedirectResponse CSVのダウンロードが開始するか、検索画面へのリダイレクト
     */
    public function exportCsv(SearchAtRecordsRequest $request): Response | RedirectResponse
    {
        try {
            $validated_data = $request->validated();
            $formatted_data = $this->formatSearchRequirements(false, $validated_data);
            $results = $this->search($formatted_data['search_requirements'], true);
            $response_data = $this->createCSV($formatted_data, $results);

            return response($response_data['csv'], 200)
                ->withHeaders($response_data['headers']);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 検索条件と結果に基づき、CSVを作成する
     * @param array $data 検索条件
     * @param array $results 検索条件と結果に基づき、CSVを作成する
     * @return array 
     */
    private static function createCSV(array $data, array $results): array
    {

        $headers = [
            'Content-Type'
            => 'text/csv',
            'Content-Disposition'
            => 'attachment; filename="AtRecords_'
                . $data['search_requirements']['start_date']
                . '_' . $data['search_requirements']['end_date']
                . '.csv"',
        ];

        // 出力データの作成
        $output = fopen('php://temp', 'r+');
        fputcsv($output, [
            ConstParams::AT_RECORD_ID_JP,
            ConstParams::USER_ID_JP,
            ConstParams::AT_RECORD_TYPE_JP,
            ConstParams::AT_RECORD_TYPE_TRANSLATED_JP,
            ConstParams::AT_RECORD_DATE_JP,
            ConstParams::AT_RECORD_TIME_JP,
            ConstParams::CREATED_BY_JP,
            ConstParams::UPDATED_BY_JP,
            ConstParams::CREATED_AT_JP,
            ConstParams::UPDATED_AT_JP,
        ]);

        foreach ($results as $result) {
            fputcsv($output, [
                $result[ConstParams::AT_RECORD_ID],
                $result[ConstParams::USER_ID],
                $result[ConstParams::AT_RECORD_TYPE],
                $result[ConstParams::AT_RECORD_TYPE_TRANSLATED],
                $result[ConstParams::AT_RECORD_DATE],
                $result[ConstParams::AT_RECORD_TIME],
                $result[ConstParams::CREATED_BY],
                $result[ConstParams::UPDATED_BY],
                $result[ConstParams::CREATED_AT],
                $result[ConstParams::UPDATED_AT],
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return [
            'headers' => $headers,
            'csv' => $csv,
        ];
    }

    /**
     * 検索条件に基づき、打刻レコードを検索する
     * @param array $search_requirements 検索条件
     * @param bool $asArray 検索結果を配列で受け取るかどうか
     * @return LengthAwarePaginator|array 検索結果
     */
    private function search(array $search_requirements, bool $asArray): LengthAwarePaginator | array
    {
        return AttendanceRecord::search($search_requirements, $asArray);
    }

    /**
     * 打刻レコード編集画面を返す
     * @param int $at_record_id 更新対象のID
     * @return View|RedirectResponse 編集画面か、検索画面へのリダイレクト
     */
    public function edit(int $at_record_id): View | RedirectResponse
    {
        try {
            $data = AttendanceRecord::searchById($at_record_id)->dataArray();
            return view('at_records.edit', ['data' => $data]);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * 打刻レコードを更新する
     * @param int $at_record_id 更新対象のID
     * @param AtRecordUpdateRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse  更新結果画面か、前の画面へのリダイレクト
     *  */
    public function update(int $at_record_id, AtRecordUpdateRequest $request): RedirectResponse
    {
        try {
            if (!$request) {
                ExceptionThrower::unauthorizedAccess(1111);
            }
            return DB::transaction(function () use ($at_record_id, $request) {
                $data = $request->validated();
                $result = AttendanceRecord::updateInfo($at_record_id, $data);
                $record = AttendanceRecord::searchById($at_record_id);
                $at_record_labels = $record->labels();
                $at_record_data = $record->data();
                return redirect()
                    ->route('at_records.update.result', [ConstParams::AT_RECORD_ID => $result['data'][ConstParams::AT_RECORD_ID]])
                    ->with([
                        'at_record_id' => $record->at_record_id,
                        'at_record_labels' => $at_record_labels,
                        'at_record_data' => $at_record_data,
                        'count' => $result['count'],
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの更新結果画面を返す
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showUpdateResult(): View | RedirectResponse
    {
        try {
            if (!session('at_record_id')) {
                ExceptionThrower::unauthorizedAccess(1112);
            }
            return view('at_records.editResult', [
                'at_record_id' => session('at_record_id'),
                'at_record_labels' => session('at_record_labels'),
                'at_record_data' => session('at_record_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの削除確認画面を返す
     * @param Request $request IDを受け取るために使う
     * @return View|RedirectResponse 確認画面か検索画面へのリダイレクト
     */
    public function confirmDestroy(Request $request): View | RedirectResponse
    {
        try {
            $record = AttendanceRecord::searchById($request->at_record_id);
            $at_record_labels = $record->labels();
            $at_record_data = $record->data();
            return view('at_records.confirmDestroy', [
                'at_record_id' => $record->at_record_id,
                'at_record_labels' => $at_record_labels,
                'at_record_data' => $at_record_data,
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * 打刻レコードを削除する
     * @param int $at_record_id 削除対象のID
     * @return RedirectResponse  削除結果画面か、前の画面へのリダイレクト
     */
    public function destroy(int $at_record_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($at_record_id) {
                $record = AttendanceRecord::searchById($at_record_id);
                if (!$record) {
                    ExceptionThrower::notExist(ConstParams::AT_RECORD_JP, 1102);
                }
                $at_record_labels = $record->labels();
                $at_record_data = $record->data();
                $count = AttendanceRecord::deletedById($at_record_id);
                return redirect()->route('at_records.delete.result', [
                    ConstParams::AT_RECORD_ID => $at_record_id,
                ])->with([
                    'at_record_labels' => $at_record_labels,
                    'at_record_data' => $at_record_data,
                    'count' => $count,
                ]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの削除結果画面を返す
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showDestroyResult(): View | RedirectResponse
    {
        try {
            if (!session('at_record_labels')) {
                ExceptionThrower::unauthorizedAccess(1113);
            }
            return view('at_records.destroyResult', [
                'at_record_labels' => session('at_record_labels'),
                'at_record_data' => session('at_record_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('at_records.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの作成に必要なデータを整形する
     * @param int $user_id 打刻者のID
     * @param string $name 更新者の名前
     * @param array $data バリエーション済みのデータ
     * @return array 整形済みのデータの配列
     */
    private function formatDataForAtRecord(int $user_id, string $name, array $data): array
    {
        $formatted_data = [
            'target_user_id' => $user_id,
            ConstParams::AT_SESSION_ID => $data[ConstParams::AT_SESSION_ID],
            ConstParams::AT_RECORD_TYPE => $data[ConstParams::AT_RECORD_TYPE],
            ConstParams::AT_RECORD_DATE => $data[ConstParams::AT_RECORD_DATE],
            ConstParams::AT_RECORD_TIME => $data[ConstParams::AT_RECORD_TIME],
            ConstParams::CREATED_BY => $name,
        ];

        return $formatted_data;
    }


    /**
     * 打刻レコード検索の実行と結果表示に必要なデータを整形する
     * @param bool $is_empty 空の配列を返すかどうか
     * @param array $data バリエーション済みの検索条件
     * @return array
     */
    private static function formatSearchRequirements(bool $is_empty, array $data = []): array
    {
        if ($is_empty) {
            return [
                'search_requirements' => null,
                'search_requirement_labels' => null,
                'search_requirements_data' => null,
                'default_dates' => self::defaultDates(),
            ];
        }

        $search_field = $data['search_field'] ?? 'all';
        $keyword = $data['keyword'] ?? 'empty';
        if ($search_field === 'all') {
            $keyword = 'all';
        }
        $search_requirements = [
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'search_field' => $search_field,
            'search_field_jp' => getFieldNameJP($search_field),
            'keyword' => $keyword,
            'column' => $data['column'],
            'order' => $data['order'],
        ];
        $search_requirement_labels = [
            '検索種別',
            'キーワード',
            '開始日',
            '終了日',
        ];
        $search_requirements_data = [
            getFieldNameJP($search_field),
            $keyword,
            $search_requirements['start_date'],
            $search_requirements['end_date'],
        ];

        $default_dates = self::defaultDates();

        return [
            'search_requirements' => $search_requirements,
            'search_requirement_labels' => $search_requirement_labels,
            'search_requirements_data' => $search_requirements_data,
            'default_dates' => $default_dates,
        ];
    }



    /**
     * at_records 検索用に、開始日と終了日のデフォルト値を返す。
     * @return array デフォルトの開始日と終了日
     */
    private static function defaultDates(): array
    {
        $start_date = date('Y-m-d', strtotime('-1 week'));
        $end_date = date('Y-m-d', strtotime('+1 day'));
        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
