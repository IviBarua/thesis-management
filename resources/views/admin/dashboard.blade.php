<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #d1e3f0;">
        <div class="container">
            <a class="navbar-brand fw-bold text-center" href="#">Thesis Group Management</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-success" type="submit">Logout</button>
            </form>
        </div>
    </nav>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif
    
    <div class="container">
        <div class="d-flex justify-content-left align-items-center" style="min-height: 20vh;">
            <a class="btn btn-primary" href="{{ route('groups.create') }}" role="button">Create Group</a>
        </div>
        <div class="row g-4 mb-4">
            <!-- Total Members -->
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        <h5 class="card-title">
                            Total Members
                        </h5>

                        <h2 class="display-5 fw-bold">
                            {{ $totalMembers }}
                        </h2>

                        <p class="card-text text-muted">
                            Registered group members
                        </p>

                    </div>
                </div>
            </div>
            <!-- Total Teachers -->
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        <h5 class="card-title">
                            Total Teachers
                        </h5>

                        <h2 class="display-5 fw-bold">
                            {{ $totalTeachers }}
                        </h2>

                        <p class="card-text text-muted">
                            Registered teachers
                        </p>

                    </div>
                </div>
            </div>
            <!-- Total Groups -->
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        <h5 class="card-title">
                            Total Groups
                        </h5>

                        <h2 class="display-5 fw-bold">
                            {{ $totalGroups }}
                        </h2>

                        <p class="card-text text-muted">
                            Created thesis groups
                        </p>

                    </div>
                </div>
            </div>
            <!-- Total Admins -->
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        <h5 class="card-title">
                            Total Admins
                        </h5>

                        <h2 class="display-5 fw-bold">
                            {{ $totalAdmins }}
                        </h2>

                        <p class="card-text text-muted">
                            System administrators
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Groups Information</h4>
            </div>
            <div class="card-body">
                @foreach($groups as $group)
                    <div class="accordion mb-3"
                        id="groupAccordion{{ $group->id }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $group->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $group->id }}" aria-expanded="false" aria-controls="collapse{{ $group->id }}" >
                                    <div>
                                        <strong>{{ $group->group_name }} </strong>
                                        <span class="ms-3 text-muted">{{ $group->members_count }} Members</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $group->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $group->id }}" data-bs-parent="#groupAccordion{{ $group->id }}" >
                                <div class="accordion-body">
                                    <!-- GROUP INFORMATION -->
                                    <h5 class="mb-3"> Group Information </h5>
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-2">
                                            <strong> Group Name: </strong>
                                            {{ $group->group_name }}
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Thesis Title:</strong>
                                            {{ $group->thesis_title }}
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Number of Members:</strong>
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
                                    <!-- MEMBERS -->

                                <h5 class="mb-3"> Members </h5>
                                    @foreach($group->members as $member)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title"> Member {{ $loop->iteration }}</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Name:</strong>
                                                        {{ $member->name }}
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Student ID:</strong>
                                                        {{ $member->student_id }}
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Batch: </strong>
                                                        {{ $member->batch }}
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Session: </strong>
                                                        {{ ucfirst($member->session) }}
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Department: </strong>
                                                        {{ $member->department }}
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong> Role:</strong>
                                                        {{ ucfirst($member->role) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- GROUP ACTION BUTTONS -->
                                    <div class="border-top pt-3 mt-3">
                                        <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-warning"> Edit Group </a>
                                        <form action="{{ route('admin.groups.delete', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group and all its members?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" > Delete Group </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Teachers Information</h4>
            </div>
            <div class="card-body">
                <div class="accordion" id="teacherAccordion">
                    @foreach($teachers as $teacher)
                        <div class="accordion-item mb-3">
                            <!-- Teacher Header -->
                            <h2 class="accordion-header" id="headingTeacher{{ $teacher->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTeacher{{ $teacher->id }}" aria-expanded="false" aria-controls="collapseTeacher{{ $teacher->id }}" >
                                    <div>
                                        <strong>
                                            {{ $teacher->first_name }}
                                            {{ $teacher->last_name }}
                                        </strong>
                                        <span class="ms-3 text-muted"> {{ $teacher->department }} </span>
                                    </div>
                                </button>
                            </h2>

                            <!-- Teacher Details -->
                            <div id="collapseTeacher{{ $teacher->id }}"  class="accordion-collapse collapse" aria-labelledby="headingTeacher{{ $teacher->id }}" data-bs-parent="#teacherAccordion" >
                                <div class="accordion-body">
                                    <h5 class="mb-3"> Teacher Information </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <strong>First Name:</strong>
                                            {{ $teacher->first_name }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Last Name:</strong>
                                            {{ $teacher->last_name }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Email:</strong>
                                            {{ $teacher->email }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Phone:</strong>
                                            {{ $teacher->phone }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Teacher ID:</strong>
                                            {{ $teacher->teacher_id }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Department:</strong>
                                            {{ $teacher->department }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Degree:</strong>
                                            {{ $teacher->degree }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Designation:</strong>
                                            {{ $teacher->designation }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Batch:</strong>
                                            {{ $teacher->batch }}
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <strong>Session:</strong>
                                            {{ $teacher->session }}
                                        </div>

                                    </div>
                                <!-- Edit / Delete Buttons -->
                                    <div class="border-top pt-3 mt-3">
                                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-warning" > Edit </a>
                                        <form action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this teacher?');" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" > Delete </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>       
    </div>
</body>
</html>