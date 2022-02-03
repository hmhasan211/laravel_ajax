@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="alertSuccess" class="alert alert-success ">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">*</a>
                <strong id="msg"></strong>
            </div>
            <div id="alertDanger" class="alert alert-danger ">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">*</a>
                <strong id="dangerMsg"></strong>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3> Entry List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Name</th>
                                <th>Designition</th>
                                <th>Institute</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 id="add"> Add New</h3>
                    <h3 id="upd">Update </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span id="nerror" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Designition</label>
                        <input type="text" id="desi" name="desi" class="form-control">
                        <span id="derror" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Institute</label>
                        <input type="text" id="inst" name="inst" class="form-control">
                        <span id="insterror" class="text-danger"></span>
                    </div>
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <button id="subbtn" type="submit" onclick="saveData()" class="btn btn-block btn-primary">Submit</button>
                        <button id="updbtn" type="submit" onclick="updateData()" class="btn btn-block btn-warning">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#upd').hide();
    $('#updbtn').hide();
    $('#alertSuccess').hide();
    $('#alertDanger').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    // ------------- start get data -------------//
    function getData() {
        $.ajax({
            type: "GET",
            data: "json",
            url: "get/alldata",
            success: function(res) {
                var data = '';
                $.each(res, function(key, value) {
                    // console.log(value)
                    data += "<tr>"
                    data += "<td>" + value.id + "</td>"
                    data += "<td>" + value.name + "</td>"
                    data += "<td>" + value.desi + "</td>"
                    data += "<td>" + value.inst + "</td>"
                    data += "<td>" + '<button class="btn btn-sm btn-info mr-2" onclick="editData(' + value.id + ')">Edit</button>' + "</td"
                    data += "<td>" + '<button class="btn btn-sm btn-danger" onclick="deleteData(' + value.id + ')" >Del</button>' + "</td"
                    // data += "</td>"
                    data += "</tr>"
                })
                $('tbody').html(data);
            }
        })
    }
    getData();
    // ------------- end get data -------------//




    // ------------- start clear data -------------//
    function clearData() {
        $('#name').val('');
        $('#desi').val('');
        $('#inst').val('');
        $('#nerror').text('');
        $('#derror').text('');
        $('#insterror').text('');
    }
    // ------------- end clear data -------------//



    // ------------- start store -------------//
    function saveData() {
        var name = $('#name').val();
        var desi = $('#desi').val();
        var inst = $('#inst').val();

        $.ajax({
            url: "/save/data/",
            type: "post",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                desi: desi,
                inst: inst
            },
            success: function(res) {
                clearData();
                getData();
                $('#alertSuccess').show();
                $('#msg').text('Data Added Succesfully!!');
                $('#alertSuccess').hide(3000);
            },
            error: function(error) {
                $('#nerror').text(error.responseJSON.errors.name);
                $('#derror').text(error.responseJSON.errors.desi);
                $('#insterror').text(error.responseJSON.errors.inst);
            }
        })
    }
    // ------------- end store -------------//



    // ------------- start edit -------------//

    function editData(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/edit/data/" + id,
            success: function(res) {
                // console.log(res);
                $('#upd').show();
                $('#updbtn').show();
                $('#add').hide();
                $('#subbtn').hide();

                $('#id').val(res.id);
                $('#name').val(res.name);
                $('#desi').val(res.desi);
                $('#inst').val(res.inst);
            }
        })
    }

    // ------------- end edit -------------//




    // ------------- start update -------------//

    function updateData() {
        var name = $('#name').val();
        var desi = $('#desi').val();
        var inst = $('#inst').val();
        var id = $('#id').val();

        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                desi: desi,
                inst: inst
            },
            url: "/update/data/" + id,
            success: function(res) {
                clearData();
                getData();
                $('#alertSuccess').show();
                $('#msg').text('Data Updatee Succesfully!!');
                $('#alertSuccess').hide(3000);
                $('#upd').hide();
                $('#updbtn').hide();
                $('#add').show();
                $('#subbtn').show();
            },
            error: function(error) {
                $('#nerror').text(error.responseJSON.errors.name);
                $('#derror').text(error.responseJSON.errors.desi);
                $('#insterror').text(error.responseJSON.errors.inst);
            }
        })
    }

    // ------------- end update -------------//


    // ------------- Start delete-------------//

    function deleteData(id){
        $.ajax({
            type: "get",
            url: "/delete/data/"+id,
            dataType:'JSON',
            success: function(res){
                getData();
                $('#alertDanger').show();
                $('#dangerMsg').text('Data has been Deleted!!');
                $('#alertDanger').hide(3000);
                
            }
            
        })
    }
    // ------------- end delete -------------//
</script>
@endsection