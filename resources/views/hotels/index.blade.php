<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hotels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between mb-4">
                        <h3>Hotel List</h3>
                        <a href="{{ route('hotels.create') }}" class="btn btn-primary">Add New Hotel</a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Price</th>
                                <th>Rating</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->id }}</td>
                                <td>{{ $hotel->name }}</td>
                                <td>{{ $hotel->city }}</td>
                                <td>{{ $hotel->price }}</td>
                                <td>{{ $hotel->rating }}</td>
                                <td>
                                    <form action="{{ route('hotels.destroy',$hotel->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('hotels.show',$hotel->id) }}">Show</a>
                                        <a class="btn btn-primary" href="{{ route('hotels.edit',$hotel->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
