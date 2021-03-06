@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('competition_deleted'))
        <div class="alert alert-warning alert-block">
            <strong>{{ session('competition_deleted') }}</strong>
        </div>
        @endif
        @if (session('competition_created'))
        <div class="alert alert-success alert-block">
            <strong>{{ session('competition_created') }}</strong>
        </div>
        @endif
        @if (session('saved'))
            <div class="alert alert-success alert-block">
                <strong>{{ session('saved') }}</strong>
            </div>
        @endif
        @if (session('updated'))
        <div class="alert alert-success alert-block">
            <strong>{{ session('updated') }}</strong>
        </div>
        @endif
        @if (session('deleted'))
        <div class="alert alert-warning alert-block">
            <strong>{{ session('deleted') }}</strong>
        </div>
        @endif
        
        <div class="row my-4 justify-content-center text-center">
            <div class="col-md-10" style="color:#0c3f6b">
                <h3><strong>Experiences Record</strong></h3>
            </div>
            <div class="divider"></div>
        </div> 

        <!-- RANK STATUS -->
        <div class="row my-3 justify-content-center">
            <div class="col-md-2 my-2">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <small>RANK</small>
                    </div>
                    <div class="card-body text-center">
                        <h4><strong>Unknown</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <small>POINTS</small>
                    </div>
                    <div class="card-body text-center">
                        <h1><strong>{{ Auth::user()->point }}</strong></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <small>EVENTS</small>
                    </div>
                    <div class="card-body text-center">
                        <h1><strong>{{ $events->count() }}</strong></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm my-2">
                    <div class="card-header text-center">
                        <small>ACHIEVEMENTS</small>
                    </div>
                    <div class="card-body text-center">
                        <h1><strong>{{ $competitions->count() }}</strong></h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- EVENT PARTICIPATION -->
        <div class="row mt-5 mb-3 justify-content-center">
            <div class="col-md-8">
                <h4>Event Participation</h4>
            </div>
            <div class="col-md-2">
                <a href="/events/create" class="btn float-right btn-success">Add New</a>
            </div>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ( $events->count() < 1)
                            <h4 class="my-4 text-center"> Woops! It seems that you haven't participated in any! </h4>
                        @else
                            <table class="table">
                                    <thead class="table-header">
                                        <th>Event</th>
                                        <th>Scope</th>
                                        <th>City</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($events as $event)
                                            <tr>
                                                <td>{{ $event->event_name }}</td>
                                                <td>{{ $event->event_scope->event_scope_name }}</td>
                                                <td>{{ $event->event_city }}</td>
                                                <td>{{ $event->start_date }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#edit-modal">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete({{ $event->event_id }})" >Delete</button>
                                                </td>
                                            </tr>   

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="edit-modalLabel">Edit Event</h5>
                                                            <button type="modal" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                            <form action="/events/{{ $event->event_id }}/modal/update" method="post">
                                                                @csrf
                                                                <input type="hidden" name="event_city" value="{{ $event->event_city }}">
                                                                <input type="hidden" name="event_country" value="{{ $event->event_country }}">
                                                                <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                                                                <input type="hidden" name="finish_date" value="{{ $event->finish_date }}">
                                                                <input type="hidden" name="event_desc" value="{{ $event->event_desc }}">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="event_name">Event Name</label>
                                                                                <input type="text" name="event_name" id="event_name" value="{{ $event->event_name }}" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="event_scope">Scope</label>
                                                                                <select name="event_scope" id="event_scope" class="form-control">
                                                                                    <option value="{{ $event->event_scope_id }}">{{ $event->event_scope->event_scope_name }}</option>
                                                                                    @foreach ($scopes as $scope)
                                                                                        <option value="{{ $scope->event_scope_id }}">{{ $scope->event_scope_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="event_type">Type</label>
                                                                                <select name="event_type" id="event_type" class="form-control">
                                                                                    <option value="{{ $event->event_type_id }}">{{ $event->event_type->event_type_name }}</option>
                                                                                    @foreach ($types as $type)
                                                                                        <option value="{{ $type->event_type_id }}">{{ $type->event_type_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>   
                                                                    <div class="row">
                                                                        <div class="col-md-12 float-right">
                                                                            <small><a href="/events/{{ $event->event_id }}/edit">Edit Entire Data..</a></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-success">Yes, Update!</button>
                                                                </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- COMPETITION ACHIEVEMENT -->
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8">
                <h4>Competition Achievement</h4>
            </div>
            <div class="col-md-2">
                <a href="/competition/create" class="btn float-right btn-success">Add New</a>
            </div>
        </div>
        <div class="row my-3 justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ( $competitions->count() < 1)
                            <h4 class="text-center my-4">Whoops! It seems that you haven't made any prizes.. Keep Moving Forward!</h4>
                        @else
                            <table class="table">
                                <thead class="table-head">
                                    <th>No</th>
                                    <th>Competition</th>
                                    <th>Scope</th>
                                    <th>Prize</th>
                                    <th>Action</th>
                                </thead>
                        @endif
                            @foreach ($competitions as $competition)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $competition->competition_name }}</td>
                                    <td>{{ $competition->scope->event_scope_name }}</td>
                                    <td>{{ $competition->prize->prize_name }}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="handleCompetitionDelete({{ $competition->competition_id }})" >Delete</button></td>
                                </tr>
                            @endforeach
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- DELETE EVENT MODAL -->
    <form action="" method="post" id="deleteForm">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="handleDelete" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="handleDelete"><strong>Delete Confirmation</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Are you really mean to delete this experience?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, cancel</button>
                <button type="submits" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <!-- DELETE COMPETITION PRIZE MODAL -->
    <form action="" method="post" id="deleteCompetitionForm">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="deleteCompetitionModal" tabindex="-1" role="dialog" aria-labelledby="handleCompetitionDelete" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="handleCompetitionDelete"><strong>Delete Confirmation</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Are you really mean to delete this Competition Prize?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, cancel</button>
                <button type="submits" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection

@section('scripts')

    <script>
        function handleDelete(id){
            var form = document.getElementById('deleteForm')
            form.action = '/events/' + id
            console.log('deleting',form)
            $('#deleteModal').modal('show')
        }

        function handleCompetitionDelete(id){
            var form = document.getElementById('deleteCompetitionForm')
            form.action = '/competition/' + id
            console.log('deleting',form)
            $('#deleteCompetitionModal').modal('show')
        }
    </script>
    
@endsection