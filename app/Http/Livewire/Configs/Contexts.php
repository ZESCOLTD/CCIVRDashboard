<?php

namespace App\Http\Livewire\Configs;

use App\Models\Configs\ContextsModel;
use Livewire\Component;

class Contexts extends Component
{
//    public function render()
//    {
//        return view('livewire.configs.contexts');
//    }

    public $config_contexts, $context, $config_context_id;
    public $updateConfigContext = false;
    protected $listeners = [
        'deleteConfigContext'=>'destroy'
    ];


    // Validation Rules
    protected $rules = [
        'context'=>'required'
    ];




    public function render()
    {
        $this->config_contexts = ContextsModel::select('id','context')->get();
        return view('livewire.configs.contexts.index');
    }





    public function resetFields(){
        $this->context = '';
    }





    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create Config Destination
            ContextsModel::updateOrCreate(
                [
                'context'=>$this->context
            ],
                [
                'context'=>$this->context
            ]

            );

            // Set Flash Message
            session()->flash('success','Config Context Created Successfully!!');
            // Reset Form Fields After Creating Config Destination
            $this->resetFields();
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating config context!!');
            // Reset Form Fields After Creating Config Destination
            $this->resetFields();
        }
    }






    public function edit($id){
        $config_context = ContextsModel::findOrFail($id);
        $this->context = $config_context->context;
        $this->config_context_id = $config_context->id;
        $this->updateConfigContext = true;
    }





    public function cancel()
    {
        $this->updateConfigContext = false;
        $this->resetFields();
    }






    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update config_destination
            ContextsModel::find($this->config_context_id)->fill([
                'context'=>$this->context,
            ])->save();
            session()->flash('success','Config Destination Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating config context!!');
            $this->cancel();
        }
    }





    public function destroy($id){
        try{
            ContextsModel::find($id)->delete();
            session()->flash('success',"Config Destination Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something went wrong while deleting config Context!!");
        }
    }

}
