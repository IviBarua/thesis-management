<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<style>
body {
  margin: 0;
  min-height: 100vh;

  /* your gradient */
  background-image: linear-gradient(to top, #fbc2eb 0%, #a6c1ee 100%);
  background-size: 200% 200%;

  /* smooth movement */
  animation: gradientMove 10s ease infinite;
}

@keyframes gradientMove {
  0% {
    background-position: 50% 0%;
  }
  50% {
    background-position: 50% 100%;
  }
  100% {
    background-position: 50% 0%;
  }
}
</style>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand fw-bold text-center" href="#">Thesis Group Management</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-success" type="submit">Logout</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-left align-items-center" style="min-height: 20vh;">
            <a class="btn btn-primary" href="{{ url('/groups/create') }}" role="button">Create Group</a>
        </div>
        <div class="card mb-4">

        <div class="card-header">
            <h4 class="mb-0"> Groups Information </h4>
        </div>

        <div class="card-body">
            @forelse($groups as $group)
                <div class="accordion mb-3" id="groupAccordion{{ $group->id }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $group->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $group->id }}" aria-expanded="false" aria-controls="collapse{{ $group->id }}" >
                                <div>
                                    <strong> {{ $group->group_name }} </strong>
                                    <span class="ms-3 text-muted">
                                        {{ $group->members_count }}
                                        {{ $group->members_count == 1 ? 'Member' : 'Members' }}
                                    </span>
                                </div>
                            </button>
                        </h2>

                        <div id="collapse{{ $group->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $group->id }}" data-bs-parent="#groupAccordion{{ $group->id }}" >
                            <div class="accordion-body">
                                <h5 class="mb-3"> Group Information </h5>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-2">
                                        <strong> Group Name: </strong>
                                        {{ $group->group_name }}
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <strong>  Thesis Title: </strong>
                                        {{ $group->thesis_title }}
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <strong> Number of Members: </strong>
                                        {{ $group->members_count }}
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <strong> Supervisor: </strong>
                                        @if($group->supervisor)
                                            {{ $group->supervisor->first_name }}
                                            {{ $group->supervisor->last_name }}
                                        @else
                                            Not Assigned
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-3"> Members </h5>
                                @foreach($group->members as $member)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <strong> Member {{ $loop->iteration }} </strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <strong> Name: </strong> {{ $member->name }} 
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <strong> Student ID: </strong> {{ $member->student_id }} 
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <strong>Batch:</strong>{{ $member->batch }}
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <strong>Session:</strong>{{ ucfirst($member->session) }}
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <strong>Department:</strong>{{ $member->department }}
                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Role:</strong>{{ ucfirst($member->role) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="border-top pt-3 mt-3">
                                    <a href="{{ route('teacher.groups.edit', $group->id) }}" class="btn btn-warning">Edit Group</a>
                                    <form action="{{ route('teacher.groups.delete', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group and all its members?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> Delete Group </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="alert alert-info"> You don't have any groups yet. </div>
            @endforelse

            </div>
        </div>
</div>
    


</body>
</html>