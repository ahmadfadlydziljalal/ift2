<?php

namespace app\models\form;

use yii\base\Model;

/**  Excel mempunyai Format sebagai berikut:
 * ```
 * A => No (Nomor Urut)
 * B => Part Number
 * C => Description (Nama Barang)
 * D => Kode Vendor
 * E => Qty Barang
 * F => Harga Per Item
 * G => Total Harga
 * H => Stock
 * I => Remark
 * ```
 * Contoh php array dari Excel:
 *
 * ```
 * [
 *  [
 *      'No',
 *      'PN',
 *      'Description',
 *      'Qty',
 *      'Price/Item',
 *      'TOTAL Price',
 *      'STOCK ',
 *      'REMARK',
 *      null,
 *      null,
 *      null,
 *      null,
 *      null,
 *  ],
 *  [
 *      '1',
 *      '60000075',
 *      'Radiator Assembly',
 *      '3',
 *      '16,007,000',
 *      '48,021,000',
 *      '0',
 *      'TRANS CONTINENT',
 *      null,
 *      null,
 *      null,
 *      null,
 *      null,
 *  ],
 * [
 *      '2',
 *      '14181873',
 *      'Sealing Kit',
 *      '6',
 *      '276,000',
 *      '1,656,000',
 *      '0',
 *      'SEACON LNJ',
 *      null,
 *      null,
 *      null,
 *      null,
 *      null,
 *      ],
 * ]
 * ```
 *
 */
class ImportMaterialRequestExcelFormRecord extends Model {
    public ?string $nomor = null;
    public ?string $part_number = null;
    public ?string $description = null;
    public ?string $kode_vendor = null;
    public ?string $quantity = null;
    public ?string $harga_per_item = null;
    public ?string $total_harga = null;
    public ?string $stock = null;
    public ?string $remark = null;
    public ?string $satuan_id = null;

    public function rules() {
        return [
            [['part_number', 'kode_vendor', 'quantity', 'harga_per_item', 'satuan_id'], 'required'],
            [['remark', 'description'], 'safe'],
        ];
    }
}