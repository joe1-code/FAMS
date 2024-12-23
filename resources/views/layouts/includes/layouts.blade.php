

<div id="layout-wrapper">
            
            @include('layouts.includes.top_bar')
            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.includes.vertical_bar')
            <!-- Left Sidebar End -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid"> 
                        

    <div class="row">
    
    <div class="col-lg-12">
        <div class="card">
        <div>
        <h4 class="mb-sm-0 font-size-18">Edit Member Information</h4>
        </div> 
            <div class="card-body">
            <form class="needs-validation" action="{{ route('submit_members', ['id'=>$request->input('member_id')]) }}" method="POST" novalidate>
        @csrf
        @if (session('success'))
        <div class="col-md-8 alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="Enter Firstname" value="{{$particulars->firstname}}" required>
                @if ($errors->has('firstname'))
                    <div class="text-danger">
                        {{ $errors->first('firstname') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Firstname
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="middlename" class="form-label">Middlename</label>
                <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Enter Middlename" value="{{$particulars->middlename}}" required>
                @if ($errors->has('middlename'))
                    <div class="text-danger">
                        {{ $errors->first('middlename') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Middlename
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Enter Lastname" value="{{$particulars->lastname}}" required>
                @if ($errors->has('lastname'))
                    <div class="text-danger">
                        {{ $errors->first('lastname') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Lastname
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$particulars->email ?? ''}}" placeholder="Enter email" >
                <!-- @if ($errors->has('email'))
                    <div class="text-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Email
                </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone" value="{{$particulars->phone ?? ''}}" required>
                @if ($errors->has('phone'))
                    <div class="text-danger">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Phone
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="phone" class="form-label">Job Title</label>
                <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" placeholder="Enter Job Title" value="{{$particulars->job_title ?? ''}}" >
                @if ($errors->has('phone'))
                    <div class="text-danger">
                        {{ $errors->first('job_title') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Job Title
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="regions" class="form-label">Region</label>
                <select class="form-control search-select" id="regions" name="regions" required>
                    <option value="" disabled selected>Select a region</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id ?? '' }}" {{ (old('region') == $region->id || $particulars->region_id == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('regions'))
                    <div class="text-danger">
                        {{ $errors->first('regions') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please select a region
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="regions" class="form-label">District</label>
                <select class="form-control search-select" id="districts" name="districts" required>
                    <option value="" disabled selected>Select a district</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id ?? '' }}" {{ (old('district') == $district->id || $particulars->district_id == $district->id) ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('districts'))
                    <div class="text-danger">
                        {{ $errors->first('districts') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please select a region
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="dob" class="form-label">Date of Birth(DOB)</label>
                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" placeholder="Enter dob" value="{{$particulars->dob ?? ''}}" required>
                @if ($errors->has('dob'))
                    <div class="text-danger">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter dob
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="phone" class="form-label">Entitled Amount</label>
                <input type="number" class="form-control @error('entitled_amount') is-invalid @enderror" id="entitled_amount" name="entitled_amount" placeholder="Enter Entitled Amount" value="{{$particulars->entitled_amount ?? ''}}" required>
                @if ($errors->has('entitled_amount'))
                    <div class="text-danger">
                        {{ $errors->first('entitled_amount') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Entitled Amount
                </div>
            </div>
        
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="units" class="form-label">Unit</label>
                <select class="form-control search-select" id="units" name="units" required>
                    <option value="" disabled selected>Select a unit</option>
                    @foreach($units as $unit) 
                        <option value="{{ $unit->id ?? '' }}" {{ (old('unit') == $unit->id || $particulars->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('units'))
                    <div class="text-danger">
                        {{ $errors->first('units') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please select a unit
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="designation" class="form-label">Designation</label>
                <select class="form-control search-select" id="designations" name="designations" required>
                    <option value="" disabled selected>Select a designation</option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->id ?? '' }}" {{ (old('designation') == $designation->id || $particulars->designation_id == $designation->id) ? 'selected' : '' }}>{{ $designation->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('designations'))
                    <div class="text-danger">
                        {{ $errors->first('designations') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please select a designations
                </div>
            </div>
        </div>
          
        <div class="mt-4 d-grid col-md-4"  style="margin-left: auto; margin-right: auto;">
            <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
</div>     
