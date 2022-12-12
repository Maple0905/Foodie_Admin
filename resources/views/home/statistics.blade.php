@extends('layouts.app')

<?php
error_reporting(E_ALL ^ E_NOTICE);
$zero = 0;
?>

@section('content')
    <div id="main-wrapper" class="page-wrapper" style="min-height: 207px;">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.statistics')}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.statistics')}}</li>
                </ol>
            </div>
            <div></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.statistics_general')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div id="users-table_filter" class="pull-right">
                                <label>{{trans('lang.search_by')}}</label>
                                <select name="selected_search" id="selected_search" class="form-control input-sm">
                                    <option value="title">{{trans('lang.title')}}</option>
                                </select>
                                <div class="form-group">
                                    <input type="search" id="search" class="search form-control" placeholder="Search">
                                    <button onclick="searchtext();" class="btn btn-warning btn-flat">{{trans('lang.search')}}</button>
                                    <button onclick="searchclear();" class="btn btn-warning btn-flat">{{trans('lang.clear')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table id="example24" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.area_name')}}</th>
                                        <th>{{trans('lang.area_admin_name')}}</th>
                                        <th>{{trans('lang.added_restaurants')}}</th>
                                        <th>{{trans('lang.added_drivers')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="table_general">
                                @if(auth()->user()->role == trans('lang.role_super'))
                                    @foreach($area_admins as $area_admin)
                                        <tr>
                                            <td>{{$area_admin->area_name}}</td>
                                            <td>{{$area_admin->area_admin_name}}</td>
                                            <td id="added_restaurant"></td>
                                            <td id="added_driver"></td>
                                        </tr>
                                    @endforeach
                                @elseif(auth()->user()->role == trans('lang.role_area'))
                                    <tr>
                                        <td>{{$area_admins->area_name}}</td>
                                        <td>{{$area_admins->area_admin_name}}</td>
                                        <td id="added_restaurant">0</td>
                                        <td id="added_driver">0</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="data-table_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item ">
                                            <a class="page-link" href="javascript:void(0);" id="users_table_previous_btn"
                                               onclick="prev()" data-dt-idx="0" tabindex="0">
                                                {{trans('lang.previous')}}
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                               onclick="next()" data-dt-idx="2" tabindex="0">
                                                {{trans('lang.next')}}
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.statistics_restaurant')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div id="users-table_filter" class="pull-right">
                                <label>{{trans('lang.search_by')}}</label>
                                <select name="selected_search" id="selected_search" class="form-control input-sm">
                                    <option value="title">{{trans('lang.title')}}</option>
                                </select>
                                <div class="form-group">
                                    <input type="search" id="search" class="search form-control" placeholder="Search">
                                    <button onclick="searchtext();" class="btn btn-warning btn-flat">{{trans('lang.search')}}</button>
                                    <button onclick="searchclear();" class="btn btn-warning btn-flat">{{trans('lang.clear')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table id="example24" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td>{{trans('lang.area_name')}}</td>
                                        <td>{{trans('lang.admin_name')}}</td>
                                        <td>{{trans('lang.statistics_restaurant_name')}}</td>
                                        <td># {{trans('lang.tab_orders')}}</td>
                                        <td>$ {{trans('lang.tab_orders')}}</td>
                                        <td>{{trans('lang.statistics_super_commission')}}</td>
                                        <td>{{trans('lang.statistics_area_commission')}}</td>
                                        <td>{{trans('lang.statistics_total_pay')}}</td>
                                        <td>{{trans('lang.payment_plural')}}</td>
                                        <td>{{trans('lang.statistics_remaining_payments')}}</td>
                                    </tr>
                                </thead>
                                <tbody id="table_restaurants">
                                </tbody>
                            </table>
                            <div class="data-table_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item ">
                                            <a class="page-link" href="javascript:void(0);"
                                               id="users_table_previous_btn" onclick="prev()" data-dt-idx="0"
                                               tabindex="0">{{trans('lang.previous')}}</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                               onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.statistics_driver')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div id="users-table_filter" class="pull-right">
                                <label>{{trans('lang.search_by')}}</label>
                                <select name="selected_search" id="selected_search" class="form-control input-sm">
                                    <option value="title">{{trans('lang.title')}}</option>
                                </select>
                                <div class="form-group">
                                    <input type="search" id="search" class="search form-control" placeholder="Search">
                                    <button onclick="searchtext();" class="btn btn-warning btn-flat">{{trans('lang.search')}}</button>
                                    <button onclick="searchclear();" class="btn btn-warning btn-flat">{{trans('lang.clear')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table id="example24" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <td>{{trans('lang.area_name')}}</td>
                                    <td>{{trans('lang.admin_name')}}</td>
                                    <td>{{trans('lang.statistics_driver_name')}}</td>
                                    <td># {{trans('lang.tab_orders')}}</td>
                                    <td>$ {{trans('lang.tab_orders')}}</td>
                                    <td>{{trans('lang.statistics_super_commission')}}</td>
                                    <td>{{trans('lang.statistics_area_commission')}}</td>
                                    <td>{{trans('lang.statistics_total_pay')}}</td>
                                    <td>{{trans('lang.payment_plural')}}</td>
                                    <td>{{trans('lang.statistics_remaining_payments')}}</td>
                                </tr>
                                </thead>
                                <tbody id="append_restaurants">
                                </tbody>
                            </table>
                            <div class="data-table_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item ">
                                            <a class="page-link" href="javascript:void(0);"
                                               id="users_table_previous_btn" onclick="prev()" data-dt-idx="0"
                                               tabindex="0">{{trans('lang.previous')}}</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                               onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>

    var area_admins = <?php echo $area_admins; ?>;
    var general_added_res_total = 0, general_added_driver_total = 0;
    var general_added_res_counts = Array(area_admins.length).fill(0);
    var general_added_driver_counts = Array(area_admins.length).fill(0);

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];
    var table_general = '';

    function getResData(id) {
        return database.collection('vendors').where("admin_id", "==", parseInt(id));
    }

    function getDriverData(id) {
        return database.collection('users').where("role", "==", "driver").where("admin_id", "==", parseInt(id));
    }

    $(document).ready(function () {

        // jQuery("#data-table_processing").show();

        // table_general = document.getElementById('table_general');
        // table_general.innerHTML = getGeneralData();
    })

    async function getGeneralData() {
        var html = '', i;
        // debugger;
        for (i = 0 ; i < area_admins.length ; i ++) {
            html += '<tr>';
            html += '<td>' + area_admins[i].area_name + '</td>';
            html += '<td>' + area_admins[i].area_admin_name + '</td>';

            var refResData = getResData(area_admins[i].id);
            var refDriverData = getDriverData(area_admins[i].id);
            console.log(area_admins[i].id);

            await refResData.get().then(function (snapshots) {
                console.log(snapshots.docs.length);
                general_added_res_total += snapshots.docs.length;
                general_added_res_counts = snapshots.docs.length;
                html += '<td>' + snapshots.docs.length + '</td>';
            });

            await refDriverData.get().then(function (snapshots) {
                console.log(snapshots.docs.length);
                general_added_driver_total += snapshots.docs.length;
                general_added_driver_counts[i] = snapshots.docs.length;
                html += '<td>' + snapshots.docs.length + '</td>';
            });
            html += '</tr>';
        }
    }

    function tableGeneral() {
        var html = '', i;
        getGeneralData().then(res => {
            for (i = 0 ; i < area_admins.length ; i ++) {
                html += '<tr>';
                html += '<td>' + area_admins[i].area_name + '</td>';
                html += '<td>' + area_admins[i].area_admin_name + '</td>';
                html += '<td>' + general_added_res_counts[i] + '</td>';
                html += '<td>' + general_added_driver_counts[i] + '</td>';
                html += '</tr>';
            }
        });
        return html;
    }

</script>
@endsection

