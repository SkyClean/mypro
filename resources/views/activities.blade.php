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
                <h2>Activity Management</h2>
            </header>
            <div class="panel-body" id="pageDocument">
                <div class="row">
                    <div class="col-sm-9">
                      <h5 style="font-weight:bold">Activities</h5>
                    </div>
                    <div class="col-sm-3">
                      <form id="search-form" method="GET" action="">
      								<div class="input-group input-search">
      									<input type="text" class="form-control" name="query" id="query" placeholder="Search..." value="{{$search}}">
      									<span class="input-group-btn">
      										<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
      									</span>
      								</div>
                     </form>
      							</div>
                </div>
                <div class="row" style="padding-top:10px;">
                <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>SERVER</th>
                        <th>DESCRIPTION</th>
                        <th>CREATED_AT</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($activities) > 0)
                    @foreach ($activities as $item)
                        <tr id="{{$item->id}}">
                            <td>{{$item->name}}</td>
                            <td>{{$item->server}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                {{ $activities->links() }}
                </div>
            </div>
        </section>
    <script>

</script>
@endsection
