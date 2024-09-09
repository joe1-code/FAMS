 <div class="row">

        <div class="container mt-5">
        <h2 class="mb-4">Non-Paid & Paid Members</h2>
        <table class="table table-bordered" id="non_paid_members">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Region</th>
                    <th>District</th>
                    <th>DOB</th>
                    <th>Phone</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

 <script type="text/javascript">

$(document).ready()
$(function () {

    var table = $('#non_paid_members').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_monthly_nonpaid') }}",
        columns: [
            { data: 'firstname', name: 'firstname' },
            { data: 'region', name: 'region' },
            { data: 'district', name: 'district' },
            { data: 'dob', name: 'dob' },
            { data: 'phone', name: 'phone' },
            { data: 'payment_status', name: 'payment_status', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']],
    });
});
 </script>
