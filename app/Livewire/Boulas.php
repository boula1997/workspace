<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Boula;
  
class Boulas extends Component
{
    public $boulas, $title,$tasks,$fees,$cost,$payed,$debit,$deadline,$lastTransaction, $boula_id,$ai_prompt;
    public $updateMode = false;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {   
        //  dd(request()->routeIs('accountantFilter'));
        if(request()->routeIs('accountantFilter'))
        $this->boulas = Boula::OrderBy('debit','DESC')->get();
        else
        $this->boulas = Boula::OrderBy('title','ASC')->get();

                // Combine all ai_prompt values
                $combinedai_prompt = $this->boulas->pluck('ai_prompt')->implode(' ');

                // List of words to replace
                $wordsToReplace = ['ser', 'code', 'install', 'npm start', 'npx start', 'npx','npm', 'serve', 'dev','ssh'];
        
                // Iterate through each word and replace it with 'unknown'
                foreach ($wordsToReplace as $word) {
                    $combinedai_prompt = preg_replace('/\b' . preg_quote($word, '/') . '\b/', 'unknown', $combinedai_prompt);
                }
            
        return view('livewire.boulas',compact('combinedai_prompt'));
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

  
        Boula::create([         
        'title' => $this->title,
        'fees' => $this->fees,
        'cost' => $this->cost,
        'payed' => $this->payed,
        'debit' => $this->cost-$this->payed,
        'deadline' => $this->deadline,
        'tasks' => $this->tasks,
        'ai_prompt' => $this->ai_prompt,
        'lastTransaction' => $this->lastTransaction,
    ]);
  
        session()->flash('message', 'Boula Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $boula = Boula::findOrFail($id);
        $this->boula_id = $id;
        $this->title = $boula->title;
        $this->fees = $boula->fees;
        $this->cost = $boula->cost;
        $this->payed = $boula->payed;
        $this->debit = $boula->debit;
        $this->deadline = $boula->deadline;
        $this->tasks = $boula->tasks;
        $this->ai_prompt = $boula->ai_prompt;
        $this->lastTransaction = $boula->lastTransaction;
  
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
  
        $boula = Boula::find($this->boula_id);
        
        if($boula->payed!==$this->payed)
        $boula->update([
            'lastTransaction' => todayDate(),
        ]);
        else
            $boula->update([
                'lastTransaction' => $this->lastTransaction,
            ]);

        $boula->update([
            'title' => $this->title,
            'fees' => $this->fees,
            'cost' => $this->cost,
            'payed' => $this->payed,
            'debit' => $this->cost-$this->payed,
            'deadline' => $this->deadline,
            'ai_prompt' => $this->ai_prompt,
        ]);


        $this->updateMode = false;
  
        session()->flash('message', 'Boula Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Boula::find($id)->delete();
        session()->flash('message', 'Boula Deleted Successfully.');
    }
}   
