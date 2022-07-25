@extends('layouts.master')
@section('css')
<style>
    @media print{
        #print_btn{
            display: none;
        }
    }
</style>
@endsection
@section('title')
    طباعة الفاتورة - برنامج الفواتير
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة الفاتورة</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row ">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتورة تحصيل </h1>
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
                                        {{-- <div class="col-md"></div> --}}
										<div class="col-md-6">
											<label class="tx-gray-600">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoices->invoice_number}}</span></p>
											<p class="invoice-info-row"><span>تاريخ إصدار الفاتورة</span> <span>{{$invoices->invoice_date}}</span></p>
											<p class="invoice-info-row"><span>تاريخ أستحقاق الفاتورة</span> <span>{{$invoices->due_date}}</span></p>
											<p class="invoice-info-row"><span>القسم</span> <span>{{$invoices->section->section_name}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
                                                <tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">المنتج</th>
													<th>مبلغ التحصيل</th>
													<th class="tx-center">مبلغ العمولة</th>
                                                </tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td class="tx-12">{{$invoices->product}}</td>
													<td>${{ number_format($invoices->Amount_Collection,2)}}</td>
													<td class="tx-right">${{number_format($invoices->Amount_Commission,2)}}</td>
												</tr>
												
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">التفاصيل</label>
														</div><!-- invoice-notes -->
													</td>
													<td class="tx-right">الأجمالي</td>
													<td class="tx-right" colspan="2">${{number_format($invoices->Amount_Collection + $invoices->Amount_Commission,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبة ({{$invoices->Rate_VAT}})</td>
													<td class="tx-right" colspan="2">${{number_format($invoices->Value_VAT,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right">قيمة الخصم</td>
													<td class="tx-right" colspan="2">${{number_format($invoices->discount,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الأجمالي شامل الخصم</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">${{number_format($invoices->total,2)}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<button class="btn btn-danger float-left mt-3 mr-2 w-25 " id="print_btn" onclick="printDiv()">
										<i class="mdi mdi-printer ml-1"></i>طباعة الفاتورة
                                    </button>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    function printDiv(){
        var printContents = document.getElementById('print').innerHTML;
        // console.log(printContents);
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection