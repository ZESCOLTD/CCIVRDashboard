<?php

namespace App\Http\Livewire\Configs;

use App\Models\Configs\ConfigDestinationsModel;
use App\Models\Configs\ContextsModel;
use Livewire\Component;

class Destination extends Component
{


    public $config_destinations, $context, $destination, $description, $option, $config_destination_id;

    public  $contexts = [];
    public $updateConfigDestination = false;
    protected $listeners = [
        'deleteConfigDestination' => 'destroy'
    ];


    // Validation Rules
    protected $rules = [
        'context' => 'required',
        'destination' => 'required',
        'description' => 'required',
        'option' => 'required',
    ];




    public function render()
    {
        $this->contexts = ContextsModel::select('id', 'context')->get();
        $this->config_destinations = ConfigDestinationsModel::select('id', 'context', 'destination', 'description', 'option')->get();
        return view('livewire.configs.destinations.index');
    }





    public function resetFields()
    {
        $this->context = '';
        $this->destination = '';
        $this->description = '';
        $this->option = '';
    }





    public function store()
    {
        // Validate Form Request
        //$this->validate();
        try {
            // Create Config Destination
            ConfigDestinationsModel::updateOrCreate(
                [
                    'context' => $this->context,
                    'destination' => $this->destination,
                ],

                [
                    'context' => $this->context,
                    'destination' => $this->destination,
                    'description' => $this->description,
                    'option' => $this->option
                ]
            );

            // Set Flash Message
            session()->flash('success', 'Config Destination Created Successfully!!');
            // Reset Form Fields After Creating Config Destination
            $this->resetFields();
        } catch (\Exception $e) {
            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating config_destination!!
            ERR' . $e);
            // Reset Form Fields After Creating Config Destination
            $this->resetFields();
        }
    }






    public function edit($id)
    {
        $config_destination = ConfigDestinationsModel::findOrFail($id);
        $this->context = $config_destination->context;
        $this->destination = $config_destination->destination;
        $this->description = $config_destination->description;
        $this->config_destination_id = $config_destination->id;
        $this->option = $config_destination->option;
        $this->updateConfigDestination = true;
    }





    public function cancel()
    {
        $this->updateConfigDestination = false;
        $this->resetFields();
    }






    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update config_destination
            ConfigDestinationsModel::find($this->config_destination_id)->fill([
                'context' => $this->context,
                'destination' => $this->destination,
                'description' => $this->description,
                'option' => $this->option
            ])->save();
            session()->flash('success', 'Config Destination Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating config_destination!!');
            $this->cancel();
        }
    }





    public function destroy($id)
    {
        try {
            ConfigDestinationsModel::find($id)->delete();
            session()->flash('success', "Config Destination Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting config_destination!!");
        }
    }
}
