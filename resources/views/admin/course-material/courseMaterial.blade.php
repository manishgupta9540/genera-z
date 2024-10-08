@extends('admin.master.index')

@section('title', 'Course Materials')
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            {{-- <div class="card-header">
                            </div> --}}

                            <div class="card-body">
                                <h4 class="border-bottom pb-2">Course Materials for Sub-Module : {{ $subModule->name }}
                                </h4>
                                <form action="{{ route('materialsStore', urlencode(base64_encode($subModule->id))) }}"
                                    method="post" id="updatedmaterialFrm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12 addGrandParent">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h4 class="form-control-label font-weight-bold">Sub-Module : Course
                                                    Materials</h4>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.courseMaterial.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add New</button>
                                            </div>

                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.courseMaterial.id') }}"
                                                id="courseMaterialAddParent">
                                                @foreach ($subModule->materials as $value)
                                                    @include('admin.components.courseMaterial', $value)
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="card-footer text-left">
                                            <button class="btn btn-primary mr-1 submit"
                                            type="submit"
                                            id="submitBtn"
                                            style="{{count($subModule->materials) > 0 ? 'display:block' : 'display:none' }}">
                                            Submit
                                        </button>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

@endsection


@push('customjs')
    <script>
        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    </script>
    <script>
        var materialTypes = @json(config('constants.materialTypes'));
    </script>
    <script src="{{ asset('admin/assets/js/page/courseMaterial.js') }}"></script>

    <script>
        // function deleteAccordionItem(id) {
        //     var item = document.getElementById('courseMaterial_' + id);
        //     if (item) {
        //         item.remove();
        //     }
        // }
    </script>
    <script>
        // function deleteAccordionItem(id) {
        //     var item = document.getElementById('courseMaterial_' + id);
        //     var table = 'materials';
        //     var _this = $(item);

        //     swal({
        //             type: "warning",
        //             title: "Are You Sure You Want to Delete?",
        //             text: "",
        //             dangerMode: true,
        //             showCancelButton: true,
        //             confirmButtonColor: "#007358",
        //             confirmButtonText: "YES",
        //             cancelButtonText: "CANCEL",
        //             closeOnConfirm: false,
        //             closeOnCancel: false
        //         },
        //         function(e) {
        //             if (e == true) {
        //                 _this.addClass('disabled-link');
        //                 $.ajax({
        //                     type: "POST",
        //                     dataType: "json",
        //                     url: "{{ route('material-delete') }}",
        //                     data: {
        //                         "_token": "{{ csrf_token() }}",
        //                         'id': id,
        //                         'table_name': table
        //                     },
        //                     success: function(response) {
        //                         console.log(response);
        //                         window.setTimeout(function() {
        //                             _this.removeClass('disabled-link');
        //                         }, 2000);

        //                         if (response.success === true) {
        //                             swal("Deleted!", response.message, "success");
        //                             item.remove();
        //                         } else {
        //                             swal("Error!", response.message, "error");
        //                         }
        //                     },
        //                     error: function(response) {
        //                         console.log(response);
        //                     }
        //                 });
        //                 swal.close();
        //             } else {
        //                 swal.close();
        //             }
        //         }
        //     );
        // }

        function deleteAccordionItem(id) {
    var item = document.getElementById('courseMaterial_' + id);
    var table = 'materials';
    var _this = $(item);

    swal({
            type: "warning",
            title: "Are You Sure You Want to Delete?",
            text: "",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: "#007358",
            confirmButtonText: "YES",
            cancelButtonText: "CANCEL",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(e) {
            if (e == true) {
                _this.addClass('disabled-link');

                // Immediately remove accordion item from DOM
                item.remove();

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('material-delete') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id,
                        'table_name': table
                    },
                    success: function(response) {
                        console.log(response);
                        window.setTimeout(function() {
                            _this.removeClass('disabled-link');
                        }, 2000);

                        if (response.success === true) {
                            swal("Deleted!", response.message, "success");
                        } else {
                            swal("Error!", response.message, "error");
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
                swal.close();
            } else {
                swal.close();
            }
        }
    );
}

    </script>
@endpush
