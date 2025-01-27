<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Boula;
  
class Boulas extends Component
{
    public $boulas, $title,$tasks,$fees,$cost,$payed,$debit,$deadline,$lastTransaction, $boula_id,$codeLinks;
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

                // Combine all codeLinks values
                $combinedCodeLinks = $this->boulas->pluck('codeLinks')->implode(' ');

                // List of words to replace
                $wordsToReplace = ['ser', 'code', 'install', 'npm start', 'npx start', 'npx','npm', 'serve', 'dev','ssh'];
        
                // Iterate through each word and replace it with 'unknown'
                foreach ($wordsToReplace as $word) {
                    $combinedCodeLinks = preg_replace('/\b' . preg_quote($word, '/') . '\b/', 'unknown', $combinedCodeLinks);
                }
            
        return view('livewire.boulas',compact('combinedCodeLinks'));
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
            'title' => 'required',
            'tasks' => 'nullable',
            'cost' => 'numeric|required',
            'payed' => 'numeric|required',
            'deadline' => 'date|required',
            'codeLinks' => 'nullable',
        ]);

  
        Boula::create([         
        'title' => $this->title,
        'fees' => $this->fees,
        'cost' => $this->cost,
        'payed' => $this->payed,
        'debit' => $this->cost-$this->payed,
        'deadline' => $this->deadline,
        'tasks' => $this->tasks,
        'codeLinks' => $this->codeLinks,
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
        $this->codeLinks = $boula->codeLinks;
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
            'codeLinks' => 'nullable',
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
            'codeLinks' => $this->codeLinks,
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
