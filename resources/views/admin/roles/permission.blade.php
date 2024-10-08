@extends('admin.master.index')
@section('title', 'Roles & Permission')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-11">
                        <form action="{{route('roles/permission/update')}}"  method="post" >
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                     @if(count($permission)>0)
                                      @foreach($permission as $data)
                                            <?php
                                              $action = DB::table('action_masters')->where(['route_group'=>'','status'=>'1','parent_id'=>$data->id])->orderBy('display_order','ASC')->get();
                                            ?>
                                            @php
                                              if($action_route_count==0){
                                                $checked = '';
                                              }else{
                                                $route_link = explode(',',$action_route->permission_id);
                                              
                                                $checked = in_array($data->id,$route_link)  ? 'checked' : '';
                                                // dd($checked);
                                              }
                                            @endphp
                                          <li style="display: block;">
                                            <input type="checkbox" name="permissions[]" id="{{$data->id}}" value="{{$data->id}}" {{$checked}} > <label for="{{ $data->id }}" > {{$data->action_title}} </label>
                                            <ul>
                                              @if(count($action)>0)
                                                @foreach($action as $premission)
                                                  <?php
                                                    $sub_action = DB::table('action_masters')->where(['route_group'=>'','status'=>'1','parent_id'=>$premission->id])->orderBy('display_order','ASC')->get();
                                                  ?>
                                                  @php
                                                    if($action_route_count==0){
                                                      $checked = '';
                                                    }else{
                                                        $route_link = explode(',',$action_route->permission_id);
                                                        $checked = in_array($premission->id,$route_link)  ? 'checked' : '';
                                                    }
                                                  @endphp
                                                  <li style="display: block">
                                                    <input type="checkbox"  name="permissions[]" id="{{$premission->id}}" value="{{$premission->id}}" {{$checked}} > <label for="{{$premission->id}}">{{$premission->action_title}}</label>
                                                  </li>
                                                @endforeach
                                              @endif
                                            </ul>
                                          </li>
                                      @endforeach
                                      @endif
                                      <hr>
                                </div>
                            </div>
                            <input type="hidden" name="role_id" value="{{$role_id}}">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <a href="{{route('roles.index')}}" class="btn  btn-danger" ><i class="metismenu-icon"></i>Cancel</a>
                        </form>   
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
  $('input[type=checkbox]').click(function () {
     $(this).parent().find('li input[type=checkbox]').prop('checked', $(this).is(':checked'));
     var sibs = false;
     $(this).closest('ul').children('li').each(function () {
         if($('input[type=checkbox]', this).is(':checked')) sibs=true;
     })
     $(this).parents('ul').prev().prop('checked', sibs);
 });
</script>
@endpush