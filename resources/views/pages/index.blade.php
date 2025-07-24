@extends('layouts.app')

@section('title')
    Book List
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
@endpush

@section('content')
  @if (session('success'))
        <div id="toast-success"
            class="fixed top-14 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transition-opacity duration-300"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto py-8 px-4 pt-28">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">📚 Book List</h1>
            <a href="{{ route('create.rating') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded shadow">
                ➕ Insert Rating
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto p-4">
            <table id="booklists" class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No.</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Book Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Category Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Author Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Avg Rating</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Voter</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <!-- Rows populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toast-success');
            if (toast) {
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 300); 
                }, 3000);
            }
        });
    </script>

    <!-- jQuery + DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#booklists').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                    [10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
                ],
                pageLength: 10,
                order: [
                    [4, 'desc']
                ],
                ajax: "/book-list",
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category.name',
                        name: 'category.name'
                    },
                    {
                        data: 'author.name',
                        name: 'author.name'
                    },
                    {
                        data: 'avg_rating',
                        name: 'avg_rating'
                    },
                    {
                        data: 'voter_count',
                        name: 'voter_count'
                    }
                ],
                dom: '<"flex justify-between items-center mb-4"l f>t' +
                    '<"mt-4 flex justify-between items-center"' +
                    'i p>',

                language: {
                    paginate: {
                        previous: "←",
                        next: "→"
                    },
                    lengthMenu: "per halaman _MENU_",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ hasil"
                },
                pageLength: 10,
                lengthChange: true
            });
        });
    </script>
@endpush
