<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Issue;
  
class Issues extends Component
{
    public $issues, $title,$issue_id,$script,$codeLinks;
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
        ]);

  
        Issue::create([         
        'title' => $this->title,
        'script' => $this->script,
        'codeLinks' => $this->codeLinks,
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
        $this->codeLinks = $issue->codeLinks;

  
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
            'codeLinks' => $this->codeLinks,
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
