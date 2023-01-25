<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
/**
 * @property int $id
 * @property int $bot_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $rich_menu
 * @property string $condition
 * @property string $name
 * @property Bot $bot
 * @property Rule[] $rules
 */
class Stores extends Model
{
    protected $dates = ["arrival_confirmed_at"];
    /**
     * @var array
     */
    protected $fillable = [
      "contractor_id","contractor_name","owner_id","owner_name","area_id","area_name","arv_slip","arv_slip_line","arv_detail_num","other_slip_num","duties_typ_id","duties_typ_name","arv_status","arv_plndate","accept_date","arv_define_date","cust_id","cust_name","branch_id","branch_name","item_id","item_name","search_name","remarks","good_typ_id","good_typ_name","block_id","block_short_name","loc","lot","effective_term","stock_key1","stock_key1_name","stock_key2","stock_key2_name","stock_key3","stock_key3_name","stock_key4","stock_key4_name","arv_pln_qty","arv_acc_qty","arv_chk_qty","bad_state_id","bad_state_name","bad_reason_id","bad_reason_name","back_reason_id","back_reason_name","create_dttm","update_dttm","arv_define_dttm","arv_head_rsv_col001","arv_head_rsv_col002","arv_head_rsv_col003","arv_head_rsv_col004","arv_head_rsv_col005","arv_head_rsv_col006","arv_head_rsv_col007","arv_head_rsv_col008","arv_head_rsv_col009","arv_head_rsv_col010","arv_dtl_rsv_col001","arv_dtl_rsv_col002","arv_dtl_rsv_col003","arv_dtl_rsv_col004","arv_dtl_rsv_col005","arv_dtl_rsv_col006","arv_dtl_rsv_col007","arv_dtl_rsv_col008","arv_dtl_rsv_col009","arv_dtl_rsv_col010","buyer_price","barcode","cust_rsv_col001","cust_rsv_col002","cust_rsv_col003","cust_rsv_col004","cust_rsv_col005","cust_rsv_col006","cust_rsv_col007","cust_rsv_col008","cust_rsv_col009","cust_rsv_col010","item_rsv_col001","item_rsv_col002","item_rsv_col003","item_rsv_col004","item_rsv_col005","item_rsv_col006","item_rsv_col007","item_rsv_col008","item_rsv_col009","item_rsv_col010","arrival_confirmed_at"
    ];


