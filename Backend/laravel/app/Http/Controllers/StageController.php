<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Stage;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StageController extends Controller
{
    public function createStage(Request $request)
    {
        try {
            $stageData = json_decode($request->get('stage'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON format for stage data');
            }

            $eventsData = $request->input('events', []);



            if (Stage::where('name', $stageData['name'])->exists()) {
                return Response::json(['error' => 'A stage with this name already exists'], 400);
            }

            DB::beginTransaction();

            $stage = Stage::create($stageData);
            Log::info('Stage created: ' . $stage->id);

            usort($eventsData, function ($a, $b) {
                return $a['start_time'] <=> $b['start_time'];
            });

            for ($i = 0; $i < count($eventsData); $i++) {
                if ($i > 0 && $eventsData[$i]['start_time'] <= $eventsData[$i - 1]['end_time']) {
                    DB::rollBack();
                    return Response::json(['error' => 'Event times are overlapping'], 400);
                }

                if ($request->hasFile('events.' . $i . '.image')) {
                    $file = $request->file('events.' . $i . '.image');
                    $path = Storage::putFile('public/images/events', $file);
                    $url = Storage::url($path);
                    $eventsData[$i]['image_path'] = $url;
                }

                $eventsData[$i]['stage_id'] = $stage->id;
                $eventsData[$i]['speaker_id'] = $eventsData[$i]['speaker_id'] ?? null;
                $eventsData[$i]['capacity'] = $eventsData[$i]['capacity'] ?? 0;

                Event::create($eventsData[$i]);
            }

            DB::commit();

            return Response::json($stage, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred while creating the stage: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return Response::json(['error' => 'An error occurred while creating the stage', 'message' => $e->getMessage()], 500);
        }
    }

    public function readStage()
    {
        $stages = Stage::all();
        $events = Event::all();
        return response()->json(['stages' => $stages, 'events' => $events]);
    }

    public function updateStage($id, Request $request)
    {
        try {
            $stageData = json_decode($request->get('stage'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON format for stage data');
            }

            $eventsData = $request->input('events', []);

            $stage = Stage::find($id);

            if (!$stage) {
                return Response::json(['error' => 'Stage not found'], 404);
            }

            DB::beginTransaction();

            $stage->update($stageData);
            $stage->events()->delete();

            usort($eventsData, function ($a, $b) {
                return $a['start_time'] <=> $b['start_time'];
            });

            for ($i = 0; $i < count($eventsData); $i++) {
                if ($i > 0 && $eventsData[$i]['start_time'] <= $eventsData[$i - 1]['end_time']) {
                    DB::rollBack();
                    return Response::json(['error' => 'Event times are overlapping'], 400);
                }

                if ($request->hasFile('events.' . $i . '.image')) {
                    $file = $request->file('events.' . $i . '.image');
                    $path = Storage::putFile('public/images', $file);
                    $url = Storage::url($path);
                    $eventsData[$i]['image_path'] = $url;
                }

                $eventsData[$i]['stage_id'] = $stage->id;
                $eventsData[$i]['speaker_id'] = $eventsData[$i]['speaker_id'] ?? null;

                Event::create($eventsData[$i]);
            }

            DB::commit();

            return Response::json($stage);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred while updating the stage: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return Response::json(['error' => 'An error occurred while updating the stage', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteStage($id)
    {
        try {
            $stage = Stage::findOrFail($id);
            // Get all event IDs associated with the stage
            $eventIds = $stage->events()->pluck('id');

            // Delete all registrations associated with these events
            DB::table('registrations')->whereIn('event_id', $eventIds)->delete();

            // Delete the events associated with the stage
            Event::whereIn('id', $eventIds)->delete();

            // Finally, delete the stage
            $stage->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('An error occurred while deleting the stage: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return Response::json(['error' => 'An error occurred while deleting the stage', 'message' => $e->getMessage()], 500);
        }
    }

    public function getSpeakers()
    {
        $speakers = Speaker::all();
        return response()->json($speakers);
    }

    public function getEvents()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function getEventsGroupedByTime()
    {
        $events = Event::orderBy('start_time')->get();
        $groupedEvents = [];

        foreach ($events as $event) {
            $timeWindow = $event->start_time . ' - ' . $event->end_time;
            if (!isset($groupedEvents[$timeWindow])) {
                $groupedEvents[$timeWindow] = [];
            }
            $groupedEvents[$timeWindow][] = $event;
        }

        return response()->json($groupedEvents);
    }
}
