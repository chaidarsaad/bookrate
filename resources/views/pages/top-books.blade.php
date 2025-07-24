@extends('layouts.app')

@section('title')
    Top Books
@endsection

@push('addon-style')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
@endpush

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 pt-28">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Top 10 Most Famous Author</h1>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto p-4">
            <table id="topAuthor" class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No.</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Author Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Voter</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('addon-script')
    <!-- jQuery + DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#topAuthor').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                lengthChange: false,
                language: {
                    info: "",
                    infoEmpty: "",
                    infoFiltered: "",
                },
                ajax: "/top",
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'voter_count',
                        name: 'voter_count',
                        orderable: false,
                    }
                ],
                order: [
                    [2, 'desc']
                ]
            });
        });
    </script>
@endpush
