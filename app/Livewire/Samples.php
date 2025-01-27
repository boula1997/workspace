<?php

namespace App\Livewire;

use App\Models\Sample;
use Livewire\Component;

class Samples extends Component
{
    public $samples,$script,$sample_id,$title,$type,$stack;
    public $updateMode = false;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {   

        $this->samples = Sample::orderBy('id','ASC')->where('stack','dashfastkart')->whereIn('title',["create","edit","show"])->get();
        return view('livewire.samples');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->script = '';
        $this->title = '';
        $this->type = '';
        $this->stack = '';

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
            'script' => 'required',
            'type' => 'required',
            'stack' => 'required',

        ]);

  
        Sample::create([         
        'script' => $this->script,
        'title' => $this->title,
        'type' => $this->type,
        'stack' => $this->stack,
    ]);
  
        session()->flash('message', 'Sample Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $sample = Sample::findOrFail($id);
        $this->sample_id = $id;
        $this->script = $sample->script;
        $this->title = $sample->title;
        $this->type = $sample->type;
        $this->stack = $sample->stack;

  
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
            'script' => 'required',
            'title' => 'required',
            'type' => 'required',
            'stack' => 'required',

        ]);
  
        $sample = Sample::find($this->sample_id);
        $sample->update([
            'script' => $this->script,
            'title' => $this->title,
            'type' => $this->type,
            'stack' => $this->stack,

        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Sample Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *+
     * @var array
     */
    public function delete($id)
    {
        Sample::find($id)->delete();
        session()->flash('message', 'Sample Deleted Successfully.');
    }
}
