@extends('layouts.app')
@section('content')
    <h1>Students</h1>
    <div class="row float-end">
        <div class="col">
            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#studentModal">
                Add New Student
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Reporting Teacher</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <th scope="row">{{$student->id}}</th>
                        <td>{{$student->name}}</td>
                        <td>{{$student->age}}</td>
                        @if($student->gender == 'm')
                        <td>Male</td>
                        @else
                        <td>Female</td>
                        @endif
                        <td>{{$student->reportingTeacher->name}}</td>
                        <td><a href="#" data-sid="{{$student->id}}" class="stud-edit" data-bs-toggle="modal"
                               data-bs-target="#studentModal">Edit</a> /
                            <a href="#" class="stud-delete" data-sid="{{$student->id}}" data-bs-toggle="modal"
                               data-bs-target="#studentDeleteModal">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="student-submit">
                    <div class="modal-body">
                        <div id="err-div"></div>
                        <div></div>
                        @csrf
                        <input name="id" type="hidden" id="stud-id" value="">
                        <div class="mb-3">
                            <label for="stud-name" class="form-label">Name</label>
                            <input required name="stud-name" type="text" class="form-control" id="stud-name" placeholder="Name">
                            <div class="invalid-feedback name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stud-age" class="form-label">Age</label>
                            <input required name="stud-age" type="number" class="form-control" id="stud-age" placeholder="Age">
                        </div>

                        <div class="mb-3">
                            <label for="stud-gender" class="form-label">Gender</label>
                            <select required name="stud-gender" class="form-control" id="stud-gender">
                                <option value="">Select One</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stud-report-teach" class="form-label">Reporting Teacher</label>
                            <select required name="stud-report-teach" class="form-control" id="stud-report-teach"
                                    placeholder="teacher">
                                <option value="">Select One</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete -->
    <div class="modal fade" id="studentDeleteModal" tabindex="-1" aria-labelledby="studentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Student Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger del-confirm" id="delete" data-del="">Delete</button>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script>
        $('#student-submit').on('submit', function (e) {
            $('#err-div').html('');
            e.preventDefault();
            formData = $('#student-submit').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('student.save') }}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $('.btn-close').click();
                        location.reload();
                    }
                }, error: function (e) {
                    console.log(e.responseJSON.errors);
                    let errArr = e.responseJSON.errors
                    for (key in errArr) {
                        $('#err-div').append(`
                        <div class="invalid-feedback">` +
                            errArr[key][0] +
                            `</div>`)
                    }
                    $(".invalid-feedback").css('display','block');
                }
            });
        });

        $('.add-btn').on('click', function(){
            $('#err-div').html('');
            $('#studentModal form').trigger('reset');
        });

        $('.stud-edit').on('click', function (e) {
            $('#err-div').html('');
            var url = '{{ route('student.get', [":id"]) }}';
            url = url.replace(':id', $(this).data('sid'));
            $.get(url, (data, status) => {
                $('#studentModal input[name="id"]').val(data.id);
                $('#studentModal input[name="stud-name"]').val(data.name);
                $('#studentModal input[name="stud-age"]').val(data.age);
                $('#studentModal select[name="stud-gender"] option[value="' + data.gender + '"]').prop('selected', true);
                $('#studentModal select[name="stud-report-teach"] option[value="' + data.reporting_teacher_id + '"]').prop('selected', true);
            });
        });

        $('.stud-delete').on('click', function (e) {
            $('.del-confirm').attr('data-del', $(this).data('sid'));
        });

        $('.del-confirm').on('click', function (e) {
            var url = '{{ route('student.delete', [":id"]) }}';
            url = url.replace(':id', $(this).attr('data-del'));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'DELETE',
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $('.btn-close').click();
                        location.reload();
                    }
                }
            });
        });
    </script>
@endsection

