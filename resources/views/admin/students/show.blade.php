@extends('admin.layouts.master_layout')

@section('pageTitle', 'Student Details - ' . $student->khmer_name)

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            @if($student->photo_path)
              <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $student->photo_path) }}" alt="User profile picture">
            @else
              <img class="profile-user-img img-fluid img-circle" src="{{ assetUrl('') }}/dist/img/user4-128x128.jpg" alt="User profile picture">
            @endif
          </div>
          <h3 class="profile-username text-center">{{ $student->khmer_name }}</h3>
          <p class="text-muted text-center">{{ $student->latin_name }}</p>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Code</b> <a class="float-right">{{ $student->student_code }}</a>
            </li>
            <li class="list-group-item">
              <b>Gender</b> <a class="float-right">{{ $student->gender->name_kh ?? '-' }}</a>
            </li>
            <li class="list-group-item">
              <b>Status</b> <a class="float-right"><span class="badge badge-{{ $student->status == 'active' ? 'success' : 'secondary' }}">{{ $student->status }}</span></a>
            </li>
            <li class="list-group-item">
              <b>Phone</b> <a class="float-right">{{ $student->phone ?? '-' }}</a>
            </li>
            <li class="list-group-item">
              <b>Email</b> <a class="float-right">{{ $student->email ?? '-' }}</a>
            </li>
            <li class="list-group-item">
              <b>DOB</b> <a class="float-right">{{ $student->date_of_birth ?? '-' }}</a>
            </li>
          </ul>
          <a href="{{ route('students.edit', $student) }}" class="btn btn-primary btn-block"><b>Edit Student</b></a>
          <a href="{{ route('students.files.index', $student) }}" class="btn btn-info btn-block"><b>Manage Files</b></a>
          <a href="{{ route('students.room-assignments.index', $student) }}" class="btn btn-secondary btn-block"><b>Room Assignments</b></a>
          <a href="{{ route('students.cards.index', $student) }}" class="btn btn-success btn-block"><b>Cards</b></a>
          <a href="{{ route('students.certificates.index', $student) }}" class="btn btn-warning btn-block"><b>Certificates</b></a>
          <a href="{{ route('students.diplomas.index', $student) }}" class="btn btn-dark btn-block"><b>Diplomas</b></a>
          <a href="{{ route('students.update-requests.index', $student) }}" class="btn btn-outline-primary btn-block"><b>Update Requests</b></a>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Info</a></li>
            <li class="nav-item"><a class="nav-link" href="#enrollments" data-toggle="tab">Enrollments</a></li>
            <li class="nav-item"><a class="nav-link" href="#guardians" data-toggle="tab">Guardians</a></li>
            <li class="nav-item"><a class="nav-link" href="#files" data-toggle="tab">Files</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="info">
              <div class="row">
                <div class="col-md-6">
                  <h5>Birth Place</h5>
                  <p>
                    Province: {{ $student->birthPlace->province->name_kh ?? '-' }}<br>
                    District: {{ $student->birthPlace->district->name_kh ?? '-' }}<br>
                    Commune: {{ $student->birthPlace->commune->name_kh ?? '-' }}<br>
                    Village: {{ $student->birthPlace->village->name_kh ?? '-' }}<br>
                    Street: {{ $student->birthPlace->street ?? '-' }}<br>
                    House No: {{ $student->birthPlace->house_no ?? '-' }}
                  </p>
                </div>
                <div class="col-md-6">
                  <h5>Current Address</h5>
                  <p>
                    Province: {{ $student->currentAddress->province->name_kh ?? '-' }}<br>
                    District: {{ $student->currentAddress->district->name_kh ?? '-' }}<br>
                    Commune: {{ $student->currentAddress->commune->name_kh ?? '-' }}<br>
                    Village: {{ $student->currentAddress->village->name_kh ?? '-' }}<br>
                    Street: {{ $student->currentAddress->street ?? '-' }}<br>
                    House No: {{ $student->currentAddress->house_no ?? '-' }}
                  </p>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <h5>Note</h5>
                  <p>{{ $student->note ?? 'No notes' }}</p>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="enrollments">
              <table class="table table-bordered">
                <thead>
                  <tr><th>Class</th><th>Course</th><th>Year</th><th>Shift</th><th>Status</th></tr>
                </thead>
                <tbody>
                  @forelse($student->enrollments as $enrollment)
                  <tr>
                    <td>{{ $enrollment->class->class_code ?? '-' }}</td>
                    <td>{{ $enrollment->class->course->name ?? '-' }}</td>
                    <td>{{ $enrollment->academicYear->name ?? '-' }}</td>
                    <td>{{ $enrollment->shift->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $enrollment->status == 'studying' ? 'success' : 'secondary' }}">{{ $enrollment->status }}</span></td>
                  </tr>
                  @empty
                  <tr><td colspan="5" class="text-center">No enrollments.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="guardians">
              <table class="table table-bordered">
                <thead>
                  <tr><th>Name</th><th>Relationship</th><th>Phone</th><th>Primary</th></tr>
                </thead>
                <tbody>
                  @forelse($student->guardians as $guardian)
                  <tr>
                    <td>{{ $guardian->name_kh }}</td>
                    <td>{{ $guardian->pivot->relationship ?? '-' }}</td>
                    <td>{{ $guardian->phone ?? '-' }}</td>
                    <td>{{ $guardian->pivot->is_primary ? 'Yes' : 'No' }}</td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="text-center">No guardians.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="files">
              <table class="table table-bordered">
                <thead>
                  <tr><th>Type</th><th>Name</th><th>Size</th><th>Primary</th></tr>
                </thead>
                <tbody>
                  @forelse($student->files as $file)
                  <tr>
                    <td>{{ $file->file_type }}</td>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                    <td>{{ $file->is_primary ? 'Yes' : 'No' }}</td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="text-center">No files.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
