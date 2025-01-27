<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Account;
use App\Models\Post;

class Accounts extends Component
{
    public $accounts, $client,$tasks,$fees,$cost,$payed,$debit,$deadline,$lastTransaction, $account_id,$codeLinks;
    public $updateMode = false;
    public $sortField = 'client'; 
    public $sortDirection = 'asc'; // Default sort direction

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public function toggleDeal($id)
     {
         $account = Post::find($id);
         if ($account) {
             $account->deal = !$account->deal;
             $account->save();
         }
     }
     public function toggleShow($id)
     {
         $account = Post::find($id);
         if ($account) {
             $account->appearance = !$account->appearance;
             $account->save();
         }
     }

    public function render()
    {   

        $query = Post::orderBy($this->sortField, $this->sortDirection);
        if(request()->routeIs('accountantFilter')) {
            $this->accounts = Post::where('isYousab',0)->orderBy('debit', 'DESC')->get();
        } else {
            $this->accounts = Post::where('isYousab',0)->orderBy('client', 'ASC')->get();
        }
    
        // Combine all codeLinks values
        $combinedCodeLinks = $this->accounts->pluck('codeLinks')->implode(' ');

                // List of words to replace
                $wordsToReplace = ['ser', 'code', 'install', 'npm start', 'npx start', 'npx','npm', 'serve', 'dev','ssh'];

        // Iterate through each word and replace it with 'unknown'
        foreach ($wordsToReplace as $word) {
            $combinedCodeLinks = preg_replace('/\b' . preg_quote($word, '/') . '\b/', 'unknown', $combinedCodeLinks);
        }
        $this->accounts = $query->where('isYousab',0)->get();
    
        return view('livewire.accounts', [
            'accounts' => $this->accounts,
            'combinedCodeLinks' => $combinedCodeLinks,
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
        $this->client = '';
        $this->tasks = '';
        $this->fees = '';
        $this->cost = '';
        $this->payed = '';
        $this->debit = '';
        $this->deadline = '';
        $this->lastTransaction = '';
        $this->codeLinks = '';
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedDate = $this->validate([
            'client' => 'required',
            'tasks' => 'nullable',
            'cost' => 'numeric|required',
            'payed' => 'numeric|required',
            'deadline' => 'date|required',
            'codeLinks' => 'nullable',
        ]);

  
        Post::create([         
        'client' => $this->client,
        'fees' => $this->fees,
        'cost' => $this->cost,
        'payed' => $this->payed,
        'debit' => $this->cost-$this->payed,
        'deadline' => $this->deadline,
        'tasks' => $this->tasks,
        'codeLinks' => $this->codeLinks,
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
        $account = Post::findOrFail($id);
        $this->account_id = $id;
        $this->client = $account->client;
        $this->fees = $account->fees;
        $this->cost = $account->cost;
        $this->payed = $account->payed;
        $this->debit = $account->debit;
        $this->deadline = $account->deadline;
        $this->tasks = $account->tasks;
        $this->codeLinks = $account->codeLinks;
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
            'client' => 'required',
            'cost' => 'numeric|required',
            'payed' => 'numeric|required',
            'deadline' => 'date|required',
            'tasks' => 'nullable',
            'codeLinks' => 'nullable',
        ]);
  
        $account = Post::find($this->account_id);
        
        if($account->payed!==$this->payed)
        $account->update([
            'lastTransaction' => todayDate(),
        ]);
        else
            $account->update([
                'lastTransaction' => $this->lastTransaction,
            ]);

        $account->update([
            'client' => $this->client,
            'fees' => $this->fees,
            'cost' => $this->cost,
            'payed' => $this->payed,
            'debit' => $this->cost-$this->payed,
            'deadline' => $this->deadline,
            'codeLinks' => $this->codeLinks,
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
        Post::find($id)->delete();
        session()->flash('message', 'Account Deleted Successfully.');
    }
}   
