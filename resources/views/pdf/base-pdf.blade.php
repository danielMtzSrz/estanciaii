<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        <style>
        * {
            box-sizing: border-box;
            font-size: 12px;
        }

        @page {
            margin: 50px 0;
        }

        body {
            margin: 2cm 2cm 2cm 2cm;
            overflow-wrap: anywhere;
            height: 100%;
        }

        ,
        header {
            position: fixed;
            top: -90px;
            left: 0;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
        }
        .portada {
            position: fixed;
            top: 350px;
            left: 0px;
            right: 0px;
        }
        .titulo {
            text-align: center;
        }

        .brand {
            width: 80%;
            position: absolute;
            top: 15%;
            left: 10%;
            z-index: -1;
        }

        .image {
            width: 100%;
        }

        .contenido {
            position: absolute;
            width: 80%;
            height: 600px;
            top: 20px;
            left: 10%;
            background: rgba(255, 255, 255, 0.9);
        }

        .label {
            width: 30%;
            text-align: left;
            display: inline;
        }

        .cont {
            width: 70%;
            text-align: left;
            display: inline;
        }

        .row {
            width: 100%;
            display: block;
        }

        .banco {
            width: 100px;
            margin-bottom: 20px;
        }

        table.blueTable {
            border: 1px solid #151830;
            background-color: #EEEEEE;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
        }

        table.blueTable tbody td {
            font-size: 12px;
        }

        /* table.blueTable tr:nth-child(odd) {
            background: rgba(255, 91, 121, 0.15);
        } */
        table.blueTable tr:nth-child(odd) {
            background: #faf9f9;
        }

        table.blueTable tr:nth-child(even) {
            background: rgba(139, 184, 250, 0.15);
        }

        table.blueTable thead {
            background-color: #1A535C;
            background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 13px;
            font-weight: bold;
            color: #FFFFFF;
            background-color: #151830;
            border-left: 2px solid #D0E4F5;
        }

        table.blueTable thead th:first-child {
            border-left: none;
        }

        table.blueTable tfoot {
            font-size: 13px;
            font-weight: bold;
            color: #FFFFFF;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 13px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }

        .table-without-borders{
            width: 635px;
            padding-left: 2px;
            border-collapse: collapse;
        }

        .table-without-borders th, td{
            border: none;
            text-align: left;
        }

        .page-break {
            page-break-after: always;
        }

        .divider {
            border-top: 1px solid #304562;
        }

        /* Position */
        .static {
            position: static;
        }

        .fixed {
            position: fixed;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .sticky {
            position: sticky;
        }

        /* Font size */
        .text-xs {
            font-size: 12px;
            padding: 0;
            margin: 2px;
        }

        .text-sm {
            font-size: 14px;
            padding: 0;
            margin: 2px;
        }

        .text-base {
            font-size: 16px;
            padding: 0;
            margin: 2px;
        }

        .text-lg {
            font-size: 18px;
            padding: 0;
            margin: 2px;
        }

        .text-xl {
            font-size: 20px;
            padding: 0;
            margin: 2px;
        }

        .text-2xl {
            font-size: 24px;
            padding: 0;
            margin: 2px;
        }

        .text-3xl {
            font-size: 28px;
            padding: 0;
            margin: 2px;
        }

        .text-4xl {
            font-size: 32px;
            padding: 0;
            margin: 2px;
        }

        .text-5xl {
            font-size: 40px;
            padding: 0;
            margin: 2px;
        }

        .text-6xl {
            font-size: 48px;
            padding: 0;
            margin: 2px;
        }

        .text-7xl {
            font-size: 64px;
            padding: 0;
            margin: 2px;
        }

        .text-8xl {
            font-size: 96px;
            padding: 0;
            margin: 2px;
        }

        /* Text align */
        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Text style */
        .text-italic {
            font-style: italic
        }

        /* Font weight */
        .font-light {
            font-weight: 300;
        }

        .font-normal {
            font-weight: 400;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        /* Margins */
        .m-auto {
            margin: auto;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .my-auto {
            margin-top: auto;
            margin-bottom: auto;
        }

        .mt-auto {
            margin-top: auto;
        }

        .mb-auto {
            margin-bottom: auto;
        }

        .ml-auto {
            margin-left: auto;
        }

        .mr-auto {
            margin-right: auto;
        }

        .m-0 {
            margin: 0;
        }

        .m-1 {
            margin: 4px;
        }

        .m-2 {
            margin: 8px;
        }

        .m-3 {
            margin: 16px;
        }

        .m-4 {
            margin: 24px;
        }

        .m-5 {
            margin: 32px;
        }

        .m-6 {
            margin: 48px;
        }

        .m-7 {
            margin: 64px;
        }

        .m-8 {
            margin: 80px;
        }

        .mt-0 {
            margin-top: 0;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .mt-4 {
            margin-top: 24px;
        }

        .mt-5 {
            margin-top: 32px;
        }

        .mt-6 {
            margin-top: 48px;
        }

        .mt-7 {
            margin-top: 64px;
        }

        .mt-8 {
            margin-top: 80px;
        }

        .mr-0 {
            margin-right: 0;
        }

        .mr-1 {
            margin-right: 4px;
        }

        .mr-2 {
            margin-right: 8px;
        }

        .mr-3 {
            margin-right: 16px;
        }

        .mr-4 {
            margin-right: 24px;
        }

        .mr-5 {
            margin-right: 32px;
        }

        .mr-6 {
            margin-right: 48px;
        }

        .mr-7 {
            margin-right: 64px;
        }

        .mr-8 {
            margin-right: 80px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .mb-5 {
            margin-bottom: 32px;
        }

        .mb-6 {
            margin-bottom: 48px;
        }

        .mb-7 {
            margin-bottom: 64px;
        }

        .mb-8 {
            margin-bottom: 80px;
        }

        .ml-0 {
            margin-left: 0;
        }

        .ml-1 {
            margin-left: 4px;
        }

        .ml-2 {
            margin-left: 8px;
        }

        .ml-3 {
            margin-left: 16px;
        }

        .ml-4 {
            margin-left: 24px;
        }

        .ml-5 {
            margin-left: 32px;
        }

        .ml-6 {
            margin-left: 48px;
        }

        .ml-7 {
            margin-left: 64px;
        }

        .ml-8 {
            margin-left: 80px;
        }

        .mx-0 {
            margin-left: 0;
            margin-right: 0;
        }

        .mx-1 {
            margin-left: 4px;
            margin-right: 4px;
        }

        .mx-2 {
            margin-left: 8px;
            margin-right: 8px;
        }

        .mx-3 {
            margin-left: 16px;
            margin-right: 16px;
        }

        .mx-4 {
            margin-left: 24px;
            margin-right: 24px;
        }

        .mx-5 {
            margin-left: 32px;
            margin-right: 32px;
        }

        .mx-6 {
            margin-left: 48px;
            margin-right: 48px;
        }

        .mx-7 {
            margin-left: 64px;
            margin-right: 64px;
        }

        .mx-8 {
            margin-left: 80px;
            margin-right: 80px;
        }

        .my-0 {
            margin-top: 0;
            margin-bottom: 0;
        }

        .my-1 {
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .my-2 {
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .my-3 {
            margin-top: 16px;
            margin-bottom: 16px;
        }

        .my-4 {
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .my-5 {
            margin-top: 32px;
            margin-bottom: 32px;
        }

        .my-6 {
            margin-top: 48px;
            margin-bottom: 48px;
        }

        .my-7 {
            margin-top: 64px;
            margin-bottom: 64px;
        }

        .my-8 {
            margin-top: 80px;
            margin-bottom: 80px;
        }

        /* Paddings */
        .p-auto {
            padding: auto;
        }

        .px-auto {
            padding-left: auto;
            padding-right: auto;
        }

        .py-auto {
            padding-top: auto;
            padding-bottom: auto;
        }

        .pt-auto {
            padding-top: auto;
        }

        .pb-auto {
            padding-bottom: auto;
        }

        .pl-auto {
            padding-left: auto;
        }

        .pr-auto {
            padding-right: auto;
        }

        .p-0 {
            padding: 0;
        }

        .p-1 {
            padding: 4px;
        }

        .p-2 {
            padding: 8px;
        }

        .p-3 {
            padding: 16px;
        }

        .p-4 {
            padding: 24px;
        }

        .p-5 {
            padding: 32px;
        }

        .p-6 {
            padding: 48px;
        }

        .p-7 {
            padding: 64px;
        }

        .p-8 {
            padding: 80px;
        }

        .pt-0 {
            padding-top: 0;
        }

        .pt-1 {
            padding-top: 4px;
        }

        .pt-2 {
            padding-top: 8px;
        }

        .pt-3 {
            padding-top: 16px;
        }

        .pt-4 {
            padding-top: 24px;
        }

        .pt-5 {
            padding-top: 32px;
        }

        .pt-6 {
            padding-top: 48px;
        }

        .pt-7 {
            padding-top: 64px;
        }

        .pt-8 {
            padding-top: 80px;
        }

        .pr-0 {
            padding-right: 0;
        }

        .pr-1 {
            padding-right: 4px;
        }

        .pr-2 {
            padding-right: 8px;
        }

        .pr-3 {
            padding-right: 16px;
        }

        .pr-4 {
            padding-right: 24px;
        }

        .pr-5 {
            padding-right: 32px;
        }

        .pr-6 {
            padding-right: 48px;
        }

        .pr-7 {
            padding-right: 64px;
        }

        .pr-8 {
            padding-right: 80px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        .pb-1 {
            padding-bottom: 4px;
        }

        .pb-2 {
            padding-bottom: 8px;
        }

        .pb-3 {
            padding-bottom: 16px;
        }

        .pb-4 {
            padding-bottom: 24px;
        }

        .pb-5 {
            padding-bottom: 32px;
        }

        .pb-6 {
            padding-bottom: 48px;
        }

        .pb-7 {
            padding-bottom: 64px;
        }

        .pb-8 {
            padding-bottom: 80px;
        }

        .pl-0 {
            padding-left: 0;
        }

        .pl-1 {
            padding-left: 4px;
        }

        .pl-2 {
            padding-left: 8px;
        }

        .pl-3 {
            padding-left: 16px;
        }

        .pl-4 {
            padding-left: 24px;
        }

        .pl-5 {
            padding-left: 32px;
        }

        .pl-6 {
            padding-left: 48px;
        }

        .pl-7 {
            padding-left: 64px;
        }

        .pl-8 {
            padding-left: 80px;
        }

        .px-0 {
            padding-left: 0;
            padding-right: 0;
        }

        .px-1 {
            padding-left: 4px;
            padding-right: 4px;
        }

        .px-2 {
            padding-left: 8px;
            padding-right: 8px;
        }

        .px-3 {
            padding-left: 16px;
            padding-right: 16px;
        }

        .px-4 {
            padding-left: 24px;
            padding-right: 24px;
        }

        .px-5 {
            padding-left: 32px;
            padding-right: 32px;
        }

        .px-6 {
            padding-left: 48px;
            padding-right: 48px;
        }

        .px-7 {
            padding-left: 64px;
            padding-right: 64px;
        }

        .px-8 {
            padding-left: 80px;
            padding-right: 80px;
        }

        .py-0 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .py-1 {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .py-2 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .py-3 {
            padding-top: 16px;
            padding-bottom: 16px;
        }

        .py-4 {
            padding-top: 24px;
            padding-bottom: 24px;
        }

        .py-5 {
            padding-top: 32px;
            padding-bottom: 32px;
        }

        .py-6 {
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .py-7 {
            padding-top: 64px;
            padding-bottom: 64px;
        }

        .py-8 {
            padding-top: 80px;
            padding-bottom: 80px;
        }

        .page {
            margin-top: 0px;
            left: 50px;
            right: 50px;
        }
        .ql-video {
            display: block;
            max-width: 100%;
        }
        .ql-video.ql-align-center {
            margin: 0 auto;
        }
        .ql-video.ql-align-right {
            margin: 0 0 0 auto;
        }
        .ql-bg-black {
            background-color: #000;
        }
        .ql-bg-red {
            background-color: #e60000;
        }
        .ql-bg-orange {
            background-color: #f90;
        }
        .ql-bg-yellow {
            background-color: #ff0;
        }
        .ql-bg-green {
            background-color: #008a00;
        }
        .ql-bg-blue {
            background-color: #06c;
        }
        .ql-bg-purple {
            background-color: #93f;
        }
        .ql-color-white {
            color: #fff;
        }
        .ql-color-red {
            color: #e60000;
        }
        .ql-color-orange {
            color: #f90;
        }
        .ql-color-yellow {
            color: #ff0;
        }
        .ql-color-green {
            color: #008a00;
        }
        .ql-color-blue {
            color: #06c;
        }
        .ql-color-purple {
            color: #93f;
        }
        .ql-font-serif {
            font-family: Georgia, Times New Roman, serif;
        }
        .ql-font-monospace {
            font-family: Monaco, Courier New, monospace;
        }
        .ql-size-small {
            font-size: 0.75rem;
        }
        .ql-size-large {
            font-size: 1.5rem;
        }
        .ql-size-huge {
            font-size: 2.5rem;
        }
        .ql-direction-rtl {
            direction: rtl;
            text-align: inherit;
        }
        .ql-align-center {
            text-align: center;
        }
        .ql-align-justify {
            text-align: justify;
        }
        .ql-align-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Sección del contenido -->
    <main class="page">
        <!-- El ancho del documento es de 685px -->
        {{-- <p class="text-2xl" style="text-align: center;">@yield('title')</p>  --}}
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>
