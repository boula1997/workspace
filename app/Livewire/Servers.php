<?php
namespace App\Livewire;

use App\Models\Server;
use App\Models\Post;
use Livewire\Component;

class Servers extends Component
{
    public $servers, $server_id, $title, $project, $employee, $committed, $personal, $color, $necessary, $automation, $ask, $easy;
    public $updateMode = false;
    public $searchFilter = ''; 
    public $sortField = 'title'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction
    public $shouldSort = true; // Flag to control sorting
    public $searchFinishedTasks = false; // Checkbox for searching inside finished tasks
    public $searchPersonalTasks = false; // Checkbox for searching personal tasks
    public $searchNecessaryTasks = false; // Checkbox for searching necessary tasks
    public $searchAutomationTasks = false; // Checkbox for searching automation tasks
    public $searchEasyTasks = false; // Checkbox for searching easy tasks

    public function mount()
    {
        // Ensure default values for boolean properties
        $this->personal = false;
        $this->necessary = false;
        $this->automation = false;
        $this->easy = false;
    }

    public function render()
    {
        // Get a list of website clients from the Post model
        $websites = Post::where('appearance', 1)
                        ->where('status', '!=', 0)
                        ->latest()
                        ->pluck('client')
                        ->prepend('All'); // Add 'All' to the beginning of the list
    
        // Build the query for the Server model
        $query = Server::query();
    
        // Filter based on 'committed' status
        if ($this->searchFinishedTasks) {
            $query->where('committed', 1);
        } else {
            $query->where('committed', 0);
        }
    
        // Apply personal filter if 'searchPersonalTasks' checkbox is checked
        if ($this->searchPersonalTasks) {
            $query->where('personal', 1);
        } else {
            // Show non-personal tasks when the checkbox is not checked
            $query->where(function ($q) {
                $q->where('personal', 0)
                  ->orWhereNull('personal');
            });
        }

        // Apply necessary filter if 'searchNecessaryTasks' checkbox is checked
        if ($this->searchNecessaryTasks) {
            $query->where('necessary', 1);
        }

        // Apply automation filter if 'searchAutomationTasks' checkbox is checked
        if ($this->searchAutomationTasks) {
            $query->where('automation', 1);
        }

        // Apply easy filter if 'searchEasyTasks' checkbox is checked
        if ($this->searchEasyTasks) {
            $query->where('easy', 1);
        }

        // Apply search filter if it is set and is an array
        $searchFilters = explode(',', $this->searchFilter);
        if (!empty($searchFilters)) {
            $query->where(function ($q) use ($searchFilters) {
                foreach ($searchFilters as $filter) {
                    if (!empty($filter)) {
                        $q->where(function ($q) use ($filter) {
                            $q->orWhere('title', 'like', '%' . $filter . '%')
                              ->orWhere('project', 'like', '%' . $filter . '%')
                              ->orWhere('employee', 'like', '%' . $filter . '%');
                        });
                    }
                }
            });
        }

        // Apply sorting if enabled
        if ($this->shouldSort) {
            if ($this->sortField != 'employee') {
                $query->orderBy($this->sortField, $this->sortDirection);
            }
        }

        // Ensure that the websites list is not empty and apply the filter
        if ($websites->isNotEmpty() && $websites->first() !== 'All') {
            $this->servers = $query->whereIn('project', $websites)->latest()->get();
        } else {
            $this->servers = $query->latest()->get(); // No project filtering if 'All' is selected
        }

        return view('livewire.servers', [
            'servers' => $this->servers,
            'websites' => $websites, // Pass websites to the view if needed
        ]);
    }

