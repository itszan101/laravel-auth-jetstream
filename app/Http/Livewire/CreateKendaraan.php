<?php

namespace App\Http\Livewire;

use App\Models\kendaraan;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateKendaraan extends Component
{
    public $user;
    public $userId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules = ($this->action == "updateUser") ? [
            'user.email' => 'required|email|unique:users,email,' . $this->userId
        ] : [
            'user.password' => 'required|min:8|confirmed',
            'user.password_confirmation' => 'required' // livewire need this
        ];

        return array_merge([
            'user.name' => 'required|min:3',
            'user.email' => 'required|email|unique:users,email'
        ], $rules);
    }

    public function createUser ()
    {
        $this->resetErrorBag();
        $this->validate();

        $password = $this->user['password'];

        if ( !empty($password) ) {
            $this->user['password'] = Hash::make($password);
        }

        User::create($this->user);

        $this->emit('saved');
        $this->reset('user');
    }

    public function updateUser ()
    {
        $this->resetErrorBag();
        $this->validate();

        User::query()
            ->where('id', $this->userId)
            ->update([
                "name" => $this->user->name,
                "email" => $this->user->email,
            ]);

        $this->emit('saved');
    }

    public function mount ()
    {
        if (!$this->user && $this->userId) {
            $this->user = User::find($this->userId);
        }

        $this->button = create_button($this->action, "User");
    }
    
    // public function store()
    // {
    //     $this->validate([
    //         'nik' => 'required|digits:16|numeric',
    //         'nama_pemilik' => 'required|string|max:225',
    //         'email' => 'required|string|email|unique:kendaraans,email',
    //         'nama_kendaraan' => 'required|string|max:225',
    //         'nomor_kendaraan' => 'required|string|max:20|unique:kendaraans,nomor_kendaraan',
    //         'nomor_rangka' => 'required|numeric',
    //         'nomor_mesin' => 'required|numeric',
    //         'kapasitas_mesin' => 'required|string',
    //         'poto_kendaraan' => 'required|string'
    //     ]);

    //     $post = kendaraan::create([
    //         'title' => $this->title,
    //         'content' => $this->content
    //     ]);
    // }

    public function render()
    {
        return view('livewire.create-kendaraan');
    }
}
