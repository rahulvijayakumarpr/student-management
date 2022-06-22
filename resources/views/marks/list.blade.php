@extends('layouts.app')
@section('content')
    <h1>Marks</h1>
    <div class="row float-end">
        <div class="col">
            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#markModal">
                Add New
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
                    <th scope="col">Math</th>
                    <th scope="col">Science</th>
                    <th scope="col">History</th>
                    <th scope="col">Term</th>
                    <th scope="col">Total</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dispArr as $eachEle)
                    <tr>
                        <th scope="row">{{$eachEle['id']}}</th>
                        <td>{{$eachEle['name']}}</td>
                        <td>{{$eachEle['math']}}</td>
                        <td>{{$eachEle['science']}}</td>
                        <td>{{$eachEle['history']}}</td>
                        <td>{{$eachEle['term']}}</td>
                        <td>{{$eachEle['total']}}</td>
                        <td>{{$eachEle['created']}}</td>
                        <td><a href="#" data-stid="{{$eachEle['stud_id']}}"  data-termid="{{$eachEle['term_id']}}" class="mark-edit" data-bs-toggle="modal"
                               data-bs-target="#markModal">Edit</a> /
                            <a href="#" class="mark-delete" data-stid="{{$eachEle['stud_id']}}"  data-termid="{{$eachEle['term_id']}}" data-bs-toggle="modal"
                               data-bs-target="#markDeleteModal">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="markModal" tabindex="-1" aria-labelledby="markModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markModalLabel">Mark Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="mark-submit">
                    <div class="modal-body">
                        <div id="err-div"></div>
                        <div></div>
                        @csrf
                        <input name="id" type="hidden" id="stud-id" value="">
                        <div class="mb-3">
                            <label for="mark-stud" class="form-label">Student</label>
                            <select name="mark-stud" class="form-control" id="mark-stud"
                                    placeholder="teacher">
                                <option value="">Select One</option>
                                @foreach($students as $student)
                                    <option value="{{$student->id}}">{{$student->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mark-term" class="form-label">Term</label>
                            <select name="mark-term" class="form-control" id="mark-term">
                                <option value="">Select One</option>
                                <option value="one">One</option>
                                <option value="two">Two</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Marks</label>
                        </div>
                        <div class="mb-3">
                            <label for="math" class="form-label">Math</label>
                            <input min="0" max="100" name="math" type="number" class="form-control" id="math" placeholder="Marks">
                        </div>
                        <div class="mb-3">
                            <label for="sci" class="form-label">Science</label>
                            <input min="0" max="100" name="sci" type="number" class="form-control" id="sci" placeholder="Marks">
                        </div>
                        <div class="mb-3">
                            <label for="hist" class="form-label">History</label>
                            <input min="0" max="100" name="hist" type="number" class="form-control" id="hist" placeholder="Marks">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save" data-action="post">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete -->
    <div class="modal fade" id="markDeleteModal" tabindex="-1" aria-labelledby="studentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Mark Delete</h5>
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
        $('#mark-submit').on('submit', function (e) {
            $('#err-div').html('');
            e.preventDefault();
            formData = $('#mark-submit').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('marks.save') }}",
                type: $("#save").attr('data-action'),
                data: formData,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $('.btn-close').click();
                        location.reload();
                    }
                }, error: function (e) {
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
            $("#save").attr('data-action','post');
            $('#err-div').html('');
            $('#markModal form').trigger('reset');
        });


        $('.mark-edit').on('click', function (e) {
            $("#save").attr('data-action','patch');
            $('#err-div').html('');
            var url = '{{ route('marks.get', [":id", ":term"]) }}';
            url = url.replace(':id', $(this).data('stid'));
            url = url.replace(':term', $(this).data('termid'));
            $.get(url, (data, status) => {
                $('#markModal input[name="math"]').val(data.math);
                $('#markModal input[name="sci"]').val(data.science);
                $('#markModal input[name="hist"]').val(data.history);
                $('#markModal select[name="mark-term"] option[value="' + data.term_id + '"]').prop('selected', true);
                $('#markModal select[name="mark-stud"] option[value="' + data.stud_id + '"]').prop('selected', true);
            });
        });

        $('.mark-delete').on('click', function (e) {
            $('.del-confirm').attr('data-stid',$(this).data('stid'));
            $('.del-confirm').attr('data-termid',$(this).data('termid'));
        });

        $('.del-confirm').on('click', function (e) {
            var url = '{{ route('marks.delete', [":id",":term"]) }}';
            url = url.replace(':id', $(this).attr('data-stid'));
            url = url.replace(':term', $(this).attr('data-termid'));
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

