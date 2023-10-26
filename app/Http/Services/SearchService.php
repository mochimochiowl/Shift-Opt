<?php

namespace App\Http\Services;

use App\Const\ConstParams;

/**
 * ユーザーや打刻レコードの検索に関連するビジネスロジックを管轄する
 * @author mochimochiowl
 * @version 1.0.0
 */
class SearchService
{
    /**
     * ユーザーレコード検索の実行と結果表示に必要なデータを整形する
     * @param bool $is_empty 空の配列を返すかどうか
     * @param array $data バリエーション済みの検索条件
     * @return array 整形済みのデータの配列
     */
    public static function formatUserSearchRequirements(bool $is_empty, array $data = []): array
    {
        if ($is_empty) {
            return [
                'search_requirements' => null,
                'search_requirement_labels' => null,
                'search_requirements_data' => null,
            ];
        }

        $search_field = $data['search_field'] ?? 'all';
        $keyword = $data['keyword'] ?? 'empty';
        if ($search_field === 'all') {
            $keyword = 'all';
        }
        $search_requirements = [
            'search_field' => $search_field,
            'search_field_jp' => self::getFieldNameJP($search_field),
            'keyword' => $keyword,
            'column' => $data['column'],
            'order' => $data['order'],
        ];

        $search_requirement_labels = [
            '検索種別',
            'キーワード',
        ];

        $search_requirements_data = [
            self::getFieldNameJP($search_requirements['search_field']),
            $search_requirements['keyword'],
        ];

        $default_dates = self::defaultDates();

        return [
            'search_requirements' => $search_requirements,
            'search_requirement_labels' => $search_requirement_labels,
            'search_requirements_data' => $search_requirements_data,
        ];
    }

    /**
     * 打刻レコード検索の実行と結果表示に必要なデータを整形する
     * @param bool $is_empty 空の配列を返すかどうか
     * @param array $data バリエーション済みの検索条件
     * @return array
     */
    public static function formatAtRecordSearchRequirements(bool $is_empty, array $data = []): array
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
            'search_field_jp' => self::getFieldNameJP($search_field),
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
            self::getFieldNameJP($search_field),
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
     * 検索条件と結果に基づき、CSVを作成する
     * @param array $data 検索条件
     * @param array $results 検索条件と結果に基づき、CSVを作成する
     * @return array 
     */
    public static function createCSV(array $data, array $results): array
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
     * at_records 検索用に、開始日と終了日のデフォルト値を返す。
     * @return array
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

    /**
     * 検索用の属性「search_field」に対応する日本語表記の項目名を返す
     * @return string
     */
    private static function getFieldNameJP(string $search_field): string
    {
        switch ($search_field) {
            case ConstParams::USER_ID:
                return ConstParams::USER_ID_JP;
            case ConstParams::LOGIN_ID:
                return ConstParams::LOGIN_ID_JP;
            case 'name':
                return '名前（漢字・かな）';
            case ConstParams::EMAIL:
                return ConstParams::EMAIL_JP;
            case 'all':
                return '全件表示';
        }
    }
}
