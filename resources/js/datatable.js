// Import jQuery and DataTables
import $ from 'jquery';
import 'datatables.net-dt';

// Your DataTables initialization code
document.addEventListener('DOMContentLoaded', function() {

    var url = $('#non_paid_members').data('url');
    $('#non_paid_members').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,  
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
                    if (data === 'Paid') {
                        return '<span class="badge bg-success">Paid</span>';
                    } else if (data === 'Not Paid') {
                        return '<span class="badge bg-warning">Not Paid</span>';
                    } else {
                        return '<span class="badge bg-secondary">Unknown</span>';
                    }
                }
            }
        ],
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
    });
});
