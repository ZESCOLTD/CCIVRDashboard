<?php

namespace App\Http\Livewire\Live\Supervisor\KnowledgeBase;

use Livewire\Component;
use App\Models\KnowledgeBase;

class KnowledgeBaseManager extends Component
{
    public $knowledgeBases;
    public $currentItem = null;
    public $isEditing = false;

    public $topic = '';
    public $description = '';

    protected $rules = [
        'topic' => 'required|string|max:255',
        'description' => 'required|string|min:10',
    ];

    protected $messages = [
        'topic.required' => 'Please provide a topic.',
        'description.required' => 'Please enter a description.',
        'description.min' => 'The description must be at least 10 characters long.',
    ];

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->knowledgeBases = KnowledgeBase::latest('last_updated')->get();
    }

    public function render()
    {
        return view('livewire.live.supervisor.knowledge-base.knowledge-base')
            ->extends('layouts.app')
            ->section('content');
    }

    public function show($id)
    {
        $this->currentItem = KnowledgeBase::findOrFail($id);
        $this->topic = $this->currentItem->topic;
        $this->description = $this->currentItem->description;
        $this->isEditing = true;
        $this->resetErrorBag();
    }

    public function startCreating()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->currentItem = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        KnowledgeBase::updateOrCreate(
            [
            'topic' => $this->topic,
            'description' => $this->description,
            'last_updated' => now(),

            ],
            [
                'topic' => $this->topic,
                'description' => $this->description,
                'last_updated' => now(),
        ]);


        $this->resetForm();
        $this->loadItems();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Knowledge base item created successfully!'
        ]);
    }

    public function updateItem()
    {
        $this->validate();

        $this->currentItem->update([
            'topic' => $this->topic,
            'description' => $this->description,
            'last_updated' => now(),
        ]);

        $this->resetForm();
        $this->loadItems();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Knowledge base item updated successfully!'
        ]);
    }

    public function delete($id)
    {
        $item = KnowledgeBase::findOrFail($id);
        $item->delete();

        $this->loadItems();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Knowledge base item deleted successfully!'
        ]);

        if ($this->currentItem && $this->currentItem->id == $id) {
            $this->resetForm();
        }
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['topic', 'description', 'isEditing', 'currentItem']);
    }
}
