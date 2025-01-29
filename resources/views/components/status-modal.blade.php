
@props(['equipo', 'statuses'])
<div wire:ignore.self class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Estatus de OS {{ $equipo->fullOs }}</h4>
                </div>
                <div class="p-4 pb-0">
                    <div class="">
                        <div class="row">
                            <h5 class="mb-0">Estatus Actual</h5>
                            <p class="mb-0">El estatus actual de la OS es: <x-status-badge
                                    status_id="{{ $equipo->status_id }}" /></p>
                        </div>
                        <div class="row">
                            <select class="form-select my-3" aria-label="Default select example" wire:model="newStatus" wire:change="updateStatus">
                                @foreach ($statuses as $item)
                                    <option value="{{$item->id}}">{{$item->status}} </option>
                                @endforeach
                            </select>
                                
                                
                            
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>