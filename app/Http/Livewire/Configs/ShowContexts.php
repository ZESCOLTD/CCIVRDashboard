<?php

namespace App\Http\Livewire\Configs;

use App\Models\Configs\ContextsModel;
use Livewire\Component;

class ShowContexts extends Component
{

    // public $context;


    public $name;
    public $description;
    public $config_contexts, $context, $config_context_id;

    public function mount($id)
    {
        $this->context = ContextsModel::findOrFail($id);
        $this->name = $this->context->name;
        $this->description = $this->context->description;
    }

    public function render()
    {
        return view('livewire.configs.contexts.show');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->context->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Context updated successfully.');
    }



    public function edit($id){
        $config_context = ContextsModel::findOrFail($id);
        $this->context = $config_context->context;
        $this->config_context_id = $config_context->id;
        $this->updateConfigContext = true;
    }

}
