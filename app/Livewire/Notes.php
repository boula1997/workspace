<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use App\Models\Note;
  
class Notes extends Component
{
    public $notes, $title,$note_id,$script,$codeLinks;
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
        $this->notes = Note::OrderBy('title','ASC')->get();
        else
        $this->notes = Note::OrderBy('title','ASC')->get();
        // $this->notes = Note::paginate(1);

        return view('livewire.notes');
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

  
        Note::create([         
        'title' => $this->title,
        'script' => $this->script,
        'codeLinks' => $this->codeLinks,
    ]);
  
        session()->flash('message', 'Note Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $this->note_id = $id;
        $this->title = $note->title;
        $this->codeLinks = $note->codeLinks;

  
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

  
        $note = Note::find($this->note_id);
        $note->update([
            'title' => $this->title,
            'codeLinks' => $this->codeLinks,
        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Note Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Note::find($id)->delete();
        session()->flash('message', 'Note Deleted Successfully.');
    }
}   
