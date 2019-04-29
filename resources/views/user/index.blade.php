@extends('layouts.app')


@section('title', '| User Interface | '.Auth::user()->name)


@section('header')
<style>
	body {
		color: var(--main-color-dark);
	}
	div>nav {
		padding: 6px;
		border-bottom: 1px solid var(--main-color-med);
	}
	div>.main {
		padding: 1rem;
	}
	input {
		background: unset;
		border: unset;
		border-bottom: 1px solid var(--main-color-med);
		background-color: white;
		margin-left: 1rem;
		transition: box-shadow 0.2s ease-in;
		padding: 4px;
	}
	input:focus {
		box-shadow: 0 0 .5rem .2rem var(--main-color-med) !important;
	}
	input.invalid {
		background-color: #f99 !important;
	}
	input.invalid:focus {
		box-shadow: 0 0 .5rem .2rem #f99 !important;
	}
	input[name="password_old"] {
		margin-bottom: .5rem;
	}
	button {
		transition: color 0.2s, background-color 0.2s;
	}
	label {
		margin-top: 4px;
	}
	#container {
		border-top: 2px solid var(--main-color-dark);
		border-left: 2px solid var(--main-color-dark);
		border-right: 2px solid var(--main-color-med);
		border-bottom: 2px solid var(--main-color-med);
		background-color: var(--main-color-light);
		border-radius: 1rem;
		
	}
	.row {
		padding: 1rem;
	}
	#submit-changes-message {
		margin-top: 1rem;
		border-radius: 6px;
		text-align: center;
		background-color: white;
		color: black;
		border: 1px solid var(--main-color-med);
	}
	#submit-changes-pw {
		margin-top: 1rem;
	}
	.input-feedback {
		color: red;
		border: solid 1px red;
		margin-top: 4px;
		background-color: #f99;
		width: auto;
	}
</style>
@endsection


@section('content')
<div class="row">
	<div class="col-md-10 offset-md-1" id="container">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" data-window="info" href="#personal-information">Gebruikersinformatie <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" data-window="password" href="#password-change">Verander Paswoord</a>
				</div>
			</div>
		</nav>

		<div class="row">
			<div class="col-md-4" id="personal-information"><h4>Uw naam</h4></div>
			<div class="col-md-8">
				<label for="name">Naam:</label><br>
				<input placeholder="John Doe" type="text" name="name" value="{{ $user->name }}" pattern="[ a-zA-Z]+" title="Naam: alleen letters en nummers">
				<p id="input-name-feedback" hidden class="input-feedback">Naam: alleen letters en nummers</p><br>
				<label for="email">Email:</label><br>
				<input placeholder="John Doe" type="text" name="email" value="{{ $user->email }}" disabled><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"><h4>Uw Gravatar afbeelding</h4><p>deze afbeelding hoort bij uw email en kan u op de Gravatar website instellen. Per default wordt een willekeurige afbeelding geselecteerd</p></div>
			<div class="col-md-8">
				<label for="gravatar-picture"><a href="https://www.gravatar.com/">Gravatar</a> profiel afbeelding</label><br>
				<img src="https://www.gravatar.com/avatar/{{ md5( strtolower( trim( "$user->email" ) ) ) }}?d=identicon" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"><h4>Uw rollen</h4><p>U hebt deze rollen gekregen van een Admin. Admins kunnen u rollen toe en ontkennen via de admin interface.</p></div>
			<div class="col-md-8">
				<p>
				@foreach($roles as $role)
					<span class="role-list-item">{{$role->name}}</span>
				@endforeach
			</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"><h4>Uw adres informatie</h4></div>
			<div class="col-md-8">
				<label for="street">Adres:</label><br>
				<input placeholder="Hoofdstraat" type="text" name="street" value="{{ $user->street }}" pattern="[ a-zA-Z]+" title="Adres: alleen letters en spaties"> Huis Nr:<input placeholder="999" type="text" name="streetnr" class="col-sm-1" value="{{ $user->streetnr }}" pattern="[0-9]+" title="Adres Nr: alleen nummers"><br>
				<p id="input-street-feedback" hidden class="input-feedback">Adres: alleen letters en spaties</p><p id=input-streetnr-feedback>Adres Nr: alleen nummers</p>
				<label for="city">Stad:</label><br>
				<input placeholder="Amsterdam" type="text" name="city" value="{{ $user->city }}" pattern="[ a-zA-Z]+" title="Adres: alleen letters en spaties">
				<p id="input-city-feedback" hidden class="input-feedback">Adres: alleen letters en spaties</p><br>
				<label for="province">Provincie:</label><br>
				<input placeholder="Noord Holland" type="text" name="province" value="{{ $user->province }}" pattern="[ a-zA-Z]+" title="Provincie: alleen letters en spaties">
				<p id="input-province-feedback" hidden class="input-feedback">Provincie: alleen letters en spaties</p><br>
				<label for="country">Land:</label><br>
				<input placeholder="Nederland" type="text" name="country" value="{{ $user->country }}" pattern="[ a-zA-Z]+" title="Land: alleen letters en spaties">
				<p id="input-country-feedback" hidden class="input-feedback">Land: alleen letters en spaties</p><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"><h4>Uw telefoon nrs</h4></div>
			<div class="col-md-8">
				<label for="country">Telefoon nr 1:</label><br>
				<input placeholder="06-12345678" type="text" name="telephone1" value="{{ $user->telephone1 }}" pattern="[\-0-9]+" title="TelefoonNr: alleen nummers en -">
				<p id="input-telephone1-feedback" hidden class="input-feedback">Alleen nummers en '-'</p><br>
				<label for="country">Telefoon nr 2:</label><br>
				<input placeholder="030-6543210" type="text" name="telephone2" value="{{ $user->telephone2 }}" pattern="[\-0-9]+" title="TelefoonNr: alleen nummers en -">
				<p id="input-telephone2-feedback" hidden class="input-feedback">Alleen nummers en '-'</p>
			</div>
		</div>
		<br>
		<button id="submit-changes-nonpw" type="button" class="btn btn-dark col-md-4 offset-md-4" style="">Profiel Bijwerken</button>
		<h5 id="submit-changes-message" hidden>Gebruiker opgeslagen</h5>

		<div class="row">
			<div class="col-md-4"><h4 id="password-change">Paswoord Veranderen</h4></div>
			<div class="col-md-8">
				<input placeholder="huidig paswoord" type="password" name="password_old" value="" pattern=".{8,128}" title="Paswoord: tussen 8 en 128 karakters"><br><br>
				<input placeholder="paswoord" type="password" name="password" value="" pattern=".{8,128}" title="Paswoord: tussen 8 en 128 karakters">
				<input placeholder="paswoord opnieuw" type="password" name="password_confirmation" value="" pattern=".{8,128}" title="Paswoord: tussen 8 en 128 karakters">
				<p id="input-password-feedback" hidden class="input-feedback">Paswoorden komen niet overeen</p>
			</div>
		<button id="submit-changes-pw" type="button" class="btn btn-dark col-md-4 offset-md-4" style="">Paswoord opslaan</button>
		</div>
		<br>
			
	</div>
