@extends('layouts.master')
@section('title')
    تفاصيل الفاتورة - برنامج الفواتير
@stop
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-3">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                        class="fa fa-info-circle"></i> &nbsp;معلومات الفاتورة</a></li>
                                            <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>
                                                    &nbsp;
                                                    حالات الفاتورة</a></li>
                                            <li><a href="#tab13" data-toggle="tab"><i class="fa fa-paperclip"></i>
                                                    &nbsp;
                                                    المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab11">
                                            <div class="card-body col-md-12">
                                                <form action="{{ route('invoices.store') }}" method="post"
                                                    enctype="multipart/form-data" autocomplete="off">
                                                    {{ csrf_field() }}
                                                    {{-- 1 --}}
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">رقم
                                                                الفاتورة</label>
                                                            <input type="text" class="form-control" id="inputName"
                                                                name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}" readonly>
                                                        </div>

                                                        <div class="col">
                                                            <label>تاريخ الفاتورة</label>
                                                            <input class="form-control fc-datepicker" name="invoice_Date"
                                                                type="text" value="{{ $invoices->invoice_date }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col">
                                                            <label>تاريخ الاستحقاق</label>
                                                            <input class="form-control fc-datepicker" name="Due_date"
                                                                type="text" value="{{ $invoices->due_date }}"
                                                                readonly>
                                                        </div>

                                                        <div class="col">
                                                            <label for="inputName" class="control-label">القسم</label>
                                                            <input class="form-control" name="section" type="text"
                                                                value="{{ $invoices->section->section_name }}"readonly>
                                                        </div>

                                                    </div>

                                                    {{-- 2 --}}
                                                    <div class="row ">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">المنتج</label>
                                                            <input class="form-control" name="product" id="product"
                                                                type="text" value="{{ $invoices->product }}" readonly>
                                                        </div>

                                                        <div class="col">
                                                            <label for="inputName" class="control-label">مبلغ
                                                                التحصيل</label>
                                                            <input type="text" class="form-control" id="inputName"
                                                                name="Amount_collection"
                                                                value="{{ $invoices->Amount_Collection }}" readonly>
                                                        </div>
                                                    </div>

                                                    {{-- 3 --}}
                                                    <div class="row">

                                                        <div class="col">
                                                            <label for="inputName" class="control-label">مبلغ
                                                                العمولة</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Amount_Commission" name="Amount_Commission"
                                                                value="{{ $invoices->Amount_Commission }}" readonly>
                                                        </div>

                                                        <div class="col">
                                                            <label for="inputName" class="control-label">الخصم</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Discount" name="Discount"
                                                                value="{{ $invoices->discount }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">نسبة
                                                                ضريبة القيمة المضافة</label>
                                                            <input type="text" class="form-control" id="Rate_VAT"
                                                                name="Rate_VAT" value="{{ $invoices->Rate_VAT }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">قيمة
                                                                ضريبة القيمة المضافة</label>
                                                            <input type="text" class="form-control" id="Value_VAT"
                                                                name="Value_VAT" value="{{ $invoices->Value_VAT }}"
                                                                readonly>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">الملاحظات</label>
                                                            <input type="text" class="form-control" id="note"
                                                                name="note" value="{{ $invoices->note }}" readonly>
                                                        </div>
                                                    </div>
                                                    {{-- 4 --}}
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">الاجمالي شامل
                                                                الضريبة</label>
                                                            <input type="text" class="form-control" id="Total"
                                                                name="Total" value="{{ $invoices->total }}" readonly>
                                                        </div>
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">الحالة
                                                                الحالية</label>
                                                            @if ($invoices->value_status == 1)
                                                                <input type="text"
                                                                    class="form-control text-light bg-success text-center"
                                                                    id="Value_Status" name="Value_Status"
                                                                    value="{{ $invoices->status }}" readonly>
                                                            @elseif($invoices->value_status == 2)
                                                                <input type="text"
                                                                    class="form-control text-light bg-danger text-center"
                                                                    id="Value_Status" name="Value_Status"
                                                                    value="{{ $invoices->status }}" readonly>
                                                            @else
                                                                <input type="text"
                                                                    class="form-control text-dark bg-warning text-center"
                                                                    id="Value_Status" name="Value_Status"
                                                                    value="{{ $invoices->status }}" readonly>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab12">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>رقم الفاتورة</th>
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الدفع </th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريخ الاضافة </th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($details as$index=>$detail)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $detail->invoice_number }}</td>
                                                                <td>{{ $detail->product }}</td>
                                                                <td>{{ $invoices->section->section_name }}</td>
                                                                @if ($detail->Value_Status == 1)
                                                                    <td><span
                                                                            class="badge badge-pill badge-success">{{ $detail->status }}</span>
                                                                    </td>
                                                                @elseif($detail->Value_Status ==2)
                                                                    <td><span
                                                                            class="badge badge-pill badge-danger">{{ $detail->status }}</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge badge-pill badge-warning">{{ $detail->status }}</span>
                                                                    </td>
                                                                @endif
                                                                <td>{{ $detail->Payment_Date }}</td>
                                                                <td>{{ $detail->note }}</td>
                                                                <td>{{ $detail->created_at }}</td>
                                                                <td>{{ $detail->user }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab13">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                @can('اضافة مرفق')
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                        enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="customFile" name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoices->id }}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>
                                                @endcan
                                                <br>

                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($attachments as $index => $attachment)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('/View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>
                                                                            @can('حذف المرفق')
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                                            data-id_file="{{ $attachment->id }}"
                                                                            data-target="#delete_file">حذف</button>
                                                                            @endcan
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
        <!-- delete -->
        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('delete_file') }}" method="post">

                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p class="text-center">
                            <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                            </p>

                            <input type="hidden" name="id_file" id="id_file" value="">
                            <input type="hidden" name="file_name" id="file_name" value="">
                            <input type="hidden" name="invoice_number" id="invoice_number" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>

@endsection