    const LOGI_HEADER = [
      '契約者ID' => 'contractor_id',
      '契約者名' => 'contractor_name',
      '荷主ID' => 'owner_id',
      '荷主名' => 'owner_name',
      '倉庫ID' => 'area_id',
      '倉庫名' => 'area_name',
      '入荷管理番号' => 'arv_slip',
      '入荷管理行番号' => 'arv_slip_line',
      '入荷管理詳細行番号' => 'arv_detail_num',
      '荷主入荷NO' => 'other_slip_num',
      '業務区分ID' => 'duties_typ_id',
      '業務区分名称' => 'duties_typ_name',
      'ステータス区分' => 'arv_status',
      '入荷予定日' => 'arv_plndate',
      '入荷受付日' => 'accept_date',
      '入荷日' => 'arv_define_date',
      '取引先ID' => 'cust_id',
      '取引先名' => 'cust_name',
      '出荷先ID' => 'branch_id',
      '出荷先名' => 'branch_name',
      '商品ID' => 'item_id',
      '商品名' => 'item_name',
      '検索名称' => 'search_name',
      '備考' => 'remarks',
      '品質区分ID' => 'good_typ_id',
      '品質区分' => 'good_typ_name',
      'ブロックID' => 'block_id',
      'ブロック略称' => 'block_short_name',
      'ロケーション' => 'loc',
      'ロット' => 'lot',
      '有効期限' => 'effective_term',
      '在庫キー１' => 'stock_key1',
      '在庫キー１名称' => 'stock_key1_name',
      '在庫キー２' => 'stock_key2',
      '在庫キー２名称' => 'stock_key2_name',
      '在庫キー３' => 'stock_key3',
      '在庫キー３名称' => 'stock_key3_name',
      '在庫キー４' => 'stock_key4',
      '在庫キー４名称' => 'stock_key4_name',
      '予定数' => 'arv_pln_qty',
      '受付数' => 'arv_acc_qty',
      '確定数' => 'arv_chk_qty',
      '不良内容区分ID' => 'bad_state_id',
      '不良内容区分名' => 'bad_state_name',
      '不良理由区分ID' => 'bad_reason_id',
      '不良理由区分名' => 'bad_reason_name',
      '返品理由区分ID' => 'back_reason_id',
      '返品理由区分名' => 'back_reason_name',
      '登録日時' => 'create_dttm',
      '変更日時' => 'update_dttm',
      '入荷確定日' => 'arv_define_dttm',
      'ヘッダ予備項目００１' => 'arv_head_rsv_col001',
      'ヘッダ予備項目００２' => 'arv_head_rsv_col002',
      'ヘッダ予備項目００３' => 'arv_head_rsv_col003',
      'ヘッダ予備項目００４' => 'arv_head_rsv_col004',
      'ヘッダ予備項目００５' => 'arv_head_rsv_col005',
      'ヘッダ予備項目００６' => 'arv_head_rsv_col006',
      'ヘッダ予備項目００７' => 'arv_head_rsv_col007',
      'ヘッダ予備項目００８' => 'arv_head_rsv_col008',
      'ヘッダ予備項目００９' => 'arv_head_rsv_col009',
      'ヘッダ予備項目０１０' => 'arv_head_rsv_col010',
      '明細予備項目００１' => 'arv_dtl_rsv_col001',
      '明細予備項目００２' => 'arv_dtl_rsv_col002',
      '明細予備項目００３' => 'arv_dtl_rsv_col003',
      '明細予備項目００４' => 'arv_dtl_rsv_col004',
      '明細予備項目００５' => 'arv_dtl_rsv_col005',
      '明細予備項目００６' => 'arv_dtl_rsv_col006',
      '明細予備項目００７' => 'arv_dtl_rsv_col007',
      '明細予備項目００８' => 'arv_dtl_rsv_col008',
      '明細予備項目００９' => 'arv_dtl_rsv_col009',
      '明細予備項目０１０' => 'arv_dtl_rsv_col010',
      '仕入単価' => 'buyer_price',
      'バーコード' => 'barcode',
      '取引先予備項目００１' => 'cust_rsv_col001',
      '取引先予備項目００２' => 'cust_rsv_col002',
      '取引先予備項目００３' => 'cust_rsv_col003',
      '取引先予備項目００４' => 'cust_rsv_col004',
      '取引先予備項目００５' => 'cust_rsv_col005',
      '取引先予備項目００６' => 'cust_rsv_col006',
      '取引先予備項目００７' => 'cust_rsv_col007',
      '取引先予備項目００８' => 'cust_rsv_col008',
      '取引先予備項目００９' => 'cust_rsv_col009',
      '取引先予備項目０１０' => 'cust_rsv_col010',
      '商品予備項目００１' => 'item_rsv_col001',
      '商品予備項目００２' => 'item_rsv_col002',
      '商品予備項目００３' => 'item_rsv_col003',
      '商品予備項目００４' => 'item_rsv_col004',
      '商品予備項目００５' => 'item_rsv_col005',
      '商品予備項目００６' => 'item_rsv_col006',
      '商品予備項目００７' => 'item_rsv_col007',
      '商品予備項目００８' => 'item_rsv_col008',
      '商品予備項目００９' => 'item_rsv_col009',
      '商品予備項目０１０' => 'item_rsv_col010',
    ];

    public static function createFromApi($raw){
      $current = Stores::where("arv_slip", $raw["入荷管理番号"])->first();
      if( $current == null ){
        $base = [
          "arrival_confirmed_at" => Carbon::createFromFormat("YmdHis", $raw["入荷確定日時"]),
          "other_slip_num" => $raw["荷主入荷NO"],
        ];
        foreach( $raw as $key => $data ){
          if( !isset(Stores::LOGI_HEADER[$key]) ){
            continue;
          }
          $base[  Stores::LOGI_HEADER[$key] ] = $data;
        }
        return Stores::create($base);
      }else{
        $base = [
          "arrival_confirmed_at" => Carbon::createFromFormat("YmdHis", $raw["入荷確定日時"]),
          "other_slip_num" => $raw["荷主入荷NO"],
        ];
        foreach( $raw as $key => $data ){
          if( !isset(Stores::LOGI_HEADER[$key]) ){
            continue;
          }
          $base[  Stores::LOGI_HEADER[$key] ] = $data;
        }
        $current->fill($base);
        $current->save();
        return $current;     
      }
    }
}
