<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\TaskChanged;
use App\Scopes\DateFilterScope;
use App\Traits\MorphFiles;

class Task extends \App\Models\BaseModel
{
    use HasFactory, MorphFiles;

    protected $table = 'tasks';
    protected $guarded = [];
    public $timestamps = true;


protected $casts = [
    'employees' => 'array',
];
    /**
     * Define the project relationship.
     */
public function project()
{
    return $this->belongsTo(Project::class)->withoutGlobalScope('excludePersonal');
}


    public function scopeFilter($query, $request, $options = [])
    {
        $user = auth()->user();

        if ($request->filled('status') || $request->status === 0 || $request->status === '0') {
            $query->where('status', $request->status);
        }

        // --- Working hours ---
        if (!isWithinWorkingHours() && empty($options['ignore_working_hours'])) {
            $query->where('isOverthinking', 0);
        }

        // --- Restrict to logged user (unless Boula) ---
        if (!boula() && empty($options['ignore_user_scope'])) {
            $query->where(function ($q) use ($user) {
                $q->whereJsonContains('employees', (int) $user->id)
                  ->orWhereJsonContains('employees', (string) $user->id)
                  ->orWhere('employees', 'LIKE', "%{$user->id}%");
            });
        }

        // --- Search ---
        if ($request->filled('search')) {
            $terms = explode(',', $request->search);

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $term = trim($term);
                    if (!$term) continue;

                    if (strtolower($term) === 'priority') {
                        $q->orWhere('piority', 1);
                        continue;
                    }

                    if (strtolower($term) === '!priority') {
                        $q->orWhere('piority', 0);
                        continue;
                    }

                    $q->orWhere('title', 'like', "%$term%")
                      ->orWhereHas('project', function ($qp) use ($term) {
                          $qp->where('title', 'like', "%$term%");
                      })
->orWhereRaw("EXISTS (
    SELECT 1
    FROM admins
    WHERE JSON_CONTAINS(tasks.employees, CONCAT('[', admins.id, ']'))
    AND admins.name LIKE ?
)", ["%$term%"]);
                }
            });
        }

        // --- isFixed ---
        if ($request->has('is_fixed') && $request->is_fixed !== '' && $request->is_fixed !== null) {
            $query->where('isFixed', (int) $request->is_fixed);
        }

        // --- Date filters ---
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // --- Employees filter ---
        if ($request->filled('employees')) {
            $ids = explode(',', $request->employees);
            $query->where(function ($q) use ($ids) {
                foreach ($ids as $id) {
                    $id = trim($id);
                    $q->orWhereJsonContains('employees', (int)$id)
  ->orWhere('employees', 'LIKE', "%{$id}%")
                      ->orWhere('employees', 'LIKE', "%{$id}%");
                }
            });
        }

        // --- Projects filter ---
        if ($request->filled('projects')) {
            $query->whereIn('project_id', explode(',', $request->projects));
        }


        // --- Type filter (personal / yousab / all) ---
        if ($request->filled('type')) {
            $type = $request->input('type');

            if ($type === 'personal') {
                $query->whereHas('project', fn($q) => $q->where('isPersonal', 1));
            } elseif ($type === 'yousab') {
                $query->whereHas('project', fn($q) => $q->where('isYousab', 1));
            } elseif ($type === 'all') {
                $query->whereHas('project', fn($q) =>
                    $q->where('isPersonal', 1)->orWhere('isYousab', 1)
                );
            }
        }

        // --- Parcel special case ---
        if (auth('api')->user()->email === 'parcel@gmail.com') {
            $query->where('project_id', parcelProject()->id);
        }

        // --- Active only ---
        $query->where('isActive', 1);

        // --- Ordering ---
        $query->orderByRaw('ISNULL(date), date ASC')
              ->orderBy('id', 'ASC');

        return $query;
    }

    /**
     * Define the employee relationship.
     */
    public function employee()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Mutator for the title attribute.
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }
    public function getCounterAttribute($value)
    {
        return $this->status != 0 ? 0 : $value;
    }
    // public function getPiorityAttribute($value)
    // {
    //     return $this->project->status == 2 ? 1 : 0;
    // }
    

        // Relation to employees (JSON IDs)
    public function employeeRelation() {
        return $this->belongsToMany(Admin::class, null, 'id', 'id') // dummy pivot
            ->whereIn('admins.id', $this->employees ?? []);
    }

        public function deadlines()
    {
        return $this->morphMany(Deadline::class, 'deadlineable');
    }


    // Task.php
public function getEmployeesAttribute($value): array
{
    if (empty($value)) return [];
    
    $decoded = is_string($value) ? json_decode($value, true) : $value;
    
    return is_array($decoded) ? $decoded : [];
}


    public function getImagesAttribute()
    {
        return  count($this->files)>0?$this->files:["default.jpg"];
    }
}
