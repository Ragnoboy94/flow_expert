<?php

namespace App\Jobs;

use App\Models\ExcelRow;
use App\Models\InvalidXmlRecord;
use App\Models\XmlData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckItemNameInXmlData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $excelRow;

    /**
     * Create a new job instance.
     */
    public function __construct(ExcelRow $excelRow)
    {
        $this->excelRow = $excelRow;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $itemName = $this->excelRow->item_name;
        $itemNameParts = explode(',', strtolower($itemName));
        $itemNameShort = $itemNameParts[0];
        $match = XmlData::where('search_name', $itemNameShort)->first();

        if (!$match) {
            if (!InvalidXmlRecord::where('item_name', $itemNameShort)->first()){
                $this->processXmlAndSaveData($itemNameShort);
            }
        } else {
            $this->excelRow->update(['found' => true, 'xml_data_id' => $match->id]);
        }
    }

    private function processXmlAndSaveData($itemName)
    {
        $filePath = public_path('esklp.xml');
        $reader = new \XMLReader();
        $reader->open($filePath);
        $foundMatch = false;

        while ($reader->read()) {
            if ($reader->nodeType == (\XMLReader::ELEMENT) && $reader->localName == 'klp') {
                $klpData = $reader->readOuterXML();
                $klpData_clean = preg_replace('/\W+/u', ' ', $klpData);
                if (stripos(mb_strtolower($klpData_clean), mb_str_pad($itemName, 1, ' ', 2)) !== false) {
                    $xml = simplexml_load_string($klpData);
                    $namespaces = $xml->getNamespaces(true);
                    $data = json_decode(json_encode($xml->children($namespaces['ns2'])), true);
                    if (isset($data['klp_lim_price_list']['klp_lim_price']) && !empty($data['klp_lim_price_list']['klp_lim_price'])) {
                        $klpLimPriceList = $data['klp_lim_price_list']['klp_lim_price'];
                        $lastKlpLimPrice = end($klpLimPriceList);
                        if (isset($lastKlpLimPrice['price_value'])) {
                            $foundMatch = true;
                            $xmlData = XmlData::create([
                                'search_name' => $itemName,
                                'code' => $data['code'] ?? null,
                                'mnn_norm_name' => $data['mnn_norm_name'] ?? null,
                                'dosage_norm_name' => $data['dosage_norm_name'] ?? null,
                                'lf_norm_name' => $data['lf_norm_name'] ?? null,
                                'is_dosed' => $data['is_dosed'] ?? null,
                                'is_znvlp' => $data['is_znvlp'] ?? null,
                                'is_narcotic' => $data['is_narcotic'] ?? null,
                                'trade_name' => $data['trade_name'] ?? null,
                                'pack_1_num' => $data['pack_1']['num'] ?? null,
                                'pack_1_name' => $data['pack_1']['name'] ?? null,
                                'pack_2_num' => $data['pack_2']['num'] ?? null,
                                'pack_2_name' => $data['pack_2']['name'] ?? null,
                                'consumer_total' => $data['consumer_total'] ?? null,
                                'completeness' => $data['completeness'] ?? null,
                                'owner_name' => $data['owner']['name'] ?? null,
                                'owner_country_code' => $data['owner']['country_code'] ?? null,
                                'owner_country_name' => $data['owner']['country_name'] ?? null,
                                'num_reg' => $data['num_reg'] ?? null,
                                'date_reg' => $data['date_reg'] ?? null,
                                'manufacturer_name' => $data['manufacturer']['name'] ?? null,
                                'manufacturer_country_code' => $data['manufacturer']['country_code'] ?? null,
                                'manufacturer_country_name' => $data['manufacturer']['country_name'] ?? null,
                                'date_create' => $data['date_create'] ?? null,
                                'date_start' => $data['date_start'] ?? null,
                                'date_change' => $data['date_change'] ?? null,
                                'price_value' => $lastKlpLimPrice['price_value'],
                                'reg_date' => $lastKlpLimPrice['reg_date'],
                                'reg_num' => $lastKlpLimPrice['reg_num'],
                                'barcode' => $lastKlpLimPrice['barcode'],
                            ]);
                            $this->excelRow->update(['xml_data_id' => $xmlData->id]);
                            break;
                        }
                    }
                }
            }
        }

        $reader->close();

        if (!$foundMatch) {
            InvalidXmlRecord::create([
                'item_name' => $itemName,
            ]);
        }
    }
}
