<?php

namespace App\Http\Livewire\Live;

use Livewire\Component;
use App\Models\Live\TransactionCode as TransCode;

class TransactionCode extends Component
{
    public $name, $description, $code;
    public $selectedTC;

    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'code' => 'required'
    ];

    public function render()
    {
        $transactionCodes = TransCode::all();
        return view('livewire.live.transaction-code.transaction-code', ['transactionCodes' => $transactionCodes]);
    }

    public function store()
    {
        $this->validate();

        $this->selectedTC = TransCode::create([
            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code
        ]);
        session()->flash('message', 'Deleted Successfully');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $transactionCode = TransCode::findOrFail($id);
        $this->selectedTC = $transactionCode;
        $this->name = $transactionCode->name;
        $this->description = $transactionCode->description;
        $this->code = $transactionCode->code;
    }

    public function update()
    {
        $this->validate();

        if ($this->selectedTC) {
            $this->selectedTC->update([
                'name' => $this->name,
                'description' => $this->description,
                'code' => $this->code
            ]);

            $this->resetInputFields();
        }
        session()->flash('message', 'Updated Successfully');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->code = '';
        $this->selectedTC = null;
    }

    public function delete()
    {


        if ($this->selectedTC) {
            TransCode::destroy($this->selectedTC->id);
            $this->resetInputFields();

            session()->flash('message', 'Deleted Successfully');
        }
    }
}
