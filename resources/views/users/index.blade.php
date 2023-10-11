@extends('layouts.master')

@section('styles')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@endsection


@section('content')
<section class="section">
    <div class="section-body">
    <div class="row">
       
        <div class="col-12 ">
        <div class="card">
            <div class="card-header">
            <h4>All Users</h4>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Status</th>
                    <th>Accounts</th>
                    <th>Actions</th>
                </tr>


            @foreach($users as $index=> $user)
                @php
                    $index ++;
                @endphp
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                     <img alt="image" src="{{$user->avatar}}" class="rounded-circle" width="35"
                        data-toggle="tooltip" title="{{$user->name}}">
                    </td>
                    <td> 
                    <label class="switch" >
                    <input type="checkbox" class="switch-btn" data-id={{$user->id}}      {{ $user->status==1 ? 'checked' : '' }}>
                    <span class="slider round"></span>
                    </label>
                    </td>
                    <td>
                      <a href="{{route('dashboard.posts.all',$user->id)}}" class="btn btn-social-icon mr-1 btn-facebook">
                      <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                        <i class="fab fa-instagram"></i>
                      </a>

                    </td>
                </tr>

            @endforeach

                </table>
            </div>
            </div>
            <div class="card-footer text-right">
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                
                <li class="page-item active"><a class="page-link" href="#">1 <span
                        class="sr-only">(current)</span></a></li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
                </ul>
            </nav>
            </div>
        </div>
        </div>
    </div>
 

    </div>
</section>
@endsection


@section('scripts')

<script>

$(document).ready(function(){

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $(".switch-btn").click(function(){
    var id=$(this).data('id');
    var url='{{ route("user.updateStatus") }}';
    var status = $(this).is(':checked') ? 1 : 0;
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to update status",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText:'Cancel',
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'POST',
        url: url,
        data: {status: status, id:id},
        success: function(response)
        {
            console.log(response);
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        }
    });
    }
});


      
  });

});


</script>

@endsection