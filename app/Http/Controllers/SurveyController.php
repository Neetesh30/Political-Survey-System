<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Support\Facades\Log;


class SurveyController extends Controller
{
    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:15',

            'q1' => 'required|integer|min:1|max:5',
            'q2' => 'required|integer|min:1|max:5',
            'q3' => 'required|integer|min:1|max:5',
            'q4' => 'required|integer|min:1|max:5',
            'q5' => 'required|integer|min:1|max:5',
            'q6' => 'required|integer|min:1|max:5',
            'q7' => 'required|integer|min:1|max:5',
            'q8' => 'required|integer|min:1|max:5',
            'q9' => 'required|integer|min:1|max:5',
            'q10' => 'required|integer|min:1|max:5',

            'q11' => 'required|string|max:100',
        ]);

        // ✅ Calculate average score
        $ratings = [
            $data['q1'], $data['q2'], $data['q3'], $data['q4'], $data['q5'],
            $data['q6'], $data['q7'], $data['q8'], $data['q9'], $data['q10']
        ];

        $data['average_score'] = array_sum($ratings) / count($ratings);

        // ✅ Save to DB
        $survey = Survey::create($data);

        // Get total submissions count
        $totalCount = Survey::count();

        return response()->json([
            'status' => true,
            'message' => 'Survey submitted',
            'count' => (int)  $totalCount+5249,
            'survey_id' => $survey->id
        ]);
    }



    public function updateUserDetails(Request $request)
    {
        Log::info('🔥 API HIT: survey-user-details', $request->all());

        try {

            $data = $request->validate([
                'survey_id' => 'required|exists:surveys,id',
                'name' => 'nullable|string|max:100',
                'phone' => 'nullable|string|max:15',
            ]);

            Log::info('✅ Validation Passed', $data);

            $survey = Survey::find($data['survey_id']);

            if (!$survey) {
                Log::error('❌ Survey not found', ['id' => $data['survey_id']]);
                return response()->json(['status' => false, 'message' => 'Survey not found']);
            }

            $survey->update([
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
            ]);

            Log::info('✅ Data Updated Successfully', $survey->toArray());

            return response()->json([
                'status' => true,
                'message' => 'Details saved'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error updating user details', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function results()
    {
        $surveys = Survey::latest()->get();

        // Basic stats
        $total = $surveys->count();
        $avgScore = round($surveys->avg('average_score'), 2);

        // Party distribution (Q11)
        $partyStats = Survey::select('q11', \DB::raw('count(*) as total'))
            ->groupBy('q11')
            ->pluck('total', 'q11');

        // Question-wise averages
        $questionAvg = [];
        for ($i = 1; $i <= 10; $i++) {
            $questionAvg["q$i"] = round(Survey::avg("q$i"), 2);
        }

        return view('survey-results', compact(
            'surveys',
            'total',
            'avgScore',
            'partyStats',
            'questionAvg'
        ));
    }

    public function exportCsv()
{
    $fileName = 'survey_' . now()->format('Y-m-d_H-i-s') . '.csv';
    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    $callback = function () {
        $handle = fopen('php://output', 'w');

        // Header row
        fputcsv($handle, [
            'ID','Name','Phone','Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10','Party','Average'
        ]);

        foreach (Survey::all() as $s) {
            fputcsv($handle, [
                $s->id,
                $s->name,
                $s->phone,
                $s->q1,
                $s->q2,
                $s->q3,
                $s->q4,
                $s->q5,
                $s->q6,
                $s->q7,
                $s->q8,
                $s->q9,
                $s->q10,
                $s->q11,
                $s->average_score,
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

}
