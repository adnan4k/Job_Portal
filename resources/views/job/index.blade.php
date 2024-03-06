@extends('layouts.admin.main')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card mb-4" style="display:flex; align-items:center;">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Your Jobs
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        All Jobs
                    </div>
                    <div class="card-body" style="width: 100%;">
                        <table id="datatablesSimple" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created on</th>
                                    <th>Delete</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Created on</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                {{-- {{$jobs}} --}}
                                @foreach ($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }} </td>
                                        <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                        <td><a href="{{ route('job.edit', [$job->id]) }}">Edit</a></td>
                                        <td><a href="#" type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $job->id }}">Delete</a></td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $job->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form action="{{ route('job.delete', [$job->id]) }}" method="POST"> @csrf
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
                                                        Are you sure you want to delete this job ?
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

                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
