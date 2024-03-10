@extends('layouts.admin.main')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card mb-4" style="display:flex; align-items:center;">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                  Applicants
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        All listings
                        @if (Session::has('error'))
                            <div class=" alert alert-success">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                    <div class="card-body" style="width: 100%;">
                        <table id="datatablesSimple" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created on</th>
                                    <th>Total Applicants</th>
                                    <th>View listing</th>
                                    <th>View Applilcant</th>
                                 

                                </tr>
                            </thead>
                          
                            <tbody>
                                {{-- {{$listings}} --}}
                                @foreach ($listings as $listing)
                                    <tr>
                                        <td>{{ $listing->title }} </td>
                                        <td>{{ $listing->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $listing->userCount }} </td>
                                        <td><a href="{{ route('listing.edit', [$listing->id]) }}">view</a></td>
                                        <td><a href="#" type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $listing->id }}">view</a></td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $listing->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form action="{{ route('listing.delete', [$listing->id]) }}" method="POST"> @csrf
                                            @method('DELETE')
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                            Confirmation</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this listing ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
