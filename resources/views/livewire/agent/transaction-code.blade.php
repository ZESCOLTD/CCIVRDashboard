<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateTransactionCodeModal" tabindex="-1" role="dialog"
    aria-labelledby="updateTransactionCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTransactionCodeModalLabel">Update Transaction Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>
            <form wire:submit.prevent="editTCode">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="transactionCode" class="form-label">Transaction Code</label>
                        <select id="transactionCode" class="form-control" required wire:model="t_code">
                            <option value="">--Choose--</option>
                            @foreach ($transactionCodes as $transactionCode)
                                <option value="{{ $transactionCode->code }}">{{ $transactionCode->code }} :
                                    {{ $transactionCode->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">
                        <span wire:loading wire:target="editTCode" class="spinner-border spinner-border-sm"
                            role="status" aria-hidden="true"></span>
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
