@extends('master')

@push('add_modal')
{{-- add new employee modal start --}}
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_company_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="name">Company Name</label>
              <input type="text" name="name" class="form-control" placeholder="Company Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" placeholder="Address" required>
          </div>

          <div class="my-2">
            <label for="avatar">Select Logo</label>
            <input type="file" name="logo" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_company_btn" class="btn btn-primary">Save Company</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new employee modal end --}}

{{-- edit employee modal start --}}
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="comp_id" id="comp_id">
        <input type="hidden" name="comp_logo" id="comp_logo">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="name">Company Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Company Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="Phone" required>
          </div>

          <div class="my-2">
            <label for="logo">Select Logo</label>
            <input type="file" name="logo" class="form-control">
          </div>
          <div class="mt-2" id="logo">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Compnay</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}
@endpush

@section('content')
    <div class="row my-5">
        <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Company</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addCompanyModal"><i
                class="bi-plus-circle me-2"></i>Add New Compnay</button>
            </div>
            <div class="card-body" id="show_all_companies">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
        </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function() {

      // add new employee ajax request
      $("#add_company_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_company_btn").text('Adding...');
        $.ajax({
          url: '{{ route('save_company') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Company Added Successfully!',
                'success'
              )
              fetchAllCompany();
            }
            $("#add_company_btn").text('Add Company');
            $("#add_company_form")[0].reset();
            $("#addCompanyModal").modal('hide');
          }
        });
      });

      // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('comp_edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#name").val(response.name);
            // $("#lname").val(response.last_name);
            $("#email").val(response.email);
            $("#address").val(response.address);
            // $("#post").val(response.post);
            $("#logo").html(
              `<img src="storage/images/${response.logo}" width="100" class="img-fluid img-thumbnail">`);
            $("#comp_id").val(response.id);
            $("#comp_logo").val(response.logo);
          }
        });
      });

      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_employee_btn").text('Updating...');
        $.ajax({
          url: '{{ route('comp_update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Employee Updated Successfully!',
                'success'
              )
              fetchAllCompany();
            }
            $("#edit_employee_btn").text('Update Employee');
            $("#edit_employee_form")[0].reset();
            $("#editEmployeeModal").modal('hide');
          }
        });
      });

      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('comp_delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllCompany();
              }
            });
          }
        })
      });

      // fetch all employees ajax request
      fetchAllCompany();

      function fetchAllCompany() {
        $.ajax({
          url: '{{ route('comp_fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_companies").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
@endpush
