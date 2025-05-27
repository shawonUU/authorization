@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="content container-fluid">
<div class="page-header">
						<div class="content-page-header">
							<h5>Edit User</h5>
						</div>	
					</div>
            
            <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1"></h4>
                      <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('users.index') }}" class="btn btn-info">User List</a>
                        </div>
                      </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                      <div class="live-preview">
                        <div class="row gy-4">
                            <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xxl-3 col-md-6 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ old('name',$user->name) }}" id="name" name="name" placeholder="Enter User name" >
                                    </div>                                    
                                    <div class="col-xxl-3 col-md-6 mb-3">
                                        <label for="name" class="form-label">Email</label>
                                        <input type="text" class="form-control" value="{{ old('email',$user->email) }}" id="email" name="email" placeholder="Enter User email" >
                                    </div>
                                    <div class="col-xxl-3 col-md-6 mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select js-example-basic-single" id="role" name="roles[]" required multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach                                                                                        
                                        </select>
                                    </div>                                    
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Submit</button>
                            </form>

                        </div>
                        <!--end row-->
                      </div>
                    </div>
                  </div>
                </div>
                <!--end col-->
              </div>

        </div>
        <!-- container-fluid -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
        
        $('.js-example-basic-single').select2({
            
        });

        $('.js-example-basic-single-no-new-value').select2({
        });

        
    });
</script>
<script>
    
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });

</script>
@endsection
