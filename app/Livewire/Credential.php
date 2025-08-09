<?php

namespace App\Livewire;

use App\Models\DBCredential;
use Livewire\Component;

class Credential extends Component
{
    public $credentials,$db_name,$credential_id,$db_username,$db_password;
    public $updateMode = false;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {   

        $this->credentials = DBcredential::orderBy('db_name','ASC')->get();
        return view('livewire.dbcredential');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->db_name = '';
        $this->db_username = '';
        $this->db_password = '';
     

    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedDate = $this->validate([
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
          

        ]);

  
        DBcredential::create([         
        'db_name' => $this->db_name,
        'db_username' => $this->db_username,
        'db_password' => $this->db_password,
    ]);
  
        session()->flash('message', 'Credential Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $credential = DBcredential::findOrFail($id);
        $this->credential_id = $id;
        $this->db_name = $credential->db_name;
        $this->db_username = $credential->db_username;
        $this->db_password = $credential->db_password;

  
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
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
        ]);
  
        $credential = DBcredential::find($this->credential_id);
        $credential->update([
            'db_name' => $this->db_name,
            'db_username' => $this->db_username,
            'db_password' => $this->db_password,
        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Credential Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *+
     * @var array
     */
    public function delete($id)
    {
        DBcredential::find($id)->delete();
        session()->flash('message', 'Credential Deleted Successfully.');
    }
}
