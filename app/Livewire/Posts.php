<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Project;
  
class Posts extends Component
{
    public $posts, $title,$tasks,$fees,$cost,$payed,$debit,$deadline,$lastTransaction, $routesLink,$post_id,$ai_prompt;
    public $updateMode = false;
    public $sortField = 'title'; 
    public $sortDirection = 'asc'; // Default sort direction

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public function toggleDeal($id)
     {
         $post = Project::find($id);
         if ($post) {
             $post->deal = !$post->deal;
             $post->save();
         }
     }
     public function toggleShow($id)
     {
         $post = Project::find($id);
         if ($post) {
             $post->appearance = !$post->appearance;
             $post->save();
         }
     }

    public function render()
    {   

        $query = Project::orderBy($this->sortField, $this->sortDirection);
        if(request()->routeIs('accountantFilter')) {
            $this->posts = Project::where('isYousab',1)->orderBy('debit', 'DESC')->get();
        } else {
            $this->posts = Project::where('isYousab',1)->orderBy('title', 'ASC')->get();
        }
    
        // Combine all ai_prompt values
        $combinedai_prompt = $this->posts->pluck('ai_prompt')->implode(' ');

                // List of words to replace
                $wordsToReplace = ['ser', 'code', 'install', 'npm start', 'npx start', 'npx','npm', 'serve', 'dev','ssh'];

        // Iterate through each word and replace it with 'unknown'
        foreach ($wordsToReplace as $word) {
            $combinedai_prompt = preg_replace('/\b' . preg_quote($word, '/') . '\b/', 'unknown', $combinedai_prompt);
        }
        $this->posts = $query->where('isYousab',1)->get();
    
        return view('livewire.posts', [
            'posts' => $this->posts,
            'combinedai_prompt' => $combinedai_prompt,
        ]);
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->tasks = '';
        $this->fees = '';
        $this->cost = '';
        $this->payed = '';
        $this->debit = '';
        $this->deadline = '';
        $this->lastTransaction = '';
        $this->routesLink = '';
        $this->ai_prompt = '';
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'tasks' => 'nullable',
            'cost' => 'numeric|required',
            'payed' => 'numeric|required',
            'deadline' => 'date|required',
            'ai_prompt' => 'nullable',
        ]);

  
        Project::create([         
        'title' => $this->title,
        'fees' => $this->fees,
        'cost' => $this->cost,
        'payed' => $this->payed,
        'debit' => $this->cost-$this->payed,
        'deadline' => $this->deadline,
        'tasks' => $this->tasks,
        'ai_prompt' => $this->ai_prompt,
        'lastTransaction' => $this->lastTransaction,
        'routesLink' => $this->routesLink,
        'isYousab' => 1,
    ]);
  
        session()->flash('message', 'Post Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $post = Project::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->fees = $post->fees;
        $this->cost = $post->cost;
        $this->payed = $post->payed;
        $this->debit = $post->debit;
        $this->deadline = $post->deadline;
        $this->tasks = $post->tasks;
        $this->ai_prompt = $post->ai_prompt;
        $this->lastTransaction = $post->lastTransaction;
        $this->routesLink = $post->routesLink;
  
        $this->updateMode = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'cost' => 'numeric|required',
            'payed' => 'numeric|required',
            'deadline' => 'date|required',
            'tasks' => 'nullable',
            'ai_prompt' => 'nullable',
            'routesLink' => 'nullable',
        ]);
  
        $post = Project::find($this->post_id);
        
        if($post->payed!==$this->payed)
        $post->update([
            'lastTransaction' => todayDate(),
        ]);
        else
            $post->update([
                'lastTransaction' => $this->lastTransaction,
            ]);

        $post->update([
            'title' => $this->title,
            'fees' => $this->fees,
            'cost' => $this->cost,
            'payed' => $this->payed,
            'debit' => $this->cost-$this->payed,
            'deadline' => $this->deadline,
            'ai_prompt' => $this->ai_prompt,
            'routesLink' => $this->routesLink,
            'isYousab' => 1,
        ]);


        $this->updateMode = false;
  
        session()->flash('message', 'Post Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Project::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}   
