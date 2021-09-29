<!doctype html>
<html lang="en">

<head>
    <title>Crud</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>CRUD</h2>
                <button type="button" class="btn btn-primary float-left mb-5" onclick="openform()"> <i
                        class="fas fa-plus"></i> Add</button>

                <table class="table  mt-6" id="mytable">
                    <thead>
                        <tr>

                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mtitle">Add new record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('savefrom') }}" id="usersform" autocomplete="off"
                        onsubmit="saveform();">
                        @csrf

                        <input type="hidden" name="id" value="" id="rid">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" aria-describedby="helpId"
                                placeholder="Enter name">
                            <span class="text-danger err" id="e-name"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" aria-describedby="helpId"
                                placeholder="Enter Email">
                            <span class="text-danger err" id="e-email"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="text" class="form-control" name="mobile" aria-describedby="helpId"
                                placeholder="Enter mobile">
                            <span class="text-danger err" id="e-mobile"></span>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="saveform();">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        function openform(data = null) {
            $("#usersform")[0].reset();
            if (data == null) {
                $("#mtitle").text('Add new record');
                $("#rid").val('');
            } else {
                $.each(data, function(i, f) {
                    $("#mtitle").text('Edit record');
                    $("#usersform input[name=" + i + "]").val(f);
                })
            }

            $("#modelId").modal("toggle");

        }

        function saveform() {
            $('.err').hide();
            var form = $("#usersform");
            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: form.serialize(),
                success: function(r) {

                    $("#modelId").modal("toggle");
                    form[0].reset();
                    loadtable();


                },
                error: function(dp) {
                    $.each(dp.responseJSON.errors, function(i, f) {
                        $("#e-" + i).show();
                        $("#e-" + i).text(f[0]);
                    })
                }
            });
        }
        var notloaded = 1;

        function loadtable() {

            if (notloaded) {
                $("#mytable").DataTable({
                    ajax: "{{ route('getrecords') }}",
                    columns: [{
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'mobile'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {

                                return `<button class='btn btn-danger btn-sm'onclick='editr(${data})'> <i class="far fa-edit"></i>Edit</button>
                                <button class='btn btn-danger btn-sm' onclick='delr(${data})' > <i class="fas fa-trash-alt"></i> Delete</button>`; 
                            },
                        },
                    ]
                });

                notloaded = 0;
            } else

                $("#mytable").DataTable().ajax.reload();
        }



        function delr(id) {
            $.get("{{ url('delete') }}/" + id);
            loadtable();
        }


        function editr(id) {
            $.get("{{ url('getrec') }}/" + id, function(r) {
                openform(r);
            });

        }
        window.onload = function() {
            loadtable();
        }
    </script>
</body>

</html>
