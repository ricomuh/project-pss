<x-main-layout>
    @section('title', 'Orders')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders</h3>
                    </div>
                    <div class="card-body">
                        <!-- Date range input -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="date-range" class="form-control" placeholder="Select date range">
                            </div>
                        </div>
                        <!-- DataTable -->
                        <div class="table-responsive">
                            <table id="orders" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>
                                            Products
                                        </th>
                                        <th>Total Price</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($order->products as $product)
                                                        <li>{{ $product->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>Rp{{ $order->total_price }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
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
    </div>

    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    @endpush

    @push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(function () {
            // Date range picker
            $('#date-range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            // DataTable initialization
            var table = $('#orders').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Date range filter
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var date = data[4]; // Use the index of the date column
                        if (date >= startDate && date <= endDate) {
                            return true;
                        }
                        return false;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            });
        });
    </script>
    @endpush

</x-main-layout>
