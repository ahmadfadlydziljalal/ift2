<?php

namespace app\models\form;

use app\models\Card;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;

/**
 * Represents a form for generating quotation reports within a specific period.
 * This class is used to encapsulate the data and logic required for handling
 * and processing the report generation based on the provided criteria.
 */
class LaporanQuotationPerPeriodForm extends Model
{
    const PERIOD_TYPE_YEAR = 1;
    const PERIOD_TYPE_MONTH_YEAR = 2;
    const PERIOD_TYPE_DAY = 3;
    const PERIOD_DATE_RANGE = 4;

    public ?string $periodType = null;
    public ?string $periodYear = null;  # TAHUNAN
    public ?string $periodMonthYear = null;  # BULANAN
    public ?string $periodDate = null; # HARIAN
    public ?string $periodDateRange = null; // DATE RANGE
    public ?string $customerId = null;

    /**
     * Provides an associative array of period types mapped to their corresponding labels.
     *
     * @return array An associative array where keys represent period type identifiers, and values are the respective labels.
     */
    public static function optionsPeriodType(): array
    {
        return [
            self::PERIOD_TYPE_YEAR => 'Tahunan',
            self::PERIOD_TYPE_MONTH_YEAR => 'Bulanan',
            self::PERIOD_TYPE_DAY => 'Harian',
            self::PERIOD_DATE_RANGE => 'Rentang Waktu'
        ];
    }

