<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">Edit Teacher</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ $teacher->first_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ $teacher->last_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth" class="form-control" value="{{ $teacher->birth }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}> Male </option>
                            <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}> Female </option>
                            <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}> Other </option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ $teacher->department }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Degree</label>
                        <input type="text" name="degree" class="form-control" value="{{ $teacher->degree }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batch</label>
                        <input type="number" name="batch" class="form-control" value="{{ $teacher->batch }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Session</label>
                        <input type="text" name="session" class="form-control" value="{{ $teacher->session }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control" value="{{ $teacher->designation }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teacher ID</label>
                        <input type="text" name="teacher_id" class="form-control" value="{{ $teacher->teacher_id }}" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary"> Update Teacher </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"> Cancel </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>