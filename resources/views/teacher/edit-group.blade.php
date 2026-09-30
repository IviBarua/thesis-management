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

    <div class="card shadow p-4" style="width: 55rem;">

        <div class="card-body">

            <h3 class="card-title text-center py-3">
                Edit Group
            </h3>


            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            {{-- VALIDATION ERRORS --}}
            @if($errors->any())
                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>
            @endif


            <form
                action="{{ route('groups.update', $group->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                {{-- ========================= --}}
                {{-- GROUP NAME --}}
                {{-- ========================= --}}

                <div class="mb-3">

                    <label
                        class="form-label"
                        for="group_name"
                    >
                        Group Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="group_name"
                        name="group_name"
                        value="{{ old('group_name', $group->group_name) }}"
                        required
                    >

                </div>


                {{-- ========================= --}}
                {{-- THESIS TITLE --}}
                {{-- ========================= --}}

                <div class="mb-3">

                    <label
                        class="form-label"
                        for="thesis_title"
                    >
                        Thesis Title
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="thesis_title"
                        name="thesis_title"
                        value="{{ old('thesis_title', $group->thesis_title) }}"
                        required
                    >

                </div>


                {{-- ========================= --}}
                {{-- SUPERVISOR --}}
                {{-- ========================= --}}

                <div class="mb-4">

                    <label
                        class="form-label"
                        for="supervisor"
                    >
                        Supervisor
                    </label>

                    <select
                        class="form-select"
                        id="supervisor"
                        name="supervisor"
                        required
                    >

                        <option value="" disabled>
                            Select Supervisor
                        </option>

                        @foreach($teachers as $teacher)

                            <option
                                value="{{ $teacher->id }}"
                                {{ $group->supervisor_id == $teacher->id ? 'selected' : '' }}
                            >
                                {{ $teacher->first_name }}
                                {{ $teacher->last_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- ========================= --}}
                {{-- MEMBERS --}}
                {{-- ========================= --}}

                <h4 class="mb-3">
                    Members
                </h4>


                <div id="members-container">


                    {{-- EXISTING MEMBERS --}}

                    @foreach($group->members as $member)

                        <div class="card mb-4 member-box">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <strong>
                                    Member
                                </strong>


                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm remove-member"
                                >
                                    Remove
                                </button>

                            </div>


                            <div class="card-body">

                                {{-- EXISTING MEMBER ID --}}
                                <input
                                    type="hidden"
                                    name="members[{{ $member->id }}][id]"
                                    value="{{ $member->id }}"
                                >


                                <div class="row">


                                    {{-- NAME --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Full Name
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="members[{{ $member->id }}][name]"
                                            value="{{ $member->name }}"
                                            required
                                        >

                                    </div>


                                    {{-- STUDENT ID --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Student ID
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="members[{{ $member->id }}][student_id]"
                                            value="{{ $member->student_id }}"
                                            required
                                        >

                                    </div>


                                    {{-- BATCH --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Batch
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            name="members[{{ $member->id }}][batch]"
                                            value="{{ $member->batch }}"
                                            required
                                        >

                                    </div>


                                    {{-- SESSION --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Session
                                        </label>

                                        <select
                                            class="form-select"
                                            name="members[{{ $member->id }}][session]"
                                            required
                                        >

                                            <option value="">
                                                Select session
                                            </option>

                                            <option
                                                value="spring"
                                                {{ $member->session == 'spring' ? 'selected' : '' }}
                                            >
                                                Spring
                                            </option>

                                            <option
                                                value="summer"
                                                {{ $member->session == 'summer' ? 'selected' : '' }}
                                            >
                                                Summer
                                            </option>

                                            <option
                                                value="fall"
                                                {{ $member->session == 'fall' ? 'selected' : '' }}
                                            >
                                                Fall
                                            </option>

                                        </select>

                                    </div>


                                    {{-- DEPARTMENT --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Department
                                        </label>

                                        <select
                                            class="form-select"
                                            name="members[{{ $member->id }}][department]"
                                            required
                                        >

                                            <option value="">
                                                Select department
                                            </option>

                                            <option
                                                value="CSE"
                                                {{ $member->department == 'CSE' ? 'selected' : '' }}
                                            >
                                                Department of Computer Science and Engineering
                                            </option>

                                            <option
                                                value="EEE"
                                                {{ $member->department == 'EEE' ? 'selected' : '' }}
                                            >
                                                Department of Electrical and Electronic Engineering
                                            </option>

                                            <option
                                                value="MATH"
                                                {{ $member->department == 'MATH' ? 'selected' : '' }}
                                            >
                                                Department of Mathematics
                                            </option>

                                            <option
                                                value="ECO"
                                                {{ $member->department == 'ECO' ? 'selected' : '' }}
                                            >
                                                Department of Economics
                                            </option>

                                        </select>

                                    </div>


                                    {{-- ROLE --}}

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Role
                                        </label>

                                        <select
                                            class="form-select"
                                            name="members[{{ $member->id }}][role]"
                                            required
                                        >

                                            <option value="">
                                                Select role
                                            </option>

                                            <option
                                                value="leader"
                                                {{ $member->role == 'leader' ? 'selected' : '' }}
                                            >
                                                Leader
                                            </option>

                                            <option
                                                value="member"
                                                {{ $member->role == 'member' ? 'selected' : '' }}
                                            >
                                                Member
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- ========================= --}}
                {{-- ADD MEMBER --}}
                {{-- ========================= --}}

                <div class="mb-4">

                    <button
                        type="button"
                        id="add-member"
                        class="btn btn-success"
                    >
                        + Add Member
                    </button>

                </div>


                {{-- ========================= --}}
                {{-- REMOVED MEMBERS --}}
                {{-- ========================= --}}

                <div id="removed-members"></div>


                {{-- ========================= --}}
                {{-- UPDATE BUTTON --}}
                {{-- ========================= --}}

                <div class="d-grid gap-2 col-6 mx-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Group
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ======================================== --}}
{{-- REMOVE MEMBER CONFIRMATION MODAL --}}
{{-- ======================================== --}}

<div
    class="modal fade"
    id="removeMemberModal"
    tabindex="-1"
    aria-labelledby="removeMemberModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="removeMemberModalLabel"
                >
                    Remove Member
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                Do you want to remove this member?

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmRemoveMember"
                >
                    Remove
                </button>

            </div>

        </div>

    </div>

</div>


{{-- BOOTSTRAP --}}

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

const modalElement =
    document.getElementById('removeMemberModal');

const confirmRemoveButton =
    document.getElementById('confirmRemoveMember');


const removeModal =
    new bootstrap.Modal(modalElement);


// ========================================
// REMOVE MEMBER BUTTON
// ========================================

membersContainer.addEventListener('click', function(event) {

    if (!event.target.classList.contains('remove-member')) {
        return;
    }


    memberToRemove =
        event.target.closest('.member-box');


    removeModal.show();

});


// ========================================
// CONFIRM REMOVE
// ========================================

confirmRemoveButton.addEventListener('click', function() {

    if (!memberToRemove) {
        return;
    }


    // Check if member already exists
    // in the database

    const memberIdInput =
        memberToRemove.querySelector(
            'input[name$="[id]"]'
        );


    if (memberIdInput) {

        const memberId =
            memberIdInput.value;


        // Tell Laravel to delete this member
        // when Update Group is clicked

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


    // Remove member from screen

    memberToRemove.remove();


    memberToRemove = null;


    removeModal.hide();

});


// ========================================
// ADD NEW MEMBER
// ========================================

addMemberButton.addEventListener('click', function() {


    const currentMembers =
        membersContainer.querySelectorAll(
            '.member-box'
        ).length;


    if (currentMembers >= 5) {

        alert(
            'A group can have a maximum of 5 members.'
        );

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

            <strong>
                New Member
            </strong>

            <button
                type="button"
                class="btn btn-danger btn-sm remove-member"
            >
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
                        class="form-control"
                        name="members[${key}][name]"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Student ID
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="members[${key}][student_id]"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Batch
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        name="members[${key}][batch]"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Session
                    </label>

                    <select
                        class="form-select"
                        name="members[${key}][session]"
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
                        class="form-select"
                        name="members[${key}][department]"
                        required
                    >

                        <option value="">
                            Select department
                        </option>

                        <option value="CSE">
                            Department of Computer Science and Engineering
                        </option>

                        <option value="EEE">
                            Department of Electrical and Electronic Engineering
                        </option>

                        <option value="MATH">
                            Department of Mathematics
                        </option>

                        <option value="ECO">
                            Department of Economics
                        </option>

                    </select>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Role
                    </label>

                    <select
                        class="form-select"
                        name="members[${key}][role]"
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