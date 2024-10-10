
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .content-layer1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            background-color: #f7f7f7;
        }
        .card {
            width: 50%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
                background: linear-gradient(to right, #f5f5f5, #ffffff); /* Light smoke-like effect */
                color: black; /* Change text color to black for contrast */
                text-align: center;
                font-size: 1.25rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds some depth */
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .monthly_pay_butt {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="content-layer1">
    <div class="card">
        <div class="card-header">
           <small>Preview Payment Document</small> 
        </div>
        <div class="card-body">
            <form id="doc_view" method="get">
                @csrf
                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="member"><small>Select Members</small></label>
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
                    
                </div>

                <div class="form-group row">
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

                </div>

                <div class="monthly_preview_doc col-md-12 mt-3">
                    <button type="submit" class="btn btn-success">Preview Document</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

            
<!-- CSRF token -->

<!-- //<======================= -->
<div class="modal fade" id="monthly_doc_modal" tabindex="-1" role="dialog" aria-labelledby="monthly_doc_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Document Preview</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="document_frame"></div> <!-- This is where the document will be displayed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
    </div>
</div>
