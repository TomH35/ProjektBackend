<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Stage;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function handleStage(Request $request)
    {
        $stageData = json_decode($request->get('stage'), true);
        $eventsData = $request->all()['events'];

        if (Stage::where('name', $stageData['name'])->exists()) {
            return Response::json(['error' => 'A stage with this name already exists'], 400);
        }

        DB::beginTransaction();

        try {
            $stage = Stage::create($stageData);

            usort($eventsData, function ($a, $b) {
                return $a['start_time'] <=> $b['start_time'];
            });

            for ($i = 0; $i < count($eventsData); $i++) {

                if ($i > 0 && $eventsData[$i]['start_time'] <= $eventsData[$i - 1]['end_time']) {
                    return Response::json(['error' => 'Event times are overlapping'], 400);
                }

                if ($request->hasFile('events.' . $i . '.image')) {
                    $file = $request->file('events.' . $i . '.image');
                    $path = Storage::putFile('public/images', $file);
                    $url = Storage::url($path);
                    $eventsData[$i]['image_path'] = $url;
                }

                $eventsData[$i]['stage_id'] = $stage->id;

                Event::create($eventsData[$i]);
            }

            DB::commit();

            return Response::json($stage);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response::json(['error' => 'An error occurred while creating the stage'], 500);
        }
    }

}
