<?php

namespace App\Livewire;

use Livewire\Component;

class SonnerToaster extends Component
{
    protected $listeners = ['toast', 'show-toast'];

    public function toast($type, $message, $duration = 3000)
    {
        $this->dispatchBrowserEvent('toast-message', [
            'type' => $type,
            'message' => $message,
            'duration' => $duration
        ]);
    }

    public function showToast($type, $message, $duration = 3000)
    {
        $this->dispatchBrowserEvent('toast-message', [
            'type' => $type,
            'message' => $message,
            'duration' => $duration
        ]);
    }

    public function render()
    {
        return view('livewire.sonner-toaster');
    }
}