    public function sortBy($field)
    {
        $this->shouldSort = true;
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleColor($id)
    {
        $server = Server::find($id);
        if ($server) {
            $server->color = !$server->color;
            $server->save();

            foreach ($this->servers as &$s) {
                if ($s->id == $id) {
                    $s->color = $server->color;
                }
            }
        }
    }

    public function deleteYellowTitles()
    {
        // Delete all servers with yellow titles
        Server::where('color', true)->delete();

        // Optionally, refresh the component to reflect the changes
        $this->servers = Server::all();
    }

    public function necessaryYellowTitles()
    {
        // Update the 'necessary' field to 1 for all servers with yellow titles
        Server::where('color', true)->update(['necessary' => 1, 'color' => false]);

        // Optionally, refresh the servers list
        $this->servers = Server::all();
    }

    public function automationYellowTitles()
    {
        // Update the 'automation' field to 1 for all servers with yellow titles
        Server::where('color', true)->update(['automation' => 1, 'color' => false]);

        // Optionally, refresh the servers list
        $this->servers = Server::all();
    }

    public function easyYellowTitles()
    {
        // Update the 'easy' field to 1 for all servers with yellow titles
        Server::where('color', true)->update([ 'easy' => 1, 'color' => false]);

        // Optionally, refresh the servers list
        $this->servers = Server::all();
    }

    public function toggleNecessary($id)
    {
        $server = Server::find($id);
        if ($server) {
            $server->necessary = !$server->necessary;
            $server->save();

            foreach ($this->servers as &$s) {
                if ($s->id == $id) {
                    $s->necessary = $server->necessary;
                }
            }
        }
    }

    public function toggleAutomation($id)
    {
        $server = Server::find($id);
        if ($server) {
            $server->automation = !$server->automation;
            $server->save();

            foreach ($this->servers as &$s) {
                if ($s->id == $id) {
                    $s->automation = $server->automation;
                }
            }
        }
    }

    public function toggleAsk($id)
    {
        $server = Server::find($id);
        if ($server) {
            $server->ask = !$server->ask;
            $server->save();

            foreach ($this->servers as &$s) {
                if ($s->id == $id) {
                    $s->ask = $server->ask;
                }
            }
        }
    }

    public function toggleEasy($id)
    {
        $server = Server::find($id);
        if ($server) {
            $server->easy = !$server->easy;
            $server->save();

            foreach ($this->servers as &$s) {
                if ($s->id == $id) {
                    $s->easy = $server->easy;
                }
            }
        }
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'project' => 'required',
            'employee' => 'required',
        ]);
        $titles = explode(',', $this->title);   
        foreach ($titles as $item) {
            Server::create([         
                'title' => $item,
                'project' => $this->project,
                'employee' => $this->employee,
                'committed' => 0,
                'personal' => $this->personal ? 1 : 0, // Ensure it is stored as an integer
                'necessary' => $this->necessary ? 1 : 0, // Ensure it is stored as an integer
                'automation' => $this->automation ? 1 : 0, // Ensure it is stored as an integer
            ]);
        }
  
        session()->flash('message', 'Server Created Successfully.');
  
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $server = Server::findOrFail($id);
        $this->server_id = $id;
        $this->title = $server->title;
        $this->project = $server->project;
        $this->employee = $server->employee;
        $this->personal = $server->personal ? true : false; // Ensure it is a boolean
        $this->necessary = $server->necessary ? true : false; // Ensure it is a boolean
        $this->automation = $server->automation ? true : false; // Ensure it is a boolean
  
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->project = '';
        $this->employee = '';
        $this->personal = false;
        $this->necessary = false;
        $this->automation = false;
        $this->easy = false;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'project' => 'required',
            'employee' => 'required',
        ]);
  
        if ($this->server_id) {
            $server = Server::find($this->server_id);
            $server->update([
                'title' => $this->title,
                'project' => $this->project,
                'employee' => $this->employee,
                'personal' => $this->personal ? 1 : 0, // Ensure it is stored as an integer
                'necessary' => $this->necessary ? 1 : 0, // Ensure it is stored as an integer
                'automation' => $this->automation ? 1 : 0, // Ensure it is stored as an integer
            ]);
  
            $this->updateMode = false;
            session()->flash('message', 'Server Updated Successfully.');
            $this->resetInputFields();
        }
    }
  
    public function delete($id)
    {
        if($id){
            Server::where('id',$id)->delete();
            session()->flash('message', 'Server Deleted Successfully.');
        }
    }
}
