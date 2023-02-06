@extends('layouts.app')
@section('content')
    <div class="col">

        <h1>Apartments</h1>
        <a name="" id="" class="btn btn-primary position-fixed bottom-0 end-0 " href="" role="button">New
            Apartments
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
        </a>


        <div class="table-responsive">
            <table class="table table-striped table-hover table-borderless table-primary align-middle">
                <thead class="table-light">

                    <tr>
                        <th>ID</th>
                        <th>title</th>
                        <th>price </th>
                        <th>mq</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($apartments as $apartment)
                        <tr class="table-primary">

                            <td scope="row">
                                {{ $apartment->id }}
                            </td>
                            <td scope="row">
                                {{ $apartment->title }}
                            </td>

                            <td>{{ $apartment->price }}</td>
                            <td>{{ $apartment->mq }}</td>
                            <td>
                                <!-- show -->
                                <a href="">
                                    <i class="fas fa-eye fa-sm fa-fw"></i>
                                </a>
                                <!-- edit -->
                                <a href="">
                                    <i class="fas fa-pencil fa-sm fa-fw"></i>
                                </a>
                                <a href="">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>



        </div>
    </div>
@endsection
