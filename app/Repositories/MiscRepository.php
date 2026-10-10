<?php

namespace App\Repositories;

use App\Contracts\Repositories\MiscRepositoryInterface;
use App\Models\Base;
use App\Models\Category;
use App\Models\Note;
use App\Models\Projecthour;
use App\Models\ReadyClientResbonseMessage;
use App\Models\Repeat;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MiscRepository implements MiscRepositoryInterface
{
    public function logTrack(string $payload): void
    {
        DB::table('tracks')->insert([
            'dispatch_status' => 'showing data of ' . $payload,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    public function allBases(): \Illuminate\Database\Eloquent\Collection
    {
        return Base::all();
    }

    public function randomSurveys(int $take = 5): \Illuminate\Support\Collection
    {
        return Survey::query()
            ->where('isActive', 1)
            ->get()
            ->shuffle()
            ->take($take)
            ->values();
    }

    public function getRepeatSurveyMinutes(): ?int
    {
        return setting()->repeat_survey_minuits;
    }

    public function lastRepeatDate(): ?string
    {
        $lastRepeat = Repeat::latest()->first();

        return $lastRepeat
            ? Carbon::parse($lastRepeat->date)->timezone('Africa/Cairo')->toDateString()
            : null;
    }

    public function createRepeat(string $date): Repeat
    {
        return Repeat::create([
            'date'       => Carbon::parse($date)->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function createProjectHour(array $data): Projecthour
    {
        return Projecthour::create($data);
    }

    public function randomNotes(int $take = 300): \Illuminate\Database\Eloquent\Collection
    {
        return Note::inRandomOrder()->take($take)->get();
    }

    public function allReadyResponseMessages(): \Illuminate\Database\Eloquent\Collection
    {
        // Personal messages first: older app builds take the first match, and personal is the default.
        return ReadyClientResbonseMessage::orderByDesc('is_personal')->latest()->get();
    }

    public function paginateElements(int $categoryId, array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $category = Category::withoutGlobalScopes()->findOrFail($categoryId);

        if (!$category->model || !class_exists($category->model)) {
            throw new \Exception('Invalid model or model class not found for category');
        }

        $model       = $category->model;
        $searchKeys  = $category->search_keys ?? [];
        $configClass = $category->config_class ?? \App\CategoryConfigs\BaseCategoryConfig::class;

        if (!class_exists($configClass)) {
            throw new \Exception('Invalid config class');
        }

        if (is_string($searchKeys)) {
            $searchKeys = array_map('trim', explode(',', $searchKeys));
        }

        $relations = array_unique(array_filter(
            array_map(fn($key) => strstr($key, '.', true) ?: null, $searchKeys)
        ));

        $query = $model::with($relations)->latest()->withoutGlobalScopes();

        if (isset($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (isset($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        if (isset($filters['search'])) {
            $values = array_filter(array_map('trim', explode(',', $filters['search'])));
            $configClass::applySearch($query, $values, $searchKeys);
        }

        $items = $query->paginate($filters['per_page'] ?? 20);

        $items->getCollection()->transform(function ($item) use ($configClass, $searchKeys) {
            $transformed = $configClass::transform($item, 'id');
            $extraValues = [];

            foreach ($searchKeys as $key) {
                $value = data_get($item, trim($key));
                if ($value !== null && $value !== '') {
                    $extraValues[] = $value;
                }
            }

            // A config class can provide its own list line (e.g. the audit log's change summary)
            $transformed['extra'] = method_exists($configClass, 'extra')
                ? $configClass::extra($item)
                : implode(', ', $extraValues);
            return $transformed;
        });

        return $items;
    }
}
