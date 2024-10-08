@extends('admin.master.index')

@section('title', 'Chat')

@section('content')


<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <h3>Chat and Queries</h3>
            </div>
        </div>
      <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped user_datatable" id="user_datatable" >
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Chat Date </th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                            @if (count($messages))
                                @foreach ($messages as $key => $message)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($message->created_at)->format('d-M-Y') }}</td>
                                        <td>{{ $message->body }}</td>
                                        <td>
                                            <a href="{{ url('chatify/'.$message->id) }}" class="btn btn-outline-info" title="chat">
                                                <i class="fas fa-comments text-info"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h4>No Chat Awailable</h4>
                            @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>

  </div>

@endsection

@push('customjs')
<script>

</script>
@endpush