    /**
     * Returns the label corresponding to the given period type, if it exists in the options.
     * Otherwise, returns the original period type.
     *
     * @param int $periodType The period type identifier to retrieve the corresponding label for.
     * @return int|string The label corresponding to the period type, or the period type itself if no label is found.
     */
    public static function optionsPeriodTypeLabel(int $periodType): int|string
    {
        if (isset(self::optionsPeriodType()[$periodType])) {
            return self::optionsPeriodType()[$periodType];
        }
        return $periodType;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules(): array
    {
        return [
            ['periodType', 'required'],
            ['periodType', 'in', 'range' => array_keys(self::optionsPeriodType())],
            [
                ['periodYear'],
                'required',
                'when' => function ($model) {
                    return $model->periodType == self::PERIOD_TYPE_YEAR;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#laporanquotationperperiodform-periodtype').val() == '" . self::PERIOD_TYPE_YEAR . "';
                }"
            ],
            [['periodMonthYear'], 'required', 'when' => function ($model) {
                return $model->periodType == self::PERIOD_TYPE_MONTH_YEAR;
            }, 'whenClient' => "function (attribute, value) {
                return $('#laporanquotationperperiodform-periodtype').val() == '" . self::PERIOD_TYPE_MONTH_YEAR . "';
            }"],
            [['periodYear'], 'trim'],
            [['periodDate'], 'required', 'when' => function ($model) {
                return $model->periodType == self::PERIOD_TYPE_DAY;
            }, 'whenClient' => "function (attribute, value) {
                return $('#laporanquotationperperiodform-periodtype').val() == '" . self::PERIOD_TYPE_DAY . "';
            }"],
            [['periodDateRange'], 'required', 'when' => function ($model) {
                return $model->periodType == self::PERIOD_DATE_RANGE;
            }, 'whenClient' => "function (attribute, value) {
                return $('#laporanquotationperperiodform-periodtype').val() == '" . self::PERIOD_DATE_RANGE . "';
            }"],
            [['customerId'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'periodYear' => 'Tahun',
            'periodMonthYear' => 'Bulan - Tahun',
            'periodDate' => 'Tanggal',
            'periodDateRange' => 'Rentang Waktu',
            'customerId' => 'Customer'
        ]);
    }

    /**
     * @return Query
     * @throws InvalidConfigException
     */
    public function buildQuotationReportQuery()
    {
        // --- Build kondisi WHERE dinamis untuk CTE base (mengacu pada alias q di CTE) ---
        $conditions = [];
        $params = [];

        switch ($this->periodType) {
            case self::PERIOD_TYPE_YEAR:
                if (!empty($this->periodYear)) {
                    $conditions[] = 'YEAR(q.tanggal) = :periodYear';
                    $params[':periodYear'] = $this->periodYear;
                }
                break;

            case self::PERIOD_TYPE_MONTH_YEAR:
                if (!empty($this->periodMonthYear)) {
                    // asumsi format "MM-YYYY" atau "M-YYYY"
                    [$month, $year] = array_map('trim', explode('-', $this->periodMonthYear) + [null, null]);
                    $conditions[] = 'MONTH(q.tanggal) = :periodMonth';
                    $conditions[] = 'YEAR(q.tanggal) = :periodYear';
                    $params[':periodMonth'] = $month;
                    $params[':periodYear'] = $year;
                }
                break;

            case self::PERIOD_TYPE_DAY:
                if (!empty($this->periodDate)) {
                    $conditions[] = 'DATE(q.tanggal) = :periodDate';
                    $params[':periodDate'] = Yii::$app->formatter->asDate($this->periodDate, 'php:Y-m-d');
                }
                break;

            case self::PERIOD_DATE_RANGE:
                if (!empty($this->periodDateRange)) {
                    [$start, $end] = array_map('trim', explode(' sampai ', $this->periodDateRange) + [null, null]);
                    $conditions[] = 'q.tanggal BETWEEN :periodDateStart AND :periodDateEnd';
                    $params[':periodDateStart'] = Yii::$app->formatter->asDate($start, 'php:Y-m-d');
                    $params[':periodDateEnd'] = Yii::$app->formatter->asDate($end, 'php:Y-m-d');
                }
                break;
        }

        if (!empty($this->customerId)) {
            $conditions[] = 'q.customer_id = :customerId';
            $params[':customerId'] = $this->customerId;
        }

        $whereSql = $conditions ? ' ' . implode(' AND ', $conditions) : '';

        // --- Siapkan SQL untuk tiap CTE (string SQL) ---
        $quotationBarangBaseSql = <<<SQL
            SELECT q.id AS quotation_penjulan_barang_id,
                   ROUND(SUM(qb.quantity * qb.unit_price), 2) AS sum_barang_before_discount,
                   ROUND(SUM(qb.quantity * (qb.unit_price - (qb.unit_price * qb.discount / 100))), 2) AS dpp_barang,
                   q.vat_percentage AS persentase_ppn_barang
            FROM quotation q
            INNER JOIN ift.card c ON q.customer_id = c.id
            INNER JOIN ift.quotation_barang qb ON q.id = qb.quotation_id
            INNER JOIN ift.barang b ON qb.barang_id = b.id
            WHERE {$whereSql}
            GROUP BY q.id
        SQL;
        $quotationBarangPpnSql = <<<SQL
            SELECT qb.*, ROUND(qb.dpp_barang * qb.persentase_ppn_barang / 100, 2) AS ppn_barang
            FROM quotation_barang_base qb
        SQL;
        $quotationBarangFinalSql = <<<SQL
            SELECT qw.*, COALESCE(ROUND(qw.dpp_barang + qw.ppn_barang, 2), 0) AS total_price_barang
            FROM quotation_barang_ppn qw
        SQL;
        $quotationServiceBaseSql = <<<SQL
            SELECT q.id AS quotation_penjulan_service_id,
                   COALESCE(ROUND(SUM(qs.quantity * qs.rate), 2), 0) AS sum_service_before_discount,
                   ROUND(SUM(qs.quantity * (qs.rate - (qs.rate * qs.discount / 100))), 2) AS dpp_service,
                   q.vat_percentage AS persentase_ppn_service
            FROM quotation q
            INNER JOIN ift.quotation_service qs ON q.id = qs.quotation_id
            WHERE {$whereSql}
            GROUP BY q.id
        SQL;
        $quotationServicePpnSql = <<<SQL
            SELECT qb.*, COALESCE(ROUND(qb.dpp_service * qb.persentase_ppn_service / 100, 2), 0) AS ppn_service
            FROM quotation_service_base qb
        SQL;
        $quotationServiceFinalSql = <<<SQL
            SELECT qw.*, COALESCE(ROUND(qw.dpp_service + qw.ppn_service, 2), 0) AS total_price_service
            FROM quotation_service_ppn qw
        SQL;

        // --- Main query: daftarkan semua CTE top-level satu per satu (withQuery requires 2 arg) ---
        $query = (new Query());

        $query->withQuery(new Expression($quotationBarangBaseSql), 'quotation_barang_base');
        $query->withQuery(new Expression($quotationBarangPpnSql), 'quotation_barang_ppn');
        $query->withQuery(new Expression($quotationBarangFinalSql), 'quotation_barang_final');

        $query->withQuery(new Expression($quotationServiceBaseSql), 'quotation_service_base');
        $query->withQuery(new Expression($quotationServicePpnSql), 'quotation_service_ppn');
        $query->withQuery(new Expression($quotationServiceFinalSql), 'quotation_service_final');

        // --- Bangun select / join utama ---
        $query->from(['masterQuotation' => 'quotation'])
            ->innerJoin(['customer' => 'card'], 'masterQuotation.customer_id = customer.id')
            ->leftJoin(['penjualanBarang' => 'quotation_barang_final'], 'penjualanBarang.quotation_penjulan_barang_id   = masterQuotation.id')
            ->leftJoin(['penjualanService' => 'quotation_service_final'], 'penjualanService.quotation_penjulan_service_id = masterQuotation.id');

        // Apply filter juga ke masterQuotation
        if ($whereSql) {
            $query->andWhere(new Expression(str_replace('q.', 'masterQuotation.', $whereSql)));
        }

        $query->select([
            'masterQuotation.id',
            'masterQuotation.nomor',
            'masterQuotation.tanggal',
            'customer.nama AS customer',
            'masterQuotation.catatan_quotation_barang',
            'masterQuotation.catatan_quotation_service',
            new Expression('COALESCE(masterQuotation.delivery_fee, 0) AS delivery_fee'),
            new Expression('COALESCE(masterQuotation.materai_fee, 0) AS materai_fee'),

            new Expression('COALESCE(penjualanBarang.sum_barang_before_discount, 0) AS sum_barang_before_discount'),
            new Expression('COALESCE(penjualanBarang.dpp_barang, 0) AS dpp_barang'),
            new Expression('COALESCE(penjualanBarang.persentase_ppn_barang, 0) AS persentase_ppn_barang'),
            new Expression('COALESCE(penjualanBarang.ppn_barang, 0) AS ppn_barang'),
            new Expression('COALESCE(penjualanBarang.total_price_barang, 0) AS total_price_barang'),

            new Expression('COALESCE(penjualanService.sum_service_before_discount, 0) AS sum_service_before_discount'),
            new Expression('COALESCE(penjualanService.dpp_service, 0) AS dpp_service'),
            new Expression('COALESCE(penjualanService.persentase_ppn_service, 0) AS persentase_ppn_service'),
            new Expression('COALESCE(penjualanService.ppn_service, 0) AS ppn_service'),
            new Expression('COALESCE(penjualanService.total_price_service, 0) AS total_price_service'),

            new Expression('
                COALESCE(masterQuotation.delivery_fee, 0) +
                COALESCE(masterQuotation.materai_fee, 0) +
                COALESCE(penjualanBarang.total_price_barang, 0) +
                COALESCE(penjualanService.total_price_service, 0)
            AS grand_total'),
        ])
            ->groupBy('masterQuotation.id')
            ->orderBy(['masterQuotation.id' => SORT_DESC])
            ->params($params);

        return $query;
    }

    public function getFilename(): string
    {
        $string = 'Laporan-' . $this::optionsPeriodTypeLabel($this->periodType) . '-';
        switch ($this->periodType) {
            case self::PERIOD_TYPE_YEAR:
                $string .= $this->periodYear;
                break;

            case self::PERIOD_TYPE_MONTH_YEAR:
                [$month, $year] = array_map('trim', explode('-', $this->periodMonthYear) + [null, null]);
                $string .= $month . ' ' . $year;
                break;

            case self::PERIOD_TYPE_DAY:
                $string .= $this->periodDate;
                break;

            case self::PERIOD_DATE_RANGE:
                [$start, $end] = array_map('trim', explode(' sampai ', $this->periodDateRange) + [null, null]);
                $string .= $start . ' ' . $end;
                break;
        }

        if (!empty($this->customerId)) {
            $string .= '-' . Card::findOne($this->customerId)->nama;
        }

        return $string;


    }


}