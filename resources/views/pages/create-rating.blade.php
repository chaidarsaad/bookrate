@extends('layouts.app')

@section('title', 'Input Rating')

@push('addon-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="max-w-2xl mx-auto py-8 pt-28 px-4">
        <h1 class="text-2xl font-bold mb-6">➕ Input Rating</h1>

        <form action="{{ route('store.rating') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="author_id" class="block font-medium mb-1">Author</label>
                <select name="author_id" id="author_id" class="select2-author w-full" required></select>
                </select>
            </div>

            <div>
                <label for="book_id" class="block font-medium mb-1">Book</label>
                <select name="book_id" id="book_id" class="select2-book w-full" required></select>

            </div>

            <div>
                <label for="score" class="block font-medium mb-1">Rating</label>
                <select name="score" id="score" class="select2 w-full" required>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded">
                Submit
            </button>
        </form>
    </div>
@endsection

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-author').select2({
                ajax: {
                    url: '/authors.json',
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        q: params.term
                    }),
                    processResults: data => ({
                        results: data.results
                    }),
                    cache: true
                },
                placeholder: '-- Select Author --',
                minimumInputLength: 0,
            });
        });

        $('.select2-book').select2({
            ajax: {
                url: function() {
                    let authorId = $('#author_id').val();
                    return `/search-books/${authorId}`;
                },
                dataType: 'json',
                delay: 250,
                data: params => ({
                    q: params.term
                }),
                processResults: data => ({
                    results: data.map(item => ({
                        id: item.id,
                        text: item.title
                    }))
                }),
                cache: true
            },
            placeholder: 'Select a book',
            minimumInputLength: 0
        });
    </script>
@endpush
