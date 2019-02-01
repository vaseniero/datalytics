<?php

namespace App\Http\Controllers;

use App\Spreadsheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpreadSheetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the spreadsheet reader.
     *
     */
    public function index()
    {
        $user = Auth::user();

        if (Auth::check()) {
            $spreadsheet = new SpreadSheet();
            $result = $spreadsheet->PullPNLActiveTraffic("Impression");
            $data = $result['data'];
            $values = $result['values'];
            $totals = $result['totals'];
            $overall = $result['overall'];
            $percentage = $result['percentage'];
            $sparkline = $result['sparkline'];
            $caption = $result['caption'];
            $message = $result['message'];

            return view('spreadsheet', compact('data', 'values', 'totals', 'overall', 'percentage', 'sparkline', 'caption', 'message'));
        }
        else {
            return redirect()->route('login');
        }
    }

    /**
     * Ajax PNL specific label
     * 
     * @return string json
     */
    public function ajaxChartLabelPercentage($chartLabelPercentage)
    {
        $spreadsheet = new SpreadSheet();
        $result = $spreadsheet->getChartLabelPercentage($chartLabelPercentage);
        
        return json_encode($result);
    }

    /**
     * Ajax PNL specific label
     * 
     * @return string json
     */
    public function ajaxChartLabelValue($chartLabelValue)
    {
        $spreadsheet = new SpreadSheet();
        $result = $spreadsheet->getChartLabelValue($chartLabelValue);
        
        return json_encode($result);
    }

    /**
     * Ajax PNL specific label search date range
     * 
     * @return string json
     */
    public function ajaxChartLabelDateRange($chartLabel,$dteStart,$dteEnd)
    {
        $spreadsheet = new SpreadSheet();
        $result = array();

        switch ($chartLabel) {
            case "adservingcpm" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "adservingcosts" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "netprofit" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "conversionrate" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "clicktorate" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "returnofinvestment" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "costperclick" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "earningsperclick" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "costperacquisition" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "costperlead" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            case "leadtakerate" :
                $result = $spreadsheet->getChartLabelValueDateRange($chartLabel,$dteStart,$dteEnd);
                break;
            default :
                $result = $spreadsheet->getChartLabelPercentageDateRange($chartLabel,$dteStart,$dteEnd);
                break;
        }
        
        return json_encode($result);
    }

}
