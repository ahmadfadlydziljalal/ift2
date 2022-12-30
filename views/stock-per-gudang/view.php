<?php

use app\models\Card;
use app\models\StockPerGudangByCardSearch;
use yii\web\View;


/* @var $this View */
/* @var $card Card|null */
/* @var $searchModel StockPerGudangByCardSearch */
/* @var $dataProvider */

$this->title = 'Stock di ' . $card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-per-gudang-index">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <table class="table table-bordered w-100">
        <thead>
        <tr class="text-nowrap align-middle text-center">
            <th>No</th>
            <th>Detail Barang</th>
            <th>Initialize (Memulai penggunaan sistem)</th>
            <th>In</th>
            <th>Out</th>
            <th>Sisa Stock</th>
            <th>Lokasi</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td></td>
            <td>Diambil dari data:<br/>barang.initialize_stock_quantity</td>
            <td>Diambil dari data:
                <ol>
                    <li>Tanda Terima P.O</li>
                    <li>Claim Petty Cash (Tipe pembelian persediaan / stock)</li>
                </ol>
            </td>
            <td>
                Diambil dari data:<br/>
                <ol>
                    <li>Quotation Delivery Receipt</li>
                </ol>
            </td>
            <td class="text-nowrap">
                <strong>
                    Stock Akhir = Initialize + In - Out
                </strong>
            </td>
            <td>
                Menampilkan detail barang yang masih terdeteksi sebagai stock persediaan dengan detail:<br/>
                <ol>
                    <li>Quantity</li>
                    <li>Block</li>
                    <li>Rak</li>
                    <li>Tier</li>
                    <li>Row</li>
                </ol>

            </td>
        </tr>

        </tbody>
    </table>


</div>