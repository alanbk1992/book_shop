@extends('layouts.app')

@section('content')

<section id="content" class="content">
<div class="content__header content__boxed overlapping">
<div class="content__wrap">

</div>
</div>
<div class="content__boxed">
<div class="content__wrap">

<div class="card">
<div class="card-header -4 mb-3">
<h5 class="card-title mb-3">Books</h5>
<div class="row">






<div class="col-md-6 d-flex gap-1 align-items-center mb-3">

     <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                <input id="txt_search_service_internet_home" class="searchbox__input form-control bg-transparent" type="search" placeholder="Cari Nama Buku" aria-label="Search">
                <div class="searchbox__backdrop">
                  <button class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm" type="button" id="btn_search_service_internet_home">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </form>


</div>


<div class="col-md-6 d-flex gap-1 align-items-center justify-content-md-end mb-3">			
	
 <div class="col-sm-6 col-md-3 btn-group">
<button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Semua Status</button>
<ul class="dropdown-menu scrollable-menu" role="menu">

<li>
<a class="dropdown-item" href="#">Connected</a>
</li> 

<li>
<a class="dropdown-item" href="#">Not Connect</a>
</li> 

</ul>
</div>

<button id="btn_add_internet_home" data-target="#modal_add_internet_home" data-toggle="modal" class="btn btn-primary hstack gap-2 align-self-center">
<i class="bi bi-file-earmark-plus fs-6"></i>
<span class="vr"></span>
Add New
</button>


</div>


</div>
</div>
<div class="card-body ">
<div class="table-responsive-xl text-nowrap" style="overflow-x: auto; overflow-y: scroll; max-height: 500px; ">
<table class="table table-hover">
<thead>
<tr>


<th  class="th-lg">No</th>
<th class="th-lg">Nama Buku</th>
<th  class="th-lg">Penerbit</th>
</tr>
</thead>
<tbody>
@foreach ($customer as $no => $data)
<tr>
 <div hidden>{{  $data['service_member_id'] ?? ''}}</div>
<th class="align-middle" >{{ $no+1 }} </th>
<td class="align-middle">{{ $data['title'] ?? '' }} </td>
<td class="align-middle">{{ $data['authors'] ?? '' }} </td>
<?php
echo '<td class="align-middle"><button class="btn btn-default btn-icon"   data-id='.$data['book_id'].'  onclick="action_internet_home(this)"><i class="bi bi-pencil-square fs-5"></i></button></td>';
?>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="col-md-6 d-flex gap-1 align-items-center justify-content-md-end mb-3">
<nav class="text-align-center mt-5" aria-label="Table navigation">
<ul class="pagination justify-content-center">
<li class="page-item disabled">
<a class="page-link">Previous</a>
</li>
<li class="page-item active" aria-current="page">
<span class="page-link">1</span>
</li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item disabled"><a class="page-link" href="#">...</a></li>
<li class="page-item"><a class="page-link" href="#">5</a></li>
<li class="page-item">
<a class="page-link" href="#">Next</a>
</li>
</ul>
</nav>
</div>



</div>
</div>

</div>
</div>

<div class="modal fade" id="modal_add_internet_home" tabindex="-1" aria-labelledby="modal_add_internet_home" aria-hidden="true">
<div class="modal-dialog" >
<div class="modal-content" style="background-color: #ffffff;">
<!-- Header Modal -->
<div class="modal-header">
<h5 class="modal-title" id="modal_add_internet_home">Add Internet Home</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="row px-3 mt-2 mb-2">
<div class="col-md-12" style="overflow: auto; height: 70vh;">
<div id="UpdatePanelinfo">
<div class="row">
                                           
<div id="dv_customers" class="col-md-12 pt-2">
<div class="form-group">
<label for="CbCustomers">Nama Customer *</label>
<select name="CbCustomers"  id="CbCustomers" class="form-control  mt-1">
<option selected="selected" value="">Pilih Nama Customer</option>
</select>

</div>
</div>
												
<div id="dv_package_internet_home" class="col-md-12 pt-2">
<div class="form-group">
<label for="CbPackageInternetHome">Paket Internet *</label>
<select name="CbPackageInternetHome"  id="CbPackageInternetHome" class="form-control  mt-1">
<option selected="selected" value="">Pilih Paket</option>
</select>
</div>
</div>

<div id="dv_installation_date" class="col-md-12 pt-2">
<div class="form-group">
<label for="installation_date">Tanggal Pemasangan *</label>
<input type="datetime-local" id="installation_date" name="installation_date" class="form-control  mt-1">
</select>
</div>
</div>


