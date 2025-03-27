<?php

namespace App\Http\Livewire\Configs;

use App\Models\Configs\ContextsModel;
use Livewire\Component;

class ShowContexts extends Component
{

    public $context ;

    public function mount($id)
    {
        $this->context = ContextsModel::where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.configs.contexts.show');
    }
}
