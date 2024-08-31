

<div id="layout-wrapper">
            
            @include('layouts.includes.top_bar')
            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.includes.vertical_bar')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            

        

    <!-- <========================= Content Here=======================================================> -->
    <div class="wrapper">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">MONTHLY PAYMENTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">DOCUMENTS CENTRE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab3" role="tab">WORKFLOW HISTORY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab">NON-PAID MEMBERS</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="tab1" class="container tab-pane active" role="tabpanel"><br>
                
                    <div class="content-layer">
                        <form id="month_payment_form" method="post" enctype="multipart/form-data">
                               @csrf
                            <div class="row">
                           
                            <div class="col-md-4 mb-4">

                                <label for="member" class="form-label">Select Members</label>
                                <select class="form-control search-select" id="user_data" name="id" required>
                                    <option value="" disabled selected placeholder=''></option>
                                    @foreach($memberData as $data)
                                        <option value="{{$data->id}}">{{ $data->firstname.' '.$data->lastname }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('member'))
                                    <div class="text-danger">
                                        {{ $errors->first('member') }}
                                    </div>
                                @endif
                                <div class="invalid-feedback">
                                    Please select a member
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <!-- File Upload -->
                                <label for="document" class="form-label">Upload Document</label>
                                <input type="file" class="form-control" id="1" name="document" >
                                @if ($errors->has('document'))
                                    <div class="text-danger">
                                        {{ $errors->first('document') }}
                                    </div>
                                @endif
                                <div class="invalid-feedback">
                                    Please upload a document
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="paid_amount" class="form-label">Amount(Tshs.)</label>
                                <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" placeholder="Enter Amount" value="" required>
                                @if ($errors->has('paid_amount'))
                                    <div class="text-danger">
                                        {{ $errors->first('paid_amount') }}
                                    </div>
                                @endif
                                <div class="invalid-feedback">
                                    Please Enter Amount
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="hidden" class="form-control" id="module_id" name="module_id" value="1" required>
                                <input type="hidden" class="form-control" id="module_group_id" name="module_group_id" value="1" required>
                            </div>
                            <div class="monthly_pay_butt">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        

                            </div>
                            



                        </form>
                        @if(session('error'))
                <div class="alert alert-danger" style="background-color: red;">
                    {{ session('error') }}
                </div>
                @endif
                    
                    </div>
                    
                </div>
                <div id="tab2" class="container tab-pane fade" role="tabpanel">
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="content-layer2">
                <form id="doc_view" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="member" class="form-label">Select Members</label>
                            <select class="form-control search-select" id="user_data" name="id" required>
                                <option value="" disabled selected></option>
                                @foreach($memberData as $data)
                                    <option value="{{$data->id}}">{{ $data->firstname.' '.$data->lastname }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('member'))
                                <div class="text-danger">{{ $errors->first('member') }}</div>
                            @endif
                            <div class="invalid-feedback">Please select a member</div>
                        </div>

                        <div class="col-md-6">
                            <label for="contr_month">Contribution Month</label>
                            <select name="contr_month" id="contr_month" class="form-control search-select">
                                <option value="" disabled selected>Month</option>
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" 
                                        {{ old('contr_month', isset($request->from_date) ? \Carbon\Carbon::parse($request->from_date)->format('m') : '') == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="contr_year">Contribution Year</label>
                            <select name="contr_year" id="contr_year" class="form-control search-select">
                                <option value="" disabled selected>Year</option>
                                @foreach(range(\Carbon\Carbon::now()->format('Y'), 2022) as $year)
                                    <option value="{{ $year }}" 
                                        {{ old('contr_year', isset($request->from_date) ? \Carbon\Carbon::parse($request->from_date)->format('Y') : '') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="monthly_preview_doc col-md-12 mt-3">
                            <button type="submit" class="btn btn-success">Preview Document</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
        <div class="doc_preview">
            <legend>Document Preview</legend>
            <div id="document_frame" style="text-align: center;">

            </div>
        </div>
    </div>

        <!-- <div class="col-md-6">
            <div class="doc_preview">
                <legend>Document Preview</legend>
                <div id="document_frame">
                    @if(isset($docs))
                        <iframe id="document_preview" name="document_preview" src="{{'/storage/app/public/documents'.$docs->filename}}" width='100%' height='600px'></iframe>
                    @else

                    @endif
                </div>
            </div>
        </div> -->
    </div>
</div>

                
                <div id="tab3" class="container tab-pane fade" role="tabpanel"><br>
                    <h3>Tab 3</h3>
                    <p>Content for Tab 3.</p>
                </div>
                <div id="tab4" class="container tab-pane fade" role="tabpanel"><br>
                
                <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4" style="background-color: #17a2b8;">Non-Paid Members</h4>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check font-size-16 align-middle">
                                        <input class="form-check-input" type="checkbox" id="transactionCheckAll">
                                        <label class="form-check-label" for="transactionCheckAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Name</th>
                                <th class="align-middle">Region</th>
                                <th class="align-middle">District</th>
                                <th class="align-middle">DOB</th>
                                <th class="align-middle">Phone</th>
                                <th class="align-middle">Payment Status</th>
                                <th class="align-middle">View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memberData as $data)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="transactionCheck{{$loop->index}}">
                                            <label class="form-check-label" for="transactionCheck{{$loop->index}}"></label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{$data->firstname.' '.$data->middlename.' '.$data->lastname}}</a></td>
                                    <td>{{$data->region_name}}</td>
                                    <td>{{$data->district_name}}</td>
                                    <td>{{$data->dob}}</td>
                                    <td><i class="fas fa-phone me-1"></i> {{$data->phone}}</td>
                                    <td><span class="badge badge-pill badge-soft-success font-size-11">Paid</span></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light view-details-btn" data-id="{{$data->id}}" data-name="{{$data->firstname.' '.$data->middlename.' '.$data->lastname}}" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
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

<script>
    $(document).ready(function(){
        // "
        $('#month_payment_form').on('submit', function(e){

            e.preventDefault();

            var formdata = new FormData(this);
            console.log(formdata);

            $ajax({
                type: 'post',
                url: "{{ route('get_monthly_payments') }}",
                data: formdata,
                contentType: false,
                processData: false,

                
            });
            
        });
    });
</script>