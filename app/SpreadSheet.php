<?php

namespace App;

use App\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class SpreadSheet extends Model
{
 
    /**
     * PNL spreadsheet constant columns
     * 
     */
    const PNLCOLUMNS = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", 
        "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", 
        "U", "V", "W", "X", "Y", "Z", 
        "AA", "AB", "AC", "AD", "AE", "AF", "AG"
    );

    const PNLCOLUMNS2 = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", 
        "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", 
        "u", "v", "w", "x", "y", "z", 
        "aa", "ab", "ac", "ad", "ae", "af", "ag"
    );

    /**
     * Line Chart Keys
     * 
     */
    const LINECHARTKEYS = array(
        "'a'", "'b'", "'c'", "'d'", "'e'", "'f'", "'g'", "'h'", "'i'", "'j'", 
        "'k'", "'l'", "'m'", "'n'", "'o'", "'p'", "'q'", "'r'", "'s'", "'t'", 
        "'u'", "'v'", "'w'", "'x'", "'y'", "'z'",
        "'aa'", "'ab'", "'ac'", "'ad'", "'ae'", "'af'", "'ag'"
    );

    /**
     * Private const variables
     */
    private const PNLFILETYPE = "Xlsx";
    private const PNLSHEETNAME = "Traffic Tracking Spreadsheet";
    private const PNLROWSTART = 2;
    private const PNLROWEND = 6020;
    private const PNLROWUSEPERSOURCE = 20;
    private const PNLROWSTARTSOURCE = 2;
    private const PLNROWENDSOURCE = 6002;

    /**
     * Protected variables
     * 
     */
    protected $worksheet;
    protected $arrActiveTraffic;
    protected $pnlFile;
    protected $msgContructor;

    /**
     * Public variables
     * 
     */


    /**
     * Get runtime script execution
     * 
     * @return integer
     */
    private function runTime($ru, $rus, $index) {
        return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000)) - ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
    }

    /**
     * Get PNL Path + File
     * 
     * @return string
     */
    private function getPNLFile()
    {
        $user = Auth::user();
        $userFile = File::where('user_id', $user->id)->first();

        $storagePath = strpos(storage_path('app'), "\\", -1) ? storage_path('app') . str_replace("/", "\\", $userFile->folder_path) : storage_path('app') . "\\" . str_replace("/", "\\", $userFile->folder_path);
        $storagePath = str_replace("\\", "/", $storagePath);
        $pnlFile = strpos($storagePath, "/", -1) ? $storagePath . $userFile->file_used : $storagePath . "/" . $userFile->file_used;

        return $pnlFile;
    }

    /**
     * Get PNL Traffic source(s)
     * 
     * @return array
     */
    private function getActiveTraffic()
    {
        $x = self::PNLROWSTART;
        $y = 0;
        $arr = array();
        
        do {
            // Get the value from cell column A = 1
            $cellValue = $this->worksheet->getCellByColumnAndRow(1, $x)->getValue();
        
            if(!empty($cellValue)) {
                $arr[$y] = $cellValue;
            }
            else {
                break;
            }
        
            $x = $x + self::PNLROWUSEPERSOURCE;
            $y++;
        } while ($x <= self::PLNROWENDSOURCE);

        return $arr;
    }

    /**
     * Get Chart config json file
     * 
     * @param string $chartLabel
     * @return array
     */
    private function getChartConfig($chartLabel)
    {
        $path = storage_path('app') . "/json/" . strtolower($chartLabel) . ".json";
        $result = json_decode(file_get_contents($path),true);

        return $result;
    }

    /**
     * Get Cell calculated percentage
     * 
     * @param int $col
     * @param int $row
     * @return integer
     */
    private function getCellPercentage($col,$row)
    {
        $cell = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
        $total = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

        if(is_numeric($cell) && is_numeric($total)) {
            $result = intval(($cell/$total)*100);
        } 
        else {
            return 0;
        }

        return $result;
    }

    /**
     * Get Cell calculated percentage date range
     * 
     * @param int $col
     * @param int $row
     * @return integer
     */
    private function getCellPercentageDateRange($col,$row,$dteStart,$dteEnd)
    {
        $cell = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
        $total = $this->getCurrentRowRunningTotalDateRange($row,$dteStart,$dteEnd);

        if(is_numeric($cell) && is_numeric($total)) {
            $result = intval(($cell/$total)*100);
        } 
        else {
            return 0;
        }

        return $result;
    }

    /**
     * Get current running values per label
     * 
     * @return array
     */
    private function getCurrentLabelValues($chartLabel,$row)
    {
        $data = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($chartLabel);

        if ( $activeTraffic > 1 ) {
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'] + 1;

            $arr = array();
            $index = 0;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $col = $i + 1;
             
                $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();

                if ($cellValue > 0) {
                    $arr[$index] = $cellValue;
                    $index++;
                 }
                 else {
                    break;
                 }
            }

            $data = $arr;
            unset($arr);
        }

        $result = $data;

        return $result;
    }

    /**
     * Get current running total date range
     * 
     * @return integer
     */
    private function getCurrentRowRunningTotalDateRange($row,$dteStart,$dteEnd)
    {
       $total = 0;

        for ( $i = $dteStart; $i <= $dteEnd; $i++ )
        {
            $col = $i + 2;
         
            $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();            

            if ($cellValue > 0) {                
                $total = $total + $cellValue;
             }
             else {
                break;
             }
        }

        $result = intval($total);

        return $result;
    }

    /**
     * Get current running percentage values per label
     * 
     * @return array
     */
    private function getCurrentLabelPercentageValues($chartLabel,$row)
    {
        $data = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($chartLabel);

        if ( $activeTraffic > 1 ) {
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'] + 1;

            $arr = array();
            $index = 0;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $col = $i + 2;
             
                $cellValue = $this->getCellPercentage($col,$row);;

                if ($cellValue > 0) {
                    $arr[$index] = intval($cellValue);
                    $index++;
                 }
                 else {
                    break;
                 }
            }

            $data = $arr;
            unset($arr);
        }

        $result = $data;

        return $result;
    }

    /**
     * Get min and max percentage values per day on a specific label
     * 
     * @return array
     */
    private function getMinMaxPercentageValuesPerDayLabel($chartLabel)
    {
        $data = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($chartLabel);

        if ( $activeTraffic > 1 ) {
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];
            $cntCharts = count($charts) - 1;

            $arr = array();

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr1 = array();

                for ( $y = 1; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr1[$y-1] = $this->getCellPercentage($col,$row);
                }

                $min = min($arr1);
                $max = max($arr1);
                $arr[$i-1] = array($min,$max);
                unset($arr1);
            }

            $data = $arr;
            unset($arr);
        }

        $result = $data;

        return $result;
    }

    /**
     * Get average overall total label per day
     * 
     * @return array
     */
    private function getOverallTotalForSelectedLabels()
    {
        $data = array();

        // Impression Overall
        $arrPNLTraffic = $this->getChartConfig('impression');
        $impression = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('impression', $arrPNLTraffic['config'][0]['rowStart']) : array();

        // Clicks Overall
        $arrPNLTraffic = $this->getChartConfig('clicks');
        $clicks = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('clicks', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Ad Spend Overall
        $arrPNLTraffic = $this->getChartConfig('adspend');
        $adspend = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('adspend', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Pixel Fires Overall
        $arrPNLTraffic = $this->getChartConfig('pixelfires');
        $pixelfires = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('pixelfires', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Leads Overall
        $arrPNLTraffic = $this->getChartConfig('leads');
        $leads = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('leads', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Sales Overall
        $arrPNLTraffic = $this->getChartConfig('sales');
        $sales = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('sales', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Impression Overall
        $arrPNLTraffic = $this->getChartConfig('revenue');
        $revenue = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelValues('revenue', $arrPNLTraffic['config'][0]['rowStart']) : array();

        $result['Impression-Overall'] = $impression;
        $result['Clicks-Overall'] = $clicks;
        $result['AdSpend-Overall'] = $adspend;
        $result['PixelFires-Overall'] = $pixelfires;
        $result['Leads-Overall'] = $leads;
        $result['Sales-Overall'] = $sales;
        $result['Revenue-Overall'] = $revenue;

        return $result;
    }

    /**
     * Get average overall total label per day
     * 
     * @return array
     */
    private function getOverallPercentageForSelectedLabels()
    {
        $data = array();

        // Impression Overall
        $arrPNLTraffic = $this->getChartConfig('impression');
        $impression = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('impression', $arrPNLTraffic['config'][0]['rowStart']) : array();

        // Clicks Overall
        $arrPNLTraffic = $this->getChartConfig('clicks');
        $clicks = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('clicks', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Ad Spend Overall
        $arrPNLTraffic = $this->getChartConfig('adspend');
        $adspend = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('adspend', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Pixel Fires Overall
        $arrPNLTraffic = $this->getChartConfig('pixelfires');
        $pixelfires = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('pixelfires', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Leads Overall
        $arrPNLTraffic = $this->getChartConfig('leads');
        $leads = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('leads', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Sales Overall
        $arrPNLTraffic = $this->getChartConfig('sales');
        $sales = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('sales', $arrPNLTraffic['config'][0]['rowStart']) : array();
        
        // Impression Overall
        $arrPNLTraffic = $this->getChartConfig('revenue');
        $revenue = ( count($arrPNLTraffic) > 0) ? $this->getCurrentLabelPercentageValues('revenue', $arrPNLTraffic['config'][0]['rowStart']) : array();

        $result['Impression-Overall'] = $impression;
        $result['Clicks-Overall'] = $clicks;
        $result['AdSpend-Overall'] = $adspend;
        $result['PixelFires-Overall'] = $pixelfires;
        $result['Leads-Overall'] = $leads;
        $result['Sales-Overall'] = $sales;
        $result['Revenue-Overall'] = $revenue;

        return $result;
    }

    /**
     * Get Sparkline per day
     * 
     * @return array
     */
    private function getSparklinePerDayForSelectedLabels()
    {
        $data = array();

        // Impression Overall
        $impression = $this->getMinMaxPercentageValuesPerDayLabel('impression');

        // Clicks Overall
        $clicks = $this->getMinMaxPercentageValuesPerDayLabel('clicks');
        
        // Ad Spend Overall
        $adspend = $this->getMinMaxPercentageValuesPerDayLabel('adspend');
        
        // Pixel Fires Overall
        $pixelfires = $this->getMinMaxPercentageValuesPerDayLabel('pixelfires');
        
        // Leads Overall
        $leads = $this->getMinMaxPercentageValuesPerDayLabel('leads');
        
        // Sales Overall
        $sales = $this->getMinMaxPercentageValuesPerDayLabel('sales');
        
        // Impression Overall
        $revenue = $this->getMinMaxPercentageValuesPerDayLabel('revenue');

        $result['Impression-Overall'] = $impression;
        $result['Clicks-Overall'] = $clicks;
        $result['AdSpend-Overall'] = $adspend;
        $result['PixelFires-Overall'] = $pixelfires;
        $result['Leads-Overall'] = $leads;
        $result['Sales-Overall'] = $sales;
        $result['Revenue-Overall'] = $revenue;

        return $result;
    }

    /**
     * Spreadsheet model constructor
     * 
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $rustart = getrusage();

        $this->pnlFile = $this->getPNLFile();

        $reader = IOFactory::createReader(self::PNLFILETYPE);
        $reader->setReadDataOnly(TRUE);
        $reader->setLoadSheetsOnly(self::PNLSHEETNAME);
        $spreadsheet = $reader->load($this->pnlFile);
        $this->worksheet = $spreadsheet->getActiveSheet();
        $this->arrActiveTraffic = $this->getActiveTraffic();

        $ru = getrusage();

        $this->msgContructor = "Constructor process used " . $this->runTime($ru, $rustart, "utime") . 
                               " ms for its computations\nIt spent " . $this->runTime($ru, $rustart, "stime") . " ms in system calls\n";
    }

    /**
     * Read and dump PNL spreadsheet
     * 
     * @return array
     */
    public function ReadPNLActiveTraffic()
    {
        $rustart = getrusage();

        //$arr = $this->arrActiveTraffic;
        $arr = $this->getChartConfig("Impression");

        $ru = getrusage();

        $result['arrPNL'] = $arr['config'];
        $result['pathPNL'] = $this->pnlFile;
        $result['message'] = "This process used " . $this->runTime($ru, $rustart, "utime") . 
                             " ms for its computations\nIt spent " . $this->runTime($ru, $rustart, "stime") . " ms in system calls\n" . "<br>" . $this->msgContructor;
        
        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for testing purposes
     * 
     * @return array
     */
    public function PullPNLActiveTraffic($chartLabel)
    {
        $rustart = getrusage();

        $data = array();
        $values = array();
        $totals = array();
        $labels = array();
        $keys = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($chartLabel);

        if ( $activeTraffic > 1 ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];
            $cntCharts = count($charts) - 1;
            $stopFetch = false;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr["y"] = strval($i);
                    $key = $chartKeys[$y];
                    //$arr[$key] = $this->getCellPercentage($col,$row);
                    $arr[$key] = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = $chartLabelKeys[$y];
                        $labels[$y] = "'" . $chartLabel . " " . $traffic . "'";
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

                    if ( intval($cellValue) === 0 ) {
                        $stopFetch = true;
                        break;
                    }

                    $arr4 = array(strval($traffic),intval($cellValue));
                    $arr5 = array(strval($traffic2),intval($cellValue2));
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                if ($stopFetch) {
                    unset($arr3);
                    unset($arr2);
                    unset($arr);
                    break;
                }

                $data[$i-1] = $arr;
                $values[$i-1] = $arr2;
                $totals[$i-1] = $arr3;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $ru = getrusage();

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['overall'] = $this->getOverallTotalForSelectedLabels();
        $result['percentage'] = $this->getOverallPercentageForSelectedLabels();
        $result['sparkline'] = $this->getSparklinePerDayForSelectedLabels();
        $result['caption'] = "[" . implode(',', $labels) . "] - " . "[" . implode(',', $keys) . "]";
        $result['message'] = "This process used " . $this->runTime($ru, $rustart, "utime") . 
                             " ms for its computations\nIt spent " . $this->runTime($ru, $rustart, "stime") . " ms in system calls\n" . "<br>" . $this->msgContructor;

        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for Impression
     * 
     * @return array
     */
    public function PullPNLImpressionActiveTraffic()
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig("impression");

        if ( $activeTraffic > 1 ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $chartLabel = "Impression";
            $cntCharts = count($charts) - 1;
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];
            $stopFetch = false;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr["y"] = strval($i);
                    $key = strval($chartKeys[$y]);
                    $arr[$key] = $this->getCellPercentage($col,$row);

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartLabelKeys[$y]); 
                        $labels[$y] = "'" . $chartLabel . " " . $traffic . "'";
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

                    if ( intval($cellValue) === 0 ) {
                        $stopFetch = true;
                        break;
                    }

                    $arr4 = array(strval($traffic),intval($cellValue));
                    $arr5 = array(strval($traffic2),intval($cellValue2));
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                if ($stopFetch) {
                    unset($arr3);
                    unset($arr2);
                    unset($arr);
                    break;
                }
                
                $data[$i-1] = $arr;
                $values[$i-1] = $arr2;
                $totals[$i-1] = $arr3;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['overall'] = $this->getOverallTotalForSelectedLabels();
        $result['percentage'] = $this->getOverallPercentageForSelectedLabels();
        $result['sparkline'] = $this->getSparklinePerDayForSelectedLabels();
        $result['labels'] = "[" . implode(',', $labels) . "]";
        $result['keys'] = "[" . implode(',', $keys) . "]";
        $result['traffic'] = $activeTraffic - 1;

        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for AdServing Cost
     * 
     * @return array
     */
    public function PullPNLAdServingCostsActiveTraffic()
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig("adservingcosts");

        if ( $activeTraffic > 1 ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $chartLabel = "AdServing Cost";
            $cntCharts = count($charts) - 1;
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr["y"] = strval($i);
                    $key = strval($chartKeys[$y]);
                    $arr[$key] = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartLabelKeys[$y]); 
                        $labels[$y] = "'" . $chartLabel . " " . $traffic . "'";
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

                    $arr4 = array(strval($traffic),$cellValue);
                    $arr5 = array(strval($traffic2),$cellValue2);
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }
            
                $data[$i-1] = $arr;
                $values[$i-1] = $arr2;
                $totals[$i-1] = $arr3;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['labels'] = "[" . implode(',', $labels) . "]";
        $result['keys'] = "[" . implode(',', $keys) . "]";

        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for specific label
     * 
     * @return array
     */
    public function getChartLabelPercentage($label)
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($label);

        if ( $activeTraffic > 1 ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);          
            $cntCharts = count($charts) - 1;
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];
            $stopFetch = false;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr['y'] = strval($i);
                    $key = strval($chartLabelKeys[$y]);
                    $arr[$key] = $this->getCellPercentage($col,$row);

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartKeys[$y]);                        
                        $labels[$y] = strval($traffic);
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

                    if ( intval($cellValue) === 0 ) {
                        $stopFetch = true;
                        break;
                    }

                    $arr4 = array(strval($traffic),intval($cellValue));
                    $arr5 = array(strval($traffic2),intval($cellValue2));
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                if ($stopFetch) {
                    unset($arr3);
                    unset($arr2);
                    unset($arr);
                    break;
                }

                $data[$i-1] = $arr;
                $values[$i-1] = $arr2;
                $totals[$i-1] = $arr3;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['traffic'] = $this->arrActiveTraffic;
        $result['labels'] = "'" . implode("','", $labels) . "'";
        $result['keys'] = "'" . implode("','", $keys) . "'";

        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for specific label via Date Range
     * 
     * @return array
     */
    public function getChartLabelPercentageDateRange($label,$start,$end)
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);
        $arrPNLTraffic = $this->getChartConfig($label);
        $value = $this->worksheet->getCell('C2')->getValue();
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
        $dtePNLCurrent = date('Y-m-d', $date);
        $dteSearchStart = date('Y-m-d', strtotime($start));
        $dteSearchEnd = date('Y-m-d', strtotime($end));
        $monthPNLCurrent = date('n', strtotime($dtePNLCurrent));
        $monthSearchStart = date('n', strtotime($dteSearchStart));
        $monthSearchEnd = date('n', strtotime($dteSearchEnd));
        $yearPNLCurrent = date('Y', strtotime($dtePNLCurrent));
        $yearSearchStart = date('Y', strtotime($dteSearchStart));
        $yearSearchEnd = date('Y', strtotime($dteSearchEnd));
        $startMonthYear = $monthSearchStart . "-" . $yearSearchStart;
        $endMonthYear = $monthSearchEnd . "-" . $yearSearchEnd;
        $pnlMonthYear = $monthPNLCurrent . "-" . $yearPNLCurrent;
        $allowFetch = false;

        if (($pnlMonthYear == $startMonthYear) && ($pnlMonthYear == $endMonthYear)) {
            $allowFetch = true;
        }

        if ( ($activeTraffic > 1) && $allowFetch ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $cntCharts = count($charts) - 1;
            $dteStart = intval(date('j', strtotime($start)));
            $dteEnd = intval(date('j', strtotime($end)));
            $index = 0;
            $stopFetch = false;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                
                    $arr['y'] = strval($i);
                    $key = strval($chartLabelKeys[$y]);
                    $arr[$key] = $this->getCellPercentageDateRange($col,$row,$dteStart,$dteEnd);

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartKeys[$y]);                        
                        $labels[$y] = strval($traffic);
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->getCurrentRowRunningTotalDateRange($row,$dteStart,$dteEnd);

                    if ( intval($cellValue) === 0 ) {
                        $stopFetch = true;
                        break;
                    }

                    $arr4 = array(strval($traffic),intval($cellValue));
                    $arr5 = array(strval($traffic2),intval($cellValue2));
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                if ($stopFetch) {
                    unset($arr3);
                    unset($arr2);
                    unset($arr);
                    break;
                }

                $data[$index] = $arr;
                $values[$index] = $arr2;
                $totals[$index] = $arr3;
                $index++;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['traffic'] = $this->arrActiveTraffic;
        $result['labels'] = "'" . implode("','", $labels) . "'";
        $result['keys'] = "'" . implode("','", $keys) . "'";
        $result['dates'] = "PNL Current Date: " . $dtePNLCurrent . "; Start Date: " . $dteSearchStart . "; End Date: " . $dteSearchEnd;
        $result['monthyear'] = "PNL Month-Year: " .$pnlMonthYear . "; Start Month-Year: " . $startMonthYear . "; End Month-Year " . $endMonthYear;

        $startMonthYear = $monthSearchStart . "-" . $yearSearchStart;
        $endMonthYear = $monthSearchEnd . "-" . $yearSearchEnd;
        $pnlMonthYear = $monthPNLCurrent . "-" . $yearPNLCurrent;
 
        return $result;
    }

        /**
     * Populate Line chart from PNL spreadsheet for specific label
     * 
     * @return array
     */
    public function getChartLabelValue($label)
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);

        $arrPNLTraffic = $this->getChartConfig($label);

        if ( $activeTraffic > 1 ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);          
            $cntCharts = count($charts) - 1;
            $dteStart = $arrPNLTraffic['config'][0]['dteStart'];
            $dteEnd = $arrPNLTraffic['config'][0]['dteEnd'];

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                 
                    $arr['y'] = strval($i);
                    $key = strval($chartLabelKeys[$y]);
                    $arr[$key] = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartKeys[$y]);                        
                        $labels[$y] = strval($traffic);
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();

                    $arr4 = array(strval($traffic),$cellValue);
                    $arr5 = array(strval($traffic2),$cellValue2);
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                $data[$i-1] = $arr;
                $values[$i-1] = $arr2;
                $totals[$i-1] = $arr3;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['traffic'] = $this->arrActiveTraffic;
        $result['labels'] = "'" . implode("','", $labels) . "'";
        $result['keys'] = "'" . implode("','", $keys) . "'";

        return $result;
    }

    /**
     * Populate Line chart from PNL spreadsheet for specific label via Date Range
     * 
     * @return array
     */
    public function getChartLabelValueDateRange($label,$start,$end)
    {
        $data = array();
        $labels = array();
        $keys = array();
        $values = array();
        $totals = array();

        $activeTraffic = count($this->arrActiveTraffic);
        $arrPNLTraffic = $this->getChartConfig($label);
        $value = $this->worksheet->getCell('C2')->getValue();
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
        $dtePNLCurrent = date('Y-m-d', $date);
        $dteSearchStart = date('Y-m-d', strtotime($start));
        $dteSearchEnd = date('Y-m-d', strtotime($end));
        $monthPNLCurrent = date('n', strtotime($dtePNLCurrent));
        $monthSearchStart = date('n', strtotime($dteSearchStart));
        $monthSearchEnd = date('n', strtotime($dteSearchEnd));
        $yearPNLCurrent = date('Y', strtotime($dtePNLCurrent));
        $yearSearchStart = date('Y', strtotime($dteSearchStart));
        $yearSearchEnd = date('Y', strtotime($dteSearchEnd));
        $startMonthYear = $monthSearchStart . "-" . $yearSearchStart;
        $endMonthYear = $monthSearchEnd . "-" . $yearSearchEnd;
        $pnlMonthYear = $monthPNLCurrent . "-" . $yearPNLCurrent;
        $allowFetch = false;

        if (($pnlMonthYear == $startMonthYear) && ($pnlMonthYear == $endMonthYear)) {
            $allowFetch = true;
        }

        if ( ($activeTraffic > 1) && $allowFetch ) {
            $chartKeys = explode(",",$arrPNLTraffic['config'][0]['keys']);
            $chartLabelKeys = explode(",",$arrPNLTraffic['config'][0]['labelKeys']);
            $charts = explode(",",$arrPNLTraffic['config'][count($this->arrActiveTraffic)-1]['charts']);
            $cntCharts = count($charts) - 1;
            $dteStart = intval(date('j', strtotime($start)));
            $dteEnd = intval(date('j', strtotime($end)));
            $index = 0;

            for ( $i = $dteStart; $i <= $dteEnd; $i++ )
            {
                $arr = array();
                $arr2 = array();
                $arr3 = array();

                for ( $y = 0; $y <= $cntCharts; $y++ )
                {
                    $row = intval($charts[$y]);
                    $col = $i + 2;
                
                    $arr['y'] = strval($i);
                    $key = strval($chartLabelKeys[$y]);
                    $arr[$key] = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();

                    $traffic = ($y == 0) ? "Overall" : $this->arrActiveTraffic[$y];
                    $traffic2 = ($y == 0) ? "Overall Total" : $this->arrActiveTraffic[$y] . " Total";

                    if ( $i == $dteStart ) {
                        $keys[$y] = strval($chartKeys[$y]);                        
                        $labels[$y] = strval($traffic);
                    }

                    $cellValue = $this->worksheet->getCellByColumnAndRow($col,$row)->getCalculatedValue();
                    $cellValue2 = $this->getCurrentRowRunningTotalDateRange($row,$dteStart,$dteEnd);

                    $arr4 = array(strval($traffic),$cellValue);
                    $arr5 = array(strval($traffic2),$cellValue2);
                    $arr2[$y] = $arr4;
                    $arr3[$y] = $arr5;
                    unset($arr4);
                    unset($arr5);
                }

                $data[$index] = $arr;
                $values[$index] = $arr2;
                $totals[$index] = $arr3;
                $index++;
                unset($arr3);
                unset($arr2);
                unset($arr);
            }
        }

        $result['data'] = $data;
        $result['values'] = $values;
        $result['totals'] = $totals;
        $result['traffic'] = $this->arrActiveTraffic;
        $result['labels'] = "'" . implode("','", $labels) . "'";
        $result['keys'] = "'" . implode("','", $keys) . "'";
        $result['dates'] = "PNL Current Date: " . $dtePNLCurrent . "; Start Date: " . $dteSearchStart . "; End Date: " . $dteSearchEnd;
        $result['monthyear'] = "PNL Month-Year: " .$pnlMonthYear . "; Start Month-Year: " . $startMonthYear . "; End Month-Year " . $endMonthYear;

        $startMonthYear = $monthSearchStart . "-" . $yearSearchStart;
        $endMonthYear = $monthSearchEnd . "-" . $yearSearchEnd;
        $pnlMonthYear = $monthPNLCurrent . "-" . $yearPNLCurrent;
 
        return $result;
    }
}
