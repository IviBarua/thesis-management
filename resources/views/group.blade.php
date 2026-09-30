<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<style>
body {
  margin: 0;
  min-height: 100vh;

  display: flex;
  justify-content: center;
  align-items: center;

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
  <div class="d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow p-4" style="width: 45rem;">
      <div class="card-body">
        <h3 class="card-title text-center py-3">Create Group</h3>
        <form action="{{ route('groups.store') }}" method="POST">
        @csrf
          <div class="mb-3">           
              <label class="form-label" for="member">Number of Members</label>
                <select class="form-select" id="member" name="member" required>
                  <option selected disabled value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>              
          </div>         
          <div id="member_fields"></div>

<script>
    const memberCount = document.getElementById('member');
    const memberFields = document.getElementById('member_fields');

    memberCount.addEventListener('change', function () {

        const count = parseInt(this.value);

        // Remove previous member fields
        memberFields.innerHTML = '';

        for (let i = 1; i <= count; i++) {

            const member = document.createElement('div');

            member.classList.add('member-card');

            member.innerHTML = `
             <div class="border rounded p-3 mb-3">
              <div class="form-group">
                <h4>Member ${i}</h4>
                <div class="mb-3">                  
                  <div class="row">
                    <div class="col">
                        <label for="name_${i}">Full Name</label>
                        <input
                            type="text"
                            id="name_${i}"
                            name="members[${i}][name]"
                            required
                        >
                    </div>
                    <div class="col">
                        <label for="student_id_${i}">Student ID</label>
                        <input
                            type="text"
                            id="student_id_${i}"
                            name="members[${i}][student_id]"
                            required
                        >
                    </div>
                  </div>
                </div>
                <div class="mb-3">                  
                  <div class="row">
                    <div class="col">
                        <label for="batch_${i}">Batch</label>
                        <input
                            type="number"
                            id="batch_${i}"
                            name="members[${i}][batch]"
                            required
                        >
                    </div>
                    <div class="col">
                        <label for="session_${i}">Session</label>
                        <select
                            id="session_${i}"
                            name="members[${i}][session]"
                            required
                        >
                            <option value="">Select session</option>
                            <option value="spring">Spring</option>
                            <option value="summer">Summer</option>
                            <option value="fall">Fall</option>
                        </select>
                    </div>
                  </div>
                </div>
                  <div class="mb-3">
                    <div class="row">
                      <div class="col">
                        <label for="department_${i}">Department</label>
                        <select
                            id="department_${i}"
                            name="members[${i}][department]"
                            required
                        >
                            <option value="">Select department</option>
                            <option value="CSE">Department of Computer Science and Engineering</option>
                            <option value="EEE">Department of Electrical and Electronic Engineering</option>
                            <option value="MATH">Department of Mathematics</option>
                            <option value="ECO">Department of Economics</option>
                        </select>
                      </div>
                      <div class="col">
                          <label for="role_${i}">Role</label>
                          <select
                              id="role_${i}"
                              name="members[${i}][role]"
                              required
                          >
                              <option value="">Select role</option>
                              <option value="leader">Leader</option>
                              <option value="member">Member</option>
                          </select>
                      </div>
                    </div>
                  </div>
              </div>                   
            </div>
            `;

            memberFields.appendChild(member);
        }
    });
</script>
          <div class="mb-3">
            <label class="form-label" for="group_name">Group Name</label>
            <input type="text" class="form-control" id="group_name" name="group_name" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="thesis_title">Thesis Title</label>
            <input type="text" class="form-control" id="thesis_title" name="thesis_title" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="supervisor">Supervisor</label>
                <select class="form-select" id="supervisor" name="supervisor" required>
                  <option selected disabled value="">Select Supervisor</option>
                  @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                @endforeach
                </select>
          </div>

          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary" value="Submit">Create Group</button>
          </div>
        </form>
      </div>
    </div>

  </div>
  
</body>
</html>