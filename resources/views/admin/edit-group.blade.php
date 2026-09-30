<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Group</title>
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
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="mb-0">Edit Group</h3>
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

                <form action="{{ route('admin.groups.update', $group->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- GROUP INFORMATION -->

                    <h5 class="mb-3"> Group Information </h5>
                    <div class="mb-3">
                        <label class="form-label">Group Name </label>
                        <input type="text" name="group_name" class="form-control" value="{{ $group->group_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Thesis Title </label>
                        <input type="text" name="thesis_title" class="form-control" value="{{ $group->thesis_title }}" required>
                    </div>

                    <!-- SUPERVISOR -->

                    <div class="mb-4">
                        <label class="form-label"> Supervisor </label>
                        <select name="supervisor" class="form-select" required >
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $group->supervisor_id == $teacher->id ? 'selected' : '' }} >
                                    {{ $teacher->first_name }}
                                    {{ $teacher->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="mb-3">Members</h5>
                    <div id="members-container">
                        @foreach($group->members as $member)
                            <div class="card mb-4 member-box">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>Member</strong>
                                    <button type="button" class="btn btn-danger btn-sm remove-member" > Remove </button>
                                </div>

                                <div class="card-body">
                                    {{-- VERY IMPORTANT: existing member ID --}}
                                    <input type="hidden" name="members[{{ $member->id }}][id]" value="{{ $member->id }}" >
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="members[{{ $member->id }}][name]" value="{{ $member->name }}" class="form-control" required >
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Student ID</label>
                                            <input type="text" name="members[{{ $member->id }}][student_id]" value="{{ $member->student_id }}" class="form-control" required >
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Batch</label>
                                            <input type="number" name="members[{{ $member->id }}][batch]" value="{{ $member->batch }}" class="form-control" required >
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Session</label>
                                            <select name="members[{{ $member->id }}][session]" class="form-select" required >
                                                <option value="spring" {{ $member->session == 'spring' ? 'selected' : '' }}> Spring </option>
                                                <option value="summer" {{ $member->session == 'summer' ? 'selected' : '' }}> Summer </option>
                                                <option value="fall" {{ $member->session == 'fall' ? 'selected' : '' }}> Fall </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Department</label>
                                            <select name="members[{{ $member->id }}][department]" class="form-select" required >
                                                <option value="CSE" {{ $member->department == 'CSE' ? 'selected' : '' }}> CSE </option>
                                                <option value="EEE" {{ $member->department == 'EEE' ? 'selected' : '' }}> EEE </option>
                                                <option value="MATH" {{ $member->department == 'MATH' ? 'selected' : '' }}>  Mathematics </option>
                                                <option value="ECO" {{ $member->department == 'ECO' ? 'selected' : '' }}> Economics </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Role</label>
                                            <select name="members[{{ $member->id }}][role]" class="form-select" required >
                                                <option value="leader" {{ $member->role == 'leader' ? 'selected' : '' }}> Leader </option>
                                                <option value="member" {{ $member->role == 'member' ? 'selected' : '' }}> Member </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        <div class="modal fade" id="removeMemberModal" tabindex="-1" aria-labelledby="removeMemberModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="removeMemberModalLabel"> Remove Member </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                                    </div>
                                    <div class="modal-body"> Do you want to remove this member? </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
                                        <button type="button" class="btn btn-danger" id="confirmRemoveMember"> Remove </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                <!-- ADD MEMBER -->
                    <div class="mb-4">
                        <button type="button" id="add-member" class="btn btn-success" > Add Member </button>
                    </div>

                    <!-- MEMBERS TO REMOVE -->
                    <div id="removed-members"></div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" > Update Group </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" > Cancel </a>
                        </div>
                </form>
            </div>
        </div>
    </div>


<!-- Javascript for adding and removing members dynamically -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>

let memberToRemove = null;
let newMemberCounter = 0;

const membersContainer =
    document.getElementById('members-container');

const addMemberButton =
    document.getElementById('add-member');

const removedMembersContainer =
    document.getElementById('removed-members');

const removeMemberModalElement =
    document.getElementById('removeMemberModal');

const confirmRemoveMember =
    document.getElementById('confirmRemoveMember');

const removeMemberModal =
    new bootstrap.Modal(removeMemberModalElement);


// ================================
// REMOVE BUTTON
// ================================

membersContainer.addEventListener('click', function(event) {

    if (!event.target.classList.contains('remove-member')) {
        return;
    }

    memberToRemove =
        event.target.closest('.member-box');

    removeMemberModal.show();

});


// ================================
// CONFIRM REMOVE
// ================================

confirmRemoveMember.addEventListener('click', function() {

    if (!memberToRemove) {
        return;
    }


    // Check whether this is an existing database member
    const memberIdInput =
        memberToRemove.querySelector(
            'input[name$="[id]"]'
        );


    if (memberIdInput) {

        const memberId =
            memberIdInput.value;


        // Tell Laravel which existing member
        // should be deleted
        const hiddenInput =
            document.createElement('input');

        hiddenInput.type = 'hidden';

        hiddenInput.name =
            'removed_members[]';

        hiddenInput.value =
            memberId;


        removedMembersContainer.appendChild(
            hiddenInput
        );
    }


    // Remove from screen
    memberToRemove.remove();


    memberToRemove = null;

    removeMemberModal.hide();

});


// ================================
// ADD MEMBER
// ================================

addMemberButton.addEventListener('click', function() {

    const currentMembers =
        membersContainer.querySelectorAll('.member-box').length;


    if (currentMembers >= 5) {

        alert('A group can have a maximum of 5 members.');

        return;
    }


    newMemberCounter++;

    const key =
        'new_' + newMemberCounter;


    const memberBox =
        document.createElement('div');

    memberBox.className =
        'card mb-4 member-box';


    memberBox.innerHTML = `

        <div class="card-header d-flex justify-content-between align-items-center">

            <strong>New Member</strong>

            <button
                type="button"
                class="btn btn-danger btn-sm remove-member">
                Remove
            </button>

        </div>


        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="members[${key}][name]"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Student ID
                    </label>

                    <input
                        type="text"
                        name="members[${key}][student_id]"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Batch
                    </label>

                    <input
                        type="number"
                        name="members[${key}][batch]"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Session
                    </label>

                    <select
                        name="members[${key}][session]"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select session
                        </option>

                        <option value="spring">
                            Spring
                        </option>

                        <option value="summer">
                            Summer
                        </option>

                        <option value="fall">
                            Fall
                        </option>

                    </select>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Department
                    </label>

                    <select
                        name="members[${key}][department]"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select department
                        </option>

                        <option value="CSE">CSE</option>
                        <option value="EEE">EEE</option>
                        <option value="MATH">Mathematics</option>
                        <option value="ECO">Economics</option>

                    </select>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Role
                    </label>

                    <select
                        name="members[${key}][role]"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select role
                        </option>

                        <option value="leader">
                            Leader
                        </option>

                        <option value="member">
                            Member
                        </option>

                    </select>

                </div>

            </div>

        </div>
    `;


    membersContainer.appendChild(memberBox);

});

</script>
</body>
</html>