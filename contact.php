<?php
include("includes/auth.php");

    include("includes/head.php");
    include("includes/navbar.php");
?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column gap-3">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form mb-3" placeholder="Search...">
                    </div>
                    
                    <div class="col-md-6">
                        <a href="addContact.php" class="btn btn-primary float-right">Add Contacs</a>
                    </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data will be injected here -->
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination" id="pagination">
                        <!-- Pagination links will be injected here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function deleteData(){
        $('.delete-btn').on('click', function() {
            var contactId = $(this).data('id');
            var isConfirmed = confirm('Are you sure you want to delete this contact?');
            
            if (isConfirmed) {
                // Create a form and submit it to delete.php
                var form = $('<form>', {
                    'method': 'post',
                    'action': 'delete.php'
                }).append($('<input>', {
                    'type': 'hidden',
                    'name': 'contact_id',
                    'value': contactId
                }));
                $('body').append(form);
                form.submit();
            }
        });
    }
   
    $(document).ready(function() {
        // delete Contact Confirmation 
        $(document).on('click','#deleteContactBtn', function() {
            var contactId = $(this).data('id');
            var isConfirmed = confirm('Are you sure you want to DELETE?');
            console.log(contactId)
            if (isConfirmed) {
                // Create a form and submit it to delete.php
                var form = $('<form>', {
                    'method': 'post',
                    'action': 'deleteContact.php'
                }).append($('<input>', {
                    'type': 'hidden',
                    'name': 'contact_id',
                    'value': contactId
                }));
                $('body').append(form);
                form.submit();
            }
        });

        function loadData(page = 1, search = '') {
            $.ajax({
                url: 'fetchData.php',
                type: 'GET',
                data: { page: page, search: search },
                success: function(response) {
                    const data = JSON.parse(response);
                    $('#tableBody').html(data.table);
                    $('#pagination').html(data.pagination);
                }
            });
        }

        // Initial data load
        loadData();

        // Search input event
        $('#searchInput').on('keyup', function() {
            const search = $(this).val();
            loadData(1, search);
        });

        // Pagination click event
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const search = $('#searchInput').val();
            loadData(page, search);
        });
    });
</script>

<?php
    include("includes/bottom.php");
?>
