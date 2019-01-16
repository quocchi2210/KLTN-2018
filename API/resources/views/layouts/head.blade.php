<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> @yield('title')Giao hàng C&K</title>
    <link href="{{ asset('layouts/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/icomoon.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('layouts/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('layouts/js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ asset('layouts/js/respond.min.js') }}"></script>
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&amp;subset=vietnamese" rel="stylesheet">
</head><!--/head-->

<style>
    .inboxMain{
        margin-top: 200px;
        min-height:400px; background-color:#fff; padding:10px;
        border:1px solid #ccc
    }
    ol.progtrckr {
        margin: 0;
        padding: 0;
        list-style-type none;
    }

    ol.progtrckr li {
        display: inline-block;
        text-align: center;
        line-height: 3.5em;
    }

    ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
    ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
    ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
    ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
    ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
    ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
    ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
    ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

    ol.progtrckr li.progtrckr-done {
        color: black;
        border-bottom: 4px solid yellowgreen;
    }
    ol.progtrckr li.progtrckr-todo {
        color: silver;
        border-bottom: 4px solid silver;
    }

    ol.progtrckr li:after {
        content: "\00a0\00a0";
    }
    ol.progtrckr li:before {
        position: relative;
        bottom: -2.5em;
        float: left;
        left: 50%;
        line-height: 1em;
    }
    ol.progtrckr li.progtrckr-done:before {
        content: "\2713";
        color: white;
        background-color: yellowgreen;
        height: 2.2em;
        width: 2.2em;
        line-height: 2.2em;
        border: none;
        border-radius: 2.2em;
    }
    ol.progtrckr li.progtrckr-todo:before {
        content: "\039F";
        color: silver;
        background-color: white;
        font-size: 2.2em;
        bottom: -1.2em;
    }
</style>