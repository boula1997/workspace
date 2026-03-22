<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Issue;
  
class Issues extends Component
{
    public $issues, $title,$issue_id,$script,$ai_prompt;
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
        $this->issues = Issue::OrderBy('title','ASC')->get();
        else
        $this->issues = Issue::OrderBy('title','ASC')->get();
        // $this->issues = Issue::paginate(1);

        return view('livewire.issues');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->script = '';
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
        ]);

  
        Issue::create([         
        'title' => $this->title,
        'script' => $this->script,
        'ai_prompt' => $this->ai_prompt,
    ]);
  
        session()->flash('message', 'Issue Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $this->issue_id = $id;
        $this->title = $issue->title;
        $this->ai_prompt = $issue->ai_prompt;

  
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
        ]);

  
        $issue = Issue::find($this->issue_id);
        $issue->update([
            'title' => $this->title,
            'ai_prompt' => $this->ai_prompt,
        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Issue Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Issue::find($id)->delete();
        session()->flash('message', 'Issue Deleted Successfully.');
    }
}   
