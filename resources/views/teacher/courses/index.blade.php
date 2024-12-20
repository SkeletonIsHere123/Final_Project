@extends('layouts/teacherLO')

@section('main')
    <div class="content mt-4">
        <div class="card shadow-lg">
            <div class="card-header text-center text-white">
                <h3 style="color: aliceblue;">Courses Management</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('teacher.courses.create') }}" class="btn btn-add mb-3">Add New Course</a>
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Course Name</th>
                            <th style="max-width: 50px;">Course Image</th>
                            <th style="width: 130px;">Description</th>
                            <th>File</th>
                            <th style="width: 120px;">Category</th>
                            <th>Participants</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td style="max-width: 100px;">{{ $course->course_name }}</td>
                                <td><img src="{{ asset('uploads/course_image/' . $course->image) }}" alt=""
                                        style="border-radius: 5px; width: 70px; height: 70px;"></td>
                                <td style="max-width: 180px;">{{ $course->description }}</td>
                                <td style="max-width: 180px; overflow: hidden; white-space: nowrap;">
                                    <a href="{{ asset('uploads/course_file/' . $course->file) }}"
                                        style="display: inline-block; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; max-width: 100%;"
                                        target="_blank" title="{{ $course->file }}">
                                        <i class="fas fa-file-pdf"></i> {{ $course->file }}
                                    </a>
                                </td>
                                <td style="">{{ $course->category->cat_name }}</td>
                                <td style="text-align: center;">{{ $course->enrolls_count }}</td>
                                <td
                                    style="color: {{ $course->status == 0 ? 'gray !important' : 'green !important' }}; font-weight: bold;">
                                    {{ $course->status == 0 ? 'Hidden' : 'Publish' }}</td>
                                <td style="text-align: center; position: relative;">
                                    <button class="btn btn-toggle" onclick="toggleActions(this)"><i
                                            class="bi bi-list"></i></button>
                                    <div class="action-buttons"
                                        style="display: none; position: absolute; top: 50%; left: 50%; border: 1px solid #ccc; transform: translateX(-50%); z-index: 1; padding: 5px; width: max-content; background-color: lightgray;">
                                        <a href="{{ route('courses.detail', $course->id) }}" class="btn btn-view">View</a>
                                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-edit"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST"
                                            style="display:inline-block; width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-delete" type="submit" onclick="confirmDelete(event, this)"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        td {
            font-size: 13px;
            vertical-align: middle;
        }

        th {
            font-size: 15px;
            text-align: center;
            align-content: center;
        }

        .btn-add {
            background-color: #28a745;
            transition: background-color 0.3s, transform 0.3s;
            color: white;
            border-radius: 1em;
        }

        .btn-add:hover {
            transform: scale(1.05);
            color: black;
            background-color: white;
            border: 1px solid black;
        }

        .btn-edit {
            background-color: green;
            color: white;
            margin-bottom: 5px;
            width: 100%;
            padding: 5px;
            font-size: 13px;
        }

        .btn-edit:hover {
            border: 1px solid black;
            background-color: white;
            color: black;
        }

        .btn-delete {
            background-color: red;
            color: white;
            width: 100%;
            padding: 5px;
            font-size: 13px;
        }

        .btn-delete:hover {
            border: 1px solid black;
            background-color: white;
            color: black;
        }

        .btn-view {
            background-color: steelblue;
            color: white;
            margin-bottom: 5px;
            width: 100%;
            padding: 5px;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 13px;
        }

        .btn-view:hover {
            border: 1px solid black;
            background-color: white;
            color: black;
            transform: scale(1.05);
        }

        .btn-toggle {
            background-color: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .btn-toggle i {
            color: #007bff;
        }

        .btn-toggle.active i {
            color: red;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
        }

        .card-body {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .action-buttons {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
            border-radius: 5px;
            padding: 5px;
        }
    </style>

    <script>
        function confirmDelete(event, button) {
            event.preventDefault(); // Ngăn hành động submit form mặc định

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gọi hàm submit của form chứa nút "delete"
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endsection
