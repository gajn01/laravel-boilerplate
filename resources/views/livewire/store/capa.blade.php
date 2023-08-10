    <div>
        <nav aria-label="breadcrumb" class="">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">CAPA</li>
            </ol>
        </nav>
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Corrective and Preventive Actions</h1>
            </div>
        </div>
        <div class="page-utilities mb-3">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                    <a class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">Import csv</a>
                </div>
            </div>
        </div>

        <!-- livewire/store/capa.blade.php -->

        <div class="mb-3">
            <label for="file" class="form-label">File <span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="file" id="file" wire:model="file">
            @error('file')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <button type="button" class="btn app-btn-primary" wire:click="onImportFile">Save</button>


        {{-- 
    <div wire:ignore class="modal fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Import File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="reset"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" id="file" wire:model="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary" wire:click="onImportFile">Save</button>
                </div>
            </div>
        </div>
    </div>
 --}}

    </div>
