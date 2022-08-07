@extends('layouts.master')
@section('title')
    كل المستخدمين - برنامج الفواتير
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة المستخدمين</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('add_user'))
<script>
    window.onload = function() {
        notif({
            msg: "تم أضافة المستخدم بنجاح",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('edit'))
<script>
    window.onload = function() {
        notif({
            msg: "تم تحديث معلومات المستخدم بنجاح",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('delete'))
<script>
    window.onload = function() {
        notif({
            msg: "تم حذف المستخدم بنجاح",
            type: "error"
        })
    }
</script>
@endif
				<!-- row -->
                <div class="row">
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card mg-b-20">
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                                    @can('اضافة مستخدم')
                                    <a href="users/create" class="modal-effect btn btn-outline-primary btn-sm ml-3"><i
                                            class="fas fa-plus"></i>&nbsp;إضافة مستخدم
                                    </a>
                                    @endcan

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">اسم المستخدم</th>
                                                <th class="border-bottom-0">البريد الإلكتروني</th>
                                                <th class="border-bottom-0">حالة المستخدم</th>
                                                <th class="border-bottom-0">نوع المستخدم</th>
                                                <th class="border-bottom-0">العمليات</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $index=>$user)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    @if ($user->status == 'مفعل')
                                                        <span class="label text-success d-flex">
                                                            <div class="dot-label bg-success ml-1"></div>{{ $user->status }}
                                                        </span>
                                                    @else
                                                        <span class="label text-danger d-flex">
                                                            <div class="dot-label bg-danger ml-1"></div>{{ $user->status }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $v)
                                                            <label class="badge badge-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td>
                                                    @can('تعديل مستخدم')
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                                            title="تعديل"><i class="las la-pen"></i></a>
                                                    @endcan

                                                    @can('حذف مستخدم')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                                            data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                                class="las la-trash"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>


                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المستخدم</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('users.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input class="form-control" name="username" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
                </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })
    </script>

@endsection
