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