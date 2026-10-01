<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScrubberService;
use App\Models\ScrubbedData;

class ScrubberController extends Controller
{
    protected ScrubberService $scrubber;

    public function __construct(ScrubberService $scrubber)
    {
        $this->scrubber = $scrubber;
    }

    /**
     * Display the scrubber dashboard and filtered history.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $type = $request->input('type', '');

        $query = ScrubbedData::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('original_content', 'like', '%' . $search . '%')
                    ->orWhere('cleaned_content', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Type Filter
        |--------------------------------------------------------------------------
        */

        if (in_array($type, ['html', 'email', 'special'])) {
            $query->where('type', $type);
        }

        /*
        |--------------------------------------------------------------------------
        | History Pagination
        |--------------------------------------------------------------------------
        */

        $allData = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Analytics
        |--------------------------------------------------------------------------
        */

        $totalRecords = ScrubbedData::count();

        $htmlRecords = ScrubbedData::where('type', 'html')->count();

        $emailRecords = ScrubbedData::where('type', 'email')->count();

        $specialRecords = ScrubbedData::where('type', 'special')->count();

        $todayRecords = ScrubbedData::whereDate(
            'created_at',
            now()->toDateString()
        )->count();

        return view('scrubber.index', compact(
            'allData',
            'search',
            'type',
            'totalRecords',
            'htmlRecords',
            'emailRecords',
            'specialRecords',
            'todayRecords'
        ));
    }

    /**
     * Process submitted content.
     */
    public function process(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'content' => ['required', 'string'],
            'type' => ['required', 'in:html,email,special'],
        ]);

        $input = $validated['content'];
        $type = $validated['type'];

        /*
        |--------------------------------------------------------------------------
        | Split textarea content line by line
        |--------------------------------------------------------------------------
        */

        $lines = preg_split('/\r\n|\r|\n/', $input);

        /*
        |--------------------------------------------------------------------------
        | Process using Service Layer
        |--------------------------------------------------------------------------
        */

        $cleanedResults = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $clean = $this->scrubber->scrub($line, $type);

            /*
            |--------------------------------------------------------------------------
            | Save processed data
            |--------------------------------------------------------------------------
            */

            ScrubbedData::create([
                'original_content' => $line,
                'cleaned_content' => $clean,
                'type' => $type,
            ]);

            $cleanedResults[] = $clean;
        }

        return redirect()
            ->route('scrubber.index')
            ->with(
                'success',
                count($cleanedResults) . ' entries processed successfully!'
            )
            ->with('clean_list', $cleanedResults);
    }

    /**
     * Export filtered scrubbing history to CSV.
     */
    public function export(Request $request)
    {
        $search = trim($request->input('search', ''));
        $type = $request->input('type', '');

        /*
        |--------------------------------------------------------------------------
        | Build the same query used by the history filter
        |--------------------------------------------------------------------------
        */

        $query = ScrubbedData::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'original_content',
                    'like',
                    '%' . $search . '%'
                )->orWhere(
                    'cleaned_content',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        if (in_array($type, ['html', 'email', 'special'])) {
            $query->where('type', $type);
        }

        $records = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Generate CSV filename
        |--------------------------------------------------------------------------
        */

        $filename = 'scrubbing-history-' . now()->format('Y-m-d-H-i-s') . '.csv';

        /*
        |--------------------------------------------------------------------------
        | CSV Download Response
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(function () use ($records) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | CSV Header
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'ID',
                'Scrubbing Type',
                'Original Content',
                'Cleaned Content',
                'Processed Date',
            ]);

            /*
            |--------------------------------------------------------------------------
            | CSV Records
            |--------------------------------------------------------------------------
            */

            foreach ($records as $record) {
                fputcsv($handle, [
                    $record->id,
                    ucfirst($record->type),
                    $record->original_content,
                    $record->cleaned_content,
                    $record->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}