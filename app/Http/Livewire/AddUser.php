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
        ]);

        $filename = $this->photo->store('public');

        User::create([
            'name'  => $this->name,
            'email'  => $this->email,
            'department'  => $this->department,
            'title'  => $this->title,
            'status'  => $this->status,
            'role'  => $this->role,
            'photo'  => $filename,
            'password'  => Hash::make('password'),
        ]);


        session()->flash('success', 'New member added');
    }

    public function render()
    {
        return view('livewire.add-user');
    }
}
