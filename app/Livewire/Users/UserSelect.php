<?php

namespace App\Livewire\Users;
use App\Models\Assortment;
use App\Models\Status;
use App\Models\Tally;
use App\Models\User;

use Livewire\Component;
use Masmerise\Toaster\Toaster;

class UserSelect extends Component
{
    public User $user;
    public $assortments;
    public $selection;
    public $title = "Turven";

    public $showSuccesNotification  = false;

    public function mount($user) {
        $this->user = $user;
        $this->assortments = Assortment::all();
    }

    public function render()
    {
        return view('livewire.users.user-select');
    }

    public function save()
    {
        foreach ($this->selection as $key => $count) {
            $assortment = Assortment::find($key);
            $data = [
                'assortment_id' => $assortment->id,
                'user_id' => $this->user->id,
                'count' => $count,
                'price' => $assortment->price * $count,
                'type_id' => Tally::TYPE_tally,
                'status_id' => Status::STATUS_ingevoerd
            ];

            Tally::create($data);
            $this->selection = null;

            session()->flash('status', 'Turven toegevoegd.');

            $this->redirect('/dashboard');
        }
    }

    public function select($assortment)
    {
        if(isset($this->selection[$assortment])){
            $this->selection[$assortment]++;
            return;
        }
        $this->selection[$assortment] = 1;
    }

    public function deSelect($assortment)
    {
        if(isset($this->selection[$assortment])){
            $this->selection[$assortment]--;
            if ($this->selection[$assortment] <= 0) {
                unset($this->selection[$assortment]);
            }
        }
    }
    public function toggleSuccesNotification(){
        $this->showSuccesNotification = !$this->showSuccesNotification;
    }
}
