<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
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

<div id="alert"></div>
<div class="content-layer1">
    <div class="card">
        <div class="card-header">
           <small>Monthly Payment</small> 
        </div>
        <div class="card-body">
            <form id="month_payment" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="member"><small>Select Members</small></label>
                        <select class="form-control search-select" id="user_data" name="id" required>
                            <option value="" disabled selected></option>
                            @foreach($memberData as $data)
                                <option value="{{$data->id}}">{{ $data->firstname.' '.$data->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="document" class="form-label"><small>Upload Document</small></label>
                        <input type="file" class="form-control" id="1" name="document">
                        @if ($errors->has('document'))
                            <div class="text-danger">
                                {{ $errors->first('document') }}
                            </div>
                        @endif
                        <div class="invalid-feedback">
                            Please upload a document
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="paid_amount" class="form-label"><small>Amount (Tshs.)</small></label>
                        <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-md-6">
                        <label for="payment_method"><small>Payment Method</small></label>
                        <select class="form-control search-select" id="payment_method" name="payment_method" required>
                            <option value="" disabled selected></option>
                            @foreach($payment_methods as $methods)
                                <option value="{{$methods->id}}">{{ $methods->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" id="module_id" name="module_id" value="1">
                <input type="hidden" id="module_group_id" name="module_group_id" value="1">

                <div class="monthly_pay_butt">
                    <button type="submit" class="btn btn-success"><small>Submit</small></button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

            
<!-- CSRF token -->
@push('after-script-end')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    $(document).ready(function(){

       $('#month_payment').on('submit', function(e){
            e.preventDefault();

            var formData = new FormData(this);
            

            $.ajax({

                url: "{{ route('get_monthly_payments') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){

                    Swal.fire({
                    title: "Good job!",
                    text: "You successfully paid your monthly bill!",
                    icon: "success",
                
                    });

                    window.location.reload();

                },
                error: function(xhr,status,error){

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        
                        $('#alert').html('<div class="alert alert-danger">' + xhr.responseJSON.message + '</div>');
                    }
                    // if (xhr.responseJSON && xhr.responseJSON.message) {
                        
                    //     $('#alert').html('<div class="alert alert-danger">' + xhr.responseJSON.message + '</div>');
                    //  }
                    // Swal.fire({
                    //         title: "Error",
                    //         text: "An error occurred while processing your payment.",
                    //         icon: "error"
                    //     });                    
                    // console.error(xhr);
                    
                }
            });
       });


    });
</script>