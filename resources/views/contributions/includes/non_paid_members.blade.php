
<!-- Table HTML -->
 <style>
    .dataTables_filter {
    float: right; 
}

.dataTables_paginate {
    float: right;
}

 </style>
<!-- @section('page-specific-styles') -->
<link rel="stylesheet" href="{{ asset('dist-assets/css/plugins/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('dist-assets/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('dist-assets/css/select2bs5.min.css') }}" />
<!-- @endsection -->

<div class="row mb-10" id="check">
        <div class="col-md-12 mb-4">
            <div class="card text-start" id="dt">
                <div class="card-body">
                    <h4 class="card-title mb-3">Paid & Non-paid Members</h4>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="non_paid_members"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="25%">Name</th>
                                    <th width="15%">Region</th>
                                    <th width="15%">District</th>
                                    <th width="15%">DOB</th>
                                    <th width="15%">Phone</th>
                                    <th width="15%">Payment Status</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Region</th>
                                    <th>District</th>
                                    <th>DOB</th>
                                    <th>Phone</th>
                                    <th>Payment Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="{{ asset('dist-assets/js/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('dist-assets/js/scripts/datatables.script.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {

        
        $('#non_paid_members').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_monthly_nonpaid') }}",
            columns: [
                { data: 'fullname', name: 'fullname' },
                { data: 'region', name: 'region' },
                { data: 'district', name: 'district' },
                { data: 'dob', name: 'dob' },
                { data: 'phone', name: 'phone' },
                {
                    data: 'pay_status',
                    name: 'pay_status',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data === 'Paid' ? 
                            '<span class="badge bg-success">Paid</span>' : 
                            '<span class="badge bg-warning">Not Paid</span>';
                    }
                }
            ],
            success: function(response){
                console.log(response);
                
            },
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-end"f><"table-responsive"t><"d-flex justify-content-end"ip>',
            // dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            lengthMenu: [10, 25, 50, 100],
            pageLength: 10,
            responsive: true // Enable responsive feature
        });
    });
</script>

