<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use WithFileUploads;

    public $name = "Kevin McKee";
    public $email = "kevin@lc.com";
    public $department = 'Information Technology';
    public $title = "Instructor";
    public $photo;
    public $status = 1;
    public $role = 'Admin';
    public $application;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'department' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|boolean',
            'role' => 'required|string',
            'photo' => 'image|max:1024', //1MB Max
            'application' => 'file|mimes:pdf|max:10000', //1MB Max
        ]);

        $filename = $this->photo->store('public');

        $user = User::create([
            'name'  => $this->name,
            'email'  => $this->email,
            'department'  => $this->department,
            'title'  => $this->title,
            'status'  => $this->status,
            'role'  => $this->role,
            'photo'  => $filename,
            'password'  => Hash::make('password'),
        ]);


        // filename
        $filename = pathinfo($this->application->getClientOriginalName(), PATHINFO_FILENAME) . '_' . now()->timestamp . '.' . $this->application->getClientOriginalExtension();


        // Store it in public
        $this->application->storeAs('public', '/documents/' . $user->id . '/' . $filename);

        // create document id db
        $user->documents()->create([
            'type' => 'application',
            'filename' => $filename,
            'extension' => $this->application->getClientOriginalExtension(),
            'size' => $this->application->getSize(),
        ]);


        redirect('/team');
        
    }

    public function render()
    {
        return view('livewire.add-user');
    }
}
