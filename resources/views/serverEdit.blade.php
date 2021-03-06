<?php
/******************************************************
 * IM - Vocabulary Builder
 * Version : 1.0.2
 * Copyright© 2016 Imprevo Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:http://imprevo.net
 ******************************************************/
?>

@extends('layouts.app0')
@section('content')

	<section role="main" class="content-body">

		<header class="page-header">
			<h2>
				Server management
			</h2>
		</header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						@if($server['id'])
							<h2 class="panel-title">Edit server</h2>
						@else
							<h2 class="panel-title">Add new server</h2>
						@endif
					</header>
					<div class="panel-body">
						<form id="form" role="form" class="form-horizontal form-bordered" action="/server" method="post">
							@if($server['id'])
								<input type="hidden" name="id" value="{{$server->id}}">
							@endif
							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="name">Server Name <span class="required">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="name" name="name" required value="{{$server['name']}}"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="host">Host</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="host" name="host" value="{{$server['host']}}">
								</div>
							</div>

              <div class="form-group">
								<label class="col-md-3 control-label label-left" for="username">Username</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="username" name="username" value="{{$server['username']}}">
								</div>
							</div>

							@if($server['id'])
							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="isResetPassword">Reset password?</label>
								<div class="col-md-6">
									<div class="switch switch-primary">
										<input type="checkbox" id="isResetPassword" name="isResetPassword" onchange="Resetpassword()" value='0' data-plugin-ios-switch />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="password">Password<span class="required">*</span></label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="reset_password" name="reset_password" disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="passwordConfirm">Confirm password<span class="required">*</span></label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="reset_password_confirm" name="reset_password_confirm" disabled>
								</div>
							</div>
							@else
							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="password">Password<span class="required">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="password" name="password">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="passwordConfirm">Confirm password<span class="required">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="password_confirm" name="password_confirm">
								</div>
							</div>
							@endif

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="save"></label>
								<div class="col-md-6">
									<button type="button" class="btn btn-primary" style="width:120px" onclick="Save()">Save</button>
								</div>
							</div>
						</form>
					</div>
				</section>
			</div>
		</div>
	</section>
	<script type="text/javascript">
  $(function(){
    $("#form").validate({
      rules: {
        password: "required",
        passwordConfirm: {
          equalTo: "#password"
        }
      },
      highlight: function( label ) {
        $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function( label ) {
        $(label).closest('.form-group').removeClass('has-error');
        label.remove();
      },
      errorPlacement: function( error, element ) {
        var placement = element.closest('.input-group');
        if (!placement.get(0)) {
          placement = element;
        }
        if (error.text() !== '') {
          placement.after(error);
        }
      }
    });
  });

  function Save(){
    var isReset = document.getElementById('isResetPassword');

    if (isReset && isReset.checked)
    {
      resetpassword = document.getElementById('reset_password').value;
      reset_password_confirm = document.getElementById('reset_password_confirm').value;

      bvalidation = false;
      if (resetpassword.length > 5 && reset_password_confirm.length > 5)
      {
        if (resetpassword == reset_password_confirm)
        {
          bvalidation = true;
        }
      }
      if (!bvalidation)
      {
        new PNotify({
          text: 'please check reset password fields again. (len > 5, equal)',
          type: 'error',
          icon: false,
          addclass: 'ui-pnotify-no-icon',
        });
        return;
      }
    }
    $('#form').submit();
  }

  function Resetpassword(){
    value = document.getElementById('isResetPassword').checked;
    if (value == true)
    {
      document.getElementById('reset_password').disabled = false;
      document.getElementById('reset_password_confirm').disabled = false;
      document.getElementById('isResetPassword').value = 1;
    }
    else
    {
      document.getElementById('reset_password').disabled = true;
      document.getElementById('reset_password_confirm').disabled = true;
      document.getElementById('isResetPassword').value = 0;
    }
  }
	</script>
@endsection
