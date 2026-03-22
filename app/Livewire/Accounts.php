<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Account;
use App\Models\Post;

class Accounts extends Component
{
    public $accounts, $title,$tasks,$fees,$cost,$payed,$debit,$deadline,$lastTransaction, $account_id,$ai_prompt;
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
         $account = Project::find($id);
         if ($account) {
             $account->deal = !$account->deal;
             $account->save();
         }
     }
     public function toggleShow($id)
     {
         $account = Project::find($id);
         if ($account) {
             $account->appearance = !$account->appearance;
             $account->save();
         }
     }

    public function render()
    {   

        $query = Project::orderBy($this->sortField, $this->sortDirection);
        if(request()->routeIs('accountantFilter')) {
            $this->accounts = Project::where('isYousab',0)->orderBy('debit', 'DESC')->get();
        } else {
            $this->accounts = Project::where('isYousab',0)->orderBy('title', 'ASC')->get();
        }
    
        // Combine all ai_prompt values
        $combinedai_prompt = $this->accounts->pluck('ai_prompt')->implode(' ');

                // List of words to replace
                $wordsToReplace = ['ser', 'code', 'install', 'npm start', 'npx start', 'npx','npm', 'serve', 'dev','ssh'];

        // Iterate through each word and replace it with 'unknown'
        foreach ($wordsToReplace as $word) {
            $combinedai_prompt = preg_replace('/\b' . preg_quote($word, '/') . '\b/', 'unknown', $combinedai_prompt);
        }
        $this->accounts = $query->where('isYousab',0)->get();
    
        return view('livewire.accounts', [
            'accounts' => $this->accounts,
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
        'isYousab' => 0,
    ]);
  
        session()->flash('message', 'Account Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $account = Project::findOrFail($id);
        $this->account_id = $id;
        $this->title = $account->title;
        $this->fees = $account->fees;
        $this->cost = $account->cost;
        $this->payed = $account->payed;
        $this->debit = $account->debit;
        $this->deadline = $account->deadline;
        $this->tasks = $account->tasks;
        $this->ai_prompt = $account->ai_prompt;
        $this->lastTransaction = $account->lastTransaction;
  
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
        ]);
  
        $account = Project::find($this->account_id);
        
        if($account->payed!==$this->payed)
        $account->update([
            'lastTransaction' => todayDate(),
        ]);
        else
            $account->update([
                'lastTransaction' => $this->lastTransaction,
            ]);

        $account->update([
            'title' => $this->title,
            'fees' => $this->fees,
            'cost' => $this->cost,
            'payed' => $this->payed,
            'debit' => $this->cost-$this->payed,
            'deadline' => $this->deadline,
            'ai_prompt' => $this->ai_prompt,
            'isYousab' => 0,
        ]);


        $this->updateMode = false;
  
        session()->flash('message', 'Account Updated Successfully.');
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
        session()->flash('message', 'Account Deleted Successfully.');
    }
}   
