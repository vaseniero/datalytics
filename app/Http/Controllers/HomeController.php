<?php

namespace App\Http\Controllers;

use App\Spreadsheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Protected variables
     * 
     */
    protected $spreadsheet;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if (Auth::check() && $user->admin) {
            return redirect()->route('admin');
        }
        elseif (Auth::check() && $user->has_file) {
            $this->spreadsheet = new SpreadSheet();

            $result = $this->spreadsheet->PullPNLImpressionActiveTraffic();
            $data = $result['data'];
            $values = $result['values'];
            $totals = $result['totals'];
            $overall = $result['overall'];
            $percentage = $result['percentage'];
            $sparkline = $result['sparkline'];
            $labels = $result['labels'];
            $keys = $result['keys'];
            $traffic = $result['traffic'];

            unset($result);

            $result = $this->spreadsheet->PullPNLAdServingCostsActiveTraffic();
            $data2 = $result['data'];
            $values2 = $result['values'];
            $totals2 = $result['totals'];
            $labels2 = $result['labels'];
            $keys2 = $result['keys'];

            unset($result);

            $user = Auth::user();
    
            return view('home', compact('data', 'data2', 'values', 'values2', 'totals', 'totals2', 'overall', 'percentage', 'sparkline', 'labels', 'labels2', 'keys', 'keys2', 'traffic', 'user'));
        }
        elseif (Auth::check() && !$user->has_file) {
            return redirect()->route('upload');
        }
        else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard2()
    {
        $user = Auth::user();

        if (Auth::check() && $user->admin) {
            return redirect()->route('admin');
        }
        elseif (Auth::check() && $user->has_file) {
            return view('dashboard2');
        }
        elseif (Auth::check() && !$user->has_file) {
            return redirect()->route('upload');
        }
        else {
            return redirect()->route('login');
        }
    }
}
