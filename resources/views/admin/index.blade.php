@extends('layouts.app')

@section('title', '| Admin User Index')

@section('header')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-10 offset-md-1">
		<div class="paginate-bar">
			<a id="paginate-left" href="#">◀</a><input type="text" id="paginate-number" width="20" value="1"><a id="paginate-right" href="#">▶</a>
		</div>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th>Email</th>
				<th>Roles</th>
				<th>Created</th>
				<th></th>
			</thead>
			<tbody id="tBody">

			</tbody>
		</table>
	</div>
</div>

<!-- Modal Body -->
<div class="modal fade" id="adminModalCenter" tabindex="-1" role="dialog" aria-labelledby="adminModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="adminModalCenterTitle">Edit User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{ Form::text('name', null, ["class"=>'form-control form-control-lg', 'id'=>'modal-name']) }}
				<hr>
				<select name="roles[]" id="select-roles" multiple="multiple" style="width: 100%;">
					@foreach($roles as $role)
						<option value="{{ $role->id }}">{{ $role->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="save-user">Save</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
let userId = <?php echo Auth::user()->id ?>;
let editUserId, editUserRoles, editUserName;
let roles = <?php echo json_encode($roles) ?>;
let users = <?php echo json_encode($users) ?>;

$(document).ready(function(){
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	});

	$('#paginate-left')[0].onclick = function(){
		let pagNr = $('#paginate-number');
		pagNr.val((parseInt(pagNr.val())-1)||1);
		refreshIndex();
	}
	$('#paginate-right')[0].onclick = function(){
		let pagNr = $('#paginate-number');
		pagNr.val(parseInt(pagNr.val())+1);
		refreshIndex();
	}

	$('#paginate-number')[0].onkeydown = function(e) {
		if (e.keyCode == 13){
			e.preventDefault();
			refreshIndex();
		}
	};
	
	$('#select-roles').select2({
    placeholder: "Select a state"
	});

	$('#save-user').click(null, function(){
		
		let arr = [];
		for (let i of $('#select-roles').select2('data')){
			arr.push(i.id)
		}

		$.ajax({
			url: `/admin/`+editUserId,
			method: 'put',
			data: {
				roles: arr,
				name: $('#modal-name').val(),
			},
			success: function(result){
				refreshIndex();
			},
			error: function(jqxhr, status, exception) {
				console.log('Exception:', exception);
				console.log(status);
				console.log(jqxhr);
			}
		})
	})

	refreshIndex();
});

function clickEdit (e) {
	for (let i of users){
		if (i.id == e){
			console.log(i);
			let arr = [];
			for (let j of i.roles){
				arr.push(j.id);
			}
			console.log(arr);
			editUserId = i.id;
			$('#select-roles').val(arr).trigger('change');
			$('#modal-name')[0].value = i.name;
			return;
		}
	}
}

function refreshIndex () {
	let pageNr = $('#paginate-number')[0].value;
	$.ajax({
		url: `/adminajax?page=${pageNr}`,
		success: function (result) {

			users = result;

			let tBodyString = ``;

			for (let user of result){
				tBodyString += `
					<tr>
						<td>${user.id}</td>
						<td>${user.name}</td>
						<td>${user.email}</td>
						<td>
							<p class="tooltip-1">`;

				for (let role of user.roles) {
					tBodyString += `<span class="role-list-item">${role.name}</span> `
				}
				tBodyString += `
							</p>
						</td>
						<td>${user.created_at}</td>
						<td>
							<button type="button" class="modal-button" data-toggle="modal" data-target="#adminModalCenter" data-user-id="${user.id}" onclick=clickEdit(${user.id})>
								<i class="fas fa-pencil-alt"></i>
							</button>
						</td>
					</tr>
				`;
				$('#tBody').html(tBodyString);
			}

		}
	})
}

</script>
@endsection