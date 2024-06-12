<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $inquiries = auth()->user()->inquiries()->with('property')->paginate(10);
            $favoriteCount = auth()->user()->favoriteCount();
            return view('inquiries.index', compact('inquiries', 'favoriteCount'));
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to view your inquiries.');
        }
    }
}