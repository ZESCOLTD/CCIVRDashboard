@php
    function getNetworkBadgeColor($network)
    {
        switch (strtolower($network)) {
            case 'airtel':
                return '#F70000';
            case 'mtn':
                return '#FFCB05';
            case 'zamtel':
                return '#20AC49';
            case 'whatsapp':
                return '#34B7F1';
            default:
                return '#6c757d'; // bootstrap secondary color fallback
        }
    }

    $now1 = now();
    $dayCurrent = $now1->copy()->subDay()->format('l'); // Last 24 = yesterday
    $dayPrevious = $now1->copy()->subDays(2)->format('l'); // Previous 24 = day before yesterday

@endphp


{{-- <div class="p-6 bg-white shadow-lg rounded-lg">
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 space-y-4 md:space-y-0">

        1. Date Input
        <div class="w-full md:w-auto">
            <label for="date-selector" class="block text-sm font-medium text-gray-700">
                Select Date (Stats for **{{ $selectedDate }}**):
            </label>
            <input
                id="date-selector"
                type="date"
                wire:model="selectedDate"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <p class="mt-1 text-xs text-gray-500">
                Comparing {{ $selectedDate }} vs {{ \Carbon\Carbon::parse($selectedDate)->subDay()->toDateString() }}
            </p>
        </div>

        2. Refresh Button and Spinner
        <button
            wire:click="refreshStats"
            wire:target="refreshStats, selectedDate"
            wire:loading.attr="disabled"
            class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-150 ease-in-out disabled:opacity-50 flex items-center justify-center"
        >
            Spinner (shows only when refreshStats or selectedDate is loading)
            <div wire:loading wire:target="refreshStats, selectedDate" class="mr-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            Refresh Stats
        </button>

    </div>

    <hr class="my-4">

    3. Data Table (or main stats container)
    Add wire:loading to the stats container for a better user experience
    <div wire:loading.class.delay="opacity-50" wire:target="refreshStats, selectedDate">
        Your stats table rendering $dailyStats goes here
        @include('livewire.dashboard.daily-stats-table')
    </div>
</div> --}}

<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Daily Stats Summary (Last 24 Hours)</h3>
    </div>


    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-start"  id="dailyStatsTable" >
            <thead>
                <tr>
                    <th style="font-size: 1.1rem;">Network/Channel</th>
                    <th class="text-right" style="font-size: 1.0rem;">{{ $dayPrevious }}</th>
                    <th class="text-right" style="font-size: 1.0rem;">{{ $dayCurrent }} </th>
                    <th class="text-right" style="font-size: 1.0rem;">Diff</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyStats as $item)
                    @php
                        $color = getNetworkBadgeColor($item->network);
                        $changeColor = $item->change >= 0 ? 'green' : 'red';
                        $arrow = $item->change >= 0 ? '↑' : '↓';
                    @endphp
                    <tr>
                        <td style="font-size: 1.5rem;">
                            <span class="badge" style="background-color: {{ $color }}; color: #fff;">
                                {{ ucfirst($item->network) }}
                            </span>
                        </td>

                        <td class="text-right" style=" font-size: 1.5rem;">{{ $item->previous }}</td>
                        <td class="text-right" style=" color: {{ $color }}; font-size: 1.5rem;">{{ $item->sessions }}</td>

                        <td class="text-right" style="color: {{ $changeColor }}    ; font-size: 0.8rem;">
                            {{ $arrow }} {{ number_format(abs($item->change), 1) }}%
                        </td>
                    </tr>
                @endforeach

                <tr class="text-bold">
                    <td style="font-size: 1.5rem;">Total</td>
                    <td class="text-bold text-right" style="font-size: 1.5rem;">{{ $dailyStats->sum('previous') }}</td>
                    <td class="text-bold text-right" style="font-size: 1.5rem;">{{ $dailyStats->sum('sessions') }}</td>
                    <td class="text-bold text-right"   style="font-size: 0.8rem;">
                        @php


                            $totalPrevious = $dailyStats->sum('previous');
                            $totalCurrent = $dailyStats->sum('sessions');
                            $totalChange = $totalPrevious > 0
                                ? (($totalCurrent - $totalPrevious) / $totalPrevious) * 100
                                : ($totalCurrent > 0 ? 100 : 0);



                            $totalColor = $totalChange >= 0 ? 'green' : 'red';
                            $totalArrow = $totalChange >= 0 ? '↑' : '↓';
                        @endphp
                        <span style="color: {{ $totalColor }}">
                            {{ $totalArrow }} {{ number_format(abs($totalChange), 1) }}%
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        @php
            $top = $dailyStats->sortByDesc('previous')->first();
            $least = $dailyStats->sortBy('previous')->first();
            $total = $dailyStats->sum('sessions');

            $topColor = getNetworkBadgeColor($top->network);
            $leastColor = getNetworkBadgeColor($least->network);
        @endphp

        <div class="mt-3 p-3 bg-light rounded" style="font-size: 1.1rem;">
            <h4>Analysis</h4>
            <h4>
                In the last 24 hours, a total of <strong>{{ number_format($total) }}</strong> sessions were recorded.
                The highest activity was on
                <strong style="color: {{ $topColor }}">{{ ucfirst($top->network) }}</strong>
                with <strong style="color: {{ $topColor }}">{{ number_format($top->sessions) }}</strong> sessions,
                while <strong style="color: {{ $leastColor }}">{{ ucfirst($least->network) }}</strong>
                had the lowest at <strong style="color: {{ $leastColor }}">{{ number_format($least->sessions) }}</strong> sessions.
            </h4>
        </div>
    </div>




    <div>

        <div class = "mt-2  p-3">


            <!-- Trigger Button -->
            <button class="btn  btn-sm btn-outline-secondary" data-toggle="modal" data-target="#channelModal">
                Add Channel Stat
            </button>
        </div>

        <div>


            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="channelModal" tabindex="-1" role="dialog"
                aria-labelledby="channelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form wire:submit.prevent="submit">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add/Update Channel Stat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <!-- Channel Dropdown -->
                                <div class="form-group">
                                    <label for="channelSelect">Channel</label>
                                    <select wire:model.defer="selectedChannel" class="form-control" id="channelSelect">
                                        <option value="">Select Channel</option>
                                        @foreach ($channels as $channel)
                                            <option value="{{ $channel }}">{{ $channel }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedChannel')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Channel Total -->
                                <div class="form-group">
                                    <label for="channelTotal">Channel Total</label>
                                    <input type="number" wire:model.defer="channelTotal" class="form-control"
                                        id="channelTotal" />
                                    @error('channelTotal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Stats Date -->
                                <div class="form-group">
                                    <label for="statsDate">Stats Date</label>
                                    <input type="date" wire:model.defer="statsDate" class="form-control"
                                        id="statsDate" />
                                    @error('statsDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="submit"
                                        class="spinner-border spinner-border-sm mr-1" role="status"
                                        aria-hidden="true"></span>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Edit Modal -->
        <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="update">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Sessions for {{ $editNetwork }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Sessions</label>
                                <input type="number" class="form-control" wire:model.defer="editSessions">
                                @error('editSessions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            @if ( $editSessions  > 0)
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                <div class="alert alert-warning" role="alert">
                                    <strong>Warning!</strong> This will override the current sessions for {{ $editNetwork }}.
                                </div>
                            @else
                                <div class="alert alert-info" role="alert">
                                    <strong>Info!</strong> Please enter a valid number greater than 0.
                                </div>

                            @endif

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </div>


    <script>
        window.addEventListener('close-modal', () => {
            const modalEl = document.getElementById('channelModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    </script>

</div>
