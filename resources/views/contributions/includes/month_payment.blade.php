<div class="content-layer">
                        <form action="{{ route('get_monthly_payments') }}" method="post" enctype="multipart/form-data">
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
                    