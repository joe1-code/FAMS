

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
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="tab1" class="container tab-pane active" role="tabpanel"><br>
                    <div class="content-layer">
                        <form action="{{ route('get_monthly_payments') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row" style="background-color: red;">
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
                                <input type="file" class="form-control" id="document" name="document" required>
                                @if ($errors->has('document'))
                                    <div class="text-danger">
                                        {{ $errors->first('document') }}
                                    </div>
                                @endif
                                <div class="invalid-feedback">
                                    Please upload a document
                                </div>
                            </div>
                            <div>
                                <button type="submit">Submit</button>
                            </div>
                            </div>
                            



                        </form>
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
    </div>
</div>

