<div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        <input type="text" wire:model="agentNumber" placeholder="Agent Number" class="form-input" />
        <input type="text" wire:model="phoneNumber" placeholder="Phone Number" class="form-input" />
        <input type="date" wire:model="fromDate" class="form-input" />
        <input type="date" wire:model="toDate" class="form-input" />
        <input type="number" wire:model="minDuration" placeholder="Min Duration (sec)" class="form-input" />
        <input type="text" wire:model="disposition" placeholder="Disposition" class="form-input" />
        <input type="text" wire:model="transactionCode" placeholder="Transaction Code" class="form-input" />
    </div>

    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th>Agent</th>
                <th>Phone</th>
                <th>Duration</th>
                <th>Date</th>
                <th>Disposition</th>
                <th>Transaction</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr class="border-t">
                    <td>{{ $record->agent_number }}</td>
                    <td>{{ $record->phone_number }}</td>
                    <td>{{ $record->call_duration }}</td>
                    <td>{{ $record->calldate }}</td>
                    <td>{{ $record->disposition }}</td>
                    <td>{{ $record->transaction_code }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-gray-500">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>