</div>
@endsection


@section('footer')
<script>

	
jQuery(document).ready(function(){

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	});

	// for (let i of $('.input-feedback')){
	// 	i.hidden = true;
	// }
	$('#submit-changes-nonpw')[0].onclick = function(e){
		e.preventDefault();

		
		let url = "/user/"+{{ Auth::user()->id }};
		$.ajax({
			url: url, //atn hackers: this id is compared to the logged in user id serverside via the tokens
			method: 'patch',
			data: {
				req:				1,
				name: 			$('input[name="name"]').val(),
				street: 		$('input[name="street"]').val(),
				streetnr: 	$('input[name="streetnr"]').val(),
				city: 			$('input[name="city"]').val(),
				province: 	$('input[name="province"]').val(),
				country: 		$('input[name="country"]').val(),
				telephone1: $('input[name="telephone1"]').val(),
				telephone2: $('input[name="telephone2"]').val()
			},
			success: function(result){
				console.log(result);
				for (let i of $('input')){
					i.classList.remove('invalid');
				}

				for (let i of $('.input-feedback')){
					i.hidden = true;
				}


				$('#submit-changes-message')[0].hidden = false;
				setInterval(() => {
					$('#submit-changes-message')[0].hidden = true;
				}, 5e3);
			},
			error: function(jqxhr, status, exception) {
				if (jqxhr.status == 422){
					//invalid data was passed and didn't get through backend validation
					//so now we give feedback in the form showing which fields are invalid.
					for (let i of $('input')){
						i.classList.remove('invalid');
					}
					for (let i of $('.input-feedback')){
						i.hidden = true;
					}
					let errors = jqxhr.responseJSON.errors;
					for (let i in errors){
						$(`input[name="${i}"]`)[0].classList.add('invalid');
						$(`#input-${i}-feedback`)[0].hidden = false;
					}
				}
				console.log(jqxhr);
				console.log(exception);
				console.log(status);
			}
		});
	};
	$('#submit-changes-pw')[0].onclick = function(e){
		e.preventDefault();
		let url = "/user/"+{{ Auth::user()->id }};
		$.ajax({
			url: url, //atn hackers: this id is compared to the logged in user id serverside via the tokens
			method: 'patch',
			data: {
				req:										2,
				password_old: 					$('input[name="password_old"]').val(),
				password: 							$('input[name="password"]').val(),
				password_confirmation: 	$('input[name="password_confirmation"]').val(),
			},
			success: function(result){
				console.log(result);
				let inputPwFb = $('#input-password-feedback')[0];
				if (result.failure) {
					inputPwFb.innerHTML = result.message;
					inputPwFb.hidden = false;
					setInterval(() => {
						inputPwFb.hidden = true
					;}, 15e3);
				}
			},
			error: function(jqxhr, status, exception) {
				console.log(jqxhr);
				console.log(exception);
				console.log(status);
			}
		});
	};
});
</script>
@endsection