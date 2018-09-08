@extends('layouts.app')
@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
{{--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
<!------ Include the above in your HEAD tag ---------->
<style>
    .dropdown-large {
        position: static !important;
    }
    .dropdown-menu-large {
        margin-left: 16px;
        margin-right: 16px;
        padding: 20px 0px;
    }
    .dropdown-menu-large > li > ul {
        padding: 0;
        margin: 0;
    }
    .dropdown-menu-large > li > ul > li {
        list-style: none;
    }
    .dropdown-menu-large > li > ul > li > a {
        display: block;
        padding: 3px 20px;
        clear: both;
        font-weight: normal;
        line-height: 1.428571429;
        color: #333333;
        white-space: normal;
    }
    .dropdown-menu-large > li ul > li > a:hover,
    .dropdown-menu-large > li ul > li > a:focus {
        text-decoration: none;
        color: #262626;
        background-color: #f5f5f5;
    }
    .dropdown-menu-large .disabled > a,
    .dropdown-menu-large .disabled > a:hover,
    .dropdown-menu-large .disabled > a:focus {
        color: #999999;
    }
    .dropdown-menu-large .disabled > a:hover,
    .dropdown-menu-large .disabled > a:focus {
        text-decoration: none;
        background-color: transparent;
        background-image: none;
        filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
        cursor: not-allowed;
    }
    .dropdown-menu-large .dropdown-header {
        color: #428bca;
        font-size: 18px;
    }
    @media (max-width: 768px) {
        .dropdown-menu-large {
            margin-left: 0 ;
            margin-right: 0 ;
        }
        .dropdown-menu-large > li {
            margin-bottom: 30px;
        }
        .dropdown-menu-large > li:last-child {
            margin-bottom: 0;
        }
        .dropdown-menu-large .dropdown-header {
            padding: 3px 15px !important;
        }
    }

</style>
<ul class="nav navbar-nav">
    <li class="dropdown dropdown-large">
        <a href="#" class="" data-toggle="dropdown">... </a>
        <ul class="dropdown-menu dropdown-menu-large row">
            <li><a href="#">Available glyphs</a></li>
            <li><a href="#">Examples</a></li>
        </ul>

    </li>
</ul>
    @endsection()
