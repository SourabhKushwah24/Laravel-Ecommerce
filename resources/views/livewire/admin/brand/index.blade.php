<div>
    @include('livewire.admin.brand.modal-form')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Brand List <a href="#" data-bs-toggle="modal" data-bs-target="#addBrandModal"
                                class="btn btn-primary btn-sm float-end">Add Brand</a></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            @if ($brand->category)
                                                {{ $brand->category->name }}
                                            @else
                                                <h4>No Category</h4>
                                            @endif
                                        </td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>{{ $brand->status == '1' ? 'hidden' : 'visible' }}</td>
                                        <td><a href="#" wire:click="editBrand({{ $brand->id }})"
                                                data-bs-toggle="modal" data-bs-target="#updateBrandModal"
                                                class="btn btn-primary ">Edit</a>
                                            <a href="#" wire:click="deletebrand({{ $brand->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                class="btn btn-danger ">Delete</a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5">No Brands Find</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                        {{-- pagination  --}}
                        <div class="mt-2 float-end">
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addBrandModal').modal('hide');
            $('#updateBrandModal').modal('hide');
            $('#deleteModal').modal('hide')
        })
    </script>
@endpush
