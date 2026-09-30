<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
                <h3 class="card-title text-center py-3">Registration</h3>
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf                   
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="mb-0 me-3">Personal Information</h5>
                        <div class="flex-grow-1 border-bottom"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" required>
                                            <label for="first_name" class="form-label">First Name</label>    
                                        </div>                                       
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required>
                                            <label for="last_name" class="form-label">Last Name</label>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="date" name="birth" class="form-control" id="birth" required>
                                            <label for="birth" class="form-label">Date of Birth</label>
                                        </div>                                       
                                    </div>
                                    <div class="col">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="p-t-10">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="gender" type="radio" value="male" id="male">
                                                <label class="form-check-label" for="gender">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="female" id="female">
                                                <label class="form-check-label" for="gender">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="other" id="other">
                                                <label class="form-check-label" for="gender">Other</label>
                                            </div>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Email" required>
                                            <label for="email" class="form-label">Email</label>
                                            @error('email')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>                                       
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Mobile" required>
                                            <label for="phone" class="form-label">Mobile No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="mb-0 me-3">Program Information</h5>
                                <div class="flex-grow-1 border-bottom"></div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <label class="form-label" for="department">Department</label>
                                            <select class="form-select" id="department" name="department" required>
                                                <option selected disabled value=""></option>
                                                <option value="CSE">Department of Computer Science and Engineering</option>
                                                <option value="EEE">Department of Electrical and Electronic Engineering</option>
                                                <option value="Math">Department of Mathematics</option>
                                                <option value="ECO">Department of Economics</option>
                                            </select>
                                        </div>                          
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <label class="form-label" for="degree">Degree</label>
                                            <select class="form-select" id="degree" name="degree" required>
                                                <option selected disabled value=""></option>
                                                <option value="bsc">B.Sc</option>
                                                <option value="msc">M.Sc.</option>
                                                <option value="phd">PhD</option>
                                            </select>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                                <input type="number" name="batch" class="form-control" id="batch" placeholder="Batch" required>
                                                <label for="batch" class="form-label">Batch</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <label class="form-label" for="session">Session</label>
                                            <select class="form-select" id="session" name="session" required>
                                                <option selected disabled value=""></option>
                                                <option value="spring">Spring</option>
                                                <option value="summer">Summer</option>
                                                <option value="fall">Fall</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                               
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="mb-0 me-3">Professional Information</h5>
                                <div class="flex-grow-1 border-bottom"></div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                                <input type="text" name="designation" class="form-control" id="designation" placeholder="designation" required>
                                                <label for="designation" class="form-label">Designation</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror" value="{{ old('teacher_id') }}" id="teacher_id" placeholder="Teacher ID" required>
                                            <label for="teacher_id" class="form-label">Teacher ID</label>
                                            @error('teacher_id')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="mb-0 me-3">Portal Access</h5>
                                <div class="flex-grow-1 border-bottom"></div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">    
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Create Password" required>
                                            <label for="password" class="form-label">Create Password</label>
                                            @error('password')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            @error('password_confirmation')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary" value="Submit">Create Account</button>
                            </div>
                            <div class="d-grid text-center">
                                <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="{{ route('login') }}" class="link-success" style="text-decoration: none;">Log In Here </a></p>
                            </div>                                           
                        </div>
                    </div>
                </form>
        </div>

    </div>

</div>
    
</body>
</html>

