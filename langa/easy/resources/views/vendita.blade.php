@extends('adminHome')

@section('page')
<h1>Vendita</h1><hr>
@include('common.errors')

<style>
    @keyframes bgcolor {
    from {background-color: #f39538;}
    to {background-color: #f37f0d;}
    }
    a div {
        animation-name: bgcolor;
        animation-duration: 1s;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        text-align: center;
        height: 100px;
        border-right: 10px solid #fff;
        border-bottom: 10px solid #fff;
    }
    a div h2 {
        color: #ffffff;
    }
    
</style>

<a href="{{url('/admin/tassonomie/pacchetti/add')}}">
<div class="col-xs-3">
    <h2>Pacchetti</h2>
</div>
</a>

<a href="{{url('/admin/tassonomie/optional/add')}}">
<div class="col-xs-3">
    <h2>Optional</h2>
</div>
</a>

<a href="{{url('/admin/tassonomie/sconti/add')}}">
<div class="col-xs-3">
    <h2>Sconti</h2>
</div>
</a>

<a href="{{url('/admin/tassonomie/scontibonus/add')}}">
<div class="col-xs-3">
    <h2>Sconti bonus</h2>
</div>
</a>

@endsection