<div class="col-md-12 pt-3">

<div class="card-body" id="ringkasan" style="display: none;">
<h5 class="card-title">Ringkasan</h5>

<form>
<div class="row">
<label class="col-sm-5 col-form-label">Harga Paket</label>
<div class="col-sm-6">
<label id="lblPrice" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label class="col-sm-5 col-form-label">Harga Prorate</label>
<div class="col-sm-6">
<label id="lblProrate" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label  class="col-sm-5 col-form-label">PPN</label>
<div class="col-sm-6">
<label id="lblPpn" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label  class="col-sm-5 col-form-label">Biaya Pemasangan</label>
<div class="col-sm-6">
<label id="lblInstallationFee" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>

</form>

</div>
</div>



</div>
</div>
</div>
</div>
                  
<!-- Footer Modal -->
<div class="modal-footer">
<button data-dismiss="modal" class="btn btn-dark" type="button" data-bs-dismiss="modal">Cancel</button>
<button class="btn btn-primary" id="btn_confrim_add_service_internet_home">Confrim</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modal_action_internet_home" tabindex="-1" aria-labelledby="modal_action_internet_home" aria-hidden="true">
<div class="modal-dialog" >
<div class="modal-content" style="background-color: #ffffff;">
<!-- Header Modal -->
<div class="modal-header">
<h5 class="modal-title" id="modal_action_internet_home">Action Internet Home</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="row px-3 mt-2 mb-2">
<div class="col-md-12" style="overflow: auto; height: 70vh;">
<div id="UpdatePanelinfo">
<div class="row">
                                           
<div class="row">
<div class="col-sm-6 mt-2">
<div class="form-group">
<label for="action_fullname">Nama Pelanggan</label>
<input type="text" id="action_fullname" class="form-control  mt-1" readonly>
</div>
</div>
<div class="col-sm-6 mt-2">
<div class="form-group">
<label for="action_service_member_id">No Pelanggan</label>
<input type="text" id="action_service_member_id" class="form-control  mt-1" readonly>
</div>
</div>

</div>
												
<div class="row">
<div class="col-sm-6 mt-2">
<div class="form-group">
<label for="action_item_name">Nama Layanan</label>
<input type="text" id="action_item_name" class="form-control  mt-1" readonly>
</div>
</div>
<div class="col-sm-6 mt-2">
<div class="form-group">
<label for="action_price">Harga</label>
<input type="text" id="action_price" class="form-control  mt-1" readonly>
</div>
</div>

</div>

<div class="col-sm-12  mt-2">
<div class="form-group">
<label for="action_profile">Profile</label>
<select name="action_profile"  id="action_profile" class="form-control  mt-1">
<option selected="selected" value="">Pilih Profile</option>
</select>
</div>
</div>



<div class="col-md-12 pt-3">

<div class="card-body" id="ringkasan" style="display: none;">
<h5 class="card-title">Ringkasan</h5>

<form>
<div class="row">
<label class="col-sm-5 col-form-label">Harga Paket</label>
<div class="col-sm-6">
<label id="lblPrice" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label class="col-sm-5 col-form-label">Harga Prorate</label>
<div class="col-sm-6">
<label id="lblProrate" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label  class="col-sm-5 col-form-label">PPN</label>
<div class="col-sm-6">
<label id="lblPpn" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>
<div class="row">
<label  class="col-sm-5 col-form-label">Biaya Pemasangan</label>
<div class="col-sm-6">
<label id="lblInstallationFee" class="col-sm-6 col-form-label">Rp. 0</label>
</div>
</div>

</form>

</div>
</div>



</div>
</div>
</div>
</div>
                  
<!-- Footer Modal -->
<div class="modal-footer">
<button data-dismiss="modal" class="btn btn-dark" type="button" data-bs-dismiss="modal">Cancel</button>
<button class="btn btn-primary" id="btn_confrim_action_service_internet_home">Confrim</button>
</div>
</div>
</div>
</div>


 <script>
        // Get a reference to the input element
        var datetimeInput = document.getElementById('installation_date');

        // Add an event listener to the input element to handle changes
        datetimeInput.addEventListener('change', function() {
            var selectedDateTime = datetimeInput.value;
            console.log('Selected date and time:', selectedDateTime);
        });
    </script>
<script language="JavaScript" type="text/javascript" src="/assets/js/services/internet_home.js"></script>
<script language="JavaScript" type="text/javascript" src="/assets/js/bootstrap-datepicker.min.js"></script>
</section>
@endsection