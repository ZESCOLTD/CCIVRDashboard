<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class CallHistory extends Component
{
    public string $selectedContact = '1179';

    public array $contacts = [
        ['id' => '01002', 'date' => '2026-02-12'],
        ['id' => '1179', 'date' => '2025-12-02'],
        ['id' => 'alice', 'date' => '2025-11-28'],
    ];

    public array $calls = [
        [
            'type' => 'received',
            'message' => 'You received an audio call, and spoke for 32 seconds.',
            'date' => '2025-04-09'
        ],
        [
            'type' => 'received',
            'message' => 'You received an audio call, and spoke for 6 seconds.',
            'date' => '2025-04-09'
        ],
        [
            'type' => 'missed',
            'message' => 'You missed a call (Call Cancelled).',
            'date' => '2025-04-09'
        ],
        [
            'type' => 'received',
            'message' => 'You received an audio call, and spoke for 30 seconds.',
            'date' => '2025-04-09'
        ],
    ];

    public function selectContact(string $id): void
    {
        $this->selectedContact = $id;
        // later: load calls from DB here
    }

    public function render()
    {
        return view('livewire.chat.call-history');
    }
}