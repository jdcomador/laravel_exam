<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title> Laravel Exam </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container mt-5">
            <div class="col-12 text-right mb-2">
                <button type="button" id="add" class="btn btn-success show-modal" data-toggle="modal" data-target="#employee_details">Add Employee</button>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Employee Name</td>
                            <td>Employee Address</td>
                            <td>Contact No</td>
                            <td>Company</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{$employee->e_name}}</td>
                            <td>{{$employee->e_address}}</td>
                            <td>{{$employee->e_contact}}</td>
                            <td value="{{$employee->c_id}}">{{$employee->c_name}}</td>
                            <td>
                                <button type="button" class="btn btn-primary edit" name="edit" value="{{$employee->id}}"> Edit </button>
                                <button type="button" class="btn btn-danger delete" name="delete" data-toggle="modal" data-target="#delete_employee" value="{{$employee->id}}"> Delete </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="employee_details" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Employee Details</h5><button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <input type="hidden" name="id" id="id" value="" autocomplete="off">
                    <div class="modal-body">
                        <div class="errors text-danger">

                        </div>
                        <div class="form-group">
                            <label for="e_name">Employee Name: </label>
                            <input type="text" id="e_name" name="e_name" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="e_address">Employee Address: </label>
                            <input type="text" id="e_address" name="e_address" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="e_contact">Contact No: </label>
                            <input type="text" id="e_contact" name="e_contact" class="form-control" autocomplete="off">
                        </div>                        
                        <div class="form-group">
                            <label for="company">Company Name: </label>
                            <select type="text" id="company" name="company" class="form-control">
                                <option value=""></option>
                                @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->c_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary modal-close"
                            data-dismiss="modal">Close</button>
                        <input type="submit" id="submit" class="btn btn-primary" value="Save">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete_employee" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <h5>Are you sure?</h5>
                    <input type="hidden" name="delete_id" id="delete_id" value="" autocomplete="off">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-close"
                        data-dismiss="modal">No</button>
                    <input type="submit" id="confirm_delete" class="btn btn-primary" value="Yes">
                </div>
            </div>
        </div>
        </div>
        <script>
            $('#add').click(function(){
                $('#id').val('');
                $('#e_name').val('');
                $('#e_address').val('');
                $('#e_contact').val('');
                $('#company').val('');
            });

            $('#submit').click(function(){
                var id = $('#id').val();
                    e_name = $('#e_name').val(),
                    e_address = $('#e_address').val(),
                    e_contact = $('#e_contact').val(),
                    company = $('#company').val();
                    
                if(id != 0) {
                    var url = '/employee/update';
                } else {
                    var url = '/employee';
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': id,
                        'name': e_name,
                        'address': e_address,
                        'contact': e_contact,
                        'company': company,
                    },
                    error: function (xhr) {
                        $('.errors').empty();
                        var errors = xhr.responseJSON.errors;
                        var logs = "";
                        console.log(errors);
                        $.each(errors, function(key, val){
                            logs += '<p>'+val+'</p>';
                        });
                        $('.errors').append(logs);
                    },
                    success: function(res){
                        window.location=res.url;
                    }
                });
            });

            $('.edit').click(function(){
                var id = $(this).val();
                $.ajax({
                    type: 'PUT',
                    url: '/employee/'+id,
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                    },
                    success: function(data){
                        $('#id').val(id),
                        $('#e_name').val(data[0].e_name);
                        $('#e_address').val(data[0].e_address);
                        $('#e_contact').val(data[0].e_contact);
                        $('#company').val(data[0].c_id);

                        $('#employee_details').modal('show');
                    }
                });
            });
            
            $('.delete').click(function(){
                var id = $(this).val();
                $("#delete_id").val(id);
            });

            $('#confirm_delete').click(function(){
                var id = $("#delete_id").val();

                $.ajax({
                    type: 'POST',
                    url: '/employee/delete',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': id,
                    },
                    success: function(res){
                        window.location=res.url;
                    }
                });
            });
        </script>
    </body>
</html>