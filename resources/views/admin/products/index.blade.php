<x-main-layout>
    @section('title', 'Products')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-widget widget-user-2">
                    <div class="card-header">
                        <h3 class="card-title">
                            Products</h3>

                            {{-- create button --}}
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Create</a>
                    </div>
                    {{-- datatable --}}
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered" id="products">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stocks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                class="img-thumbnail" style="width: 100px">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            {{-- <a href="{{ route('admin.products.show', $product->id) }}" --}}

                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- end datatable --}}
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script>
        $(function () {
            $('#products').DataTable();
        });
    </script>
    @endpush

</x-main-layout>
