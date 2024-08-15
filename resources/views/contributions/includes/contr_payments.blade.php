

<div id="layout-wrapper">
            
            @include('layouts.includes.top_bar')
            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.includes.vertical_bar')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
             <div class="wrapper">
                <!-- <div class="content-layer" style="width: 80.17%;"> -->
                            <!-- start page title -->
                            <div class="row">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">Monthly Payments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">Documents Centre</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab3" role="tab">Workflow History</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="tab1" class="container tab-pane active" role="tabpanel"><br>
                                            <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Fund Members</h4>
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
                                    <div id="tab2" class="container tab-pane fade" role="tabpanel"><br>
                                        <h3>Tab 2</h3>
                                        <p>Content for Tab 2.</p>
                                    </div>
                                    <div id="tab3" class="container tab-pane fade" role="tabpanel"><br>
                                        <h3>Tab 3</h3>
                                        <p>Content for Tab 3.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->                   
                <!-- </div> -->
             </div>

    <!-- <========================= Content Here=======================================================> -->

</div>