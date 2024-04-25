<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Stage;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function handleStage(Request $request)
    {

        $data = $request->json()->all();


        if (Stage::where('name', $data['stage']['name'])->exists()) {
            return Response::json(['error' => 'A stage with this name already exists'], 400);
        }


        DB::beginTransaction();

        try {

            $stage = Stage::create($data['stage']);


            usort($data['events'], function ($a, $b) {
                return $a['start_time'] <=> $b['start_time'];
            });


            for ($i = 0; $i < count($data['events']); $i++) {

                if ($i > 0 && $data['events'][$i]['start_time'] <= $data['events'][$i - 1]['end_time']) {
                    return Response::json(['error' => 'Event times are overlapping'], 400);
                }


                $data['events'][$i]['stage_id'] = $stage->id;


                Event::create($data['events'][$i]);
            }


            DB::commit();


            return Response::json($stage);
        } catch (\Exception $e) {

            DB::rollBack();


            return Response::json(['error' => 'An error occurred while creating the stage'], 500);
        }
    }
}
