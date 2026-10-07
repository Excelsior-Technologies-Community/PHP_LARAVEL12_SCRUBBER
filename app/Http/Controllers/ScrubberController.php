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
     * Display dashboard and filtered history.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $type = (string) $request->input('type', '');
        $date = (string) $request->input('date', '');

        $allowedTypes = [
            'html',
            'email',
            'special',
            'phone',
            'url',
            'trim',
            'lowercase',
            'uppercase',
            'spaces',
            'html_encode',
        ];

        /*
        |--------------------------------------------------------------------------
        | History Query
        |--------------------------------------------------------------------------
        */

        $query = ScrubbedData::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Type Filter
        |--------------------------------------------------------------------------
        */

        if (in_array($type, $allowedTypes, true)) {
            $query->where('type', $type);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($date !== '') {
            $query->whereDate('created_at', $date);
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $allData = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Analytics
        |--------------------------------------------------------------------------
        */

        $totalRecords = ScrubbedData::count();

        $htmlRecords = ScrubbedData::where(
            'type',
            'html'
        )->count();

        $emailRecords = ScrubbedData::where(
            'type',
            'email'
        )->count();

        $specialRecords = ScrubbedData::where(
            'type',
            'special'
        )->count();

        $phoneRecords = ScrubbedData::where(
            'type',
            'phone'
        )->count();

        $todayRecords = ScrubbedData::whereDate(
            'created_at',
            now()->toDateString()
        )->count();

        return view('scrubber.index', compact(
            'allData',
            'search',
            'type',
            'date',
            'totalRecords',
            'htmlRecords',
            'emailRecords',
            'specialRecords',
            'phoneRecords',
            'todayRecords'
        ));
    }

    /**
     * Process submitted content.
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'content' => [
                'required',
                'string',
            ],

            'type' => [
                'required',
                'in:html,email,special,phone,url,trim,lowercase,uppercase,spaces,html_encode',
            ],
        ]);

        $input = $validated['content'];
        $type = $validated['type'];

        /*
        |--------------------------------------------------------------------------
        | Split Input Into Lines
        |--------------------------------------------------------------------------
        */

        $lines = preg_split(
            '/\r\n|\r|\n/',
            $input
        );

        $cleanedResults = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $clean = $this->scrubber->scrub(
                $line,
                $type
            );

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
                count($cleanedResults) .
                ' entries processed successfully!'
            )
            ->with(
                'clean_list',
                $cleanedResults
            );
    }

    /**
     * Export filtered history to CSV.
     */
    public function export(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $type = (string) $request->input('type', '');
        $date = (string) $request->input('date', '');

        $allowedTypes = [
            'html',
            'email',
            'special',
            'phone',
            'url',
            'trim',
            'lowercase',
            'uppercase',
            'spaces',
            'html_encode',
        ];

        $query = ScrubbedData::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Type Filter
        |--------------------------------------------------------------------------
        */

        if (in_array($type, $allowedTypes, true)) {
            $query->where('type', $type);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($date !== '') {
            $query->whereDate(
                'created_at',
                $date
            );
        }

        $records = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CSV Filename
        |--------------------------------------------------------------------------
        */

        $filename =
            'scrubbing-history-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';

        /*
        |--------------------------------------------------------------------------
        | CSV Download
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(
            function () use ($records) {
                $handle = fopen(
                    'php://output',
                    'w'
                );

                fputcsv($handle, [
                    'ID',
                    'Scrubbing Type',
                    'Original Content',
                    'Cleaned Content',
                    'Processed Date',
                ]);

                foreach ($records as $record) {
                    fputcsv($handle, [
                        $record->id,

                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $record->type
                            )
                        ),

                        $record->original_content,

                        $record->cleaned_content,

                        $record->created_at
                            ? $record->created_at->format(
                                'Y-m-d H:i:s'
                            )
                            : '',
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $filename .
                    '"',
            ]
        );
    }

    /**
     * Delete one scrubbed record.
     */
    public function destroy(ScrubbedData $scrubbedData)
    {
        $scrubbedData->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Scrubbed record deleted successfully.'
            );
    }

    /**
     * Bulk delete selected records.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => [
                'required',
                'array',
                'min:1',
            ],

            'ids.*' => [
                'integer',
                'exists:scrubbed_data,id',
            ],
        ]);

        $count = ScrubbedData::whereIn(
            'id',
            $validated['ids']
        )->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                $count .
                ' record(s) deleted successfully.'
            );
    }
}