<?php

namespace App\Http\Livewire\Technical;

use App\Models\Technical;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use App\Models\CDR\CallDetailsRecordModel;
use App\Models\User;
use Carbon\Carbon;

class TechnicalControllers extends Component

{
    public $technical_id;
    public $topic;
    public $description;
    public $technicals;
    public $updateTechnical = false;

    protected $listeners = [
        'deleteTechnical' => 'destroy'
    ];

    protected $rules = [
        'topic' => 'required|string',
        'description' => 'required|string',
    ];

    public function render()
    {
        $this->technicals = Technical::select('id', 'topic', 'description')->get();
        return view('livewire.technicals.index');
    }

    public function resetFields()
    {
        $this->topic = '';
        $this->description = '';
        $this->technical_id = null;
        $this->updateTechnical = false;
    }

    public function store()
    {
        $this->validate();

        try {
            Technical::updateOrCreate(
                [
                    'topic' => $this->topic,
                    'description' => $this->description,
                ],
                [
                    'topic' => $this->topic,
                    'description' => $this->description,

                ]
            );

            session()->flash('success', 'Knowledge Base created successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error while creating Knowledge: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $technical = Technical::findOrFail($id);
        $this->topic = $technical->topic;
        $this->description = $technical->description;
        $this->technical_id = $technical->id;
        $this->updateTechnical = true;
    }

    public function cancel()
    {
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();

        try {
            $technical = Technical::findOrFail($this->technical_id);
            $technical->update([
                'topic' => $this->topic,
                'description' => $this->description,

            ]);

            session()->flash('success', 'Knowledge Base updated successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error while updating Knowledge Base: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function destroy($id)
    {
        try {
            $technical = Technical::findOrFail($id);
            $technical->delete();
            session()->flash('success', "Knowledge Base deleted successfully!");
        } catch (\Exception $e) {
            session()->flash('error', "Error while deleting Knowledge Base: " . $e->getMessage());
        }
    }
}
