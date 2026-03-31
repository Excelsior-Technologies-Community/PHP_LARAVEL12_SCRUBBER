<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScrubberService;
use App\Models\ScrubbedData;

class ScrubberController extends Controller
{
    protected $scrubber;

    public function __construct(ScrubberService $scrubber) {
        $this->scrubber = $scrubber;
    }

   public function index() {
    // Database mathi badho data latest first (navo data upar) fetch karo
    $allData = ScrubbedData::latest()->get();
    
    return view('scrubber.index', compact('allData'));
}

    public function process(Request $request) {
    $input = $request->input('content');
    $type = $request->input('type');
    
    // TextArea mathi line by line data leva mate
    $lines = explode("\n", str_replace("\r", "", $input));
    
    $cleanedResults = [];

    foreach ($lines as $line) {
        if (empty(trim($line))) continue;

        $clean = ($type == 'html') 
                 ? $this->scrubber->cleanHtml($line) 
                 : $this->scrubber->maskEmail($line);

        // Dar ek entry ne DB ma save karo
        ScrubbedData::create([
            'original_content' => $line,
            'cleaned_content' => $clean,
            'type' => $type
        ]);

        $cleanedResults[] = $clean;
    }

    return back()
        ->with('success', count($cleanedResults) . ' entries processed!')
        ->with('clean_list', $cleanedResults);
}
    
}